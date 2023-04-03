<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class Enable extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            if ($model->enabled == 0) {
                $model->added_to_collection_at = now();
            }
            $model->enabled = $fields->status;
            $model->save();
        }
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(): array
    {
        return [
            Select::make('Status')->options([
                1 => 'Enable',
                0 => 'Disable',
            ]),
        ];
    }
}
