<?php

namespace App\Http\Livewire;

use App\Models\BoardMember;
use LivewireUI\Modal\ModalComponent;

class TeamMemberModal extends ModalComponent
{
    public $backgroundColor;

    public $person;

    public $textColor;

    public function mount($person, $backgroundColor, $textColor)
    {
        $this->backgroundColor = $backgroundColor;
        $this->person = BoardMember::find($person);
        $this->textColor = $textColor;
    }

    public function render()
    {
        return view('livewire.meet-the-team.person');
    }

    public static function modalMaxWidth(): string
    {
        return '3xl';
    }

    protected static array $maxWidths = [
        '3xl' => 'max-w-3xl',
    ];
}
