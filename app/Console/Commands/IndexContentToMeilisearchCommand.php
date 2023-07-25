<?php

namespace App\Console\Commands;

use App\Models\BoardMember;
use App\Models\Event;
use App\Models\Item;
use App\Models\Page;
use App\Models\Press;
use App\Models\Quote;
use App\Models\Subject;
use App\Models\Update;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class IndexContentToMeilisearchCommand extends Command
{
    protected $signature = 'content:index {models=Item,Page,Subject,Press,Team,Timeline,Newsletter,Quote} {--purge}';

    protected $description = 'Index all content to Meilisearch for site wide search';

    protected $chunkSize = 500;

    public function handle(): void
    {
        $models = explode(',', $this->argument('models'));

        if ($this->option('purge')) {
            Item::removeAllFromSearch();
        }

        foreach ($models as $model) {
            $this->info('Indexing '.$model);
            $this->$model();
        }

    }

    private function Item(): void
    {
        $count = 0;

        Item::query()
            ->with([
                'firstPage',
                'type',
            ])
            ->where('enabled', true)
            ->whereNull('item_id')
            ->chunkById($this->chunkSize, function (Collection $items) use (&$count) {
                $items->searchable();
                $this->info('Indexed Count: '.($count += $items->count()));
            });
    }

    private function Page(): void
    {
        $count = 0;

        Page::query()
            ->with([
                'parent',
                'parent.type',
                'media',
                'topics',
            ])
            ->whereHas('parent', function ($query) {
                $query->where('enabled', true);
            })
            ->chunkById($this->chunkSize, function (Collection $items) use (&$count) {
                $items->searchable();
                $this->info('Indexed Count: '.($count += $items->count()));
            });
    }

    private function Subject(): void
    {
        $count = 0;

        Subject::query()
            ->with([
                'category',
            ])
            ->where(function ($query) {
                $query->where('tagged_count', '>', 0)
                    ->orWhere('text_count', '>', 0)
                    ->orWhere('total_usage_count', '>', 0);
            })
            ->chunkById($this->chunkSize, function (Collection $items) use (&$count) {
                $items->searchable();
                $this->info('Indexed Count: '.($count += $items->count()));
            });
    }

    private function Press(): void
    {
        $count = 0;

        Press::query()
            ->with([
                'media',
            ])
            ->where('date', '<', now('America/Denver'))
            ->chunkById($this->chunkSize, function (Collection $items) use (&$count) {
                $items->searchable();
                $this->info('Indexed Count: '.($count += $items->count()));
            });
    }

    private function Team(): void
    {
        $count = 0;

        BoardMember::query()
            ->with([
                'team',
            ])
            ->chunkById($this->chunkSize, function (Collection $items) use (&$count) {
                $items->searchable();
                $this->info('Indexed Count: '.($count += $items->count()));
            });
    }

    private function Timeline(): void
    {
        //$this->call('scout:flush', ['model' => 'App\Models\Event']);

        $count = 0;

        Event::query()
            ->with([
                'media',
            ])
            ->chunkById($this->chunkSize, function (Collection $items) use (&$count) {
                $items->searchable();
                $this->info('Indexed Count: '.($count += $items->count()));
            });
    }

    private function Newsletter(): void
    {
        $count = 0;

        Update::query()
            ->where('enabled', true)
            ->where('publish_at', '<', now('America/Denver'))
            ->with([
                'media',
            ])
            ->chunkById($this->chunkSize, function (Collection $items) use (&$count) {
                $items->searchable();
                $this->info('Indexed Count: '.($count += $items->count()));
            });
    }

    private function Quote(): void
    {
        $count = 0;

        Quote::query()
            ->whereHas('actions')
            ->with([
                'page',
                'page.item',
                'page.media',
                'topics',
            ])
            ->withCount([
                'actions',
            ])
            ->chunkById($this->chunkSize, function (Collection $items) use (&$count) {
                $items->searchable();
                $this->info('Indexed Count: '.($count += $items->count()));
            });
    }
}
