<?php

namespace App\Console\Commands;

use App\Models\Child;
use App\Models\Subject;
use App\Models\Wife;
use Illuminate\Console\Command;

class LoadWivesAndChildren extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:family';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import wives and children';

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
        $wives = $this->getFamily();

        foreach ($wives as $person) {
            if (! $subject = Subject::whereSlug($person['link'])->first()) {
                $subject = Subject::create(['name' => $person['name']]);
            }
            $wife = new Wife();
            $wife->person_id = $subject->id;
            $wife->marriage_year = $person['year'];
            $wife->mother = $person['parents']['mother'];
            $wife->father = $person['parents']['father'];
            $wife->birthdate = $person['birthdate'];
            $wife->deathdate = $person['deathdate'];
            $wife->relationship = $person['relationship'];
            $wife->marriage = $person['marriage'];
            $wife->sealing = $person['sealing'];
            $wife->divorce = $person['divorce'];
            $wife->prior_marriage = $person['prior_marriage'];
            $wife->subsequent_marriage = $person['subsequent_marriage'];

            $wife->save();

            foreach ($person['children'] as $personchild) {
                $child = new Child();
                $child->name = $personchild['name'];
                $child->gender = $personchild['gender'];
                $child->birthdate = $personchild['birthdate'];
                $child->birthplace = $personchild['birthplace'];
                $child->deathdate = $personchild['deathdate'];
                $child->deathplace = $personchild['deathplace'];

                $wife->children()->save($child);
            }
        }

        return Command::SUCCESS;
    }

    private function getFamily()
    {
        return json_decode('[{
                                    "year": "1837",
                                    "link": "/subjects/phebe-whittemore-carter-woodruff",
                                    "name": "Phebe Whittemore Carter",
                                    "parents": {
                                        "mother": "Sarah Fabyan",
                                        "father": "Ezra Carter"
                                    },
                                    "birthdate": "Mar 8, 1807",
                                    "deathdate": "Nov 10, 1885",
                                    "relationship": "Wilford met Phebe in Kirtland, Ohio",
                                    "marriage": "April 13, 1837 in Kirtland, Ohio",
                                    "sealing": "Nov 11, 1843 in Nauvoo, Illinois",
                                    "divorce": null,
                                    "prior_marriage": null,
                                    "subsequent_marriage": null,
                                    "children": [
                                    {"name": "Sarah Emma", "gender": "F", "birthdate": "July 14, 1838", "birthplace": "Scarborough, Maine", "deathdate": "July 17, 1840", "deathplace": "Nauvoo, Illinois"},
                                        {"name": "Wilford", "gender": "M", "birthdate": "March 22, 1840", "birthplace": "Montrose, Iowa", "deathdate": "May 6, 1921", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "Phebe Amelia", "gender": "F", "birthdate": "March 4, 1842", "birthplace": "Nauvoo, Illinois", "deathdate": "February 15, 1897", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "Susan Cornelia", "gender": "F", "birthdate": "July 25, 1843", "birthplace": "Nauvoo, Illinois", "deathdate": "October 6, 1897", "deathplace": "Sioux City, Iowa"},
                                        {"name": "Joseph", "gender": "M", "birthdate": "July 18, 1845", "birthplace": "Liverpool, England", "deathdate": "November 12, 1846", "deathplace": "Winter Quarters, NE"},
                                        {"name": "Ezra", "gender": "M", "birthdate": "December 8, 1846", "birthplace": "Winter Quarters, NE", "deathdate": "December 10, 1846", "deathplace": "Winter Quarters, NE"},
                                        {"name": "Shuah Carter", "gender": "F", "birthdate": "October 28, 1847", "birthplace": "Council Bluffs, Iowa", "deathdate": "July 22, 1848", "deathplace": "Lost Grove, Illinois"},
                                        {"name": "Beulah Augusta", "gender": "F", "birthdate": "July 19, 1851", "birthplace": "Salt Lake City, Utah", "deathdate": "January 13, 1905", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "Aphek", "gender": "M", "birthdate": "January 25, 1853", "birthplace": "Salt Lake City, Utah", "deathdate": "January 25, 1853", "deathplace": "Salt Lake City, Utah"}
                                    ]
                                },
                                {
                                    "year": "1846",
                                    "link": "/subjects/mary-ann-jackson-woodruff",
                                    "name": "Mary Ann Jackson",
                                    "parents": {
                                        "mother": "Elizabeth Lloyd",
                                        "father": "William Jackson"
                                    },
                                    "birthdate": "Feb 18, 1818",
                                    "deathdate": "Oct 25, 1894",
                                    "relationship": "Woodruffs met Mary Ann on their mission in England",
                                    "marriage": "Aug 2, 1846 in Cutler’s Park, Nebraska",
                                    "sealing": "then resealed Dec 1878?",
                                    "divorce": "May 11, 1848",
                                    "prior_marriage": null,
                                    "subsequent_marriage": "David J. Ross Dec 13, 1857",
                                    "children": [
                                        {"name": "James Jackson", "gender": "M", "birthdate": "May 25, 1847", "birthplace": "Winter Quarters, NE", "deathdate": "December 8, 1927", "deathplace": "Salt Lake City, Utah"}
                                    ]
                                },
                                {
                                    "year": "1846",
                                    "link": "/subjects/",
                                    "name": "Sarah Elinor Brown",
                                    "parents": {
                                        "mother": "Mary Arey",
                                        "father": "Charles Brown"
                                    },
                                    "birthdate": "Aug 22, 1827",
                                    "deathdate": "Dec 25, 1915",
                                    "relationship": "Wilford met the Browns on his mission in Maine",
                                    "marriage": "Aug 2, 1846 in Cutler’s Park, Nebraska",
                                    "sealing": "",
                                    "divorce": "Aug 29, 1846",
                                    "prior_marriage": null,
                                    "subsequent_marriage": "Lisbon Lamb Feb 15, 1849",
                                    "children": []
                                },
                                {
                                    "year": "1846",
                                    "link": "/subjects/",
                                    "name": "Mary Caroline Barton",
                                    "parents": {
                                        "mother": "Mary Ann Swain",
                                        "father": "William Allen Barton"
                                    },
                                    "birthdate": "Jan 12, 1829",
                                    "deathdate": "Aug 10, 1910",
                                    "relationship": null,
                                    "marriage": "Aug 2, 1846 in Cutler’s Park, Nebraska",
                                    "sealing": "",
                                    "divorce": "Aug 29, 1846",
                                    "prior_marriage": null,
                                    "subsequent_marriage": "Erastus Curtis Feb 4, 1848",
                                    "children": []
                                },
                                {
                                    "year": "1852",
                                    "link": "/subjects/",
                                    "name": "Mary Meek Giles",
                                    "parents": {
                                        "mother": "Elizabeth Reith",
                                        "father": "Samuel Giles"
                                    },
                                    "birthdate": "Sept 6, 1802",
                                    "deathdate": "Oct 3, 1852",
                                    "relationship": "Woodruffs met Mary on their mission in Massachusetts?",
                                    "marriage": "Mar 26, 1852 in the Woodruff’s home in Salt Lake City, Utah",
                                    "sealing": "",
                                    "divorce": null,
                                    "prior_marriage": "Nathan Webster 1 May 1843",
                                    "subsequent_marriage": null,
                                    "children": []
                                },
                                {
                                    "year": "1852",
                                    "link": "/subjects/",
                                    "name": "Clarissa Henrietta Hardy",
                                    "parents": {
                                        "mother": "Elizabeth Harriman Nichols",
                                        "father": "Leonard W. Hardy"
                                    },
                                    "birthdate": "Nov 20, 1834",
                                    "deathdate": "Sep 3, 1903",
                                    "relationship": "Woodruffs served with Leonard on their mission in England 1844-45",
                                    "marriage": "Apr 20, 1852 in Brigham Young’s East Office in Salt Lake City, Utah",
                                    "sealing": "",
                                    "divorce": "June 4, 1853",
                                    "prior_marriage": null,
                                    "subsequent_marriage": "Alonzo H. Russell Dec 11, 1853; Thomas W. Winter Feb 11, 1867",
                                    "children": []
                                },
                                {
                                    "year": "1853",
                                    "link": "/subjects/",
                                    "name": "Sarah Brown",
                                    "parents": {
                                        "mother": "Rhoda North",
                                        "father": "Harry Brown"
                                    },
                                    "birthdate": "Jan 1, 1834",
                                    "deathdate": "May 9, 1909",
                                    "relationship": "Wilford met Harry Brown in New York in 1834 ",
                                    "marriage": "Mar 13, 1853 in Endowment House in Salt Lake City, Utah",
                                    "sealing": "",
                                    "divorce": null,
                                    "prior_marriage": null,
                                    "subsequent_marriage": null,
                                    "children": [
                                        {"name": "David Patten", "gender": "M", "birthdate": "April 4, 1854", "birthplace": "Salt Lake City, Utah", "deathdate": "January 20, 1937", "deathplace": "Long Beach, CA"},
                                        {"name": "Brigham Young", "gender": "M", "birthdate": "January 18, 1857", "birthplace": "Salt Lake City, Utah", "deathdate": "June 16, 1877", "deathplace": "Smithfield, Utah"},
                                        {"name": "Phoebe Arabell", "gender": "F", "birthdate": "May 30, 1859", "birthplace": "Salt Lake City, Utah", "deathdate": "September 7, 1939", "deathplace": "Clearfield, Utah"},
                                        {"name": "Sylvia Melvina", "gender": "F", "birthdate": "January 14, 1862", "birthplace": "Salt Lake City,   Utah", "deathdate": "August 7, 1940", "deathplace": "American Falls, Idaho"},
                                        {"name": "Newton", "gender": "M", "birthdate": "November 3, 1863", "birthplace": "Salt Lake City, Utah", "deathdate": "January 21, 1960", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "Mary", "gender": "F", "birthdate": "October 26, 1867", "birthplace": "Salt Lake City, Utah", "deathdate": "February 15, 1903", "deathplace": "Provo, Utah"},
                                        {"name": "Charles Henry", "gender": "M", "birthdate": "December 5, 1870", "birthplace": "Salt Lake City, Utah", "deathdate": "February 2, 1871", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "Edward Randolph", "gender": "M", "birthdate": "February 2, 1873", "birthplace": "Randolph, Utah", "deathdate": "February 8, 1873", "deathplace": "Randolph, Utah"}
                                    ]
                                },
                                {
                                    "year": "1853",
                                    "link": "/subjects/emma-smith-woodruff",
                                    "name": "Emma Smith",
                                    "parents": {
                                        "mother": "Martisha Smoot",
                                        "father": "Samuel Smith"
                                    },
                                    "birthdate": "Mar 1, 1838",
                                    "deathdate": "Mar 4,1912",
                                    "relationship": "Wilford met the Smiths on his mission in Kentucky",
                                    "marriage": "Mar 13, 1853 in Endowment House in Salt Lake City, Utah",
                                    "sealing": "",
                                    "divorce": null,
                                    "prior_marriage": null,
                                    "subsequent_marriage": null,
                                    "children": [
                                        {"name": "Hyrum Smith", "gender": "M", "birthdate": "October 4, 1857", "birthplace": "Salt Lake City, Utah", "deathdate": "November 24, 1858", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "Emma Manella", "gender": "F", "birthdate": "July 4, 1860", "birthplace": "Salt Lake City, Utah", "deathdate": "November 30, 1905", "deathplace": "Vernal, Utah"},
                                        {"name": "Asahel Hart", "gender": "M", "birthdate": "February 3, 1863", "birthplace": "Salt Lake City, Utah", "deathdate": "July 2, 1939", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "Ann Thompson", "gender": "F", "birthdate": "April 10, 1867", "birthplace": "Salt Lake City, Utah", "deathdate": "April 11, 1867", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "Clara Martisha", "gender": "F", "birthdate": "July 23, 1868", "birthplace": "Salt Lake City, Utah", "deathdate": "December 29, 1927", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "Abraham Owen", "gender": "M", "birthdate": "November 23, 1872", "birthplace": "Salt Lake City, Utah", "deathdate": "June 21, 1904", "deathplace": "El Paso, Texas"},
                                        {"name": "Winnifred Blanche", "gender": "F", "birthdate": "April 9, 1876", "birthplace": "Salt Lake City, Utah", "deathdate": "April 28, 1954", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "Mary Alice", "gender": "F", "birthdate": "January 2, 1879", "birthplace": "Salt Lake City, Utah", "deathdate": "January 14, 1916", "deathplace": "Salt Lake City, Utah"}
                                    ]
                                },
                                {
                                    "year": "1857",
                                    "link": "/subjects/",
                                    "name": "Sarah Delight Stocking",
                                    "parents": {
                                        "mother": "Catherine E. Ensign",
                                        "father": "John Jay Stocking"
                                    },
                                    "birthdate": "July 26, 1838",
                                    "deathdate": "May 28, 1906",
                                    "relationship": "Woodruffs knew the Stockings in Nauvoo",
                                    "marriage": "July 31, 1857 in Endowment House in Salt Lake City, Utah",
                                    "sealing": "",
                                    "divorce": null,
                                    "prior_marriage": null,
                                    "subsequent_marriage": null,
                                    "children": [
                                        {"name": "Marion", "gender": "M", "birthdate": "June 1, 1861", "birthplace": "Salt Lake City, Utah", "deathdate": "February 5, 1946", "deathplace": "Tremonton, Utah"},
                                        {"name": "Emeline", "gender": "F", "birthdate": "July 25, 1863", "birthplace": "Salt Lake City, Utah", "deathdate": "May 25, 1915", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "Ensign", "gender": "M", "birthdate": "December 23, 1865", "birthplace": "Salt Lake City, Utah", "deathdate": "May 1, 1955", "deathplace": "Murray, Utah"},
                                        {"name": "Jeremiah", "gender": "M", "birthdate": "August 29, 1868", "birthplace": "Fort Herriman, Utah", "deathdate": "December 16, 1869", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "Rosannah", "gender": "F", "birthdate": "April 17, 1871", "birthplace": "Salt Lake City, Utah", "deathdate": "October 22, 1872", "deathplace": "Salt Lake City, Utah"},
                                        {"name": "John Jay", "gender": "M", "birthdate": "August 14, 1873", "birthplace": "Salt Lake City, Utah", "deathdate": "November 1, 1964", "deathplace": "Boise, Idaho"},
                                        {"name": "Julia Delight Stocking", "gender": "F", "birthdate": "June 28, 1878", "birthplace": "Salt Lake City, Utah", "deathdate": "January 8, 1954", "deathplace": "Granger, Utah"}
                                    ]
                                },
                                {
                                    "year": "1877",
                                    "link": "/subjects/",
                                    "name": "Eudora Lovina Young",
                                    "parents": {
                                        "mother": "Lucy Bigelow",
                                        "father": "Brigham Young"
                                    },
                                    "birthdate": "May 12, 1852",
                                    "deathdate": "Oct 21, 1921",
                                    "relationship": "Wilford met Eudora in St. George, Utah",
                                    "marriage": "Mar 10, 1877 in St. George Utah Temple",
                                    "sealing": "",
                                    "divorce": "Nov 25, 1878",
                                    "prior_marriage": "Moreland Dunford Oct 3, 1870",
                                    "subsequent_marriage": "Albert Hagen March 1, 1879",
                                    "children": [
                                        {"name": "Brigham Young", "gender": "M", "birthdate": "April 1, 1878", "birthplace": "St. George, Utah", "deathdate": "April 1, 1878", "deathplace": "St. George, Utah"}
                                    ]
                                }]', true);
    }
}
