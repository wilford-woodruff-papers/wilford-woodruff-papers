<?php

namespace App\Nova\Actions;

use Anaseqal\NovaImport\Actions\Action;
use App\Imports\PhotoImport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Facades\Excel;

class ImportPhotos extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        Excel::import(new PhotoImport, $fields->file);

        return Action::message('Photos imported successfully');
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

    /**
     * Validate the given request.
     */
    public function validateFields(ActionRequest $request): void
    {
        $fields = collect($this->fields());

        return Validator::make(
            $request->all(),
            $fields->mapWithKeys(function ($field) use ($request) {
                return $field->getCreationRules($request);
            })->all(),
            [],
            $fields->reject(function ($field) {
                return empty($field->name);
            })->mapWithKeys(function ($field) {
                return [$field->attribute => $field->name];
            })->all()
        )->after(function ($validator) use ($request) {
            $this->afterValidation($request, $validator);
        })->validate();
    }

    /**
     * Handle any post-validation processing.
     */
    protected function afterValidation(NovaRequest $request, Illuminate\Validation\Validator $validator): void
    {
        //
    }
}
