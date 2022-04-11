<?php

namespace App\Http\Livewire;

use App\Models\Page;
use App\Models\Quote;
use App\Models\Subject;
use App\Models\Theme;
use App\Models\Topic;
use Illuminate\Support\Str;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class AddTheme extends ModalComponent
{
    public $page;

    public $selection;

    public $selectedTopics = [];

    public function mount($page, $selection)
    {
        $this->page = Page::find($page);

        $this->selection = $selection;
    }

    public function render()
    {
        return view('livewire.add-theme', [
            'topics' => Subject::query()
                ->whereRelation('category', 'name', 'Topics')
                ->orderBy('name')
                ->pluck('name', 'id')
                ->all()
        ]);
    }

    public function save()
    {

        $quote = Theme::create([
            'page_id' => $this->page->id,
            'text' => Str::of($this->selection)->replace('&', '&amp;'),
        ]);
        $quote->topics()->syncWithoutDetaching($this->selectedTopics);
        $this->dispatchBrowserEvent('deselect');
        $this->closeModal();
    }
}
