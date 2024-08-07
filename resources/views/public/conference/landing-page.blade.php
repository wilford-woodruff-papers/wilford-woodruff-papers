<x-guest-layout>


    <div class="px-4 pt-8 pb-4 mx-auto max-w-5xl md:pb-8">
        <div class="grid relative z-10 grid-cols-5">
            <div class="col-span-5 md:col-span-3">
                <h1 class="mt-4 mb-8 font-sans text-5xl tracking-wide text-secondary leading-[3.5rem]">
                    <small class="block mb-2 text-3xl tracking-normal uppercase text-dark-blue">
                        Join us for the First
                    </small>
                    Wilford Woodruff Papers Foundation Conference
                </h1>
                <div class="z-10 text-3xl uppercase">
                    Saturday, March 4, 2023
                </div>
                <div class="z-10 text-3xl uppercase">
                    11:00 AM - 5:00 PM
                </div>
                <div class="z-10 my-2 text-3xl">
                    <div>
                        Hinckley Center
                    </div>
                    <div>
                        At Brigham Young University
                    </div>
                </div>
            </div>
            <div>

            </div>
        </div>
        <div class="relative md:pl-12 -z-10">
            <img src="{{ asset('img/conferences/2023/conference-photo-collage-desktop.jpg') }}"
                 alt=""
                 class="hidden w-full h-auto md:block md:-mt-72"
            />
            <img src="{{ asset('img/conferences/2023/conference-photo-collage-mobile.jpg') }}"
                 alt=""
                 class="block mt-10 w-full h-auto md:hidden"
            />
            {{--<div class="z-10 p-8 text-2xl md:absolute md:bottom-10 md:left-10 md:p-0 md:text-xl lg:bottom-20 lg:text-2xl md:w-[180px] lg:w-[240px]">
                Seekers of the truth will be instructed, inspired, and motivated by Wilford Woodruff's insights through speakers, presentations, and musical performances. Lunch will be provided.
            </div>--}}
            <div class="z-10 p-12 text-2xl md:absolute md:left-0 md:-bottom-8 md:p-0 md:text-xl lg:text-2xl md:w-[390px] lg:w-[500px]">
                <h3 class="hidden py-4 md:block md:text-2xl lg:text-4xl md:w-[200px]">
                    Come and be <span class="font-extrabold text-secondary">inspired</span>
                </h3>
                Seekers of the truth will be instructed, inspired, and motivated by Wilford Woodruff's insights through speakers, presentations, art and musical performances.
            </div>
        </div>
    </div>

    {{--<livewire:forms.email-capture
        :lists="[config('wwp.list_memberships.conference')]"
        title="ENTER YOUR EMAIL TO RECEIVE A REMINDER WHEN REGISTRATION OPENS JAN 11, 2023"
        success_title="We look forward to seeing you in March!"
        success_description="You should receive an email when the conference registration opens. Check back in November for more conference updates."
    />--}}

    <div>
        <div class="bg-white">
            <div class="relative sm:py-8">
                <div aria-hidden="true" class="hidden sm:block">
                    <div class="absolute inset-y-0 left-0 w-1/2 rounded-r-3xl"></div>
                </div>
                <div class="px-0 mx-auto sm:px-0 sm:max-w-5xl lg:px-8 lg:max-w-7xl">
                    <div class="overflow-hidden relative py-10 px-6 shadow-xl sm:py-20 sm:px-24 lg:px-48 bg-secondary">
                        <div aria-hidden="true" class="absolute inset-0 -mt-72 sm:-mt-32 md:mt-0">
                            <svg class="absolute inset-0 w-full h-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 1463 360">
                                <path class="text-opacity-40 text-secondary-500" fill="currentColor" d="M-82.673 72l1761.849 472.086-134.327 501.315-1761.85-472.086z" />
                                <path class="text-opacity-40 text-secondary-700" fill="currentColor" d="M-217.088 544.086L1544.761 72l134.327 501.316-1761.849 472.086z" />
                            </svg>
                        </div>

                        <div class="relative">
                            <div class="text-center">
                                <h2 class="text-xl font-bold tracking-tight text-white uppercase sm:text-4xl md:text-3xl">
                                    Online registration is closed
                                </h2>
                                <p class="mx-auto mt-2 max-w-sm text-2xl font-normal text-white">
                                    In-person registration will be available at the Hinckley Center on March 4th
                                </p>
                                <p class="mx-auto mt-2 max-w-2xl text-xl font-normal text-white">
                                    Please note that lunch is sold out.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="px-3 pb-4 mx-auto max-w-7xl md:pb-8">
        <a href="https://airauctioneer.com/wilford-woodruff-project-art-auction"
           target="_blank"
        >
            <img src="https://wilfordwoodruffpapers.org/storage/announcements/TA9VkT7nvRfEm7UsDTRfg50NgFi83ikjeWy8lW4w.png"
                 alt="Art Auction"
                 class="w-full h-auto"
            >
        </a>
    </div>


    <div class="px-4 pb-4 mx-auto max-w-7xl md:pb-8">
        <h2 class="py-8 mb-12 text-4xl font-black text-center md:text-6xl text-secondary">
            Featured Speakers
        </h2>

        <div class="grid grid-cols-1 px-16 md:grid-cols-3 md:h-[580px]">
            <div class="grid order-2 content-end h-full md:order-1">
                <img src="{{ asset('img/conferences/2023/Jennifer-Mackley.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Jennifer Ann Mackley
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
            <div class="grid order-1 content-start h-full md:order-2">
                <img src="{{ asset('img/conferences/2023/Laurel-Thatcher-Ulrich.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Laurel Thatcher Ulrich
                    </div>
                    <div class="text-2xl text-dark-blue">
                        Pulitzer Prize Winning Historian
                    </div>
                </div>
            </div>
            <div class="grid order-3 content-end h-full md:order-3">
                <img src="{{ asset('img/conferences/2023/Steve-Harper.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Steven C. Harper
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 px-16 md:grid-cols-3 md:-mt-24 md:h-[580px]">
            <div class="grid order-1 content-end h-full md:order-1">
                <img src="{{ asset('img/conferences/2023/Amy-Harris.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Amy Harris
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
            <div class="grid order-2 content-start h-full md:order-2">
                {{--<img src="{{ asset('img/conferences/2023/Steve-Harper.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Steve Harper
                    </div>
                    <div class="text-2xl text-dark-blue">
                        Keynote Speaker
                    </div>
                </div>--}}
            </div>
            <div class="grid order-3 content-end h-full md:order-3">
                <img src="{{ asset('img/conferences/2023/Steven-Wheelright.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Steven C. Wheelwright
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 px-16 md:grid-cols-3 md:-mt-24 md:h-[580px]">
            <div class="grid order-1 content-end h-full md:order-1">
                <img src="{{ asset('img/conferences/2023/Hovan-Lawton.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Hovan Lawton
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
            <div class="grid order-2 content-start h-full md:order-2">
                <img src="{{ asset('img/conferences/2023/Ellie-Hancock.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Ellie Hancock
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
            <div class="grid order-3 content-end h-full md:order-3">
                <img src="{{ asset('img/conferences/2023/Josh-Matson.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Joshua M. Matson
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="px-4 pt-16 pb-4 mx-auto max-w-7xl md:pb-8">
        <h2 class="mb-8 text-4xl font-black text-center md:text-6xl text-secondary">
            Conference Schedule
        </h2>
        <div class="mb-4 text-3xl font-black text-center md:text-4xl text-dark-blue">
            Brigham Young University
        </div>
        <div class="mb-16 text-3xl font-black text-center text-light-gray">
            Saturday, March 4, 2023
        </div>

        <div class="mx-auto max-w-4xl text-center">
            <a href="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/files%2Fconferences%2Fconference-2023-lunch-menu.pdf"
               target="_blank"
               class="inline-block py-3 px-12 mb-12 font-semibold text-center text-white bg-secondary"
            >
                Lunch Menu
            </a>
        </div>

        <div class="mx-auto max-w-4xl">
            <iframe
                src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/files/conferences/conference-2023-program.pdf#toolbar=0"
                class="w-full border-0 h-[2200px]"
            >

            </iframe>
        </div>


        </div>
    </div>

    <div class="h-16"></div>

{{--

    <div class="px-4 pt-8 pb-4 mx-auto max-w-7xl md:pb-8">
        <img src="{{ asset('img/conferences/2023/logo.png') }}"
             class="mx-auto w-auto h-80"
        />
        <h1 class="sr-only">
            2023 Wilford Woodruff Papers Foundation Conference: Building Latter-day Faith
        </h1>
        <div class="mt-8">
            <h2 class="text-lg font-semibold text-center md:text-3xl text-secondary">
                Join us for the first Wilford Woodruff Papers Foundation Conference
            </h2>
            <h2 class="py-6 text-xl font-bold text-center md:text-5xl text-secondary">
                Building Latter-day Faith
            </h2>
            <p class="mt-4 text-lg font-semibold text-center text-black md:text-3xl">
                March 4, 2023 11:30am - 7:30pm
            </p>
            <p class="mb-8 text-lg font-semibold text-center text-black md:text-3xl">
                @ Brigham Young University
            </p>
        </div>

        <p class="py-4 px-8 text-xl">
            The purpose of this conference is to inspire all seekers of truth, especially those in the rising generation, to benefit from Wilford Woodruff's eyewitness account of the Restoration as they increase their study of and faith in Jesus Christ. At this conference, seekers of the truth will be instructed, inspired, and motivated by Wilford Woodruff's insights through speakers, presentations, and musical performances. Lunch and dinner will be provided.
        </p>

    </div>



    <div class="py-4 px-4 mx-auto max-w-7xl md:py-8">
        <div class="grid grid-cols-1 gap-8 items-center md:grid-cols-2">
            <div class="">
                <a href="https://wilfordwoodruffpapers.org/announcements/2023-building-latter-day-faith-conference-art-contest-rules"
                   target="_blank">
                    <img class="w-full h-auto"
                         src="https://wilfordwoodruffpapers.org/storage/announcements/pjDm9syqdcmuWSxNhM7aZYbf3cxRc2GFbFphCXEy.png"
                         alt="Wilford Woodruff Papers Foundation Building Latter-day Faith 2023 Conference Art Contest">
                </a>
            </div>
            <div class="px-2 md:px-8">
                <a href="https://wilfordwoodruffpapers.org/announcements/building-latter-day-faith-conference-call-for-student-paperspresentations" target="_blank">
                    <img class="w-full h-auto"
                         src="https://wilfordwoodruffpapers.org/storage/announcements/W1PxNgXbyOM6SVbW6x1TtnYVBLiZUzBQu6Wab8O1.png"
                         alt="2023 Conference Building Latter-day Faith: Wilford Woodruff Papers Foundation">
                </a>
            </div>
        </div>

    </div>
--}}

    {{--<div class="px-4 pt-8 pb-4 mx-auto max-w-7xl md:pt-12 md:pb-8 xl:pt-12">
        <div class="grid grid-cols-1 pb-8 sm:grid-cols-2 md:grid-cols-3">
            <div class="font-extrabold">
                <h2 class="pb-1 text-3xl uppercase border-b-4 border-highlight">
                    Speakers
                </h2>
            </div>
        </div>
        <div>

        </div>
    </div>--}}

    {{--<div class="px-4 pt-8 pb-4 mx-auto max-w-7xl md:pt-12 md:pb-4 xl:pt-12">
        <div class="grid grid-cols-1 pb-4">
            <div class="font-extrabold">
                <h2 class="pb-1 text-xl uppercase border-b-4 md:text-3xl border-highlight">
                    Schedule: Saturday, March 4, 2023
                </h2>
            </div>
        </div>
        <div>

        </div>
        <div class="pt-4 mx-auto max-w-3xl">
            <section>
                <p class="mt-1.5 text-base tracking-tight text-secondary">

                </p>
                <ol role="list"
                    class="py-8 px-10 space-y-4 text-center shadow-xl bg-white/60 shadow-blue-900/5 backdrop-blur">
                    <li aria-label="Registration at 11:30AM - 12:00PM MST">
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">Check-In \ Registration</h4>
                        <p class="mt-1 tracking-tight text-black">Art Competition Gallery Display</p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T11:30AM-07:00">11:30AM</time>
                            -
                            <time datetime="2023-03-04T12:00PM-07:00">12:00PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Opening Presentation and Lunch at 12:00PM - 1:20PM MST">
                        <div class="mx-auto mb-4 w-48 h-px bg-indigo-500/10"></div>
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">Opening Presentation and Lunch</h4>
                        <p class="mt-1 tracking-tight text-black">
                            <ul class="text-black">
                                <li>Welcome: Jennifer Ann Mackley</li>
                                <li>Featured Speaker: Laurel Thatcher Ulrich</li>
                            </ul>
                        </p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T12:00PM-07:00">12:00PM</time>
                            -
                            <time datetime="2023-03-04T1:20PM-07:00">1:20PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Break at 1:20PM - 1:30PM MST">
                        <div class="mx-auto mb-4 w-48 h-px bg-indigo-500/10"></div>
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">Break</h4>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T1:20PM-07:00">1:20PM</time>
                            -
                            <time datetime="2023-03-04T1:30PM-07:00">1:30PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Student Session at 1:30PM - 2:20PM MST">
                        <div class="mx-auto mb-4 w-48 h-px bg-indigo-500/10"></div>
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">Student Presentations</h4>
                        <p class="mt-1 tracking-tight text-black">
                            <ul class="text-black">
                                <li>Ellie Hancock: Wilford Woodruff the Historian</li>
                                <li>Ashlyn Pells: Insights from the Wilford Woodruff Papers</li>
                                <li>Hovan Lawton: Called to Serve: Mission Calls in the 1890s</li>
                            </ul>
                        </p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T1:30PM-07:00">1:30PM</time>
                            -
                            <time datetime="2023-03-04T2:20PM-07:00">2:20PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Break at 2:20PM - 2:30PM MST">
                        <div class="mx-auto mb-4 w-48 h-px bg-indigo-500/10"></div>
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">Break</h4>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T2:20PM-07:00">2:20PM</time>
                            -
                            <time datetime="2023-03-04T2:30PM-07:00">2:30PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Afternoon Session at 2:00PM - 3:20PM MST">
                        <div class="mx-auto mb-8 w-48 h-px bg-indigo-500/10"></div>
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">Afternoon Presentations</h4>
                        <p class="mt-1 tracking-tight text-black">
                            <ul class="text-black">
                                <li>Josh Matson: Understanding Wilford Woodruff’s Symbols</li>
                                <li>Kristy Taylor: A Day in the Life of Wilford Woodruff</li>
                            </ul>
                        </p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T2:30PM-07:00">2:30PM</time>
                            -
                            <time datetime="2023-03-04T3:20PM-07:00">3:20PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Break at 3:20PM - 3:30PM MST">
                        <div class="mx-auto mb-4 w-48 h-px bg-indigo-500/10"></div>
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">Break</h4>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T3:20PM-07:00">3:20PM</time>
                            -
                            <time datetime="2023-03-04T3:30PM-07:00">3:30PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Afternoon Session at 3:30PM - 4:30PM MST">
                        <div class="mx-auto mb-8 w-48 h-px bg-indigo-500/10"></div>
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">Afternoon Presentations</h4>
                        <p class="mt-1 tracking-tight text-black">
                            <ul class="text-black">
                                <li>Steve Wheelwright: Wilford Woodruff, Missionary</li>
                                <li>Amy Harris: British Context of Wilford Woodruff's Missions</li>
                            </ul>
                        </p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T3:30PM-07:00">3:30PM</time>
                            -
                            <time datetime="2023-03-04T4:30PM-07:00">4:30PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Break at 4:30PM - 4:40PM MST">
                        <div class="mx-auto mb-4 w-48 h-px bg-indigo-500/10"></div>
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">Break</h4>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T4:30PM-07:00">4:30PM</time>
                            -
                            <time datetime="2023-03-04T4:40PM-07:00">4:40PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Special Guest Presentation at 4:40PM - 5:30PM MST">
                        <div class="mx-auto mb-4 w-48 h-px bg-indigo-500/10"></div>
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">Special Guest Presentation</h4>
                        <p class="mt-1 tracking-tight text-black">
                        <ul class="text-black">
                            <li>Introduction</li>
                            <li>To Be Announced</li>
                        </ul>
                        </p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T4:40PM-07:00">4:40PM</time>
                            -
                            <time datetime="2023-03-04T5:30PM-07:00">5:30PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Break at 5:30PM - 6:00PM MST">
                        <div class="mx-auto mb-4 w-48 h-px bg-indigo-500/10"></div>
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">Break</h4>
                        <p class="mt-1 tracking-tight text-black">Final Audience Voting on Art Competition Entries</p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T5:30PM-07:00">5:30PM</time>
                            -
                            <time datetime="2023-03-04T6:00PM-07:00">6:00PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Dinner at 6:00PM - 7:30PM MST">
                        <div class="mx-auto mb-4 w-48 h-px bg-indigo-500/10"></div>
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">Dinner and Featured Speaker</h4>
                        <p class="mt-1 tracking-tight text-black">
                            <ul class="text-black">
                                <li>Introduction</li>
                                <li>Presentation of Carol Sorenson Smith Awards by Sarah Dunn</li>
                                <li>Special Musical Artist: Alex Melecio</li>
                                <li>Featured Speaker: To Be Announced in January 2023</li>
                            </ul>
                        </p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T6:00PM-07:00">6:00PM</time>
                            -
                            <time datetime="2023-03-04T7:30PM-07:00">7:30PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="VIP Reception - By Invitation Only at 7:30PM MST">
                        <div class="mx-auto mb-4 w-48 h-px bg-indigo-500/10"></div>
                        <h4 class="text-lg font-semibold tracking-tight md:text-xl text-secondary">VIP Reception</h4>
                        <p class="mt-1 tracking-tight text-black">By Invitation Only</p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T7:30PM-07:00">7:30PM</time>
                            MST
                        </p>
                    </li>
                </ol>
            </section>
        </div>
    </div>--}}

</x-guest-layout>
