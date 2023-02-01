<?php

namespace App\Imports;

use App\Models\Photo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PhotoImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty(trim($row['filename'])) || Storage::missing('ww_images/'.trim($row['filename']))) {
                logger()->info('Skipping: '.$row['filename']);

                continue;
            }

            $photo = Photo::updateOrCreate([
                'filename' => trim($row['filename']),
            ], [
                'title' => trim($row['title']),
                'description' => trim($row['description']),
                'date' => trim($row['date']),
                'artist_or_photographer' => trim($row['artist_or_photographer']),
                'location' => trim($row['location']),
                'journal_reference' => trim($row['journal_reference']),
                'identification_source' => trim($row['identification_source_of_image']),
                'notes' => trim($row['notes']),
            ]);

            $photo->clearMediaCollection();
            $photo->addMedia(storage_path('app/ww_images/'.$row['filename']))
                    ->preservingOriginal()
                    ->toMediaCollection();
        }
    }
}
