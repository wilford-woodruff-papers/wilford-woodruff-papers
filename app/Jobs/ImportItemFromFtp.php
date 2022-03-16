<?php

namespace App\Jobs;

use App\Models\Date;
use App\Models\Item;
use App\Models\Page;
use App\Models\Subject;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
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

    protected Item $item;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }

        $item = $this->item;
        $response = Http::get($item->ftp_id);
        $canvases = $response->json('sequences.0.canvases');
        if (! empty($canvases)) {
            foreach ($canvases as $key => $canvas) {
                $page = Page::updateOrCreate([
                    'item_id' => $item->id,
                    'ftp_id' => $canvas['@id'],
                ], [
                    'name' => $canvas['label'],
                    'transcript' => $this->convertSubjectTags(
                        (array_key_exists('otherContent', $canvas))
                            ? Http::get($canvas['otherContent'][0]['@id'])->json('resources.0.resource.chars')
                            : ''),
                    'ftp_link' => (array_key_exists('related', $canvas))
                        ? $canvas['related'][0]['@id']
                        : '',
                ]);

                if (! $page->hasMedia()) {
                    $page->clearMediaCollection();

                    if (! empty($canvas['images'][0]['resource']['@id'])) {
                        $page->addMediaFromUrl($canvas['images'][0]['resource']['@id'])->toMediaCollection();
                    }
                }

                $page->subjects()->detach();

                $subjects = [];
                Str::of($page->transcript)->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/', function ($match) use (&$subjects) {
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
                }

                $page->dates()->delete();

                $dates = $this->extractDates($page->transcript);

                foreach ($dates as $date) {
                    try {
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

        $item->imported_at = now('America/Denver');
        $item->save();
    }

    private function convertSubjectTags($transcript)
    {
        $dom = new Dom;
        $dom->loadStr($transcript);
        $transcript = Str::of($transcript);
        $links = $dom->find('a');
        foreach ($links as $link) {
            //dd($link->outerHtml(), $link->getAttribute('title'), $link->innerHtml());
            $transcript = $transcript->replace($link->outerHtml(), '[['.html_entity_decode($link->getAttribute('title')).'|'.$link->innerHtml().']]');
        }

        return $transcript;
    }

    private function extractDates($transcript)
    {
        $dates = [];
        $dom = new Dom;
        $dom->loadStr($transcript);
        $dateNodes = $dom->find('date');
        foreach ($dateNodes as $node) {
            $dates[] = $node->getAttribute('when');
        }

        return $dates;
    }
}
