<?php

namespace App\Jobs;

use App\Models\Item;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportNewLettersFromPcfAction implements ShouldQueue
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
     *
     * @return void
     */
    public function handle()
    {
        if (! empty(data_get($this->row, str('Uploaded to FTP')->lower()->snake()->toString()))) {
            info(data_get($this->row, str('Unique Identifier')->lower()->snake()->toString()).' exists in FTP');

            return;
        }

        if (empty(data_get($this->row, str('Unique Identifier')->lower()->snake()->toString()))) {
            info('No ID');

            return;
        }

        $uniqueID = data_get($this->row, str('Unique Identifier')->lower()->snake()->toString());
        $type = Type::firstWhere('name', 'Letters');

        $item = Item::query()->firstOrNew([
            'pcf_unique_id' => $uniqueID,
            'type_id' => $type->id,
        ], [
            'pcf_unique_id_prefix' => 'LE',
            'notes' => data_get($this->row, str('Notes')->lower()->snake()->toString()),
            'external_transcript' => data_get($this->row, 'link_to_transcript_formula_do_not_edit'),
        ]);

        if (empty($item->name)) {
            $item->name = data_get($this->row, 'identifier_formula_do_not_edit');
        }

        info($item);
        // $item->save();
    }

    private function getSlug($url)
    {
        return str($url)->afterLast('/')->before('?')->toString();
    }

    private function toCarbonDate($stringDate)
    {
        if (empty($stringDate) || str($stringDate)->lower()->toString() == 'n/a') {
            return null;
        }

        try {
            if (is_numeric($stringDate)) {
                return Carbon::instance(Date::excelToDateTimeObject($stringDate))->toDateString();
            } else {
                return Carbon::createFromFormat('Y-m-d', $stringDate);
            }
        } catch (\Exception $exception) {
            return null;
        }
    }
}
