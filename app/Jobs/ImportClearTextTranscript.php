<?php

namespace App\Jobs;

use App\Models\Page;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportClearTextTranscript implements ShouldQueue
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
        Page::withoutSyncingToSearch(function () {
            $pageID = data_get($this->row, str('Internal ID')->lower()->snake()->toString());

            if (empty($pageID)) {
                info('No ID');

                return;
            }

            if ($page = Page::find($pageID)) {
                $page->clear_text_transcript = data_get($this->row, str('Clear Text')->lower()->snake()->toString());
                $page->saveQuietly();
            } else {
                info('No page found for:  '.$pageID);
            }
        });
    }
}
