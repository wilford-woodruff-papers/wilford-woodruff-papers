<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Comments extends Component
{
    public $model;

    public $comment;

    protected $rules = [
        'comment' => 'required|max:1024',
    ];

    public function mount($model)
    {
        $model->load('comments');
        $this->model = $model;
    }
    public function render()
    {
        return view('livewire.comments');
    }

    public function save()
    {
        $this->validate();

        $comment = new Comment;
        $comment->comment = $this->comment;

        $comment->user()->associate(Auth::user());

        $this->model->comments()->save($comment);
        $this->model->refresh();
        $this->comment = '';
    }
}
