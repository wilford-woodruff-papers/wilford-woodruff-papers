<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Page;
use App\Models\Subject;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Livewire\Attributes\On;
use Livewire\Component;

class DocumentDashboard extends Component
{
    public Item $item;

    public array $sections;

    public string $category = '';

    public array $categories = [];

    public function mount()
    {
        $this->item
            ->loadMissing([
                'quotes.topics',
            ])
            ->setRelation('people', Subject::query()
                ->with([
                    'category',
                ])
                ->people()
                ->when($this->category, function ($query, $category) {
                    $query->whereHas('category', function ($query) use ($category) {
                        $query->where('name', $category);
                    });
                })
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('last_name', 'ASC')
                ->orderBy('name', 'ASC')
                ->get())

            ->setRelation('places', Subject::query()
                ->with([
                    'category',
                ])
                ->places()
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('name', 'ASC')
                ->get())

            ->setRelation('topics', Subject::query()
                ->with([
                    'category',
                ])
                ->index()
                ->whereNull('subject_id')
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('name', 'asc', SORT_NATURAL | SORT_FLAG_CASE)
                ->get());

        foreach ($this->item->people as $person) {
            foreach ($person->category as $category) {
                if (in_array($category->name, ['People'])) {
                    continue;
                }
                if (! array_key_exists($category->name, $this->categories)) {
                    $this->categories[$category->name] = 0;
                }
                $this->categories[$category->name]++;
            }
        }

    }

    public function render()
    {
        $peopleCategoryChart = (new PieChartModel())
            ->asPie()
            ->setTitle('People Categories')
            ->setAnimated(false)
            ->setLegendPosition('top')
            ->setDataLabelsEnabled(true)
            ->withoutLegend()
            ->setJsonConfig([
                'tooltip.y.formatter' => 'function (val) { return val + " people"; }',
            ])
            ->withOnSliceClickEvent('filterPeopleByCategory');
        $colors = ['rgba(11, 40, 54, .1)', 'rgba(11, 40, 54, .2)', 'rgba(11, 40, 54, .3)', 'rgba(11, 40, 54, .4)', 'rgba(11, 40, 54, .5)', 'rgba(11, 40, 54, .6)', 'rgba(11, 40, 54, .7)', 'rgba(11, 40, 54, .8)', '#0B2836'];

        foreach ($this->categories as $category => $count) {
            $peopleCategoryChart
                ->setOpacity(100)
                ->addSlice($category, $count, array_pop($colors));
        }

        return view('livewire.document-dashboard.overview', [
            'peopleCategoryChart' => $peopleCategoryChart,
        ])
            ->layout('layouts.guest');
    }

    #[On('filterPeopleByCategory')]
    public function filterPeopleByCategory($title)
    {
        if ($this->category === $title) {
            $this->category = '';
        } else {
            $this->category = $title;
        }

        $this->item
            ->loadMissing([
                'quotes.topics',
            ])
            ->setRelation('people', Subject::query()
                ->with([
                    'category',
                ])
                ->people()
                ->when($this->category, function ($query, $category) {
                    $query->whereHas('category', function ($query) use ($category) {
                        $query->where('name', $category);
                    });
                })
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('last_name', 'ASC')
                ->orderBy('name', 'ASC')
                ->get())

            ->setRelation('places', Subject::query()
                ->with([
                    'category',
                ])
                ->places()
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('name', 'ASC')
                ->get())

            ->setRelation('topics', Subject::query()
                ->with([
                    'category',
                ])
                ->index()
                ->whereNull('subject_id')
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('name', 'asc', SORT_NATURAL | SORT_FLAG_CASE)
                ->get());
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="flex w-full aspect-[16/9] items-center justify-center">
            <x-heroicon-o-arrow-path class="w-16 h-16 text-gray-400 animate-spin" />
        </div>
        HTML;
    }
}
