<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;

class FullScreenVideo extends ModalComponent
{
    public $url;

    public function mount($url)
    {
        $this->url = $url;

    }

    public function render()
    {
        return view('livewire.full-screen-video');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    protected static array $maxWidths = [
        '7xl' => 'max-w-7xl',
    ];
}
