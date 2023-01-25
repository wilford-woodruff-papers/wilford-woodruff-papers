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
     *
     * @return void
     */
    public function handle()
    {
        if (empty($uniqueID = data_get($this->row, 'unique_identifier'))) {
            info('No ID');

            return;
        }

        $type = Type::firstWhere('name', 'Letters');

        $item = Item::query()
            ->where('pcf_unique_id', $uniqueID)
            ->where('type_id', $type->id)
            ->first();

        if (empty($item)) {
            info('Letter could not be found for: '.$uniqueID);

            return;
        }

        $item = Item::query()
            ->where('type_id', $type->id)
            ->where('pcf_unique_id', $uniqueID)
            ->first();

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

            if (str($value)->trim()->isNotEmpty()) {
                Value::updateOrCreate([
                    'item_id' => $item->id,
                    'property_id' => $property->id,
                ], [
                    'value' => $value,
                ]);
            }
        }

        // data_get($this->row, 'pages')

        /*$item->fill([
            '' => data_get($this->row, 'researcher'),
            '' => data_get($this->row, 'notes'),
            '' => data_get($this->row, 'year'),
            '' => data_get($this->row, 'pages'),
            '' => data_get($this->row, 'discourse_date'),
            '' => data_get($this->row, 'wwj_date'),
            '' => data_get($this->row, 'journal_entry_description'),
            '' => data_get($this->row, 'day_of_the_week'),
            '' => data_get($this->row, 'speakers_title'),
            '' => data_get($this->row, 'discourse_description'),
            '' => data_get($this->row, 'city'),
            '' => data_get($this->row, 'county'),
            '' => data_get($this->row, 'state'),
            '' => data_get($this->row, 'location'),
            '' => data_get($this->row, 'occasion'),
            '' => data_get($this->row, 'link_to_google_text_doc'),
            '' => data_get($this->row, '2nd_link_to_text_image_doc'),
            '' => data_get($this->row, 'call_number'),
            '' => data_get($this->row, 'entity'),
            '' => data_get($this->row, 'source'),
            '' => data_get($this->row, 'link_to_deseret_news'),
            '' => data_get($this->row, 'link_to_millennial_star'),
            '' => data_get($this->row, 'link_to_contributor'),
            '' => data_get($this->row, 'link_to_j_of_discourses'),
            '' => data_get($this->row, 'access_needed_from_chl_yn'),
            '' => data_get($this->row, 'bibliographic_reference'),
        ]);*/

        //$item->save();
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
