<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Date;
use App\Models\Item;
use App\Models\Page;
use App\Models\Subject;
use App\Models\Translation;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;

class ImportItemFromFtp implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 600;

    protected Item $item;

    public $enable;

    public $download;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Item $item, $enable = 'false', $download = 'false')
    {
        $this->item = $item;
        $this->enable = $enable;
        $this->download = $download;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (! empty($this->batch()) && $this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }

        info('Importing: '.$this->item->name);
        $item = $this->item;

        if (empty($item->ftp_id)) {
            info($item->ftp_id.' doesn\'t have an FTP Manifest');
        }

        $response = Http::get($item->ftp_id);
        $canvases = $response->json('sequences.0.canvases');
        if (! empty($canvases)) {
            $scripturalFigureCategories = Category::query()
                ->whereIn('name', ['People', 'Scriptural Figures'])
                ->pluck('id')
                ->all();
            // TODO: Need to add a check to see if there is a translation. I think the best route is to make English the
            // translation. So we need to check, swap, and save.
            foreach ($canvases as $key => $canvas) {
                $transcript = null;
                $translation = null;

                if (array_key_exists('otherContent', $canvas) && $transcriptionUrl = data_get(collect($canvas['otherContent'])
                    ->where('label', 'Transcription')
                    ->first(), '@id')) {
                    $transcript = Http::get($transcriptionUrl)->json('resources.0.resource.chars');
                }

                $page = Page::updateOrCreate([
                    'item_id' => $item->id,
                    'name' => $canvas['label'],
                ], [
                    'ftp_id' => $canvas['@id'],
                    'transcript_link' => data_get($canvas, 'otherContent.0.@id', null),
                    'transcript' => $this->convertSubjectTags($transcript),
                    'ftp_link' => (array_key_exists('related', $canvas))
                        ? $canvas['related'][0]['@id']
                        : '',
                    'is_blank' => in_array('markedBlank', array_values(data_get($canvas, 'service.pageStatus', []))),
                    'imported_at' => now(),
                ]);

                if (array_key_exists('otherContent', $canvas) && $translationUrl = data_get(collect($canvas['otherContent'])
                    ->where('label', 'Translation')
                    ->first(), '@id')) {
                    $translation = Http::get($translationUrl)->json('resources.0.resource.chars');

                    $pageTranslation = Translation::updateOrCreate([
                        'page_id' => $page->id,
                        'language' => str($translation)
                            ->match('/\[Language:.*?\]/')
                            ->after(':')
                            ->trim('[] ')
                            ->toString(),
                    ], [
                        'transcript' => $this->convertSubjectTags(str($translation)->stripLanguageTag()),
                    ]);
                }

                if (! $page->hasMedia() || $this->download == 'true') {
                    $page->clearMediaCollection();

                    if (! empty($canvas['images'][0]['resource']['@id'])) {
                        $page->addMediaFromUrl($canvas['images'][0]['resource']['@id'])->toMediaCollection();
                    }
                }

                $page->subjects()->detach();

                $subjects = [];
                Str::of($page->transcript)->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/s', function ($match) use (&$subjects) {
                    $subjects[] = Str::of($match[0])->trim('[[]]')->explode('|')->first();

                    return '[['.$match[0].']]';
                });

                foreach ($subjects as $subject) {
                    $subject = Subject::firstOrCreate([
                        'name' => $subject,
                    ]);
                    $subject->enabled = 1;
                    $subject->save();
                    $page->subjects()->syncWithoutDetaching($subject->id);

                    if (
                        str($subject->name)->contains('(OT)')
                        || str($subject->name)->contains('(NT)')
                        || str($subject->name)->contains('(BofM)')
                    ) {
                        $subject->category()->syncWithoutDetaching($scripturalFigureCategories);
                    }
                }

                $page->dates()->delete();

                $dates = $this->extractDates($page->transcript);

                foreach ($dates as $date) {
                    try {
                        if (Carbon::canBeCreatedFromFormat($date, 'Y-m-d')) {
                            // No modification to date needed
                        } elseif (Carbon::canBeCreatedFromFormat($date, 'Y-m')) {
                            $date = $date.'-01';
                        } elseif (Carbon::canBeCreatedFromFormat($date, 'Y')) {
                            $date = $date.'-01-01';
                        } else {
                            logger()->warning('Date cannot be created from '.$date);
                        }
                        $d = new Date;
                        $d->date = $date;
                        $page->dates()->save($d);
                    } catch (\Exception $e) {
                        logger()->error($e->getMessage());
                    }
                }

                unset($page);
            }
        }

        $item->ftp_slug = str($response->json('related.0.@id'))->afterLast('/');
        $item->auto_page_count = $item->pages()->count();
        $item->imported_at = now();

        if ($this->enable == 'true') {
            if ($item->enabled != true) {
                $item->added_to_collection_at = now();
            }
            $item->enabled = true;
        }

        $item->save();

        // OrderPages::dispatch($item);

        $this->item = $item;

        $this->orderPages();
        $this->cacheDates();
    }

    private function orderPages()
    {
        $this->item->refresh();

        if (empty($this->item->item_id) && $this->item->items->count() == 0) {
            $this->setOrderForItem($this->item);
        } elseif (! empty($this->item->item_id)) {
            $parent = $this->item->parent();
            $this->setOrderForSectionsInContainer($parent);
        }

        logger()->info('Page Order Updated for '.$this->item->name);
    }

    private function setOrderForItem($item)
    {
        $pageSortColumn = $item->page_sort_column ?? 'id';
        $pages = $item->pages->sortBy($pageSortColumn);
        $pages->each(function ($page) use ($item) {
            $page->parent_item_id = $item->parent()->id;
            $page->type_id = $item->parent()->type_id;
            $page->save();
        });

        Page::setNewOrder($pages->pluck('id')->all());

        $item->fresh();
        $pages = $item->pages;
        $pages->each(function ($page) use ($item) {
            $page->full_name = $item->name.': Page'.$page->order;
            $page->save();
        });

        $this->item->fresh();
    }

    private function setOrderForSectionsInContainer($item)
    {
        $itemPages = collect([]);
        $item->items->sortBy('order')->each(function ($child) use (&$itemPages) {
            $pageSortColumn = $child->page_sort_column ?? 'id';
            $itemPages = $itemPages->concat($child->pages->sortBy($pageSortColumn));
        });
        $itemPages->each(function ($page) use ($item) {
            $page->parent_item_id = $item->parent()->id;
            $page->type_id = $item->parent()->type_id;
            $page->save();
        });

        Page::setNewOrder($itemPages->pluck('id')->all());

        $item->fresh();
        $pages = $item->pages;
        $pages->each(function ($page) use ($item) {
            $page->full_name = $item->name.': Page'.$page->order;
            $page->save();
        });

        $this->item->fresh();
    }

    private function cacheDates()
    {
        $this->item->refresh();

        if ($this->item->items->count() == 0) {
            $dates = collect();
            $this->item->pages->each(function ($page) use (&$dates) {
                $dates = $dates->concat($page->dates);
            });
            $this->item->first_date = optional($dates->sortBy('date')->first())->date;
        } else {
            $this->item->first_date = optional($this->item->items->sortBy('date')->first())->first_date;
        }

        if ($this->item->first_date) {
            $this->item->decade = floor($this->item->first_date->year / 10) * 10;
            $this->item->year = $this->item->first_date->year;
        }

        $this->item->save();

        logger()->info('Dates Cached for '.$this->item->name);
    }

    private function convertSubjectTags($transcript)
    {
        $transcript = str($transcript);
        $links = $transcript->matchAll('/<a.*?<\/a>/s');

        foreach ($links as $link) {
            $title = str($link)->match('/(?<=title=["])(.*?)(?=["])/s');
            $text = str($link)->match("/(?<=>)(.*?)(?=<\/a>)/s");
            $transcript = $transcript->replace(
                $link,
                '[['.html_entity_decode($title).'|'.$text.']]'
            );
        }

        return $transcript;
    }

    private function extractDates($transcript)
    {
        $dates = [];
        $dom = new Dom;
        $dom->loadStr($transcript);
        $dateNodes = $dom->find('time');
        foreach ($dateNodes as $node) {
            $dates[] = $node->getAttribute('datetime');
        }

        return $dates;
    }
}
