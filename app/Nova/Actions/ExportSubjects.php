<?php

namespace App\Nova\Actions;

use App\Exports\PageExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportSubjects extends DownloadExcel implements WithMapping, WithHeadings
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Category',
            'Number Occurrences',
            'URL',
            'Bio',
        ];
    }

    /**
     * @param $item
     *
     * @return array
     */
    public function map($subject): array
    {
        $subject->load('category');
        $subject->loadCount('pages');

        return [
            $subject->name,
            $subject->category->pluck('name')->join(';'),
            $subject->pages_count,
            config('app.url').'/subjects/'.$subject->slug,
            $subject->bio,
        ];
    }
}
