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
            'Additional Fields',
        ];
    }

    public function map($item): array
    {
        $extra = [];
        $item->extra_attributes->each(function ($value, $key) use (&$extra) {
            $extra["{$key}_0"] = $key;
            $extra["{$key}_1"] = $value;
        });

        return [
            $item->id,
            $item->first_name,
            $item->last_name,
            $item->email,
            $item->created_at->toDateString(),
            ...$extra,
        ];
    }
}
