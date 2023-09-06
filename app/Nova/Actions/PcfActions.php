<?php

namespace App\Nova\Actions;

use App\Imports\AdditionalDocumentsFromPcfActions;
use App\Imports\AllDocumentTypePcfActions;
use App\Imports\AutobiographiesPcfImport;
use App\Imports\DaybooksFromPcfActions;
use App\Imports\DiscoursesFromPcfActions;
use App\Imports\LettersFromPcfActions;
use App\Imports\PeopleFromPcfActions;
use App\Imports\PlacesFromPcfActions;
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
            case 'Autobiographies':
                Excel::import(new AutobiographiesPcfImport, $fields->file);
                break;
            case 'Discourses':
                Excel::import(new DiscoursesFromPcfActions($fields->action), $fields->file);
                break;
            case 'Daybooks':
                Excel::import(new DaybooksFromPcfActions($fields->action), $fields->file);
                break;
            case 'People':
                Excel::import(new PeopleFromPcfActions($fields->action), $fields->file);
                break;
            case 'Places':
                Excel::import(new PlacesFromPcfActions($fields->action), $fields->file);
                break;
            case 'All':
                Excel::import(new AllDocumentTypePcfActions($fields->file->getClientOriginalName(), $fields->action), $fields->file);
                break;
        }

        return Action::message("$fields->action successfully processed");
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Type')
                ->options([
                    'Additional Documents' => 'Additional Documents',
                    'Autobiographies' => 'Autobiographies',
                    'Discourses' => 'Discourses',
                    'Letters' => 'Letters',
                    'Daybooks' => 'Daybooks',
                    'People' => 'People',
                    'Places' => 'Places',
                    'All' => 'All',
                ])
                ->rules('required'),
            Select::make('Action')
                ->options([
                    'Import New' => 'Import New',
                    'Import Master File' => 'Import Master File',
                    'Import Publish Dates' => 'Import Publish Dates (Any)',
                    'Import Identification' => 'Import Identification',
                    'Import Bio Approved At' => 'Import Bio Approved At',
                    'Import Research Log' => 'Import Research Log',
                    'Re-Import Links' => 'Re-Import Links',
                ])
                ->rules('required'),
            File::make('File')
                ->rules('required'),
        ];
    }
}
