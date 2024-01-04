<?php

namespace App\Imports;

use App\Models\Press;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PressTopicsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            $press = Press::firstWhere('title', $row['title']);

            if (empty($press) && ! empty($row['link_to_media_on_website'])) {
                $press = Press::firstWhere('slug', str($row['link_to_media_on_website'])->afterLast('/'));
            }

            if ($press) {
                $press->subjects()->syncWithoutDetaching(
                    Subject::query()
                        ->whereIn('name',
                            str($row['topics'])
                                ->explode(',')
                                ->map(fn ($topic) => str($topic)->trim()->toString())
                                ->toArray()
                        )
                        ->get()
                        ->pluck('id')
                        ->toArray()
                );
                info('Found: '.$key.' '.$row['title'].' | '.$press->load(['subjects'])->subjects->pluck('name')->join(', ').' | '.$row['link_to_media_on_website']);
            } else {
                info('Not Found: '.$row['title'].' | '.$row['link_to_media_on_website']);
            }
        }
    }
}
