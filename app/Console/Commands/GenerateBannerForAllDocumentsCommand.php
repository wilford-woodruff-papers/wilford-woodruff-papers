<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Type;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

class GenerateBannerForAllDocumentsCommand extends Command
{
    protected $signature = 'items-banner:generate {type?}';

    protected $description = 'Generate a banner for all documents.';

    public function handle(): int
    {
        $count = Item::query()
            ->where('enabled', true)
            ->whereNull('item_id')
            ->when($this->argument('type'), function ($query, $type) {
                return $query->where('type_id', Type::firstWhere('name', $type)->id);
            })
            ->count();

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        Item::query()
            ->where('enabled', true)
            ->whereNull('item_id')
            ->when($this->argument('type'), function ($query, $type) {
                return $query->where('type_id', Type::firstWhere('name', $type)->id);
            })
            ->chunkById(200, function (Collection $items) use ($bar) {
                foreach ($items as $item) {
                    Artisan::call('item-banner:generate', [
                        'item' => $item->uuid,
                    ]);
                    $bar->advance();
                }
            }, $column = 'id');

        $bar->finish();

        return Command::SUCCESS;
    }
}
