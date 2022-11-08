<?php

namespace App\Nova\Actions;

use App\Imports\AutobiographiesPcfImport;
use App\Imports\JournalsPcfImport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
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
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
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
        }

        return Action::message("Imported $fields->type successfully");
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
                    'Journals' => 'Journals',
                    'Autobiographies' => 'Autobiographies',
                ])
                ->rules('required'),
            File::make('File')
                ->rules('required'),
        ];
    }
}
