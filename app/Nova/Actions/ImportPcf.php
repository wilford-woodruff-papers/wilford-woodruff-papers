<?php

namespace App\Nova\Actions;

use App\Imports\JournalsPcfImport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Maatwebsite\Excel\Facades\Excel;

class ImportPcf extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $standalone = true;

    private $type;

    public function __construct($type)
    {
        $this->type = $type;
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
        switch ($this->type) {
            case 'Journals':
                Excel::import(new JournalsPcfImport('Journals'), $this->file);
                break;
            case 'Letters':
                Excel::import(new JournalsPcfImport('Letters'), $this->file);
                break;
        }

        return Action::message('Imported successfully');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            File::make('File')->rules('required'),
        ];
    }
}
