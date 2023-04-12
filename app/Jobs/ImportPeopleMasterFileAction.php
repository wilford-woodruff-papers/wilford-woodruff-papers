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

            $columns = [
                'unique_id' => 'unique_identifier',
                'reference' => 'reference',
                'relationship' => 'relationship_to_ww',
                'birth_date' => 'birth_date',
                'death_date' => 'death_date',
                'life_years' => 'b_d_dates',
                'pid' => 'pid_fsid',
                'added_to_ftp_at' => 'added_to_ftp',
                'first_name' => 'given_name',
                'middle_name' => 'middle_name',
                'last_name' => 'surname',
                'suffix' => 'suffix',
                'alternate_names' => 'alternate_names',
                'maiden_name' => 'maiden_name',
                'baptism_date' => 'baptism_date',
                'notes' => 'notes',
                'bio_completed_at' => 'date_bio_completed',
                //'log_link' => 'link_to_log',
                'researcher_text' => 'researcher',
            ];

            foreach ($columns as $key => $column) {
                if (! empty(trim($this->row[$column]))) {
                    $subject->{$key} = trim($this->row[$column]);
                }
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

    private function getResearcher($name)
    {
        if (empty($name) || str($name)->lower() == 'done' || str($name)->contains('/')) {
            return null;
        }

        $name = str($name)->trim('.')->toString();
    }
}
