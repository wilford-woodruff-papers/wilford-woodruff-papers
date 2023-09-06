<?php

namespace App\Nova\Actions;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class CopyUserRoles extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $user = User::query()
            ->with([
                'roles',
            ])
            ->where('id', $fields->user)
            ->first();

        foreach ($models as $model) {
            $model->roles()->syncWithoutDetaching($user->roles);
        }
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('User')->options(
                User::query()
                    ->has('roles')
                    ->orderBy('name')
                    ->pluck('name', 'id')
                    ->all()
            ),
        ];
    }
}
