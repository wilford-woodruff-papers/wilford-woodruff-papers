<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportSubjectsWithChildren extends DownloadExcel implements WithMapping, WithHeadings
{
    public $name = 'Export Subjects with Children';

    public function headings(): array
    {
        return [
            'Parent Name',
            'Children',
            'Grandchildren',
            'Great Grandchildren',
        ];
    }

    /**
     * @param $item
     */
    public function map($subject): array
    {
        $subject->load('children', 'children.children', 'children.children.children');

        $grandChildren = collect([]);
        $greatGrandChildren = collect([]);

        foreach ($subject->children as $child) {
            $grandChildren->push(...$child->children->all());
        }

        foreach ($grandChildren as $child) {
            $greatGrandChildren->push(...$child->children->all());
        }

        return [
            $subject->name,
            $subject->children->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name')->join(';'),
            $grandChildren->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name')->join(';'),
            $greatGrandChildren->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name')->join(';'),
        ];
    }
}
