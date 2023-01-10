<?php

namespace App\Nova\Actions;

use App\Imports\AdditionalDocumentsFromPcfActions;
use App\Imports\DiscoursesFromPcfActions;
use App\Imports\LettersFromPcfActions;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Maatwebsite\Excel\Facades\Excel;

class PcfActions extends Action
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
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        switch ($fields->type) {
            case 'Letters':
                Excel::import(new LettersFromPcfActions($fields->action), $fields->file);
                break;
            case 'Additional Documents':
                Excel::import(new AdditionalDocumentsFromPcfActions($fields->action), $fields->file);
                break;
            case 'Discourses':
                Excel::import(new DiscoursesFromPcfActions($fields->action), $fields->file);
                break;
        }

        return Action::message("$fields->action successfully processed");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('Type')
                ->options([
                    'Additional Documents' => 'Additional Documents',
                    'Discourses' => 'Discourses',
                    'Letters' => 'Letters',
                ])
                ->rules('required'),
            Select::make('Action')
                ->options([
                    'Import New' => 'Import New',
                ])
                ->rules('required'),
            File::make('File')
                ->rules('required'),
        ];
    }
}
