<?php

namespace App\Jobs;

use App\Models\Subject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportGeolocationRow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $row;

    /**
     * Create a new job instance.
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
        $subject = Subject::findOrFail($this->row['internal_id']);

        $subject->update([
            'latitude' => $this->row['latitude'],
            'longitude' => $this->row['longitude'],
            'is_partial' => $this->row['ispartial'] == 'TRUE' ? true : false,
            'google_map_address' => $this->row['google_map_address'],
            'google_map_id' => $this->row['google_map_id'],
            'northeast_box' => ! empty($this->row['northeast_box']) ? json_decode(str($this->row['northeast_box'])->replace("'", '"'), true) : null,
            'southwest_box' => ! empty($this->row['southwest_box']) ? json_decode(str($this->row['southwest_box'])->replace("'", '"'), true) : null,
            'geolocation' => ! empty($this->row['full_json']) ? json_decode(str($this->row['full_json'])->replace("'", '"'), true) : null,
            'geolocation_updated_at' => now(),
            'modern_location' => ! empty($this->row['modern_location']) ? $this->row['modern_location'] : null,
        ]);
    }
}
