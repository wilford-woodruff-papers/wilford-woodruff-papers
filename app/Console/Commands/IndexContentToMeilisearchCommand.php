<?php

namespace App\Console\Commands;

use App\Models\BoardMember;
use App\Models\Event;
use App\Models\Item;
use App\Models\Page;
use App\Models\Press;
use App\Models\Subject;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class IndexContentToMeilisearchCommand extends Command
{
    protected $signature = 'content:index';

    protected $description = 'Index all content to Meilisearch for site wide search';

    protected $chunkSize = 500;

    public function handle(): void
    {
        $models = [
            'Items',
            'Pages',
            'Subject',
            'Press',
            'Team',
            'Timeline',
        ];

        Item::removeAllFromSearch();

        foreach ($models as $model) {
            $this->info('Indexing '.$model);
            $this->$model();
        }

    }

    private function Items(): void
    {
        $count = 0;

        Item::query()
            ->with([
                'firstPage',
                'type',
            ])
            ->where('enabled', true)
            ->chunkById($this->chunkSize, function (Collection $items) use (&$count) {
                $items->searchable();
                $this->info('Indexed Count: '.($count += $items->count()));
            });
    }

    private function Pages(): void
    {
        $count = 0;

        Page::query()
            ->with([
                'parent',
                'parent.type',
                'media',
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
}
