<?php

namespace App\Http\Livewire\Admin;

use App\Models\AdminComment;
use Livewire\Component;

class Comment extends Component
{

    public AdminComment $comment;

    public function render()
    {
        return view('livewire..admin.comment');
    }

    public function delete()
    {
        $this->comment->delete();
        $this->emitUp('commentDeleted');
    }
}
