<x-guest-layout>
    <x-slot name="title">
        Get Involved | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="Get Involved"/>
                    </div>
                    <div class="content col-span-12 md:col-span-9">
                        <h2>Get Involved</h2>

                        <div class="mt-4 grid gap-2 lg:grid-cols-1 lg:gap-y-2">
                            There are several ways you can get involved to help us complete the mission and purpose of the Wilford Woodruff Papers Foundation.

                            <div>
                                <p>
                                    We are so grateful to have volunteers who share their time and talents with the Wilford Woodruff Papers Project. To learn more about available volunteer opportunities, please share your contact information and we'll reach out to you as soon as possible.
                                </p>
                                <p>
                                    <a href="{{ route('volunteer') }}"
                                       class="text-secondary font-medium">
                                        Volunteer >>
                                    </a>
                                </p>
                            </div>
                            <div>
                                <p>
                                    The Wilford Woodruff Papers Foundation makes several internships available each semester to college and high school students through a generous grant from the Sorenson Legacy Foundation. Our interns help with everything from publishing Wilford Woodruff's documents to publishing socila media posts.
                                </p>
                                <p>
                                    <a href="http://wwp.test/work-with-us/internship-opportunities"
                                       class="text-secondary font-medium">
                                        Apply for an Internship >>
                                    </a>
                                </p>
                            </div>

                            <div>
                                <p>
                                    Occasionally we hire people to fill part or full-time positions within the organization.
                                </p>
                                <p>
                                    <a href="{{ route('work-with-us') }}"
                                       class="text-secondary font-medium">
                                        Apply for a Job >>
                                    </a>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
