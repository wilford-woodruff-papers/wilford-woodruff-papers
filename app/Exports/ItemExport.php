<?php

namespace App\Exports;

use App\Models\Item;
use App\Models\User;
use App\Notifications\ExportFailedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class ItemExport implements FromQuery, ShouldQueue, WithMapping, WithHeadings
{
    use Exportable;

    public $user;

    /**
     * Optional Writer Type
     */
    private $writerType = Excel::CSV;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function query()
    {
        return Item::query()
            ->where('enabled', true)
            ->whereNull('item_id')
            ->with([
                'type',
            ]);
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error($exception->getMessage());
        $this->user->notify(new ExportFailedNotification());
    }

    public function headings(): array
    {
        return [
            'Internal ID',
            'Document Type',
            'UUID',
            'Name',
            'Website URL',
            'Short URL',
            'Image URL',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->type?->name,
            $item->uuid,
            $item->name,
            route('documents.show', ['item' => $item->uuid]),
            route('short-url.item', ['hashid' => $item->hashid()]),
            $item->firstPage?->getFirstMedia()?->getUrl(),
        ];
    }
}
