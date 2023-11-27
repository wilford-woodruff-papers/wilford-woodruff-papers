<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;

class Page extends ModalComponent
{
    public int $pageId;

    public function render()
    {
        $page = \App\Models\Page::firstWhere('id', $this->pageId);
        $item = $page->parent;

        return view('livewire.page', [
            'item' => $item,
            'page' => $page,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'full';
    }

    protected static array $maxWidths = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-md md:max-w-lg',
        'xl' => 'sm:max-w-md md:max-w-xl',
        '2xl' => 'sm:max-w-md md:max-w-xl lg:max-w-2xl',
        '3xl' => 'sm:max-w-md md:max-w-xl lg:max-w-3xl',
        '4xl' => 'sm:max-w-md md:max-w-xl lg:max-w-3xl xl:max-w-4xl',
        '5xl' => 'sm:max-w-md md:max-w-xl lg:max-w-3xl xl:max-w-5xl',
        '6xl' => 'sm:max-w-md md:max-w-xl lg:max-w-3xl xl:max-w-5xl 2xl:max-w-6xl',
        '7xl' => 'sm:max-w-md md:max-w-xl lg:max-w-3xl xl:max-w-5xl 2xl:max-w-7xl',
        'full' => 'max-w-[94%]',
    ];
}
