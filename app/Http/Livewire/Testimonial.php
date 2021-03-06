<?php

namespace App\Http\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Testimonial extends ModalComponent
{
    public $testimonial;

    public function mount($testimonial)
    {
        $this->testimonial = \App\Models\Testimonial::findOrFail($testimonial);
    }

    public function render()
    {
        return view('livewire.testimonial');
    }
}
