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
     */
    public function handle(): int
    {
        Subject::query()
                 ->where(function ($query) {
                     $query->whereNull('subject_id')
                            ->orWhere('subject_id', 0);
                 })
                 ->chunkById(100, function ($subjects) {
                     $subjects->load('children', 'children.children');
                     foreach ($subjects as $subject) {
                         $subjectPages = DB::table('page_subject')
                             ->join('pages', 'pages.id', '=', 'page_subject.page_id')
                             ->join('items', 'items.id', '=', 'pages.item_id')
                             ->where('subject_id', $subject->id)
                             ->where('items.enabled', true)
                             ->count();

                         foreach ($subject->children as $child) {
                             $childPages = DB::table('page_subject')
                                 ->join('pages', 'pages.id', '=', 'page_subject.page_id')
                                 ->join('items', 'items.id', '=', 'pages.item_id')
                                 ->where('subject_id', $child->id)
                                 ->where('items.enabled', true)
                                 ->count();

                             foreach ($child->children as $grandchild) {
                                 $grandchild->tagged_count = DB::table('page_subject')
                                     ->join('pages', 'pages.id', '=', 'page_subject.page_id')
                                     ->join('items', 'items.id', '=', 'pages.item_id')
                                     ->where('subject_id', $grandchild->id)
                                     ->where('items.enabled', true)
                                     ->count();
                                 $grandchild->save();
                             }

                             $child->tagged_count = $childPages + $child->children->sum('tagged_count');
                             $child->save();
                         }

                         $subject->tagged_count = $subjectPages + $subject->children->sum('tagged_count');
                         $subject->save();
                     }
                 });

        return Command::SUCCESS;
    }
}
