<?php

namespace App\Jobs;

use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportPeopleMasterFileAction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $row;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($row)
    {
        $this->row = $row;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if (empty(trim($this->row['name_in_ftp']))) {
            return;
        }

        if ($subject = Subject::query()->firstWhere('name', trim($this->row['name_in_ftp']))) {
            if (! empty(trim($this->row['date_pid_identified']))) {
                $subject->pid_identified_at = $this->toCarbonDate(trim($this->row['date_pid_identified']));
            }
            if (! empty(trim($this->row['date_bio_approved_formula']))) {
                $subject->bio_approved_at = $this->toCarbonDate(trim($this->row['date_bio_approved_formula']));
            }
            $subject->save();
        }
    }

    private function toCarbonDate($stringDate)
    {
        if (empty($stringDate) || str($stringDate)->lower()->toString() == 'n/a' || str($stringDate)->lower()->toString() == '#n/a') {
            info('Date invalid for: '.$this->row['name_in_ftp'].' | '.$stringDate);

            return null;
        }

        try {
            if (is_numeric($stringDate)) {
                return Carbon::instance(Date::excelToDateTimeObject($stringDate))->toDateString();
            } else {
                return Carbon::createFromFormat('m/d/Y', $stringDate);
            }
        } catch (\Exception $exception) {
            info('Date invalid for: '.$this->row['name_in_ftp'].' | '.$stringDate);

            return null;
        }
    }
}
