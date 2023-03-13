<?php

namespace App\Http\Livewire\Admin\Documents;

use App\Models\Item;
use App\Models\Type;
use Livewire\Component;

class NewDocument extends Component
{
    public Item $item;

    public $section_count = 0;

    public $type;

    public $template;

    public $templates;

    public $prefixes;

    public function mount()
    {
        $this->item = new Item();

        $this->types = Type::query()
            ->whereNull('type_id')
            ->orderBy('name', 'ASC')
            ->get();

        $this->prefixes = [
            'Additional' => [
                'Business/Financial' => 'B',
                'Community' => 'C',
                'Education' => 'E',
                'Family' => 'F',
                'Genealogy' => 'G',
                'Histories' => 'H',
                'Legal' => 'L',
                'Mission' => 'M',
                'Political/Government' => 'P',
                'Temple' => 'T',
                'Religious' => 'R',
            ],
            'Autobiographies' => 'A',
            'Daybooks' => 'DB',
            'Discourses' => 'D',
            'Journal Sections' => 'J',
            'Letters' => 'LE',
        ];
    }

    public function render()
    {
        if (! empty($this->type)) {
            $this->template = Type::query()->find($this->type)->template;
        } else {
            $this->template = null;
        }

        return view('livewire.admin.documents.new-document', [

        ])
            ->layout('layouts.admin');
    }
}
