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
                        $query->where('name', 'Index');
                    })
                    ->where('search_in_text', 1)
                    ->orderBy('name', 'ASC')
                    ->get();

        $this->info('Topics to index: '.$topics->count());

        foreach ($topics as $key => $topic) {
            $pages = Page::query()
                ->whereHas('item', function (Builder $query) {
                    $query->where('enabled', 1);
                })
                ->where('transcript', 'LIKE', '%'.$topic->name.'%')
                ->get();
            $this->info($key.' '.$topic->name.': '.$pages->count());

            foreach ($pages as $page) {
                $page->subjects()->syncWithoutDetaching($topic->id);
            }

            if ($topic->enabled == 0 && $pages->count() > 0) {
                $topic->enabled = 1;
                $topic->save();
            }
        }
    }
}
