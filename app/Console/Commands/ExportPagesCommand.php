<?php

namespace App\Console\Commands;

use App\Exports\PageExport;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Models\User;
use Illuminate\Console\Command;

class ExportPagesCommand extends Command
{
    protected $signature = 'pages:export';

    protected $description = 'Create Pages CSV Export';

    public function handle(): void
    {
        $user = User::firstWhere('email', config('wwp.admin_email'));
        $filename = 'pages-export.csv';
        (new PageExport($user))
            ->store($filename, 'exports', \Maatwebsite\Excel\Excel::CSV)
            ->onQueue('exports')
            ->chain([
                new NotifyUserOfCompletedExport(class_basename(PageExport::class), $filename, $user),
            ]);
    }
}
