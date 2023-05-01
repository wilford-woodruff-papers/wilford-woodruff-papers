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
     */
    public function handle(): void
    {
        if (empty(trim($this->row['ftp']))) {
            return;
        }

        if ($subject = Subject::query()->firstOrNew(['name' => trim($this->row['ftp'])])) {

            if (! empty($dateAdded = $this->toCarbonDate(trim($this->row['date_added'])))) {
                $subject->created_at = $dateAdded;
            }
            $subject->place_confirmed_at = $this->toCarbonDate(trim($this->row['date_confirmed']));

            if (is_int($unique_id = $this->toCarbonDate(trim($this->row['ftp_identifier_formula'])))) {
                $subject->unique_id = $unique_id;
            }

            $columns = [
                'country' => 'country',
                'state_province' => 'stateprovince',
                'county' => 'county',
                'city' => 'city',
                'specific_place' => 'specific_place',
                'years' => 'years',
                'modern_location' => 'modern_location',
                'reference' => 'sourcenote',
                'notes' => 'other_notes',
            ];

            foreach ($columns as $key => $column) {
                if (! empty(trim($this->row[$column]))) {
                    $subject->{$key} = trim($this->row[$column]);
                }
            }

            $subject->save();
        } else {
            info('Subject not found: '.$this->row['ftp']);
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
