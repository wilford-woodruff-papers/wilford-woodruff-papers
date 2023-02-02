<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportContestants extends DownloadExcel implements WithMapping, WithHeadings
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Internal ID',
            'Title',
            'Name',
            'Phone',
            'Email',
            'Address',
            'Primary Contact',
            'Subscribe to Newsletter',
        ];
    }

    /**
     * @param $item
     * @return array
     */
    public function map($contestant): array
    {
        return [
            $contestant->id,
            $contestant->submission->title,
            $contestant->full_name,
            $contestant->phone,
            $contestant->email,
            $contestant->address,
            $contestant->is_primary_contact,
            $contestant->subscribe_to_newsletter,
        ];
    }
}
