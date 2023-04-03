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

class ImportPlacesMasterFileAction implements ShouldQueue
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
        if (empty(trim($this->row['ftp']))) {
            return;
        }

        if ($subject = Subject::query()->firstWhere('name', trim($this->row['ftp']))) {
            if (! empty(trim($this->row['date_confirmed']))) {
                $subject->place_confirmed_at = $this->toCarbonDate(trim($this->row['date_confirmed']));
                $subject->save();
            }
        }
    }

    private function toCarbonDate($stringDate)
    {
        if (empty($stringDate) || str($stringDate)->lower()->toString() == 'n/a' || str($stringDate)->lower()->toString() == '#n/a') {
            info('Date invalid for: '.$this->row['ftp'].' | '.$stringDate);

            return null;
        }

        try {
            if (is_numeric($stringDate)) {
                return Carbon::instance(Date::excelToDateTimeObject($stringDate))->toDateString();
            } else {
                return Carbon::createFromFormat('m/d/Y', $stringDate);
            }
        } catch (\Exception $exception) {
            info('Date invalid for: '.$this->row['ftp'].' | '.$stringDate);

            return null;
        }
    }
}
