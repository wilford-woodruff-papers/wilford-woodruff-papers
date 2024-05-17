<?php

namespace App\Console\Commands;

use App\Imports\SubjectImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class ImportSubjectsCommand extends Command
{
    protected $signature = 'subjects:import';

    protected $description = 'Command description';

    public function handle(): void
    {
        $response = Http::withHeaders([
            'Authorization' => 'Token token=Jpu4f3wzZb4BJHFrnaErtAtt',
        ])
            ->post('https://fromthepage.com/api/v1/bulk_export/wilford-woodruff-papers-project?subject_details_csv_collection=true');

        $statusUri = $response->json('status_uri');
        $downloadUri = $response->json('download_uri');
        if (! empty($statusUri) && ! empty($downloadUri)) {
            Cache::put('import-subjects', true, $seconds = 3600);

            $tries = 0;
            $status = 'queued';

            while ($status !== 'finished' && $tries < 10) {
                $response = Http::withHeaders([
                    'Authorization' => 'Token token=Jpu4f3wzZb4BJHFrnaErtAtt',
                ])
                    ->get($statusUri);
                $status = $response->json('status');
                if ($status !== 'finished') {
                    $this->info('Attempt to download subjects from FTP '.$tries.': '.$status);
                    sleep(30);
                    $tries++;
                } else {
                    $this->info('Subjects ready to download from FTP after '.$tries);
                }
            }

            if ($status === 'finished') {
                $response = Http::withHeaders([
                    'Authorization' => 'Token token=Jpu4f3wzZb4BJHFrnaErtAtt',
                ])
                    ->get($downloadUri);
                Storage::put('subject_export.zip', $response->body());
                $zip = new ZipArchive();
                $zipFile = $zip->open(storage_path('app/subject_export.zip'));
                Excel::import(
                    new SubjectImport(false),
                    storage_path('app/exports/subject_details.csv')
                );
                Cache::forget('import-subjects');
                $this->info('Subjects downloaded successfully!');
            }
        }
    }
}
