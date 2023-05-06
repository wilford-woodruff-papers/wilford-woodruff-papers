<?php

namespace App\Jobs;

use App\Models\PeopleIdentification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportPeopleIdentificationFileAction implements ShouldQueue
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
            $subject = PeopleIdentification::query()->where(['file_id' => trim($this->row['id'])])->first();
        //if () {
            if (empty($subject)) {
                logger()
                    ->stack(['imports'])
                    ->info('Not found creating new model');
                $subject = new PeopleIdentification();
            }

            if (! empty(trim($this->row['date_added']))) {
                $subject->created_at = $this->toCarbonDate(trim($this->row['date_added']));
            }

            $columns = [
                'editorial_assistant' => 'editorial_assistant',
                'title' => 'title',
                'first_middle_name' => 'first_and_middle_names_or_initials',
                'last_name' => 'surname_or_initial',
                'other' => 'other',
                'link_to_ftp' => 'link_to_ftp',
                'guesses' => 'guesses_or_notes_if_any',
                'location' => 'location',
                /*'completed_at' => 'date_completed',*/
                'notes' => 'research_notes',
                'fs_id' => 'fs_id',
                'approximate_birth_date' => 'approx_birth',
                'approximate_death_date' => 'approx_death',
                'nauvoo_database' => 'nauvoo_database',
                'pioneer_database' => 'pioneer_database',
                'missionary_database' => 'missionary_database',
                'boston_index' => 'boston_index',
                'st_louis_index' => 'st_louis_index',
                'british_mission' => 'british_mission',
                'eighteen_forty_census' => '1840_census',
                'eighteen_fifty_census' => '1850_census',
                'eighteen_sixty_census' => '1860_census',
                'other_census' => 'other_census',
                'other_records' => 'other_records',
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
