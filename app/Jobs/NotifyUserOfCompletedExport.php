<?php

namespace App\Jobs;

use App\Models\Export;
use App\Models\User;
use App\Notifications\ExportReadyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfCompletedExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name;

    public $filename;

    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $filename, User $user)
    {
        $this->name = $name;
        $this->filename = $filename;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Export::create([
            'name' => $this->name,
            'filename' => $this->filename,
            'user_id' => $this->user->id,
            'exported_at' => now('America/Denver'),
        ]);

        $this->user->notify(new ExportReadyNotification($this->filename));
    }
}
