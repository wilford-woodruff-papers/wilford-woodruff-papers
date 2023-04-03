<?php

namespace App\Nova\Actions;

use App\Imports\TimelineImport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Maatwebsite\Excel\Facades\Excel;

class ImportTimeline extends Action
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
        Excel::import(new TimelineImport(), $fields->file);

        return Action::message('Timeline imported successfully');
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(): array
    {
        return [
            File::make('File')->rules('required'),
        ];
    }
}
