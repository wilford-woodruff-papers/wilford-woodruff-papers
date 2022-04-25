<?php

namespace App\Http\Livewire;

use App\Models\Press;
use Livewire\Component;

class Feed extends Component
{

    public $perPage = 10;

    public function render()
    {
        $articles = Press::paginate($this->perPage);

        return view('livewire.feed', [
            'articles' => $articles,
        ])
            ->layout('layouts.guest');
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }
}
