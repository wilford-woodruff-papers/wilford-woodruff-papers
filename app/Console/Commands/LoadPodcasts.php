<?php

namespace App\Console\Commands;

use App\Models\Press;
use Illuminate\Console\Command;

class LoadPodcasts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:podcasts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Podcasts';

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
        $podcasts = $this->getPodcasts();
        foreach ($podcasts as $key => $podcast) {
            $podcast['type'] = 'PODCAST';
            $press = Press::create($podcast);
        }

        return Command::SUCCESS;
    }

    private function getPodcasts()
    {
        return json_decode('[
            {
                "title":"Rational Faiths, Episode 20: Wilford Woodruff\'s Witness",
                "subtitle":"Geoff Nelson and Jennifer Mackley",
                "description":"Host Geoff Nelson talks with Jennifer Mackley, author of <i>Wilford Woodruff’s Witness: The Development of Temple Doctrine</i>, and now our project\'s Executive Director, about how she became the leading expert and historian on Wilford Woodruff\'s life and record. She explains why Wilford\'s undiluted perspective is so important to Church history, particularly as it relates to the development of temple doctrine and the process of continuing revelation.",
                "date":"2014-08-31",
                "link":"https://rationalfaiths.com/wilford-woodruffs-witness-author-interview/",
                "embed":""
            },
            {
                "title":"LDS Perspectives, Episode #57: The Evolution of Temple Doctrine",
                "subtitle":"Sarah Hatch and Jennifer Mackley",
                "description":"Host Sarah Hatch discusses Jennifer Mackley\'s book, Wilford Woodruff\'s Witness: The Development of Temple Doctrine. Jennifer, now our Executive Director and co-founder of the Wilford Woodruff Papers Foundation, explains how her mother introduced her to Wilford Woodruff\'s vision of the Founding Fathers in the St. George Temple, and how her interest grew from there.",
                "date":"2017-10-09",
                "link":"https://ldsperspectives.com/2017/10/09/temple-doctrine-development/",
                "embed":""
            },
            {
                "title":"Saints, Episode 4: An Ensign to the Nations",
                "subtitle":"Ben Godfrey, Shalyn Back, and Jake Olmstead",
                "description":"Ben Godfrey and Shalyn Back talk to Jake Olmstead, Curator of Historic Sites for the Church History Department, about Brigham Young and Wilford Woodruff\'s arrival to the Salt Lake Valley as they seek a refuge to build their temple. Olmstead explains Wilford’s role as record keeper and witness to Brigham Young\'s vision of the temple site, and the importance of those two acting together as the prophet who begins work on the Salt Lake Temple and the future prophet who completes and dedicates the temple after President Young\'s death.",
                "date":"2020-01-15",
                "link":"https://podcasts.apple.com/us/podcast/4-an-ensign-to-the-nations/id1491996695?i=1000462809813",
                "embed":""
            },
            {
                "title":"Saints, Episode 28: Until the Coming of the Son of Man",
                "subtitle":"Ben Godfrey, Shalyn Back, and Jeff Anderson",
                "description":"Ben Godfrey and Shalyn Back interview Jeff Anderson, who works on the Global Acquisition team in the Church History Department, caring for found and donated historical documents. Together they discuss the spread of the gospel to Hawaii and Europe, the early translations of the Book of Mormon, the early church academies, and the first temples built in Utah Territory during Wilford Woodruff\'s lifetime.",
                "date":"2020-07-01",
                "link":"https://podcasts.apple.com/us/podcast/28-until-the-coming-of-the-son-of-man/id1491996695?i=1000484171220",
                "embed":""
            },
            {
                "title":"Saints, Episode 44: Blessed Peace",
                "subtitle":"Ben Godfrey, Shalyn Back, and Jenny Lund",
                "description":"Hosts Ben Godfrey and Shalyn Back discuss the dedication of the Salt Lake Temple with Director of the Historic Sites Division in the Church History Department, Jenny Lund. The Saints viewed the temple dedication as the culmination of decades of persecution and struggle, as the prophet at the time and as one who was with Brigham Young as they chose the site for the temple, President Woodruff plays a pivotal role in the building and dedication of the Salt Lake Temple.",
                "date":"2020-10-21",
                "link":"https://podcasts.apple.com/us/podcast/44-blessed-peace/id1491996695?i=1000495651933",
                "embed":""
            },
            {
                "title":"FAIR Voice Episode #26: Wilford Woodruff Papers part 1",
                "subtitle":"Steve Harper and Jennifer Mackley",
                "description":"Listen as our Executive Editor, Steve Harper, interviews Jennifer Mackley, our Executive Director and co-founder of the Wilford Woodruff Papers Foundation. Together they discuss Jennifer\'s interest in Wilford Woodruff, why and how she decided to make this project her life\'s passion, and why President Woodruff\'s extensive record keeping gives us such a clear view of the Restoration of the gospel.",
                "date":"2021-01-24",
                "link":"https://www.fairlatterdaysaints.org/blog/2021/01/24/fair-voice-episode-26-wilford-woodruff-papers-part-1",
                "embed":"<iframe height=\'100\' src=\'https://drive.google.com/file/d/1xkg--EvXmVhm-44AB69Hwxspf8l4I3QU/preview\' style=\'border: none; height: 100px;\' width=\'480\'></iframe>"
            },
            {
                "title":"FAIR Voice Episode #27: Wilford Woodruff Papers part 2",
                "subtitle":"Hanna Seriac, Steve Harper, and Jennifer Mackley",
                "description":"Host Hanna Seriac talks to our Executive Editor, Steve Harper, and our Executive Director, Jennifer Mackley, about Wilford Woodruff\'s life and conversion, the development of temple doctrine, and what we can learn from him about continuing revelation. They end the interview with a discussion of how the Wilford Woodruff Papers Project got started and what the process is to collect, digitize, preserve, and publish Wilford\'s documents.",
                "date":"2021-01-31",
                "link":"https://www.fairlatterdaysaints.org/blog/2021/01/31/fair-voice-podcast-27-wilford-woodruff-papers-part-2",
                "embed":"<iframe height=\'100\' src=\'https://drive.google.com/file/d/1t9_KvZ8tZT7qdAh1KliSUbgINjS7aLrO/preview\' style=\'border: none; height: 100px;\' width=\'480\'></iframe>"
            }
        ]', true);
    }
}
