<?php

namespace App\Console\Commands;

use App\Exports\ItemExport;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Models\User;
use Illuminate\Console\Command;

class ExportItemsCommand extends Command
{
    protected $signature = 'items:export';

    protected $description = 'Create Items CSV Export';

    public function handle(): void
    {
        $user = User::firstWhere('email', config('wwp.admin_email'));
        $filename = 'documents-export.csv';
        (new ItemExport($user))
            ->store($filename, 'exports', \Maatwebsite\Excel\Excel::CSV)
            ->onQueue('exports')
            ->chain([
                new NotifyUserOfCompletedExport(class_basename(ItemExport::class), $filename, $user),
            ]);
    }
}
