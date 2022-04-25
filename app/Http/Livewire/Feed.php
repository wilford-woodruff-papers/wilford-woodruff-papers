<?php

namespace App\Http\Livewire;

use App\Models\Press;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Maize\Markable\Models\Like;

class Feed extends Component
{

    public $perPage = 10;

    public function render()
    {
        $articles = Press::query()
                            ->select('id', 'type', 'title', 'cover_image', 'slug', 'date', 'subtitle')
                            ->orderBy('created_at', 'DESC')
                            ->paginate($this->perPage);

        return view('livewire.feed', [
            'articles' => $articles,
        ])
            ->layout('layouts.guest');
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }


    public function login()
    {
        session(['url.intended' => route('landing-areas.ponder')]);

        return redirect()->route('login');
    }

    public function toggleLike($id)
    {
        Like::toggle(Press::find($id), Auth::user());
    }

}
