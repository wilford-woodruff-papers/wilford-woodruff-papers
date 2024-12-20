<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ComeFollowMeSeeder extends Seeder
{
    public function run(): void
    {

        $books = [
            'Book of Mormon' => 'Book of Mormon.csv',
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
