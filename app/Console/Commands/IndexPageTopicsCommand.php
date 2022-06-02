<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\Subject;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class IndexPageTopicsCommand extends Command
{
    protected $signature = 'index:topics';

    protected $description = 'Index all topics for pages';

    public function handle()
    {
        $topics = Subject::query()
                    ->whereHas('category', function (Builder $query) {
                        $query->where('name', 'Index');
                    });

        foreach($topics as $topic){
            $pages = Page::where('transcript', 'LIKE', '%'. $topic->name .'%')->get();
            $this->info($topic->name. ': '.$pages->count());
            foreach($pages as $page){
                $page->subjects()->syncWithoutDetaching($topic->id);
            }
        }
    }
}
