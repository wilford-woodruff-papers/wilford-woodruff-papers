<?php

namespace App\Jobs;

use App\Models\Copyright;
use App\Models\Item;
use App\Models\Property;
use App\Models\Value;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportMetatdataRow implements ShouldQueue
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
        if (empty($identifier = data_get($this->row, 'id'))) {
            info('No ID');

            return;
        }

        $item = Item::findOrFail($identifier);

        if (! empty($copyrightStatus = data_get($this->row, 'copyright_status_formula'))) {
            $item->copyright_id = Copyright::firstWhere('description', $copyrightStatus)?->id;
            $item->save();
        }

        $properties = Property::query()
            ->whereIn('name', [
                '*Source',
                '*Source Link',
                '*Repository',
                '*Sub-Repository',
                '*Collection Name',
                '*Collection Description',
                '*Collection Number',
                '*Collection Box',
                '*Collection Folder',
                '*Collection Page',
            ])
            ->get();

        foreach ($properties as $property) {
            $value = data_get($this->row, str($property->name)->replace('*', '')->snake()->toString());

            if ($property->type === 'relationship' && ! empty($value)) {
                $relationship = "App\\Models\\$property->relationship";
                $value = $relationship::firstWhere('name', $value)->id;
            }

            $value = Value::updateOrCreate([
                'item_id' => $item->id,
                'property_id' => $property->id,
            ], [
                'value' => $value,
            ]);

        }
    }
}
