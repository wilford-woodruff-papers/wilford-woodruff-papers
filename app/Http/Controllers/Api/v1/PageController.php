<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pages = Page::query();

        $pages->with([
            'dates',
            'people',
            'places',
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

        return response()->json(
            $pages->paginate(
                min($request->get('per_page', 100), 500)
            )
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return $page;
    }

    public function export()
    {
        return Storage::disk('exports')
            ->download('pages-export.xlsx');
    }
}
