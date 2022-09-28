<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class JournalsPcfImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        set_time_limit(600);

        foreach ($rows as $row) {
            if (data_get($row, str('Unique Identifier')->lower()->snake()->toString())) {
                logger()->info(
                    collect([
                        data_get($row, str('Unique Identifier')->lower()->snake()->toString()),
                        data_get($row, str('Images Uploaded to FTP')->lower()->snake()->toString()),
                        $this->toCarbonDate(data_get($row, str('Completed Transcriptions Uploaded to FTP')->lower()->snake()->toString())),
                        $this->toCarbonDate(data_get($row, str('2LV Completion Date')->lower()->snake()->toString())),
                        $this->toCarbonDate(data_get($row, str('Subject Links Completed')->lower()->snake()->toString())),
                        $this->toCarbonDate(data_get($row, str('Stylization Completed')->lower()->snake()->toString())),
                        $this->toCarbonDate(data_get($row, str('Date Topic Tagging Assigned')->lower()->snake()->toString())),
                        $this->toCarbonDate(data_get($row, str('Date Topic Tagging Completed')->lower()->snake()->toString())),
                    ])
                    ->join(' | ')
                );
            }
        }
    }

    private function toCarbonDate($stringDate)
    {
        if (empty($stringDate)) {
            return null;
        }

        try {
            if (is_numeric($stringDate)) {
                return Carbon::instance(Date::excelToDateTimeObject($stringDate))->toDateString();
            } else {
                return Carbon::createFromFormat('d-m-Y', $stringDate)->toDateString();
            }
        } catch (\Exception $exception) {
            return $stringDate;
        }
    }
}
