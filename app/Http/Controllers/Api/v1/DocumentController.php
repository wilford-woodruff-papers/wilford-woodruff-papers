<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
        $items = Item::query()
            ->whereNull('item_id');

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

        return response()->json(
            $items->paginate(
                min($request->get('per_page', 100), 500)
            )
        );
    }

    public function show(Item $item)
    {
        return [
            'id' => $item->id,
            'uuid' => $item->uuid,
            'name' => $item->name,
            'links' => [
                'frontend_url' => route('documents.show', ['item' => $item->uuid]),
                'api_url' => route('api.documents.show', ['item' => $item->uuid]),
                'images' => [
                    'thumbnail_url' => $item->firstPage?->getFirstMedia()?->getUrl('thumb'),
                    'original_url' => $item->firstPage?->getFirstMedia()?->getUrl(),
                ],
            ],
            'pages' => $item->pages,
        ];
    }
}