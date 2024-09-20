<?php

namespace App\Filament\Exports;

use App\Models\Subject;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class SubjectExporter extends Exporter
{
    protected static ?string $model = Subject::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('Internal ID'),
            ExportColumn::make('unique_id')
                ->label('Unique ID'),
            ExportColumn::make('pid')
                ->label('FamilySearch ID'),
            ExportColumn::make('name')
                ->label('Name'),
            ExportColumn::make('slug')
                ->label('Slug'),
            ExportColumn::make('category.name')
                ->label('Categories'),
            ExportColumn::make('nova_url')
                ->label('Nova URL')
                ->formatStateUsing(fn (Subject $record): string => url('nova/resources/subjects/'.$record->id)),
            ExportColumn::make('content_url')
                ->label('Content Admin URL')
                ->formatStateUsing(function (Subject $record): string {
                    if (empty($record->slug)) {
                        return '';
                    }
                    if ($record->category->contains('name', 'People')) {
                        return url('/admin/dashboard/people/'.$record->slug.'/edit');
                    } elseif ($record->category->contains('name', 'Places')) {
                        return url('/admin/dashboard/places/'.$record->slug.'/edit');
                    } else {
                        return '';
                    }
                }),
            ExportColumn::make('subject_uri')
                ->label('FTP URL'),
            ExportColumn::make('bio')
                ->label('Bio'),
            ExportColumn::make('bio_completed_at')
                ->label('Bio Completed'),
            ExportColumn::make('bio_approved_at')
                ->label('Bio Approved'),
            ExportColumn::make('footnotes')
                ->label('Footnotes'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your subject export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }

    public function getJobQueue(): ?string
    {
        return 'exports';
    }

    public function getJobMiddleware(): array
    {
        return [
            (new WithoutOverlapping("export{$this->export->getKey()}"))
                ->expireAfter(600),
        ];
    }
}
