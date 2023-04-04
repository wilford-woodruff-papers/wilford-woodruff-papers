<?php

namespace App\Console\Commands;

use App\Imports\PhotoImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class LoadPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:photos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Photos';

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
     */
    public function handle(): int
    {
        Excel::import(new PhotoImport, storage_path('app/image_metadata.csv'));

        return Command::SUCCESS;
    }
}
