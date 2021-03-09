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
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $categories = Category::all();

        foreach ($rows as $row)
        {
            logger()->info($row);
            $subject = Subject::firstOrCreate([
                'name' => $row['title'],
            ]);

            foreach(explode(';', $row['categories']) as $subjectCategory){
                if($category = $categories->firstWhere('name', $subjectCategory)){
                    $category->subjects()->attach($subject);
                }
            }
        }
    }
}
