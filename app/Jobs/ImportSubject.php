<?php

namespace App\Jobs;

use App\Models\Subject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportSubject implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $row;

    public $categories;

    /**
     * Create a new job instance.
     */
    public function __construct($row, $categories)
    {
        $this->row = $row;
        $this->categories = $categories;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $subject = Subject::firstOrCreate([
            'name' => trim(html_entity_decode($this->row['title'])),
        ]);

        foreach (explode(';', $this->row['categories']) as $subjectCategory) {
            if ($category = $this->categories->firstWhere('name', trim($subjectCategory))) {
                $category->subjects()->syncWithoutDetaching($subject);
            }
        }
    }
}
