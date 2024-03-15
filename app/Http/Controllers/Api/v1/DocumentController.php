<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
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

        $items = Item::query()
            ->whereNotNull('type_id')
            ->whereNull('item_id')
            ->with([
                'type',
                'firstPage',
                'firstPage.media',
            ]);

        if ($request->has('types')) {
            $types = [];
            foreach ($request->get('types') as $type) {
                abort_if(! isset($this->typesMap[$type]), 422, 'Invalid type: '.$type);
                if (isset($this->typesMap[$type])) {
                    $types = array_merge($types, $this->typesMap[$type]);
                }
            }

            $items = $items->whereRelation('type', function (Builder $query) use ($types) {
                $query->whereIn('name', $types);
            });
        }

        if ($request->has('q')) {
            $items = $items->where('name', 'like', '%'.$request->get('q').'%');
        }

        $items = $items->paginate(
            min($request->get('per_page', 100), 500)
        );

        $items->setCollection(collect($items->items())->map(function ($item) {
            return [
                'id' => $item->id,
                'uuid' => $item->uuid,
                'type' => $item->type?->name,
                'name' => $item->name,
                'links' => [
                    'frontend_url' => route('documents.show', ['item' => $item->uuid]),
                    'api_url' => route('api.documents.show', ['item' => $item->uuid]),
                    'images' => [
                        'thumbnail_url' => $item->firstPage?->getFirstMedia()?->getUrl('thumb'),
                        'original_url' => $item->firstPage?->getFirstMedia()?->getUrl(),
                    ],
                ],
            ];
        }));

        return response()->json(
            $items
        );
    }

    public function show(Request $request, Item $item)
    {
        abort_unless($request->ajax() || $request->user()->tokenCan('read'), 401);

        return [
            'id' => $item->id,
            'uuid' => $item->uuid,
            'type' => $item->type?->name,
            'name' => $item->name,
            'links' => [
                'frontend_url' => route('documents.show', ['item' => $item->uuid]),
                'api_url' => route('api.documents.show', ['item' => $item->uuid]),
                'images' => [
                    'thumbnail_url' => $item->firstPage?->getFirstMedia()?->getUrl('thumb'),
                    'original_url' => $item->firstPage?->getFirstMedia()?->getUrl(),
                ],
            ],
            'pages' => $item->pages->map(function ($page) {
                return [
                    'id' => $page->id,
                    'uuid' => $page->uuid,
                    'type' => $page->parent?->type?->name,
                    'full_name' => $page->full_name,
                    'name' => $page->name,
                    'transcript' => $page->transcript,
                    'text' => strip_tags($page->transcript),
                ];
            }),
        ];
    }

    public function export(Request $request)
    {
        abort_unless($request->user()->tokenCan('read'), 401);

        return Storage::disk('exports')
            ->download('documents-export.csv', now('America/Denver')->toDateString().'-documents-export.csv');
    }
}
