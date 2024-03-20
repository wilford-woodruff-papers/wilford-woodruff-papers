<?php

namespace App\Console\Commands;

use App\Jobs\GenerateDocumentBannerJob;
use Illuminate\Console\Command;

class GenerateBannerForDocumentCommand extends Command
{
    protected $signature = 'item-banner:generate {item?}';

    protected $description = 'Generate a banner for documents.';

    public function handle(): int
    {
        GenerateDocumentBannerJob::dispatch($this->argument('item'))
            ->onQueue('import');

        return Command::SUCCESS;
    }
}
