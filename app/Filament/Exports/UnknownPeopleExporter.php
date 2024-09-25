<?php

namespace App\Filament\Exports;

use App\Models\Identification;
use App\Models\Subject;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class UnknownPeopleExporter extends Exporter
{
    protected static ?string $model = Identification::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('Internal ID'),
            ExportColumn::make('researcher.name')
                ->label('Researcher'),
            ExportColumn::make('editorial_assistant')
                ->label('Editorial Assistant'),
            ExportColumn::make('title')
                ->label('Title'),
            ExportColumn::make('first_middle_name')
                ->label('First and Middle Name'),
            ExportColumn::make('last_name')
                ->label('Last Name'),
            ExportColumn::make('other')
                ->label('Other Names'),
            ExportColumn::make('guesses')
                ->label('Guesses'),
            ExportColumn::make('location')
                ->label('Location'),
            ExportColumn::make('completed_at')
                ->label('Completed At'),
            ExportColumn::make('notes')
                ->label('Notes'),
            ExportColumn::make('fs_id')
                ->label('FamilySearch ID'),
            ExportColumn::make('approximate_birth_date'),
            ExportColumn::make('approximate_death_date'),
            ExportColumn::make('nauvoo_database'),
            ExportColumn::make('pioneer_database'),
            ExportColumn::make('missionary_database'),
            ExportColumn::make('boston_index'),
            ExportColumn::make('st_louis_index'),
            ExportColumn::make('british_mission'),
            ExportColumn::make('eighteen_forty_census'),
            ExportColumn::make('eighteen_fifty_census'),
            ExportColumn::make('eighteen_sixty_census'),
            ExportColumn::make('other_census'),
            ExportColumn::make('other_records'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('correction_needed'),
            ExportColumn::make('cant_be_identified'),
            ExportColumn::make('ftp_url_checked_at'),
            ExportColumn::make('ftp_status'),
            ExportColumn::make('link_to_ftp')
                ->label('FTP URL'),
            ExportColumn::make('filament_url')
                ->label('Filament URL')
                ->formatStateUsing(fn ($record): string => url('filament/admin/unknown-people/'.$record->id.'/edit')),
            ExportColumn::make('content_url')
                ->label('Content Admin URL')
                ->formatStateUsing(function ($record): string {
                    return url('/admin/dashboard/identification/people/'.$record->id.'/edit');
                }),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your unidentified person export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

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
