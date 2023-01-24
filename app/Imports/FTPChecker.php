<?php

namespace App\Imports;

use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FTPChecker implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        if (Storage::fileExists(storage_path('app/public/reconcile_ftp.csv'))) {
            Storage::delete(storage_path('app/public/reconcile_ftp.csv'));
        }

        $filename = storage_path('app/public/reconcile_ftp.csv');
        $handle = fopen($filename, 'w');
        fputcsv($handle, [
            'Type',
            'Name',
            'Website URL',
            'FTP URL',
        ]);

        foreach ($rows as $row) {
            $transcribedPages = $row['pages_needing_review'] + $row['pages_marked_blank'] + $row['pages_transcribed'];
            $totalPages = $row['total_pages'];

            if ($transcribedPages !== $totalPages) {
                continue;
            }

            $document = Item::query()
                ->with(['type'])
                ->whereNotNull('ftp_id')
                ->whereDoesntHave('actions', function (Builder $query) {
                    $query->where('action_type_id', 1);
                })
                ->where('ftp_id', 'https://fromthepage.com/iiif/'.$row['fromthepage_id'].'/manifest')
                ->first();

            if (! empty($document)) {
                fputcsv($handle, [
                    $document->type?->name,
                    '=HYPERLINK("'.route('admin.dashboard.document.index', ['filters[search]' => $document->name]).'", "'.$document->name.'")',
                    route('admin.dashboard.document', ['item' => $document->uuid]),
                    'https://fromthepage.com/woodruff/woodruffpapers/'.$document->ftp_slug,
                ]);
            }
        }
    }
}
