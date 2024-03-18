<?php

namespace App\Livewire\DocumentDashboard;

use App\Models\Item;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public Item $item;

    public array $sections;

    public $tab = 'overview';

    public function mount()
    {

    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $this->item
            ->loadMissing([
                'quotes.topics',
                'firstPage',
                'values',
                'values.property',
                'values.source',
                'values.repository',
            ]);

        return view('livewire.document-dashboard.overview', [

        ])
            ->layout('layouts.guest');
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
