<?php

namespace App\Console\Commands;

use App\Exports\PlacesExport;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Models\User;
use Illuminate\Console\Command;

class ExportPlacesCommand extends Command
{
    protected $signature = 'places:export';

    protected $description = 'Create Places CSV Export';

    public function handle(): void
    {
        $user = User::firstWhere('email', config('wwp.admin_email'));
        $filename = 'places-export.csv';
        (new PlacesExport($user))
            ->store($filename, 'exports', \Maatwebsite\Excel\Excel::CSV)
            ->onQueue('exports')
            ->chain([
                new NotifyUserOfCompletedExport(class_basename(PlacesExport::class), $filename, $user),
            ]);
    }
}
