<?php

namespace App\Console\Commands;

use App\Exports\PeopleExport;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Models\User;
use Illuminate\Console\Command;

class ExportPeopleCommand extends Command
{
    protected $signature = 'people:export';

    protected $description = 'Create People CSV Export';

    public function handle(): void
    {
        $user = User::firstWhere('email', config('wwp.admin_email'));
        $filename = 'people-export.csv';
        (new PeopleExport($user))
            ->store($filename, 'exports', \Maatwebsite\Excel\Excel::CSV)
            ->onQueue('exports')
            ->chain([
                new NotifyUserOfCompletedExport(class_basename(PeopleExport::class), $filename, $user),
            ]);
    }
}
