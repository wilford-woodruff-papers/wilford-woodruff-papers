<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportSubjects extends DownloadExcel implements WithMapping, WithHeadings
{
    public function headings(): array
    {
        return [
            'Family Search ID',
            'Name',
            'Category',
            'Number Occurrences',
            'URL',
            'Bio',
        ];
    }

    /**
     * @param $item
     */
    public function map($subject): array
    {
        $subject->load('category');

        return [
            $subject->pid,
            $subject->name,
            $subject->category->pluck('name')->join(';'),
            $subject->total_usage_count,
            config('app.url').'/subjects/'.$subject->slug,
            $subject->bio,
        ];
    }
}
