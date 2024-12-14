<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public $typesMap = [
        'Letters' => ['Letters'],
        'Discourses' => ['Discourses'],
        'Journals' => ['Journals', 'Journal Sections'],
        'Additional' => ['Additional', 'Additional Sections'],
        'Autobiographies' => ['Autobiography Sections', 'Autobiographies'],
        'Daybooks' => ['Daybooks', 'Daybook Sections'],
    ];

    public function index(Request $request)
    {
        abort_unless($request->ajax() || $request->user()->tokenCan('read'), 401);

        $pages = Page::query()->whereRelation('item', function (Builder $query) {
            $query->whereNotNull('type_id');
        });

        $pages->with([
            'parent.type',
            'taggedDates',
            'people' => function ($query) {
                $query->select([
                    'id',
                    DB::raw('pid as family_search_id'),
                    'slug',
                    'name',
                    'first_name',
                    'middle_name',
                    'last_name',
                    'suffix',
                    'alternate_names',
                    'maiden_name',
                    'bio',
                    'footnotes',
                    'created_at',
                    'updated_at',
                    'total_usage_count',
                    'reference',
                    'relationship',
                    'birth_date',
                    'baptism_date',
                    'death_date',
                    'life_years',
                ]);
            },
            'places' => function ($query) {
                $query->select([
                    'id',
                    'slug',
                    'name',
                    'address',
                    'country',
                    'state_province',
                    'county',
                    'city',
                    'specific_place',
                    'modern_location',
                    'latitude',
                    'longitude',
                    'created_at',
                    'updated_at',
                    'total_usage_count',
                    'reference',
                    'visited',
                    'mentioned',
                ]);
            },
            'media',
        ]);

        if ($request->has('types')) {
            $types = [];
            foreach ($request->get('types') as $type) {
                abort_if(! isset($this->typesMap[$type]), 422, 'Invalid type: '.$type);
                if (isset($this->typesMap[$type])) {
                    $types = array_merge($types, $this->typesMap[$type]);
                }
            }

            $pages = $pages->whereRelation('item.type', function (Builder $query) use ($types) {
                $query->whereIn('name', $types);
            });
        }

        $pages = $pages->paginate(
            min($request->get('per_page', 100), 500)
        );

        $pages->setCollection(collect($pages->items())->map(function ($page) {
            return [
                'id' => $page->id,
                'uuid' => $page->uuid,
                'hash' => $page->hashId(),
                'type' => $page->parent?->type?->name,
                'full_name' => $page->full_name,
                'name' => $page->name,
                'transcript' => $page->transcript,
                'text' => strip_tags($page->transcript),
                'web_transcript' => $page->text(isQuoteTagger: false),
                'links' => [
                    'frontend_url' => route('pages.show', ['item' => $page->parent->uuid, 'page' => $page->uuid]),
                    'short_url' => route('short-url.page', ['hashid' => $page->hashId()]),
                    'api_url' => route('api.pages.show', ['page' => $page->uuid]),
                    'images' => [
                        'thumbnail_url' => $page->getFirstMedia()?->getUrl('thumb'),
                        'web_url' => $page->getFirstMedia()?->getUrl('web'),
                        'original_url' => $page->getFirstMedia()?->getUrl(),
                    ],
                ],
            ];
        }));

        return response()->json(
            $pages
        );
    }

    public function show(Request $request, Page $page)
    {
        abort_unless($request->ajax() || $request->user()->tokenCan('read'), 401);

        return response()->json([
            'id' => $page->id,
            'uuid' => $page->uuid,
            'hash' => $page->hashId(),
            'type' => $page->parent?->type?->name,
            'full_name' => $page->full_name,
            'name' => $page->name,
            'transcript' => $page->transcript,
            'text' => strip_tags($page->transcript),
            'web_transcript' => $page->text(isQuoteTagger: false),
            'dates' => $page->taggedDates,
            'people' => $page->people->map(function ($item) {
                return [
                    'id' => $item->id,
                    'family_search_id' => $item->pid,
                    'slug' => $item->slug,
                    'name' => $item->name,
                    'first_name' => $item->first_name,
                    'middle_name' => $item->middle_name,
                    'last_name' => $item->last_name,
                    'suffix' => $item->suffix,
                    'alternate_names' => $item->alternate_names,
                    'maiden_name' => $item->maiden_name,
                    'bio' => $item->bio,
                    'footnotes' => $item->footnotes,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'total_usage_count' => $item->total_usage_count,
                    'reference' => $item->reference,
                    'relationship' => $item->relationship,
                    'birth_date' => $item->birth_date,
                    'baptism_date' => $item->baptism_date,
                    'death_date' => $item->death_date,
                    'life_years' => $item->life_years,
                ];
            }),
            'places' => $page->places->map(function ($item) {
                return [
                    'id' => $item->id,
                    'slug' => $item->slug,
                    'name' => $item->name,
                    'address' => $item->address,
                    'country' => $item->country,
                    'state_province' => $item->state_province,
                    'county' => $item->county,
                    'city' => $item->city,
                    'specific_place' => $item->specific_place,
                    'modern_location' => $item->modern_location,
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'total_usage_count' => $item->total_usage_count,
                    'reference' => $item->reference,
                    'visited' => $item->visited,
                    'mentioned' => $item->mentioned,
                ];
            }),
            'links' => [
                'frontend_url' => route('pages.show', ['item' => $page->parent->uuid, 'page' => $page->uuid]),
                'short_url' => route('short-url.page', ['hashid' => $page->hashId()]),
                'api_url' => route('api.pages.show', ['page' => $page->uuid]),
                'images' => [
                    'thumbnail_url' => $page->getFirstMedia()?->getUrl('thumb'),
                    'web_url' => $page->getFirstMedia()?->getUrl('web'),
                    'original_url' => $page->getFirstMedia()?->getUrl(),
                ],
            ],
        ]);
    }

    public function export(Request $request)
    {
        abort_unless($request->user()->tokenCan('read'), 401);

        return Storage::disk('exports')
            ->download('pages-export.csv', now('America/Denver')->toDateString().'-pages-export.csv');
    }
}
