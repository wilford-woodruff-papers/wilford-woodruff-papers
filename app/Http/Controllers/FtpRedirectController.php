<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Page;
use App\Models\Subject;
use Illuminate\Http\Request;

class FtpRedirectController extends Controller
{
    /**
     * Handle the incoming request.
     * https://wilford-woodruff-papers.test/ftp/redirect?page_id=1590322&view=public
     * https://wilford-woodruff-papers.test/ftp/redirect?page_id=1590322&view=tasks
     * https://wilford-woodruff-papers.test/ftp/redirect?page_id=1590322&view=research
     */
    public function __invoke(Request $request)
    {
        if ($request->has('item_id')) {
            $itemId = str($request->get('item_id'))
                ->before('/');
            $item = Item::query()
                ->where('ftp_slug', $itemId)
                ->firstOrFail();

            return $this->getRoute('item', $request->get('view'), ['item' => $item]);
        }

        if ($request->has('page_id')) {
            $pageId = str($request->get('page_id'))
                ->before('?')
                ->before('/');
            $page = Page::query()
                ->with([
                    'item',
                ])
                ->where('ftp_link', 'https://fromthepage.com/display/display_page?page_id='.$pageId)
                ->firstOrFail();

            return $this->getRoute('page', $request->get('view'), ['page' => $page]);
        }

        if ($request->has('subject_id')) {
            $subjectId = str($request->get('subject_id'))
                ->before('?')
                ->before('/');
            $subject = Subject::query()
                ->with([
                    'category',
                ])
                ->where('subject_uri', 'LIKE', '%/article/'.$subjectId)
                ->firstOrFail();

            return $this->getRoute('subject', $request->get('view'), ['subject' => $subject]);
        }
    }

    private function getRoute($type, $route, $params = [])
    {
        switch ($type) {
            case 'item':
                return match ($route) {
                    'public' => redirect()->route('short-url.item', ['hashid' => $params[$type]->hashid()]),
                    'tasks' => redirect()->route('admin.dashboard.document', ['item' => $params[$type]->uuid]),
                    'research' => redirect()->route('admin.dashboard.document.edit', ['item' => $params[$type]->uuid]),
                    default => route('home')
                };
            case 'page':
                return match ($route) {
                    'public' => redirect()->route('short-url.page', ['hashid' => $params[$type]->hashid()]),
                    'tasks' => redirect()->route('admin.dashboard.document', ['item' => $params[$type]->item?->uuid]),
                    'research' => redirect()->route('admin.dashboard.document.edit', ['item' => $params[$type]->item?->uuid]),
                    default => route('home')
                };
            case 'subject':
                if (in_array('People', $params[$type]->category->pluck('name')->values()->toArray())) {
                    return match ($route) {
                        'public' => redirect()->route('subjects.show', ['subject' => $params[$type]->slug]),
                        'research' => redirect()->route('admin.dashboard.people.edit', ['person' => $params[$type]->slug]),
                        default => route('home')
                    };
                } elseif (in_array('Places', $params[$type]->category->pluck('name')->values()->toArray())) {
                    return match ($route) {
                        'public' => redirect()->route('subjects.show', ['subject' => $params[$type]->slug]),
                        'research' => redirect()->route('admin.dashboard.places.edit', ['place' => $params[$type]->slug]),
                        default => route('home')
                    };
                }

        }

    }
}
