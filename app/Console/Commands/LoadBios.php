<?php

namespace App\Console\Commands;

use App\Imports\BiographyImport;
use App\Imports\SubjectImport;
use App\Models\Child;
use App\Models\Wife;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class LoadBios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:bios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Biographies';

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
        Excel::import(new BiographyImport, storage_path('app/website_publisher.csv'));

        return 0;
    }
}
