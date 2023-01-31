<?php

namespace App\Http\Livewire\Admin\Documents;

use App\Models\Item;
use App\Models\Type;
use Livewire\Component;

class NewDocument extends Component
{
    public Item $item;

    public $type;

    public $template;

    public $templates;

    public function mount()
    {
        $this->item = new Item();

        $this->types = Type::query()
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function render()
    {
        if (! empty($this->type)) {
            $this->template = type::query()->find($this->type)->template;
        } else {
            $this->template = null;
        }

        return view('livewire.admin.documents.new-document', [

        ])
            ->layout('layouts.admin');
    }
}
