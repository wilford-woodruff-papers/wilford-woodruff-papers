<?php

namespace App\Livewire\DocumentDashboard;

use App\Models\Page;
use App\Models\Subject;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class People extends Component
{
    public int $itemId;

    public Collection $people;

    public string $category = '';

    public string $column = 'name';

    public string $direction = 'asc';

    public array $categories = [];

    public function render()
    {
        $this->getPeople();

        foreach ($this->people as $person) {
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

        $colors = [
            'rgba(11, 40, 54, .1)',
            'rgba(11, 40, 54, .2)',
            'rgba(11, 40, 54, .3)',
            'rgba(11, 40, 54, .4)',
            'rgba(11, 40, 54, .5)',
            'rgba(11, 40, 54, .6)',
            'rgba(11, 40, 54, .7)',
            'rgba(11, 40, 54, .8)',
            'rgba(11, 40, 54, .9)',
            '#0B2836',
        ];

        foreach ($this->categories as $category => $count) {
            $peopleCategoryChart
                ->setOpacity(100)
                ->addSlice($category, $count, array_pop($colors));
        }

        return view('livewire.document-dashboard.sections.people', [
            'peopleCategoryChart' => $peopleCategoryChart,
        ]);
    }

    #[On('filterPeopleByCategory')]
    public function filterPeopleByCategory($title)
    {
        if ($this->category === $title) {
            $this->category = '';
        } else {
            $this->category = $title;
        }

        $this->getPeople();
    }

    public function getPeople()
    {
        $people = Subject::query()
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
                        ->where('parent_item_id', $this->itemId)
                        ->pluck('id')
                        ->toArray()
                );
            });

        if ($this->column === 'name') {
            $people = $people
                ->orderBy('last_name', $this->direction)
                ->orderBy('name', $this->direction);
        } else {
            $people = $people->orderBy('tagged_count', $this->direction);
        }

        $this->people = $people->get();
    }

    public function toggleSort($column)
    {
        if ($this->column !== $column) {
            $this->direction = 'asc';
            $this->column = $column;
        } else {
            $this->direction = ($this->direction === 'asc') ? 'desc' : 'asc';
        }
    }
}
