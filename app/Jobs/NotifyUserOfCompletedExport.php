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
use Illuminate\Support\Collection;

class NotifyUserOfCompletedExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name;

    public $filename;

    public $users;

    public $subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $filename, Collection|User $users, $subject = 'Export Ready Notification')
    {
        $this->name = $name;
        $this->filename = $filename;
        $this->users = $users;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->users instanceof User) {
            $this->users = collect([$this->users]);
        }

        foreach ($this->users as $user) {
            Export::create([
                'name' => $this->name,
                'filename' => $this->filename,
                'user_id' => $user->id,
                'exported_at' => now('America/Denver'),
            ]);
            $user->notify(new ExportReadyNotification($this->filename, $this->subject));
        }
    }
}
