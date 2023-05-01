<?php

namespace App\Console\Commands;

use App\Models\Press;
use Illuminate\Console\Command;

class LoadVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Videos';

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
        $videos = $this->getVideos();
        foreach ($videos as $key => $video) {
            $video['type'] = 'VIDEO';
            $press = Press::create($video);
        }

        return Command::SUCCESS;
    }

    private function getVideos()
    {
        return json_decode('[
            {
                "title":"Wilford Woodruff and the Mission of Elijah",
                "subtitle":"2016 Fireside presented by Jennifer Mackley",
                "description":"",
                "date":"2016-02-24",
                "link":"",
                "embed":"<iframe style=\'width: 100%; height: 480px;\' src=\'https://www.youtube.com/embed/jnxL-rkIMK4?rel=0\' frameborder=\'0\' allow=\'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\' allowfullscreen></iframe>"
            },
            {
                "title":"The Development of Temple Doctrine Part 4",
                "subtitle":"2018 Fireside: Q&A presented by Jennifer Mackley",
                "description":"",
                "date":"2018-09-21",
                "link":"",
                "embed":"<iframe style=\'width: 100%; height: 480px;\' src=\'https://www.youtube.com/embed/7KurN7jVNqE?t=218s&rel=0\' frameborder=\'0\' allow=\'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\' allowfullscreen></iframe>"
            },
            {
                "title":"The Development of Temple Doctrine Part 3",
                "subtitle":"2018 Fireside: 1870s to 1890s + Q&A presented by Jennifer Mackley",
                "description":"",
                "date":"2018-09-21",
                "link":"",
                "embed":"<iframe style=\'width: 100%; height: 480px;\' src=\'https://www.youtube.com/embed/lk7ezwBNZvo?rel=0\' frameborder=\'0\' allow=\'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\' allowfullscreen></iframe>"
            },
            {
                "title":"The Development of Temple Doctrine Part 2",
                "subtitle":"2018 Fireside: 1840s to 1870s presented by Jennifer Mackley",
                "description":"",
                "date":"2018-09-21",
                "link":"",
                "embed":"<iframe style=\'width: 100%; height: 480px;\' src=\'https://www.youtube.com/embed/-USb8Ppto98?rel=0\' frameborder=\'0\' allow=\'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\' allowfullscreen></iframe>"
            },
            {
                "title":"The Development of Temple Doctrine Part 1",
                "subtitle":"2018 Fireside: 1820s to 1840s presented by Jennifer Mackley",
                "description":"",
                "date":"2018-09-21",
                "link":"",
                "embed":"<iframe style=\'width: 100%; height: 480px;\' src=\'https://www.youtube.com/embed/XJdrm4TijCk?t=248s&rel=0\' frameborder=\'0\' allow=\'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\' allowfullscreen></iframe>"
            },
            {
                "title":"Wilford Woodruff Papers Foundation Introduction",
                "subtitle":"",
                "description":"",
                "date":"2021-02-25",
                "link":"",
                "embed":"<iframe style=\'width: 100%; height: 480px;\' src=\'https://www.youtube.com/embed/i6iuBzxlF20?rel=0\' frameborder=\'0\' allow=\'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\' allowfullscreen></iframe>"
            },
            {
                "title":"Treasure Box",
                "subtitle":"",
                "description":"",
                "date":"2021-02-28",
                "link":"",
                "embed":"<iframe style=\'width: 100%; height: 480px;\' src=\'https://www.youtube.com/embed/LGrk-8dYpVg?rel=0\' frameborder=\'0\' allow=\'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\' allowfullscreen></iframe>"
            },
            {
                "title":"Wilford Woodruff Papers Website Introduction",
                "subtitle":"",
                "description":"",
                "date":"2021-03-11",
                "link":"",
                "embed":"<iframe style=\'width: 100%; height: 480px;\' src=\'https://www.youtube.com/embed/n-awaZrXlzs?rel=0\' frameborder=\'0\' allow=\'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\' allowfullscreen></iframe>"
            }
        ]', true);
    }
}
