<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ConferenceController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('public.conference.summary-page', [
            'photos' => Storage::disk('spaces')->files('files/conferences/2023/images/highlights/thumbnails'),
            'speakers' => [
                [
                    'name' => 'Jennifer Mackley, Executive Director / CEO',
                    'title' => 'Introduction',
                    'bio' => '<p>Jennifer co-founded the Wilford Woodruff Papers Foundation in 2019 with Donald W. Parry after decades of research on Wilford Woodruff’s life and writings. She has authored or edited 21 books including Wilford Woodruff\'s Witness: The Development of Temple Doctrine (2014) and Desarrollo de la doctrina del templo: Testimonio de Wilford Woodruff (2015). She has made numerous presentations and podcasts based on Wilford Woodruff\'s pivotal role in the restoration of temple ordinances and temple worship in the nineteenth century. Prior to becoming Executive Director of the Foundation, she worked as an attorney for 25 years and formed Mackley & Mackley, PLLC with her husband Carter. They are the parents of three miraculous children. Her hope in transcribing and publishing Wilford Woodruff\'s Papers is to help Church members and historians alike understand the importance of the temple and gain insights into the Restoration through Wilford\'s unique perspective of the revelatory process.</p>',
                    'video' => 'https://www.youtube.com/embed/r1OPb3_ObNU',
                    'article' => '',
                ],
                [
                    'name' => 'Laurel Thatcher Ulrich, Pulitzer Prize Winning Author & Historian',
                    'title' => 'Keynote Speaker',
                    'bio' => '<p>Laurel Thatcher Ulrich is an award-winning author and historian. She approaches history as a tribute to “the silent work of ordinary people.” Her work focuses on early American history and the history of women. In addition to the Pulitzer Prize she received for her book A Midwife’s Tale: The Life of Martha Ballard Based on Her Diary, 1785-1812, she has received numerous awards for teaching, scholarship and public service.</p><p>Laurel received a BA in English from the University of Utah and went on to earn an MA in English at Simmons College, taking one course a semester to allow her to raise her growing family. She went on to receive her PhD in Early American History from the University of New Hampshire, only five years after her fifth child was born. In 1995, she accepted a position at Harvard University as James Duncan Phillips Professor of Early American History and Professor of Women’s Studies.</p><p>Laurel has published seven books and numerous articles throughout her career. She has dedicated her life to learning and helping others learn about early American history, particularly as it relates to women of the Church of Jesus Christ of Latter-Day Saints. Her work has touched the lives of students, historians and scholars across the globe.</p>',
                    'video' => 'https://youtube.com/embed/jz2Fbz-8Baw',
                    'article' => '',
                ],
                [
                    'name' => 'Ellie Hancock, Award Winner',
                    'title' => 'Missionary Faith in Persecution',
                    'bio' => '<p>Ellie Hancock graduated from Brigham Young University in April 2022 with a BA in History. Throughout the course of her studies, she was able to participate on numerous research projects in 19th century, British, religious and women’s history. She is fascinated by understanding the nuances of church history and is grateful to be able to preserve and promote the legacy of Wilford Woodruff in the ongoing restoration. Ellie is a recipient of the Carol Sorenson Smith Award, earned through her research on missionary faith in persecution.</p>',
                    'video' => 'https://www.youtube.com/embed/UU0G3v3oYJM',
                    'article' => 'https://latterdaysaintmag.com/missionary-faith-in-persecution-wilford-woodruffs-first-mission-to-england/',
                ],
                [
                    'name' => 'Hovan Lawton, Award Winner',
                    'title' => 'Sacrifices of Those Called to Serve',
                    'bio' => '<p>Hovan Lawton is one of the recipients of the Carol Sorenson Smith Award, which he earned through his research on mission acceptance letters among early saints and the challenges that missionaries faced in the early days of the restoration. Hovan currently works as a Research Assistant while pursuing an MA from Utah State University. Hovan graduated from BYU in 2021 with a BA in history as department valedictorian. Before graduating, he worked for the Wilford Woodruff Papers Foundation as an editorial assistant. He has dedicated much of his time to researching the life of Wilford Woodruff and early American history.</p>',
                    'video' => 'https://www.youtube.com/embed/aHcsEi1jE6Y',
                    'article' => '',
                ],
                [
                    'name' => 'Joshua M. Matson, PhD, Religious Educator',
                    'title' => 'Decoding Wilford Woodruff\'s Journals',
                    'bio' => '<p>Joshua Matson is a religious educator through Seminaries and Institutes and an expert in decoding. He has been fascinated with the writings of Wilford Woodruff since his time as an undergraduate at Brigham Young University. He feels privileged to take part in making the words of Wilford Woodruff accessible to and relevant to the public. Joshua has dedicated his life to learning and earned a BA in Near Eastern Studies from Brigham Young University and a MA in biblical studies from Trinity Western University. He then went on to receive a Doctorate in religion from Florida State University. His academic background has allowed him to publish various articles and present papers in several different conferences and organizations.</p>',
                    'video' => 'https://www.youtube.com/embed/nYaNOSe1IqY',
                    'article' => '',
                ],
                [
                    'name' => 'Amy Harris, PhD, BYU Professor',
                    'title' => 'The World of British Converts',
                    'bio' => '<p>Amy Harris is an associate professor of history and director of the Family History department at Brigham Young University. Her research focuses on women, families and gender in early modern Britain and has published several books on family relationships during that time. She has conducted extensive research on British families during the time in which Wilford Woodruff was a missionary, though she has also written on genealogy in a Latter-Day Saint context. She enjoys seeing the humanity and reality of the people who lived during the time periods she has studied and examining the effects that the events of the time had on them.</p>',
                    'video' => 'https://www.youtube.com/embed/jaz0AO4a964',
                    'article' => '',
                ],
                [
                    'name' => 'Steven C. Wheelwright, PhD, Former PResident of BYU-Hawaii',
                    'title' => 'Wilford Woodruff\'s Missionary Service: Preparing the Future Prophet',
                    'bio' => '<p>After graduating from the University of Utah, Steve Wheelwright received an MBA and a PhD from The Stanford University Graduate School of Business. During his academic career, Steve taught at INSEAD, a private business school in Fontainebleau, France, the Stanford Graduate School of Business where he also served as the Chair of the Strategic Management Dept., and the Harvard Business School where he also served as a Senior Associate Dean overseeing the MBA program, then overseeing Faculty Planning and Development, and concluding as Chairman of HBS Publishing. Since his retirement from Harvard, he and his wife, Margaret Steele Wheelwright, presided over the England London Mission, served one year at BYU-Idaho, presided over BYU-Hawaii for 8 years, and presided over the Boston Temple, where they became deeply interested in Wilford Woodruff\'s contributions to the temple ordinances after reading Jennifer Mackley\'s book, Wilford Woodruff\'s Witness: The Development of Temple Doctrine. They are grateful for the blessing it is to have access to Wilford Woodruff\'s writings on this topic and want to assist this effort so everyone can learn from his documents and revelations. Steve and Margaret have 5 children, 20 grandchildren, and 5 great-grandchildren, with more on the way. They live in Oakley, Utah.</p>',
                    'video' => 'https://www.youtube.com/embed/wDN3mQRgoAw',
                    'article' => 'https://latterdaysaintmag.com/wilford-woodruffs-missionary-service-preparation-for-a-future-prophet/',
                ],
                [
                    'name' => 'Steven Harper. Executive Editor',
                    'title' => 'Make Beautiful Things Even if Nobody Cares',
                    'bio' => '<p>Steve is a professor of Church history and doctrine at Brigham Young University. After graduating from BYU with a BA in history, he earned an MA in American history from Utah State University, and a PhD in early American history from Lehigh University. He began teaching at BYU Hawaii in 2000, then joined the faculty at BYU in 2002, and taught at the BYU Jerusalem Center in 2011–2012. He became a volume editor of The Joseph Smith Papers and the document editor for BYU Studies in 2002. In 2012 Steve was appointed as the managing historian and a general editor of Saints: The Story of the Church of Jesus Christ in the Latter Days, and was named editor in chief of BYU Studies Quarterly in 2018. He has authored numerous books and dozens of articles including: Promised Land (2006), Making Sense of the Doctrine and Covenants (2008), Joseph Smith\'s First Vision (2012), and First Vision: Memory and Mormon Origins (2019). President Woodruff devoted his life to recording sacred knowledge and Steve feels a great desire to make sure that knowledge is widely shared with all of God’s children.</p>',
                    'video' => 'https://www.youtube.com/embed/G7laiM8dUtU',
                    'article' => '',
                ],
            ],
        ]);
    }
}
