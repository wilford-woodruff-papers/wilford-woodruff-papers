<?php

namespace App\Nova\Actions;

use App\Events\DiscussionPostCreated;
use App\Models\Date;
use App\Models\Item;
use App\Models\Page;
use App\Models\Post;
use App\Models\Review;
use App\Models\Subject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use PHPHtmlParser\Dom;

class ImportPages extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        /*foreach ($models as $model) {
            Artisan::call('import:pages', ['item' => $model->id, '--enable' => $fields->status]);
        }*/
        $items = Item::whereIn('id', $models->pluck('id')->all())
                        ->whereNotNull('ftp_id')
                        ->where(function ($query) {
                            $query->whereNull('imported_at')
                                    ->orWhere('imported_at', '<', now('America/Denver')->subHours(6));
                        });
        $items->chunkById(10, function($items){
            $items->each(function($item, $key){

                try{
                    logger()->info($item->id);
                    logger()->info($item->name);
                    logger()->info($item->ftp_id);
                    $response = Http::get($item->ftp_id);
                    $canvases = $response->json('sequences.0.canvases');
                    if(! empty($canvases)){
                        logger()->info("Canvases: ");
                        foreach($canvases as $key => $canvas){
                            logger()->info($canvas['@id']);
                            $page = Page::updateOrCreate([
                                'item_id' => $item->id,
                                'ftp_id' => $canvas['@id'],
                            ], [
                                'name' => $canvas['label'],
                                'transcript' => $this->convertSubjectTags(
                                    ( array_key_exists('otherContent', $canvas) )
                                        ? Http::get($canvas['otherContent'][0]['@id'])->json('resources.0.resource.chars')
                                        : '' ),
                                'ftp_link' => ( array_key_exists('related', $canvas) )
                                    ? $canvas['related'][0]['@id']
                                    : ''
                            ]);
                            logger()->info('Clear media');
                            $page->clearMediaCollection();
                            logger()->info($canvas['images'][0]['resource']['@id']);
                            logger()->info(route('pages.show', ['item' => $item, 'page' => $page]));

                            if(! empty($canvas['images'][0]['resource']['@id'])){
                                $page->addMediaFromUrl($canvas['images'][0]['resource']['@id'])->toMediaCollection();
                            }

                            $page->subjects()->detach();
                            logger()->info('Subjects');
                            $subjects = [];
                            Str::of($page->transcript)->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/', function ($match) use (&$subjects) {
                                $subjects[] = Str::of($match[0])->trim('[[]]')->explode('|')->first();
                                return '[['.$match[0].']]';
                            });
                            foreach($subjects as $subject){
                                $subject = Subject::firstOrCreate([
                                    'name' => $subject,
                                ]);
                                $subject->enabled = 1;
                                $subject->save();
                                $page->subjects()->syncWithoutDetaching($subject->id);
                            }

                            $page->dates()->delete();
                            logger()->info('Dates');

                            $dates = $this->extractDates($page->transcript);

                            foreach($dates as $date){
                                try{
                                    $d = new Date;
                                    $d->date = $date;
                                    $page->dates()->save($d);
                                }catch(\Exception $e){
                                    logger()->error($e->getMessage());
                                    logger()->info($page->id);
                                }
                            }
                            logger()->info("Done");
                            unset($page);
                        }
                        if($this->option('enable') == true || $this->option('enable') == 1){
                            $item->enabled = 1;
                            $item->save();
                        }
                    }
                } catch (\Exception $e) {
                    logger()->error($e->getMessage());
                }

                $item->imported_at = now('America/Denver');
                $item->save();
            });
        }, $column = 'id');

        Artisan::call('pages:order');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('Status')->options([
                1 => 'Enable',
            ])
        ];
    }

    private function convertSubjectTags($transcript)
    {
        $dom = new Dom;
        $dom->loadStr($transcript);
        $transcript = Str::of($transcript);
        $links = $dom->find('a');
        foreach($links as $link){
            //dd($link->outerHtml(), $link->getAttribute('title'), $link->innerHtml());
            $transcript = $transcript->replace($link->outerHtml(), '[['. $link->getAttribute('title') .'|'. $link->innerHtml() .']]');
        }
        return $transcript;
    }

    private function extractDates($transcript){
        $dates = [];
        $dom = new Dom;
        $dom->loadStr($transcript);
        $dateNodes = $dom->find('date');
        foreach ($dateNodes as $node){
            $dates[] = $node->getAttribute('when');
        }

        return $dates;
    }
}
