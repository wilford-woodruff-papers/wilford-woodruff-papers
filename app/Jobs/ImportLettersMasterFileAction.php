<?php

namespace App\Jobs;

use App\Models\Item;
use App\Models\Template;
use App\Models\Type;
use App\Models\Value;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportLettersMasterFileAction implements ShouldQueue
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
        if (empty($uniqueID = data_get($this->row, 'unique_identifier'))) {
            info('No ID');

            return;
        }

        $type = Type::firstWhere('name', 'Letters');

        $item = Item::firstOrNew([
            'type_id' => $type->id,
            'pcf_unique_id' => $uniqueID,
        ]);

        if (! empty(trim(data_get($this->row, 'pages')))) {
            $item->manual_page_count = trim(data_get($this->row, 'pages'));
        }

        if (empty($item->pcf_unique_id_prefix)) {
            $item->pcf_unique_id_prefix = 'LE';
        }
        if (empty($item->name)) {
            $item->name = data_get($this->row, 'letter_name_formula_do_not_edit');
        }

        $item->save();

        $map = [
            'PDF/Image' => 'link_to_pdfimage',
            'Transcript' => 'link_to_transcript',
            'Format' => 'format',
            'Held' => 'held',
            'Collection #' => 'collection',
            'WWJ Date' => 'wwj_date',
            'Summary' => 'summary',
            'Doc Date' => 'doc_date',
            'WWJ' => 'wwj',
            'WWJ Description' => 'wwj_description',
            'Author Last Name' => 'author_last_name',
            'Author First Name' => 'author_first_name',
            'Author City' => 'author_city',
            'Author State' => 'author_state',
            'Recipient Last Name' => 'recipient_last_name',
            'Recipient First Name' => 'recipient_first_name',
            'Recipient City' => 'recipient_city',
            'Recipient State' => 'recipient_state',
            'Description from Collection' => 'description_from_collection',
            'Document Type' => 'document_type',
        ];

        $template = Template::query()
            ->with(['properties'])
            ->firstWhere('name', 'Letters');

        foreach ($template->properties as $property) {
            if ($property->type == 'date') {
                $value = $this->toCarbonDate(data_get($this->row, $map[$property->name]));
            } else {
                $value = data_get($this->row, $map[$property->name]);
            }

            if (str($value)->trim()->isNotEmpty()
                && ! str($value)->contains('#VALUE!')
            ) {
                Value::updateOrCreate([
                    'item_id' => $item->id,
                    'property_id' => $property->id,
                ], [
                    'value' => $value,
                ]);
            }
        }

        if ($item->wasRecentlyCreated) {
            info($item->name.' was newly created.');
        } else {
            info($item->name.' was updated.');
        }
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
                return Carbon::createFromFormat('Y-m-d', $stringDate)->toDateString();
            }
        } catch (\Exception $exception) {
            return null;
        }
    }
}
