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
                'name' => trim(html_entity_decode($row['index_topic_do_not_tag_in_ftp_jon_will_create_the_relationship_between_index_topics_and_subtopics_by_computer'])),
            ]);
            $category->subjects()->syncWithoutDetaching($subject);

            $subTopics = str($row['sub_topics_that_are_included_under_the_content_theme_and_connected_to_main_topic_in_index_tag_in_ftp'])
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
