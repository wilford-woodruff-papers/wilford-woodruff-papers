<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportRegistrations extends DownloadExcel implements WithMapping, WithHeadings
{
    public function headings(): array
    {
        return [
            'Internal ID',
            'First Name',
            'Last Name',
            'Email',
            'Registration Date',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->first_name,
            $item->last_name,
            $item->email,
            $item->created_at->toDateString(),
        ];
    }
}
