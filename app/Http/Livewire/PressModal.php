<?php

namespace App\Http\Livewire;

use App\Models\Press;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;
use Maize\Markable\Models\Like;

class PressModal extends ModalComponent
{
    public $press;

    public function mount($press)
    {
        if(is_integer($press)){
            $this->press = Press::find($press);
        }else{
            $this->press = Press::where('slug', $press)->first();
        }
    }

    public function render()
    {
        return view('livewire.press-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    protected static array $maxWidths = [
        '7xl' => 'max-w-7xl',
    ];

    public function login()
    {
        session(['url.intended' => route('landing-areas.ponder')]);

        return redirect()->route('login');
    }

    public function toggleLike($id)
    {
        Like::toggle($press = Press::find($id), Auth::user());
        $press->total_likes = Like::count($press);
        $press->last_liked_at = now();
        $press->save();
    }
}
