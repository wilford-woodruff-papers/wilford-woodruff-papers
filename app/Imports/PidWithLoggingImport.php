<?php

namespace App\Imports;

use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PidWithLoggingImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        set_time_limit(24000);

        foreach ($rows as $row) {
            if (! empty(data_get($row, 'new_pid'))) {
                logger()
                    ->channel('imports')
                    ->info('New PID: '.data_get($row, 'new_pid'));
                $person = Subject::query()
                    ->people()
                    ->where('name', data_get($row, 'name'))
                    ->first();
                if ($person) {
                    logger()
                        ->channel('imports')
                        ->info('Name: '.data_get($row, 'name'));
                    if (empty($person->pid)) {
                        $person->pid = trim(data_get($row, 'new_pid'));
                        $person->pid_identified_at = now();
                        $person->save();
                    } else {
                        if ($person->pid !== trim(data_get($row, 'new_pid'))) {
                            logger()
                                ->channel('imports')
                                ->warning('PID Doesn\'t match');
                        } else {
                            logger()
                                ->channel('imports')
                                ->notice($person->pid.' : '.data_get($row, 'new_pid'));
                        }
                    }
                } else {
                    logger()
                        ->channel('imports')
                        ->warning('Person Not Found: '.data_get($row, 'name'));
                }

            }
        }
    }
}
