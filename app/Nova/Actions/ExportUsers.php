<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportUsers extends DownloadExcel implements WithMapping, WithHeadings
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Internal ID',
            'Name',
            'Email',
            'Roles',
        ];
    }

    /**
     * @param $item
     * @return array
     */
    public function map($item): array
    {
        $item->load(['roles']);

        return [
            $item->id,
            $item->name,
            $item->email,
            $item->roles->sortBy('name')->pluck('name')->join('|'),
        ];
    }
}
