<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignCategoryToPlacesFromMasterFileAction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $row;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($row)
    {
        $this->row = $row;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (empty(trim($this->row['ftp']))) {
            return;
        }

        if ($subject = Subject::query()->firstWhere('name', trim($this->row['ftp']))) {
            if ($category = Category::firstWhere('name', 'Places')) {
                $subject->category()->syncWithoutDetaching($category);
            }
        }
    }
}
