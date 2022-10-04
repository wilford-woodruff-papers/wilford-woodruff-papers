<?php

namespace App\Console\Commands;

use App\Models\Subject;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CalculateTaggedSubjectPageCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'topics:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the number of pages tagged with each subject';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Subject::whereNull('subject_id')
                 ->chunkById(100, function ($subjects) {
                     $subjects->load('children', 'children.children');
                     foreach ($subjects as $subject) {
                         $subjectPages = DB::table('page_subject')->where('subject_id', $subject->id)->count();

                         foreach ($subject->children as $child) {
                             $childPages = DB::table('page_subject')->where('subject_id', $child->id)->count();

                             foreach ($child->children as $grandchild) {
                                 $grandchild->tagged_count = DB::table('page_subject')->where('subject_id', $grandchild->id)->count();
                                 $grandchild->save();
                             }

                             $child->tagged_count = $childPages + $child->children->sum('tagged_count');
                             $child->save();
                         }

                         $subject->tagged_count = $subjectPages + $subject->children->sum('tagged_count');
                         $subject->save();
                     }
                 });

        return 0;
    }
}
