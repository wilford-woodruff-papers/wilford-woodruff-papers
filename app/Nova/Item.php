<?php

namespace App\Nova;

use App\Nova\Actions\AssignDocumentType;
use App\Nova\Actions\AssignToItem;
use App\Nova\Actions\Enable;
use App\Nova\Actions\ExportItems;
use App\Nova\Actions\ExportPcf;
use App\Nova\Actions\ImportItems;
use App\Nova\Actions\ImportPages;
use App\Nova\Actions\PcfActions;
use App\Nova\Filters\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Item extends Resource
{
    public static $group = 'Documents';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Item::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    public static function usesScout(): bool
    {
        return false;
    }

    public static $indexDefaultOrder = [
        'item_id' => 'ASC',
        'order' => 'ASC',
    ];

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];

            return $query->orderBy(key(static::$indexDefaultOrder), reset(static::$indexDefaultOrder));
        }

        return $query;
    }

    public static $with = ['item', 'type'];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Boolean::make('Enabled')->sortable(),
            ID::make(__('ID'), 'id')->sortable(),
            Date::make('Last Imported', 'imported_at')->sortable(),
            Text::make(__('Name'), 'name')->help('Field is overwritten on import')->sortable(),
            BelongsTo::make('Type')->sortable(),
            Date::make('Date', 'sort_date')->sortable(),

            Text::make('Preview', function ($item) {
                if ($item->uuid) {
                    return '<a href="'.route('documents.show', ['item' => $item->uuid]).'" class="no-underline dim text-primary font-bold" target="_preview">Preview</a>';
                }
            })->asHtml(),
            Text::make('Short', function () {
                if ($this->hashid()) {
                    return '<span data-url="'.route('short-url.item', ['hashid' => $this->hashid()]).'" class="no-underline dim text-primary font-bold" onclick="copyShortUrlToClipboard(this)">Short</a>';
                } else {
                    return '';
                }
            })->asHtml(),
            HasMany::make('Items')
                ->hideFromIndex(),
            HasMany::make('Pages')
                ->hideFromIndex(),
            MorphToMany::make(__('Events'))
                ->hideFromIndex(),
            BelongsTo::make('Item')
                ->nullable()
                ->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request): array
    {
        return [
            new Status,
            new \App\Nova\Filters\Type,
            new \App\Nova\Filters\LastImported,
        ];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(Request $request): array
    {
        $actions = [
            new AssignDocumentType,
            new AssignToItem,
            new Enable,
            (new ExportItems())->askForWriterType(),
            new ImportPages,
            new ImportItems,
            // new ImportPcf,
            new ExportPcf(),
            // new ImportFtpMetadataExport(),
        ];

        if (auth()->id() === 1) {
            $actions[] = new PcfActions();
        }

        return $actions;
    }
}
