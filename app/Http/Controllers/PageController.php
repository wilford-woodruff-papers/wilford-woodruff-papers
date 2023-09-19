<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Page;
use App\Models\Property;
use App\Models\Value;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(Item $item, Page $page): View
    {
        $item = $item->parent();
        $page->load([
            'parent.type',
            'translations',
            'dates',
            'topics',
            'subjects' => function ($query) {
                $query->whereHas('category', function (Builder $query) {
                    $query->whereIn('categories.name', ['People', 'Places']);
                });
            },
        ]);

        $sourceNotes = null;
        $sourceNotesProperty = Property::query()
            ->firstWhere('slug', 'source-notes-displays-publicly');

        if ($sourceNotesProperty) {
            $sourceNotes = Value::query()
                ->where('item_id', $item->id)
                ->where('property_id', $sourceNotesProperty->id)
                ->whereNotNull('value')
                ->first();
        }

        $sourceLink = null;
        $sourceLinkProperty = Property::query()
            ->whereIn('slug', [
                'pdfimage',
                'source-link',
            ])->get();

        if ($sourceLinkProperty) {
            $sourceLink = Value::query()
                ->where('item_id', $item->id)
                ->whereIn('property_id', $sourceLinkProperty->pluck('id')->all())
                ->whereNotNull('value')
                ->first();
        }

        return view('public.pages.show', [
            'item' => $item,
            'page' => $page,
            'pages' => collect([]),
            'sourceNotes' => $sourceNotes,
            'sourceLink' => $sourceLink,
        ]);
    }

    public function preview(Item $item, Page $page): View
    {
        $item = $item->parent();
        $page->load([
            'parent.type',
            'translations',
            'dates',
            'topics',
            'subjects' => function ($query) {
                $query->whereHas('category', function (Builder $query) {
                    $query->whereIn('categories.name', ['People', 'Places']);
                });
            },
        ]);

        $sourceNotes = null;
        $sourceNotesProperty = Property::query()
            ->firstWhere('slug', 'source-notes-displays-publicly');

        if ($sourceNotesProperty) {
            $sourceNotes = Value::query()
                ->where('item_id', $item->id)
                ->where('property_id', $sourceNotesProperty->id)
                ->whereNotNull('value')
                ->first();
        }

        $sourceLink = null;
        $sourceLinkProperty = Property::query()
            ->whereIn('slug', [
                'pdfimage',
                'source-link',
            ])->get();

        if ($sourceLinkProperty) {
            $sourceLink = Value::query()
                ->where('item_id', $item->id)
                ->whereIn('property_id', $sourceLinkProperty->pluck('id')->all())
                ->whereNotNull('value')
                ->first();
        }

        return view('public.pages.preview', [
            'item' => $item,
            'page' => $page,
            'pages' => collect([]),
            'sourceNotes' => $sourceNotes,
            'sourceLink' => $sourceLink,
        ]);
    }
}
