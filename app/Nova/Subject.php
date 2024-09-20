<?php

namespace App\Nova;

use App\Nova\Actions\AssignCategory;
use App\Nova\Actions\ExportPeople;
use App\Nova\Actions\ExportSubjects;
use App\Nova\Actions\ExportSubjectsWithChildren;
use App\Nova\Actions\ImportGeolocation;
use App\Nova\Actions\ImportIndexTopics;
use App\Nova\Actions\ImportPeople;
use App\Nova\Actions\ImportSubjects;
use App\Nova\Actions\ParseNames;
use App\Nova\Filters\ParentSubjects;
use App\Nova\Filters\SubjectIsTagged;
use App\Nova\Filters\SubjectType;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Rpj\Daterangepicker\Daterangepicker;

class Subject extends Resource
{
    public static $group = 'Metadata';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Subject::class;

    public static $with = [
        'parent',
        'category',
    ];

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

    public function authorizedToReplicate(Request $request)
    {
        return false;
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make(__('ID'), 'id')
                ->sortable(),
            Text::make(__('Name'), 'name')
                ->sortable(),
            Text::make(__('FTP URL'), 'subject_uri')
                ->displayUsing(function ($value) {
                    return ! empty($value) ? '<a href="'.$value.'" target="_blank" class="link-default">View</a>' : '';
                })
                ->asHtml(),
            Text::make(__('Admin'), 'slug')
                ->displayUsing(function ($value) {
                    if ($this->category->contains('name', 'People')) {
                        return '<a href="'.url('admin/dashboard/people/'.$value.'/edit').'" target="_blank" class="link-default">View</a>';
                    } elseif ($this->category->contains('name', 'Places')) {
                        return '<a href="'.url('admin/dashboard/places/'.$value.'/edit').'" target="_blank" class="link-default">View</a>';
                    } else {
                        return ' ';
                    }
                })
                ->asHtml(),
            Number::make(__('Total'), 'total_usage_count')
                ->readonly()
                ->hideFromIndex(),
            Number::make(__('Tagged'), 'tagged_count')
                ->readonly()
                ->sortable(),
            Text::make('Category', function () {
                return $this->category->pluck('name')->implode(', ');
            })
                ->onlyOnIndex(),
            Text::make(__('Slug'), 'slug')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->sortable(),
            NovaTinyMCE::make('Bio')
                ->asHtml()
                ->alwaysShow(),
            NovaTinyMCE::make('Footnotes')
                ->asHtml()
                ->alwaysShow(),
            BelongsToMany::make('Category'),
            BelongsTo::make('Parent Subject', 'parent', self::class)
                ->nullable()
                ->searchable(),
            Date::make('Created At')
                ->sortable(),
            Date::make('Updated At')
                ->sortable(),
            HasMany::make('Subjects', 'children', self::class),
            BelongsToMany::make('Events'),
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
            (new Daterangepicker(
                'created_at',
                '2019-01-01 to '.now()->addDay(1)->toDateString()
            ))
                ->setRanges([
                    'Today' => [Carbon::today(), Carbon::today()],
                    'Yesterday' => [Carbon::yesterday(), Carbon::yesterday()],
                    'Last 7 days' => [Carbon::today()->subDays(6), Carbon::today()],
                    'This week' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
                    'LAst 30 days' => [Carbon::today()->subDays(29), Carbon::today()],
                    'This month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
                    'Last month' => [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()],
                ]),
            new SubjectType,
            new SubjectIsTagged,
            new ParentSubjects,
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
        return [
            new AssignCategory,
            new ImportIndexTopics,
            new ImportSubjects,
            new ImportPeople,
            //new ImportBiographies,
            new ImportGeolocation,
            (new ExportSubjects)
                ->askForWriterType(),
            (new ExportPeople)
                ->askForWriterType(),
            (new ExportSubjectsWithChildren)
                ->askForWriterType(),
            new ParseNames,
        ];
    }
}
