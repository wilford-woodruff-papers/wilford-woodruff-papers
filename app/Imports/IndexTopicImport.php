<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IndexTopicImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        set_time_limit(600);

        $category = Category::firstOrCreate(['name' => 'Index']);

        foreach ($rows as $row) {
            $subject = Subject::firstOrCreate([
                'name' => trim(html_entity_decode($row['topics_for_index'])),
            ]);
            $category->subjects()->syncWithoutDetaching($subject);

            $subTopics = str($row['subtopics'])
                ->explode(',')
                ->map(function($t){
                    return str($t)->trim();
                });

            foreach ($subTopics as $topic) {
                if ($subSubject = Subject::firstOrCreate(['name' => $topic])) {
                    if($subject->id !== $subSubject->id){
                        $subject->children()->save($subSubject);
                        $category->subjects()->syncWithoutDetaching($subSubject);
                    }
                }
            }
        }
    }
}
