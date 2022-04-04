<?php

namespace App\Http\Livewire\Admin;

use App\Models\AdminComment;
use Illuminate\Support\Collection;
use Livewire\Component;

class Comments extends Component
{
    public AdminComment $comment;

    public $model;

    public $readyToLoad = false;

    protected $rules = [
        'comment.text' => 'required|string|max:4096',
    ];

    protected $listeners = [
        'commentDeleted',
    ];

    public function loadComments()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $this->model->load('admin_comments');

        return view('livewire.admin.comments', [
            'comments' => $this->readyToLoad === true
                ? $this->model->admin_comments
                : collect([]),
        ]);
    }

    public function mount($model)
    {
        $this->comment = new AdminComment;
        $this->model = $model;
    }

    public function save()
    {
        $this->validate();

        $this->model->admin_comments()->save($this->comment);

        $this->model = $this->model->fresh(['admin_comments']);

        $this->comment = new AdminComment;

    }

    public function commentDeleted()
    {
        $this->model = $this->model->fresh(['admin_comments']);
    }
}
