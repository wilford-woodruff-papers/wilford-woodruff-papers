<?php

namespace App\Http\Livewire;

use LivewireUI\Modal\ModalComponent;

class PhotoViewer extends ModalComponent
{
    public $url;

    public function render()
    {
        return view('livewire.photo-viewer', [
            'photo' => str($this->url)
                ->replace('-thumb', '-web'),
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    protected static array $maxWidths = [
        '7xl' => 'sm:max-w-5xl',
    ];
}
