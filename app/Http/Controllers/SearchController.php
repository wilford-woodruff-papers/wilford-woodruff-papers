<?php

namespace App\Http\Controllers;

use App\Models\Date;
use App\Models\Page;
use App\Models\Subject;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (auth()->check() && auth()->user()->hasAnyRole(['CFM Researcher'])) {
            $enabled = [0, 1];
        } else {
            $enabled = [1];
        }

        $pages = Page::query()->with('dates', 'media', 'parent');
        $pages = $pages->with([
            'item.type',
            'parent.type',
            'media',
            'dates',
            'people',
            'places',
        ])
            ->withCount([
                'quotes',
            ])
            ->whereHas('item', function (Builder $query) use ($enabled) {
                $query->whereIn('enabled', $enabled);
            });

        if ($request->has('q') && $request->get('q') != '*') {
            $pages = $pages->where(function ($query) use ($request) {
                $query->whereRelation('item', 'name', 'LIKE', '%'.$request->get('q').'%')
                                      ->orWhere('transcript', 'LIKE', '%'.$request->get('q').'%');
            });
        }

        if ($request->has('types')) {
            $pages = $pages->whereIn('type_id', $request->get('types'));
        }

        if ($request->get('use_min_date') == 'true' && $request->has('min_date') && $request->get('use_max_date') == 'true' && $request->has('max_date')) {
            $pages = $pages->whereHas('dates', function (Builder $query) use ($request) {
                $query->whereBetween('dates.date', [$request->get('min_date'), $request->get('max_date')]);
            });
        } else {
            if ($request->get('use_min_date') == 'true' && $request->has('min_date')) {
                $pages = $pages->whereHas('dates', function (Builder $query) use ($request) {
                    $query->where('dates.date', '>=', $request->get('min_date'));
                });
            }

            if ($request->get('use_max_date') == 'true' && $request->has('max_date')) {
                $pages = $pages->whereHas('dates', function (Builder $query) use ($request) {
                    $query->where('dates.date', '<=', $request->get('max_date'));
                });
            }
        }

        if ($request->has('q') || $request->has('types') || $request->has('min_date') || $request->has('max_date')) {
            try {
                activity('search')
                    ->event('search')
                    ->withProperties(array_merge(
                        ['types' => Type::whereIn('id', $request->get('types'))->pluck('name')->all()],
                        $request->except('types'),
                        ['referrer' => $request->headers->get('referer')],
                        ['user_agent' => $request->server('HTTP_USER_AGENT')],
                    ))
                    ->log((! empty($request->get('q')) ? $request->get('q') : '*'));
            } catch (\Exception $e) {
                logger()->error($e->getMessage());
            }
        }

        if ($request->has('people') && ! empty($request->get('q'))) {
            $people = Subject::query()
                                ->whereEnabled(1)
                                ->where('tagged_count', '>', 0)
                                ->whereHas('category', function (Builder $query) {
                                    $query->where('name', 'People');
                                });
            $names = str($request->get('q'))->explode(' ');
            foreach ($names as $name) {
                $people = $people->where('name', 'LIKE', '%'.str($name)->trim('.').'%');
            }
            $people = $people->get();
        } else {
            $people = collect();
        }

        return view('public.search', [
            'types' => Type::where('name', 'NOT LIKE', '%Sections%')->get(),
            'pages' => $pages->paginate(20),
            'dates' => [
                'min' => Date::where('dateable_type', Page::class)->orderBy('date', 'ASC')->firstOr(function () {
                    return new Date(['date' => '1800-01-01']);
                }),
                'max' => Date::where('dateable_type', Page::class)->orderBy('date', 'DESC')->firstOr(function () {
                    return new Date(['date' => '1900-01-01']);
                }),
            ],
            'people' => $people,
        ]);
    }
}
