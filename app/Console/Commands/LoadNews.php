<?php

namespace App\Console\Commands;

use App\Models\Press;
use Illuminate\Console\Command;

class LoadNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import News';

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
        $news = $this->getNews();
        foreach ($news as $key => $article) {
            $article['type'] = 'NEWS';
            $press = Press::create($article);
        }

        return Command::SUCCESS;
    }

    private function getNews()
    {
        return json_decode('[
            {
                "title":"The Wilford Woodruff Papers: How a Detailed Personal Record Can Give Us Stunning Insights into the Restoration",
                "subtitle":"Meridian Magazine",
                "description":"On March 1, 1807 a child was born in Connecticut who would become not only another witness of the Restoration, but a catalyst in the process of revelation that was required. From the day of his baptism on December 31, 1833 he kept a faithful record of \"this Church and kingdom and the dealings of God with us.\" His record provides a front row seat to the ongoing restoration of the principles and doctrines of the gospel of Jesus Christ.",
                "date":"2021-03-01",
                "link":"https://latterdaysaintmag.com/the-wilford-woodruff-papers-how-a-detailed-personal-record-can-give-us-stunning-insights-into-the-restoration/",
                "embed":""
            },
            {
                "title":"The Wilford Woodruff Papers website is live. Here\'s what you need to know. Very few in the history of The Church of Jesus Christ of Latter-day Saints kept records like Wilford Woodruff.",
                "subtitle":"Deseret News",
                "description":"Starting in 1828, Woodruff\'s meticulous records document his extensive ministry and missionary service, the teachings of Joseph Smith and other leaders, daily happenings, his witness of the church’s Restoration and other significant events until his death in 1898.",
                "date":"2021-03-06",
                "link":"https://www.deseret.com/faith/2021/3/6/22307952/how-journals-letters-deeper-look-at-record-keeping-latter-day-saint-leader-wilford-woodruff-papers",
                "embed":""
            },
            {
                "title":"Wilford Woodruff’s Unmatched Eyewitness Account of the Restoration",
                "subtitle":"Meridian Magazine",
                "description":"Wilford Woodruff was an apostle of the Lord Jesus Christ for 59 years. To acknowledge God\'s direction in his daily life, he documented nearly every testimony he bore, every mission on which he embarked, every person he baptized or blessed, and every temple ordinance he performed in the Lord\'s service.",
                "date":"2021-03-11",
                "link":"https://latterdaysaintmag.com/wilford-woodruffs-unmatched-eyewitness-account-of-the-restoration/",
                "embed":""
            },
            {
                "title":"The Wilford Woodruff Papers: How a Team of Individuals Are Making Possible the Impossible!",
                "subtitle":"Meridian Magazine",
                "description":"This third of a four-part series to understand the legacy of Wilford Woodruff, includes an explanation of our mission to collect, transcribe, publish, and digitally preserve Wilford Woodruff\'s records to proclaim that Jesus Christ has restored his gospel and continues to reveal his will through his prophets.",
                "date":"2021-03-22",
                "link":"https://latterdaysaintmag.com/the-wilford-woodruff-papers-how-a-team-of-individuals-are-making-possible-the-impossible",
                "embed":""
            }
        ]', true);
    }
}
