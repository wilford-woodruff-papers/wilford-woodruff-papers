<?php

namespace App\Livewire\AI;

use App\Models\AiQuestion;
use App\Models\AiSession;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class Sessions extends Component
{
    use WithPagination;

    public $filterToNoRating = true;

    public function render()
    {
        $sessions = AiSession::query()
            ->with([
                'questions',
                'questions.topics',
            ]);

        if ($this->filterToNoRating) {
            $sessions->whereHas('questions', function ($query) {
                $query->where('rating', 0);
            });
        }

        return view('livewire.ai.sessions', [
            'sessions' => $sessions
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'topics' => Subject::query()
                ->whereNull('subject_id')
                ->index()
                ->orderByRaw('UPPER(name) ASC')
                ->get(),
        ])
            ->layout('layouts.admin');
    }

    public function rate($questionId, $rating)
    {
        AiQuestion::where('id', $questionId)
            ->increment('rating', $rating);
    }

    public function updateTopics($questionId, $topics)
    {
        $question = AiQuestion::findOrFail($questionId);
        $question->topics()->sync($topics);
    }

    public function updatedPage()
    {
        $this->dispatch('scroll');
    }
}
