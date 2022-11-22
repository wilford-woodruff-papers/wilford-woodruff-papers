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
        foreach ($rows as $row) {
            $event = Event::query()->firstWhere('id', $this->getField($row['id']));

            $event->headline = $this->getField($row['headline']);
            $event->text = $this->getField($row['description']);
            $event->start_at = $this->toCarbonDate($row['start_date']);
            $event->start_year = $this->getField($row['start_year']);
            $event->start_month = $this->getField($row['start_month']);
            $event->start_day = $this->getField($row['start_day']);
            $event->end_at = $this->toCarbonDate($row['end_date']);
            $event->end_year = $this->getField($row['end_year']);
            $event->end_month = $this->getField($row['end_month']);
            $event->end_day = $this->getField($row['end_day']);
            $event->group = $this->getField($row['group']);
            $event->type = $this->getField($row['type']);

            $event->save();

            /*if (! empty($this->getField($row['year']))) {
                $event = Event::create([
                    'headline' => $this->getField($row['headline']),
                    'text' => $this->getField($row['text']),
                    'start_at' => now()->setDate($this->getField($row['year']), $this->getField($row['month'], 1), $this->getField($row['day'], 12)),
                    'start_year' => $this->getField($row['year']),
                    'start_month' => $this->getField($row['month']),
                    'start_day' => $this->getField($row['day']),
                    'end_at' => (! empty($this->getField($row['end_year'])))
                                ? now()->setDate($this->getField($row['end_year']), $this->getField($row['end_month'], 1), $this->getField($row['end_day'], 12))
                                : null,
                    'end_year' => $this->getField($row['end_year']),
                    'end_month' => $this->getField($row['end_month']),
                    'end_day' => $this->getField($row['end_day']),
                    'type' => $this->getField($row['type']),
                    'group' => $this->getField($row['group']),
                ]);

                if (! empty($this->getField($row['media']))) {
                    try {
                        $event->addMediaFromUrl(Str::of($this->getField($row['media']))->trim()->replace(' ', '%20'))->toMediaCollection();
                    } catch (\Exception $e) {
                        logger()->info('Image could not be downloaded: '.$this->getField($row['media']));
                    }
                }
            }*/
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
