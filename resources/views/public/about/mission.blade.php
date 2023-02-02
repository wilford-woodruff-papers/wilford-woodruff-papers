<x-guest-layout>
    <x-slot name="title">
        About | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="About"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 content">
                        <iframe allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" class="py-8 mx-auto" frameborder="0" height="480" src="https://www.youtube.com/embed/i6iuBzxlF20?rel=0" style="height: 480px;" width="640"></iframe>
                        <div class="h-16">
                            <div class="px-4 mx-auto max-w-7xl">
                                <div class="relative">
                                    <div aria-hidden="true" class="flex absolute inset-0 items-center">
                                        <div class="w-full border-t-2 border-gray-300" style="height: 0px">&nbsp;</div>
                                    </div>

                                    <div class="flex relative justify-center">
                                        <div class="inline-flex items-center py-4 px-8 text-4xl font-medium leading-5 text-gray-700 bg-white border-2 border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
                                            <h1 class="uppercase">Our Mission</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 pt-4 pb-8 bg-white sm:px-6 lg:px-8 lg:pb-12">
                            <div class="relative mx-auto max-w-lg lg:max-w-7xl">
                                <x-mission-statement />
                            </div>
                        </div>

                        <div class="h-16">
                            <div class="px-4 mx-auto max-w-7xl">
                                <div class="relative">
                                    <div aria-hidden="true" class="flex absolute inset-0 items-center">
                                        <div class="w-full border-t-2 border-gray-300" style="height: 0px">&nbsp;</div>
                                    </div>

                                    <div class="flex relative justify-center">
                                        <div class="inline-flex items-center py-4 px-8 text-4xl font-medium leading-5 text-gray-700 bg-white border-2 border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
                                            <h1 class="uppercase">Our Story</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 pt-4 pb-20 bg-white sm:px-6 lg:px-8 lg:pb-28">
                            <div class="relative mx-auto max-w-lg lg:max-w-7xl">
                                <div class="mb-8">
                                    <p class="text-lg text-primary">Wilford Woodruff (1807-1898) traveled vast distances for decades to teach and testify of the restored gospel of Jesus Christ. He documented his ministry and his witness of the restoration in 31 daybooks and journals and more than 13,000 letters. In these records he also documented the teachings of Joseph Smith and other prophets and apostles. But today his records are found mostly in archives or in books known to a few experts.</p>

                                    <p class="text-lg text-primary">The Wilford Woodruff Papers Foundation exists to change that. It was organized in January 2020 to accomplish one objective: to make Wilford Woodruff&#39;s records of the restoration of the gospel of Jesus Christ accessible to everyone. Jennifer Ann Mackley extensively researched Wilford Woodruff's life and documents for over two decades before she and Donald W. Parry co-founded the Foundation and formed a team to accomplish this eternally significant endeavor.</p>

                                    <p class="text-lg text-primary">On Wilford Woodruff&#39;s 213th birthday, March 1, 2020, with support from the Church History Department of The Church of Jesus Christ of Latter-day Saints, the Foundation announced its mission in cooperation with the Wilford Woodruff Family Association. One year later, on March 1, 2021, the Foundation formally launched an open access website <a href="https://wilfordwoodruffpapers.org">wilfordwoodruffpapers.org</a> with the first group of transcribed documents.</p>

                                    <p class="text-lg text-primary">The Wilford Woodruff Papers Project is like The Joseph Smith Papers. Both present high-resolution images of a prophet&#39;s handwritten documents side-by-side with accurate transcriptions based on professional document editing standards and practices. The scope of the two projects, however, is dramatically different. Joseph Smith's papers extend from 1828 to 1844. Wilford Woodruff's records begin in 1828 and end at his death in 1898. The number of Joseph Smith&#39;s documents is comparatively small, approximately 2,500, due to the length of his ministry and the difference in record keeping in the early 19th century. Wilford Woodruff daybooks and journals contain more than 11,000 pages. He wrote more than 13,000 letters and received more than 17,000. All of his daybooks and journals and all of his extant letters, together with his sermons and his legal documents and family history records, will be included.</p>

                                    <p class="text-lg text-primary">The Wilford Woodruff Papers Foundation is blessed to be involved in this effort to publish truth in context on an open access website so everyone can read and cherish Wilford Woodruff's witness of Jesus Christ and his restored gospel.</p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
