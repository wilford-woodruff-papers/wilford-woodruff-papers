<?php

namespace App\Nova\Actions;

use App\Imports\AdditionalDocumentsPcfImport;
use App\Imports\AutobiographiesPcfImport;
use App\Imports\DiscoursesPcfImport;
use App\Imports\JournalsPcfImport;
use App\Imports\LettersPcfImport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Facades\Excel;

class ImportPcf extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $standalone = true;

    public function __construct()
    {
        //
    }

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        switch ($fields->type) {
            case 'Journals':
                Excel::import(new JournalsPcfImport(), $fields->file);
                break;
            case 'Autobiographies':
                Excel::import(new AutobiographiesPcfImport(), $fields->file);
                break;
            case 'Letters':
                Excel::import(new LettersPcfImport(), $fields->file);
                break;
            case 'Additional Documents':
                Excel::import(new AdditionalDocumentsPcfImport(), $fields->file);
                break;
            case 'Discourses':
                Excel::import(new DiscoursesPcfImport(), $fields->file);
                break;
        }

        return Action::message("Imported $fields->type successfully");
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Type')
                ->options([
                    'Journals' => 'Journals',
                    'Autobiographies' => 'Autobiographies',
                    'Additional Documents' => 'Additional Documents',
                    'Letters' => 'Letters',
                    'Discourses' => 'Discourses',
                ])
                ->rules('required'),
            File::make('File')
                ->rules('required'),
        ];
    }
}
