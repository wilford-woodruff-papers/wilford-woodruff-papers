<?php

namespace App\Http\Livewire;

use App\Jobs\SendNewCommentNotification;
use App\Models\Comment;
use App\Models\Press;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Maize\Markable\Models\Like;

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
        $comment->comment = strip_tags($this->comment);

        $comment->user()->associate(Auth::user());

        $this->model->comments()->save($comment);
        $this->model->refresh();
        $this->comment = '';

        new SendNewCommentNotification($comment);
    }

    public function login()
    {
        session(['url.intended' => route('landing-areas.ponder.press', ['press' => $this->model])]);

        return redirect()->route('login');
    }

    public function toggleLike($id)
    {
        Like::toggle($press = Press::find($id), Auth::user());
        $press->total_likes = Like::count($press);
        $press->last_liked_at = now();
        $press->save();
    }

    public function toggleCommentLike($id)
    {
        Like::toggle($comment = Comment::find($id), Auth::user());
        $comment->total_likes = Like::count($comment);
        $comment->save();
    }

    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        if($comment->user_id == Auth::id()){
            $comment->delete();
        }
        $this->model->refresh();
    }
}
