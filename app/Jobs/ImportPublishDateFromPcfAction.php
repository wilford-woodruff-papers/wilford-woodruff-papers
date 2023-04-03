<?php

namespace App\Jobs;

use App\Models\Item;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportPublishDateFromPcfAction implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $row;

    public $type;

    public $dateFormat = 'Y-m-d';

    public $dateColumn = 'published_on_website';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $row)
    {
        $this->type = $type;
        $this->row = $row;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! empty($this->batch()) && $this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }

        if (empty(data_get($this->row, 'unique_identifier')) || empty(data_get($this->row, 'published_on_website'))) {
            return;
        }

        $unique_identifier = data_get($this->row, 'unique_identifier');
        $unique_identifier_prefix = null;
        $unique_identifier_suffix = null;
        dd('Need to update this to get suffix and prefix from the item');

        switch ($this->type) {
            case 'Journals':
                $typeIds = Type::query()->whereIn('name', ['Journals', 'Journal Sections'])->pluck('id')->all();
                $this->dateFormat = 'Y-m-d';
                $this->dateColumn = 'published_on_website';
                break;
            case 'Letters':
                $typeIds = Type::query()->whereIn('name', ['Letters'])->pluck('id')->all();
                $this->dateFormat = 'Y-m-d';
                $this->dateColumn = 'published';
                break;
            case 'Additional Documents':
                $typeIds = Type::query()->whereIn('name', ['Additional'])->pluck('id')->all();
                $this->dateFormat = 'Y-m-d';
                $this->dateColumn = 'published_on_website';
                break;
            case 'Discourses':
                $typeIds = Type::query()->whereIn('name', ['Discourses'])->pluck('id')->all();
                $this->dateFormat = 'Y-m-d';
                $this->dateColumn = 'published_on_website';
                break;
            case 'Autobiographies':
                $typeIds = Type::query()->whereIn('name', ['Autobiographies', 'Autobiography Sections'])->pluck('id')->all();
                $this->dateFormat = 'Y-m-d';
                $this->dateColumn = 'published_on_website';
                $unique_identifier_prefix = str($unique_identifier)->before('-');
                break;
        }

        $type = Type::firstWhere('name', $this->type);
        $actionType = \App\Models\ActionType::firstWhere('name', 'Publish');
        $user = \App\Models\User::firstWhere('email', 'auto@wilfordwoodruffpapers.org');

        $item = Item::query()
            ->whereIn('type_id', $typeIds)
            ->where('pcf_unique_id', data_get($this->row, 'unique_identifier'))
            ->when($unique_identifier_prefix, function ($query, $unique_identifier_prefix) {
                $query->where('pcf_unique_id_prefix', $unique_identifier_prefix);
            })
            ->first();

        if ($item) {
            \App\Models\Action::updateOrCreate([
                'actionable_type' => get_class($item),
                'actionable_id' => $item->id,
                'action_type_id' => $actionType->id,
            ], [
                'assigned_to' => $user->id,
                'assigned_at' => $this->toCarbonDate(data_get($this->row, $this->dateColumn)),
                'completed_by' => $user->id,
                'completed_at' => $this->toCarbonDate(data_get($this->row, $this->dateColumn)),
            ]);
        }
        foreach ($item->pages as $page) {
            \App\Models\Action::updateOrCreate([
                'actionable_type' => get_class($page),
                'actionable_id' => $page->id,
                'action_type_id' => $actionType->id,
            ], [
                'assigned_to' => $user->id,
                'assigned_at' => $this->toCarbonDate(data_get($this->row, $this->dateColumn)),
                'completed_by' => $user->id,
                'completed_at' => $this->toCarbonDate(data_get($this->row, $this->dateColumn)),
            ]);
        }
    }

    private function toCarbonDate($stringDate)
    {
        if (empty($stringDate) || str($stringDate)->lower()->toString() == 'n/a' || str($stringDate)->lower()->toString() == '#n/a') {
            info('Date invalid for: '.$this->row['unique_identifier'].' | '.$stringDate);

            return null;
        }

        try {
            if (is_numeric($stringDate)) {
                return Carbon::instance(Date::excelToDateTimeObject($stringDate))->toDateString();
            } else {
                return Carbon::createFromFormat($this->dateFormat, $stringDate);
            }
        } catch (\Exception $exception) {
            info('Date invalid for: '.$this->row['unique_identifier'].' | '.$stringDate);

            return null;
        }
    }
}
