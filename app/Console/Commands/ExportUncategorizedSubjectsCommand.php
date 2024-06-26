<?php

namespace App\Console\Commands;

use App\Exports\ItemExport;
use App\Exports\UncategorizedSubjectsExport;
use App\Jobs\NotifyUserOfCompletedSubjectExport;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Console\Command;

class ExportUncategorizedSubjectsCommand extends Command
{
    protected $signature = 'uncat:export';

    protected $description = 'Create Uncategorized Subjects Export';

    public function handle(): int
    {
        if (now()->isMonday()) {
            $period = now()->subDays(7);
        } else {
            $period = now()->subDays(1);
        }

        $count = Subject::query()
            ->where('created_at', '>', $period)
            ->whereDoesntHave('category')
            ->count();

        if ($count === 0) {
            return self::SUCCESS;
        }

        if (now()->isMonday()) {
            $subject = $count.' Uncategorized Subjects Need Reviewed';
        } else {
            $subject = $count.' New Uncategorized Subjects Found';
        }

        $user = User::firstWhere('email', config('wwp.admin_email'));
        $notify = User::query()->whereIn('email', explode('|', config('wwp.new_uncategorized_subjects_email')))->get();
        $filename = 'uncategorized-subjects-export.csv';
        (new UncategorizedSubjectsExport($user))
            ->store($filename, 'exports', \Maatwebsite\Excel\Excel::CSV)
            ->onQueue('exports')
            ->chain([
                new NotifyUserOfCompletedSubjectExport(class_basename(ItemExport::class), $filename, $notify, $subject),
            ]);

        return self::SUCCESS;
    }
}
