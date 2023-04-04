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

class ImportDiscoursesMasterFileAction implements ShouldQueue
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

        $type = Type::firstWhere('name', 'Discourses');

        $item = Item::firstOrNew([
            'type_id' => $type->id,
            'pcf_unique_id' => $uniqueID,
        ]);

        if (! empty(trim(data_get($this->row, 'of_pages')))) {
            $item->manual_page_count = trim(data_get($this->row, 'of_pages'));
        }

        if (empty($item->pcf_unique_id_prefix)) {
            $item->pcf_unique_id_prefix = 'D';
        }
        if (empty($item->name)) {
            if (! empty(data_get($this->row, 'name_link_in_ftp'))) {
                $item->name = data_get($this->row, 'name_link_in_ftp');
            } else {
                $item->name = 'Discourse '.data_get($this->row, 'discourse_date');
            }
        }

        $item->save();

        $map = [
            'Notes' => 'notes',
            'Year' => 'year',
            'Discourse Date' => 'discourse_date',
            'WWJ Date' => 'wwj_date',
            'Journal Entry Description' => 'journal_entry_description',
            'Day of the Week' => 'day_of_the_week',
            'Speaker\'s Title' => 'speakers_title',
            'Discourse Description' => 'discourse_description',
            'City' => 'city',
            'County' => 'county',
            'State' => 'state',
            'Location' => 'location',
            'Occasion' => 'occasion',
            'Google Text Doc' => 'link_to_google_text_doc',
            'PDF/Image' => '2nd_link_to_text_image_doc',
            'Call Number' => 'call_number',
            'Entity' => 'entity',
            'Source' => 'source',
            'Source Link' => 'source_link',
            'Deseret News' => 'link_to_deseret_news',
            'Deseret News Link' => 'deseret_news_link',
            'Millennial Star' => 'link_to_millennial_star',
            'Millennial Star Link' => 'millennial_star_link',
            'Access Needed From CHL (Y/N)' => 'access_needed_from_chl_yn',
            'Bibliographic Reference' => 'bibliographic_reference',
        ];

        $template = Template::query()
            ->with(['properties'])
            ->firstWhere('name', 'Discourses');

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
                return Carbon::createFromFormat('Y-m-d', $stringDate);
            }
        } catch (\Exception $exception) {
            return null;
        }
    }
}
