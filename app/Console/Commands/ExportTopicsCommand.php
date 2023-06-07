<?php

namespace App\Console\Commands;

use App\Exports\TopicsExport;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Models\User;
use Illuminate\Console\Command;

class ExportTopicsCommand extends Command
{
    protected $signature = 'topics:export';

    protected $description = 'Create Topics CSV Export';

    public function handle(): void
    {
        $user = User::firstWhere('email', config('wwp.admin_email'));
        $filename = 'topics-export.csv';
        (new TopicsExport($user))
            ->store($filename, 'exports', \Maatwebsite\Excel\Excel::CSV)
            ->onQueue('exports')
            ->chain([
                new NotifyUserOfCompletedExport(class_basename(TopicsExport::class), $filename, $user),
            ]);
    }
}
