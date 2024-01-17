<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportSubjects extends DownloadExcel implements WithHeadings, WithMapping
{
    public function headings(): array
    {
        return [
            'Internal ID',
            'Unique ID',
            'Family Search ID',
            'Name',
            'Category',
            'Document Types',
            'Number Occurrences',
            'URL',
            'Admin URL',
            'Bio',
        ];
    }

    /**
     * @param $item
     */
    public function map($subject): array
    {
        $subject
            ->load([
                'category',
                'pages.parent.type',
            ]);

        return [
            $subject->id,
            $subject->unique_id,
            $subject->pid,
            $subject->name,
            $subject->category->pluck('name')->join(';'),
            $subject->pages->map(function ($page) {
                return $page->parent?->type?->name;
            })
                ->unique()
                ->join(';'),
            (($subject->total_usage_count > 0) ? $subject->total_usage_count : $subject->tagged_count),
            config('app.url').'/subjects/'.$subject->slug,
            config('app.url').'/admin/dashboard/people/'.$subject->slug.'/edit',
            $subject->bio,
        ];
    }
}
