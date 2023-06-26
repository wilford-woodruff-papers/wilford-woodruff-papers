<?php

namespace App\Imports;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TimelineImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        $fields = [
            'context' => [
                'type' => 'text',
                'column' => 'group',
            ],
            'display_date' => [
                'type' => 'text',
                'column' => 'display_date',
            ],
            'start_date' => [
                'type' => 'date',
                'column' => 'start_at',
            ],
            'end_date' => [
                'type' => 'date',
                'column' => 'end_at',
            ],
            'headline' => [
                'type' => 'text',
                'column' => 'headline',
            ],
            'description' => [
                'type' => 'text',
                'column' => 'text',
            ],
        ];

        foreach ($rows as $row) {
            if (! empty($this->getField($row['id']))) {

                $event = Event::query()
                    ->find($this->getField($row['id']));

                if ($this->getField($row['description']) == 'DELETE') {
                    if (! empty($event)) {
                        $event->delete();
                    }

                    continue;
                }
            } else {
                $event = new Event();
            }

            foreach ($fields as $field => $properties) {
                // Skip if the field is not in the csv
                if (! $row->has($field)) {
                    continue;
                }

                if ($properties['type'] == 'date') {
                    $value = $this->toCarbonDate($row[$field]);
                } elseif ($properties['type'] == 'text') {
                    $value = $this->getField($row[$field]);
                }

                $event->{$properties['column']} = $value;

                unset($value);
            }

            $event->save();
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
