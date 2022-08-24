<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ThemeTopicImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        set_time_limit(600);

        $category = Category::firstOrCreate(['name' => 'Topics']);

        foreach ($rows as $row) {
            if (empty(trim($row['spelling']))) {
                $subject = Subject::firstOrCreate([
                    'name' => trim(html_entity_decode($row['topics_for_index'])),
                ]);

                $category->subjects()->syncWithoutDetaching($subject);
            }
        }
    }
}
