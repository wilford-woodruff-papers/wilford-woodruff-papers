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

class ImportNewDiscoursesFromPcfAction implements ShouldQueue
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
        if (! empty(data_get($this->row, str('Date Uploaded to FTP')->lower()->snake()->toString()))) {
            info(data_get($this->row, str('Unique Identifier')->lower()->snake()->toString()).' exists in FTP');

            return;
        }

        if (empty(data_get($this->row, str('Unique Identifier')->lower()->snake()->toString()))) {
            info('No ID');

            return;
        }

        $uniqueID = data_get($this->row, str('Unique Identifier')->lower()->snake()->toString());
        $type = Type::firstWhere('name', 'Discourses');

        $item = Item::query()->firstOrNew([
            'pcf_unique_id' => $uniqueID,
            'type_id' => $type->id,
        ]);

        $item->pcf_unique_id_prefix = 'D';
        // $item->notes = data_get($this->row, str('Notes')->lower()->snake()->toString());
        // $item->chl_link = data_get($this->row, 'link_to_pdfimage_formula_do_not_edit');
        // $item->external_transcript = data_get($this->row, 'link_to_transcript_formula_do_not_edit');

        if (empty($item->name)) {
            if (! empty(data_get($this->row, 'link_to_text_doc_formula'))) {
                $item->name = data_get($this->row, 'link_to_text_doc_formula');
            } else {
                $item->name = 'Discourse '.data_get($this->row, 'discourse_date_formula');
            }
        }

        info($item);

        $item->save();
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
