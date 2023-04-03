<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use PHPHtmlParser\Dom;

class ImportPages extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            Artisan::call('import:pages', [
                'item' => $model->id,
                '--enable' => $fields->status,
                '--download' => $fields->reimport_images,
            ]);
        }
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Status')->options([
                1 => 'Enable',
            ]),
            Select::make('Reimport Images')->options([
                1 => 'Yes',
            ]),
        ];
    }

    private function convertSubjectTags($transcript)
    {
        $transcript = str($transcript);
        $links = $transcript->matchAll('/<a.*?<\/a>/s');

        foreach ($links as $link) {
            $title = str($link)->match("/(?<=title=')(.*?)(?=')/s");
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
        $dateNodes = $dom->find('date');
        foreach ($dateNodes as $node) {
            $dates[] = $node->getAttribute('when');
        }

        return $dates;
    }
}
