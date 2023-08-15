<?php

namespace App\Nova\Actions;

use App\Imports\TranscriptClearTextImport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Facades\Excel;

class ImportClearText extends Action
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
    public function handle(ActionFields $fields)
    {
        Excel::import(new TranscriptClearTextImport(), $fields->file);

        return Action::message('Pages successfully added to queue');
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            File::make('File')
                ->rules('required'),
        ];
    }
}
