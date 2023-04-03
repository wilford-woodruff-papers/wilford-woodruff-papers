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

class ImportDaybooksMasterFileAction implements ShouldQueue
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
    public function handle(): void
    {
        if (empty($uniqueID = data_get($this->row, 'unique_identifier'))) {
            info('No ID');

            return;
        }

        $identifier = data_get($this->row, 'unique_identifier');
        $prefix = str($identifier)->before('-');
        $uniqueID = str($identifier)->after('-');
        $type = Type::firstWhere('name', 'Daybooks');

        $item = Item::query()->firstOrNew([
            'pcf_unique_id' => $uniqueID,
            'type_id' => $type->id,
        ]);

        if (! empty(data_get($this->row, 'of_pages'))) {
            $item->manual_page_count = data_get($this->row, 'of_pages');
        }

        if (empty($item->pcf_unique_id_prefix)) {
            $item->pcf_unique_id_prefix = $prefix;
        }
        if (empty($item->name)) {
            $item->name = data_get($this->row, 'name');
        }

        $item->save();

        $map = [
            'Notes' => 'notes',
            'Source' => 'document_collection_link_to_source',
            'Source Link' => 'source_link',
            'Access Needed From CHL (Y/N)' => 'access_needed_from_chl_yn',
            'File Format' => 'file_format',
            'Doc Date' => 'date_originally_created',
            'Description' => 'brief_document_description',
        ];

        $template = Template::query()
            ->with(['properties'])
            ->firstWhere('name', 'Daybooks');

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
