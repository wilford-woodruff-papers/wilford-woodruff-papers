<?php

namespace App\Imports;

use App\Models\Event;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TimelineImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (! empty($this->getField($row['year']))) {
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
            }
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
