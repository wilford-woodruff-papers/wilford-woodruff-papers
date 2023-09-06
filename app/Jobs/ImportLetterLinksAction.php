<?php

namespace App\Jobs;

use App\Models\Item;
use App\Models\Type;
use App\Models\Value;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportLetterLinksAction implements ShouldQueue
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
        if (empty($uniqueID = data_get($this->row, 'id'))) {
            info('No ID');

            return;
        }

        $type = Type::firstWhere('name', 'Letters');

        $item = Item::firstWhere([
            'type_id' => $type->id,
            'pcf_unique_id' => $uniqueID,
        ]);

        $value = Value::firstWhere([
            'item_id' => $item->id,
            'property_id' => 49,
        ]);

        logger('Current value: '.$value->value);
        if (empty($value->value) || ! str($value->value)->contains('http')) {
            logger('Updated to: '.data_get($this->row, 'link'));
            $value->value = data_get($this->row, 'link');
            $value->save();
        }

    }
}
