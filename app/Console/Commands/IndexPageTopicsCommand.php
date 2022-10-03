<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\Subject;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class IndexPageTopicsCommand extends Command
{
    protected $signature = 'topics:index';

    protected $description = 'Index all topics for pages';

    public function handle()
    {
        set_time_limit(600);

        $topics = Subject::query()
                    ->whereHas('category', function (Builder $query) {
                        $query->where('name', 'Topics');
                    })
                    ->get();

        $this->info('Topics to index: '.$topics->count());

        foreach ($topics as $topic) {
            $pages = Page::where('transcript', 'LIKE', '%'.$topic->name.'%')->get();
            $this->info($topic->name.': '.$pages->count());
            foreach ($pages as $page) {
                $page->subjects()->syncWithoutDetaching($topic->id);
            }
        }
    }
}
