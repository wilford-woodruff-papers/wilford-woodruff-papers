<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubjectImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        set_time_limit(2400);

        $categories = Category::all();

        foreach ($rows as $row) {
            $subject = Subject::firstOrCreate([
                'name' => trim(html_entity_decode($row['title'])),
            ]);

            foreach (explode(';', $row['categories']) as $subjectCategory) {
                if ($category = $categories->firstWhere('name', trim($subjectCategory))) {
                    $category->subjects()->syncWithoutDetaching($subject);
                }
            }
        }
    }
}
