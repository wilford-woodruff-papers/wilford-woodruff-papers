<?php

namespace App\Nova\Actions;

use App\Events\DiscussionPostCreated;
use App\Models\Item;
use App\Models\Page;
use App\Models\Post;
use App\Models\Review;
use App\Models\Type;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class AssignToItem extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
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
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('Item')->options(
                Item::whereIn('type_id', Type::where('name', 'NOT LIKE', '%Section%')->pluck('id')->all())->get()->pluck('name', 'id')
            ),
        ];
    }
}
