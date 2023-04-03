<?php

namespace App\Nova\Actions;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Number;

class AssignToItem extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $item = Item::findOrFail($fields->item);
        foreach ($models as $model) {
            $model->item()->associate($item);
            $model->save();
        }
        Artisan::call('pages:order');
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(): array
    {
        return [
            Number::make('Item ID', 'item'),
        ];
    }
}
