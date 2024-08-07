<?php

namespace App\Nova\Actions;

use App\Models\Page;
use App\Models\Type;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class AssignDocumentType extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $type = Type::findOrFail($fields->document_type);
        foreach ($models as $model) {
            $model->type()->associate($type);
            $model->save();
            Page::where('item_id', $model->id)->update(['type_id' => $type->id]);
        }
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Document Type')->options(
                Type::get()->pluck('name', 'id')
            ),
        ];
    }
}
