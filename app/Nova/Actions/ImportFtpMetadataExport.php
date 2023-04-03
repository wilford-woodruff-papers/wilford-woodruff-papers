<?php

namespace App\Nova\Actions;

use App\Imports\FTPChecker;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Maatwebsite\Excel\Facades\Excel;

class ImportFtpMetadataExport extends Action
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
        Excel::import(new FTPChecker(), $fields->file);

        return Action::message('Imported successfully');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            File::make('File')
                ->rules('required'),
        ];
    }
}
