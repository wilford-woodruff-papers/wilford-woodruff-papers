<?php

namespace App\Nova\Actions;

use App\Imports\MetadataFieldsImport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Facades\Excel;

class ImportMetadataFields extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $standalone = true;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        set_time_limit(3600);
        Excel::import(new MetadataFieldsImport, $fields->file);

        return Action::message('Metadata import queued successfully');
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            File::make('File')->rules('required'),
        ];
    }
}
