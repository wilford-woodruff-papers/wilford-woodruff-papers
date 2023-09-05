<?php

namespace App\Imports;

use App\Jobs\ImportGeolocationRow;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class GeolocationImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (
                ! empty($id = $this->getField($row['internal_id']))
                && ! empty($this->getField($row['latitude']))
                && ! empty($this->getField($row['longitude']))
                && ($this->getField($row['ispartial']) == false || $this->getField($row['ispartial']) == 'FALSE')
            ) {
                ImportGeolocationRow::dispatch($row)
                    ->onQueue('import');
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
                return Carbon::createFromFormat('Y-m-d', $stringDate);
            }
        } catch (\Exception $exception) {
            return null;
        }
    }

    private function getField($field, $default = null)
    {
        $field = trim($field);

        if (empty($field) && ! empty($default)) {
            $field = $default;
        }

        return $field;
    }
}
