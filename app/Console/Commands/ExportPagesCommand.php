<?php

namespace App\Console\Commands;

use App\Exports\PageExport;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Models\User;
use Illuminate\Console\Command;

class ExportPagesCommand extends Command
{
    protected $signature = 'pages:export';

    protected $description = 'Command description';

    public function handle(): void
    {
        $user = User::firstWhere('email', config('wwp.admin_email'));
        $filename = 'pages-export.xlsx';
        (new PageExport($user))
            ->store($filename, 'exports')
            ->onQueue('exports')
            ->chain([
                new NotifyUserOfCompletedExport(class_basename(PageExport::class), $filename, $user),
            ]);
    }
}
