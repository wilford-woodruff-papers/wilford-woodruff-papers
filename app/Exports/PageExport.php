<?php

namespace App\Exports;

use App\Models\Page;
use App\Models\User;
use App\Notifications\ExportFailedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PageExport implements FromQuery, ShouldQueue, WithMapping, WithHeadings
{
    use Exportable;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function query()
    {
        return Page::query()
            ->with([
                'item',
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
            'Parent ID',
            'Order',
            'Parent Name',
            'UUID',
            'Name',
            'Website URL',
            'Short URL',
            'Image URL',
            'Original Transcript',
            'Text Only Transcript',
            'People',
            'Places',
            'First Date',
            'Dates',
            'Topics',
        ];
    }

    public function map($page): array
    {
        return [
            $page->id,
            optional($page->parent?->type)->name,
            $page->parent_item_id,
            $page->order,
            $page->parent?->name,
            $page->uuid,
            $page->name,
            ((! empty($page->item)) ? route('pages.show', ['item' => $page->item?->uuid, 'page' => $page->uuid]) : ''),
            ((! empty($page->id)) ? route('short-url.page', ['hashid' => $page->hashid()]) : ''),
            $page->getFirstMedia()?->getUrl(),
            $page->transcript,
            strip_tags($page->transcript),
            $page->subjects()->whereHas('category', function (Builder $query) {
                $query->where('name', 'People');
            })->pluck('subjects.name')->join('|'),
            $page->subjects()->whereHas('category', function (Builder $query) {
                $query->where('name', 'Places');
            })->pluck('subjects.name')->join('|'),
            $page->first_date,
            $page->taggedDates->map(function ($date) {
                return $date->date->toDateString();
            })->join('|'),
            $page->topics()->pluck('name')->join('|'),
        ];
    }
}
