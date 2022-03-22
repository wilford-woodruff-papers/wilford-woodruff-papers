<?php

namespace App\Console\Commands;

use App\Imports\BiographyImport;
use App\Imports\TimelineImport;
use App\Models\Event;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class LoadEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Timeline events';

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
        $events = Event::where('imported', 1)->get();
        $events->each(function ($event) {
            $event->clearMediaCollection();
            $event->delete();
        });

        Excel::import(new TimelineImport, storage_path('app/timeline.csv'));

        return 0;
    }
}
