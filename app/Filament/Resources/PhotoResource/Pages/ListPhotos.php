<?php

namespace App\Filament\Resources\PhotoResource\Pages;

use App\Filament\Exports\PhotoExporter;
use App\Filament\Resources\PhotoResource;
use App\Models\Photo;
use Filament\Actions;
use Filament\Actions\Exports\Models\Export;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;
use Spatie\MediaLibrary\Support\MediaStream;

class ListPhotos extends ListRecords
{
    protected static string $resource = PhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->exporter(PhotoExporter::class)
                ->fileName(fn (Export $export): string => "photos-{$export->getKey()}")
                ->chunkSize(100),
            Actions\Action::make('download_files')
                ->label('Download Files')
                ->color('warning')
                ->action(function (Actions\Action $action, array $data, Component $livewire) {

                    if ($livewire instanceof HasTable) {
                        $query = $livewire->getTableQueryForExport();
                    } else {
                        $query = Photo::query();
                    }

                    $records = $query->with(['media'])->get();
                    $media = collect();
                    foreach ($records as $record) {
                        $media = $media->merge($record->media);
                    }

                    return MediaStream::create('photos.zip')
                        ->addMedia($media);
                }),
        ];
    }
}
