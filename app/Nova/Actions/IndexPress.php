<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class IndexPress extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $standalone = true;

    public $name = 'Index';

    public function __construct($label = '')
    {
        $this->name .= ' '.$label;
    }

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        Artisan::call('content:index', [
            'models' => 'Press',
        ]);

        return Action::message('Press indexed successfully');
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request): array
    {
        return [

        ];
    }
}
