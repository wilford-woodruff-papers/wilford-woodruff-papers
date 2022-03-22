<?php

namespace App\Console\Commands;

use App\Models\Faq;
use App\Models\Press;
use Illuminate\Console\Command;

class LoadFaqs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:faqs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Frequently asked questions';

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
        $faqs = $this->getFaqs();
        foreach ($faqs as $key => $faq) {
            $new = Faq::create($faq);
        }

        return 0;
    }

    private function getFaqs()
    {
        return json_decode('[
            {
                "question": "What is the purpose of the Wilford Woodruff Papers Project?",
                "answer": "<p>Wilford Woodruff was an apostle of the Lord Jesus Christ for fifty-nine years. To acknowledge God\'s direction in his daily life, Wilford documented nearly every testimony he bore, every mission on which he embarked, every person he baptized or blessed, and every temple ordinance he performed in the Lord’s service. Our mission is to collect, transcribe, publish, and digitally preserve Wilford Woodruff\'s records to proclaim that Jesus Christ has restored his gospel and continues to reveal his will through his prophets.</p>"
            },
{
"question": "What is the scope of the project?",
"answer": "Our goal is to locate, transcribe, and publish online every extant document created or received by Wilford Woodruff. Over the next ten years we plan to 1) digitally publish all surviving documents written or received by Wilford Woodruff, or written by scribes/assistants under his direction; 2) make accurate transcriptions of these documents  searchable and understandable in context; 3) publish annotated selections of the documents in printed volumes; and 4) organize symposia pertaining to the Wilford Woodruff Papers to encourage ongoing research, discovery, and dissemination of knowledge embedded in them."
},
{
    "question": "What documents are included?",
                "answer": "Because this is a papers project, not a documentary history project, it only includes documents created by Wilford Woodruff or, in rare cases, the documents written by scribes/secretaries at his request, and letters received by him. Wilford filled 31 daybooks and journals between 1834 and 1898 and all of these records were preserved. In those journals he tallied the 13,308 letters he wrote. the 17,439 letters he received, and the 3,559 discourses, speeches, and eulogies he delivered. Thousands of these documents have survived. In addition, he preserved thousands of pages of personal, legal, financial, business, and family records."
            },
{
    "question": "Have any documents been excluded? ",
                "answer": "No. All available documents will be included."
            },
{
    "question": "Where are these documents located? ",
                "answer": "Wilford Woodruff\'s journals and daybooks as well as the majority of his personal papers and letters are in the Church History Library  of The Church of Jesus Christ of Latter-day Saints in Salt Lake City, Utah, USA. Other papers and letters have been preserved in other historical archives, by educational institutions, and in private collections. We currently have digital images of 6,995 documents in our catalog."
            },
{
    "question": "When did work on the Wilford Woodruff Papers Project begin? ",
                "answer": "Shortly after his baptism into the Church of Jesus Christ of Latter-day Saints in 1833, Wilford Woodruff began his journal by stating that his intent in doing so was to give an account of his stewardship because it is “not only our privilege but duty to keep an accurate account of our proceedings.” He later explained, “We should write an account of those important transactions which are taking place before our eyes in fulfillment of the prophecies and the revelation of God. . . . This will make a valuable legacy to our children and a great benefit to future generations by giving them a true history of the rise and progress of the Church and the Kingdom of God upon the earth in this last dispensation . . . .” Jennifer Ann Mackley began her research on Wilford Woodruff\'s writings in 1996 and, in 2020, co-founded the Wilford Woodruff Papers Foundation with Donald W. Parry to carry out this Project. "
            },
{
    "question": "What is the urgency to do this work now?",
                "answer": "The Joseph Smith Papers encompass the written record of Church history from 1828 to 1844 and include the founding documents of the restoration of the gospel of Jesus Christ. The Wilford Woodruff Papers cover the period from 1834 to 1898 and will help complete the story of the restoration. With so much misinformation easily accessible online, it is vital to make these primary, eyewitness sources of knowledge of the restoration easily accessible so seekers can find the truth."
            },
{
    "question": "Who is leading the project?",
                "answer": "The Wilford Woodruff Papers Foundation manages this project under the leadership of Executive Director, Jennifer Ann Mackley and Executive Editor, Steven C. Harper, with Jordan Woodruff Clements and Donald W. Parry as Co-Chairs of the Board of Directors, and Richard E. Turley, Jr. as Chair of the Advisory Committee. The full staff and Board are listed <a href=\'/s/wilford-woodruff-papers/page/meet-the-team\' class=text-secondary>here</a>."
            },
{
    "question": "Who is the target audience for the project?",
                "answer": "All people everywhere are invited to learn about the restored gospel of Jesus Christ from Wilford Woodruff\'s records."
            },
{
    "question": "How is the project affiliated with The Church of Jesus Christ of Latter-day Saints?",
                "answer": "The Wilford Woodruff Papers Foundation is an independent, private non-profit organization and is not affiliated with The Church of Jesus Christ of Latter-day Saints or any other organization or institution. However, the Church History Department supports and encourages the Project. The Church History Library staff cooperates closely with us,  providing access to the documents as well as technical and research assistance. Several  team members assisted with The Joseph Smith Papers."
            },
{
    "question": "How does the project ensure that scholarly standards are maintained?",
                "answer": "Professionally trained and experienced document editors maintain and follow transcription and verification processes consistent with the best and latest academic documentary editing standards. See the editorial method they follow <a href=\'/s/wilford-woodruff-papers/page/editorial-method\' class=text-secondary>here</a>."
            },
{
    "question": "What is the project budget?",
                "answer": "The timeline for the project is 11 years 2020 to 2030  and our budget is $10 million dollars. Additional funding could lead to an accelerated completion date."
            },
{
    "question": "Who is paying for the Wilford Woodruff Papers Project?",
                "answer": "The project is funded by donations from generous individuals and families, donor-advised funds, and other charitable organizations. Information on how you can contribute is <a href=\'/s/wilford-woodruff-papers/page/donate-online\' class=text-secondary>here</a>."
            },
{
    "question": "What will my donation will pay for?",
                "answer": "<p>Donations fund the digitization, transcription, and verification of Wilford Woodruff\'s papers. Documentary editing of this quality is a painstaking and laborious process. It begins with accurate transcription of handwritten documents. Then teams of two read and verify every word and mark on every page to ensure accuracy. In addition, research is done to identify each person and place mentioned in the documents. Then the names mentioned in the documents are linked  to biographies, and places mentioned are linked to a mapping system. These reference materials enable users to better search and understand the documents. Donations cover the creation and maintenance of the content management system, including the website, to store and display the documents. The Foundation is able to accomplish most of its work without paying for physical office space or administrative staff.</p><p>Donors have access to annual report of expenditures and metrics showing the project\'s progress and success</p>"
            }
        ]', true);
    }
}
