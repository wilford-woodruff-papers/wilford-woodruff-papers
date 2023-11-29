<?php

namespace App\Http\Livewire\Documents;

use App\Models\Item;
use App\Models\Page;
use App\Models\Property;
use App\Models\Value;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public array $filters = [
        'search' => '',
        'section' => null,
    ];

    public Item $item;

    public $sourceNotes = null;

    public $sourceLink = null;

    protected $queryString = ['filters'];

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function mount(Item $item)
    {
        $this->item = $item;

        if (! empty($this->item->item_id)) {
            return redirect()->route('documents.show', ['item' => $this->item->item]);
        }

        $sourceNotesProperty = Property::query()
            ->firstWhere('slug', 'source-notes-displays-publicly');

        if ($sourceNotesProperty) {
            $this->sourceNotes = Value::query()
                ->where('item_id', $item->id)
                ->where('property_id', $sourceNotesProperty->id)
                ->whereNotNull('value')
                ->first();
        }

        $sourceLinkProperty = Property::query()
            ->whereIn('slug', [
                'pdfimage',
                'source-link',
            ])->get();

        if ($sourceLinkProperty) {
            $this->sourceLink = Value::query()
                ->where('item_id', $item->id)
                ->whereIn('property_id', $sourceLinkProperty->pluck('id')->all())
                ->whereNotNull('value')
                ->first();
        }
    }

    public function render()
    {
        $pages = Page::with(['dates', 'subjects' => function ($query) {
            $query->whereHas('category', function (Builder $query) {
                $query->whereIn('categories.name', ['People', 'Places']);
            });
        }, 'topics', 'parent', 'item'])
            ->withCount('quotes')
            ->where('parent_item_id', $this->item->id)
            ->when(data_get($this->filters, 'search'), function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->where('name', 'LIKE', '%'.$q.'%')
                        ->orWhere('transcript', 'LIKE', '%'.$q.'%');
                });
            })
            ->when(data_get($this->filters, 'section'), function ($query, $q) {
                $query->where('item_id', $this->filters['section']);
            })
            ->ordered();

        //$this->item->setRelation('item', $this->item);
        $this->item->setRelation('pages', $pages);

        $subjects = collect([]);
        $topics = collect([]);
        $this->item->pages->each(function ($page) use (&$subjects, &$topics) {
            $subjects = $subjects->merge($page->subjects->all());
            $topics = $topics->merge($page->topics->all());
        });
        $subjects = $subjects->unique('id');
        $topics = $topics->unique('id');

        return view('livewire.documents.show', [
            'pages' => $pages->paginate(20),
            'subjects' => $subjects,
            'topics' => $topics,
        ])
            ->layout('layouts.guest');
    }

    public function submit()
    {
        //$this->validate();

        $this->render();
    }
}
