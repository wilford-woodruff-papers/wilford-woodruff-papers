<?php

namespace App\Console\Commands;

use App\Imports\SubjectImport;
use App\Models\Child;
use App\Models\Wife;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class LoadSubjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:subjects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import people and places';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Excel::import(new SubjectImport, storage_path('app/fromthepage_subject_details.csv'));

        return 0;
    }
}
