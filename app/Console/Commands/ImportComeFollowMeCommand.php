<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportComeFollowMeCommand extends Command
{
    protected $signature = 'cfm:import';

    protected $description = 'Command description';

    public function handle(): void
    {
        $books = [
            'Doctrine and Covenants' => 'Doctrine and Covenants.csv',
        ];

        foreach ($books as $book => $file) {
            logger()->info($file);
            Excel::import(
                new \App\Imports\ComeFollowMeImport(book: $book),
                storage_path('app/imports/'.$file)
            );
        }
    }
}
