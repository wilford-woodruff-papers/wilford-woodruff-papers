<?php

namespace App\Jobs;

use App\Models\Subject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportResearchLogLinkFromMasterFileAction implements ShouldQueue
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
        if (empty(trim($this->row['ww_id']))) {
            return;
        }

        if ($subject = Subject::query()
            ->whereHas('category', function ($query) {
                $query->where('name', 'People');
            })
            ->where('unique_id', trim($this->row['ww_id']))
            ->first()
        ) {
            if (! empty(trim($this->row['link_to_research']))) {
                if (trim($this->row['link_to_research']) == '#VALUE!') {
                    $subject->log_link = null;
                    $subject->save();
                } elseif (empty($subject->log_link) || ! str($subject->log_link)->trim()->startsWith('http')) {
                    $subject->log_link = trim($this->row['link_to_research']);
                    $subject->save();
                }
            }
        }
    }
}
