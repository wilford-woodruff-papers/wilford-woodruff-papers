<?php

namespace App\Console\Commands\Stats;

use App\Models\Stat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UploadedFtpDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:uploaded-ftp-documents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the number of uploaded FTP documents for the previous month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = now()->subMonth();

        $response = Http::get('https://fromthepage.com/iiif/collection/970');

        $manifests = collect($response->json('manifests', []));

        $itemCount = $manifests->count($manifests);

        $previousStat = Stat::query()
                            ->where('name', 'uploaded-ftp-documents')
                            ->where('period', 'monthly')
                            ->latest()
                            ->first();

        if (! empty($previousStat)) {
            $difference = $itemCount - $previousStat->value;
        } else {
            $difference = $itemCount;
        }

        Stat::create([
            'name' => 'uploaded-ftp-documents',
            'period' => 'monthly',
            'year' => $now->year,
            'month' => $now->month,
            'day' => $now->endOfMonth()->day,
            'value' => $itemCount,
            'difference' => $difference,
        ]);

        $manifestCount = 0;

        $manifests->each(function ($manifest) use (&$manifestCount) {
            $manifestCount = $manifestCount + count(Http::get($manifest['@id'])->json('sequences.0.canvases', []));
        });

        $previousPageStat = Stat::query()
                                ->where('name', 'uploaded-ftp-pages')
                                ->where('period', 'monthly')
                                ->latest()
                                ->first();

        if (! empty($previousPageStat)) {
            $pageDifference = $manifestCount - $previousPageStat->value;
        } else {
            $pageDifference = $manifestCount;
        }

        Stat::create([
            'name' => 'uploaded-ftp-pages',
            'period' => 'monthly',
            'year' => $now->year,
            'month' => $now->month,
            'day' => $now->endOfMonth()->day,
            'value' => $manifestCount,
            'difference' => $pageDifference,
        ]);

        return 0;
    }
}
