<?php

namespace App\Jobs;

use App\Models\PlaceIdentification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportPlacesIdentificationFileAction implements ShouldQueue
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
        if (empty(trim($this->row['id']))) {
            logger()
                ->stack(['imports'])
                ->info('No ID');

            return;
        }
            $subject = PlaceIdentification::query()->where(['id' => trim($this->row['id'])])->first();
        //if () {
            if (empty($subject)) {
                logger()
                    ->stack(['imports'])
                    ->info('Not found creating new model');
                $subject = new PlaceIdentification();
            }

            if (! empty(trim($this->row['date_added']))) {
                $subject->created_at = $this->toCarbonDate(trim($this->row['date_added']));
            }

            $columns = [
                'guesses' => 'location',
                'editorial_assistant' => 'editorial_assistant',
                'location' => 'name_in_journal_as_written',
                'link_to_ftp' => 'link_to_ftp',
                'notes' => 'additional_information',
                'other_records' => 'other',
            ];

            foreach ($columns as $key => $column) {
                if (! empty(trim($this->row[$column]))) {
                    $subject->{$key} = trim($this->row[$column]);
                }
            }

            $subject->save();
        //}
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
