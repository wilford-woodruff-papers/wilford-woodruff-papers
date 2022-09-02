<x-guest-layout>

    <div class="max-w-7xl mx-auto px-4 pb-4 md:pb-8">
        <img src="{{ asset('img/conferences/2023/logo.png') }}"
             class="h-96 w-auto mx-auto"
        />
        <h1 class="sr-only">
            2023 Wilford Woodruff Papers Foundation Conference: Building Latter-day Faith
        </h1>
        <div class="mt-8">
            <h2 class="text-lg md:text-3xl font-semibold text-center text-secondary">
                Join us for the first Wilford Woodruff Papers Foundation Conference
            </h2>
            <h2 class="text-xl md:text-5xl font-bold text-center text-secondary py-6">
                Building Latter-day Faith
            </h2>
            <p class="text-lg md:text-3xl font-semibold text-center text-black mt-4">
                March 4, 2023 11:30am - 7:30pm
            </p>
            <p class="text-lg md:text-3xl font-semibold text-center text-black mb-8">
                Hinckley Building at Brigham Young University
            </p>
        </div>

        <p class="text-xl py-4 px-8">
            The purpose of this conference is to inspire all seekers of truth, especially those in the rising generation, to benefit from Wilford Woodruff's eyewitness account of the Restoration as they increase their study of and faith in Jesus Christ. At this conference, seekers of the truth will be instructed, inspired, and motivated by Wilford Woodruff's insights through speakers, presentations, and musical performances. Lunch and dinner will be provided.
        </p>

    </div>

    <livewire:forms.email-capture
        :lists="[config('wwp.list_memberships.conference')]"
        title="GET NOTIFIED WHEN REGISTRATION OPENS"
        success_title="We look forward to seeing you in March!"
        success_description="You should receive an email when the conference registration opens. Check back in October for more conference updates."
    />

    <div class="max-w-7xl mx-auto px-4 py-4 md:py-8">
        <div class="grid grid-cols-1 md: grid-cols-2 gap-8 items-center">
            <div class="">
                <a href="https://wilfordwoodruffpapers.org/announcements/2023-building-latter-day-faith-conference-art-contest-rules"
                   target="_blank">
                    <img class="w-full h-auto"
                         src="https://wilfordwoodruffpapers.org/storage/announcements/pjDm9syqdcmuWSxNhM7aZYbf3cxRc2GFbFphCXEy.png"
                         alt="Wilford Woodruff Papers Foundation Building Latter-day Faith 2023 Conference Art Contest">
                </a>
            </div>
            <div class="px-8">
                <a href="https://wilfordwoodruffpapers.org/announcements/building-latter-day-faith-conference-call-for-student-paperspresentations" target="_blank">
                    <img class="w-full h-auto"
                         src="https://wilfordwoodruffpapers.org/storage/announcements/W1PxNgXbyOM6SVbW6x1TtnYVBLiZUzBQu6Wab8O1.png"
                         alt="2023 Conference Building Latter-day Faith: Wilford Woodruff Papers Foundation">
                </a>
            </div>
        </div>

        {{--<p class="text-xl py-4 px-8">
            All students and preprofessionals are invited to participate in the <a href="/announcements/2023-building-latter-day-faith-conference-art-contest-rules" class="text-secondary underline">Conference Art Contest</a>. Prizes will be awarded to the top submissions in each division and category. <a href="/announcements/2023-building-latter-day-faith-conference-art-contest-rules" class="text-secondary underline font-medium" aria-label="View Art Contest Rules and submit artwork">Learn more >></a>
        </p>--}}
    </div>

    {{--<div class="max-w-7xl mx-auto pt-8 md:pt-12 px-4 pb-4 xl:pt-12 md:pb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 pb-8">
            <div class="font-extrabold">
                <h2 class="text-3xl uppercase pb-1 border-b-4 border-highlight">
                    Speakers
                </h2>
            </div>
        </div>
        <div>

        </div>
    </div>--}}

    <div class="max-w-7xl mx-auto pt-8 md:pt-12 px-4 pb-4 xl:pt-12 md:pb-4">
        <div class="grid grid-cols-1 pb-4">
            <div class="font-extrabold">
                <h2 class="text-3xl uppercase pb-1 border-b-4 border-highlight">
                    Schedule: Saturday, March 4, 2023
                </h2>
            </div>
        </div>
        <div>

        </div>
        <div class="max-w-3xl mx-auto pt-4">
            <section>
                <p class="mt-1.5 text-base tracking-tight text-secondary">

                </p>
                <ol role="list"
                    class="space-y-4 bg-white/60 py-8 px-10 text-center shadow-xl shadow-blue-900/5 backdrop-blur">
                    <li aria-label="Registration at 11:30AM - 12:00PM MST">
                        <h4 class="text-lg md:text-xl font-semibold tracking-tight text-secondary">Registration</h4>
                        <p class="mt-1 tracking-tight text-secondary"></p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T11:30PM-07:00">11:30PM</time>
                            -
                            <time datetime="2023-03-04T12:00PM-07:00">12:00PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Opening Presentation and Lunch at 12:00PM - 1:30PM MST">
                        <div class="mx-auto mb-4 h-px w-48 bg-indigo-500/10"></div>
                        <h4 class="text-lg md:text-xl font-semibold tracking-tight text-secondary">Opening Presentation and Lunch</h4>
                        <p class="mt-1 tracking-tight text-secondary"></p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T12:00PM-07:00">12:00PM</time>
                            -
                            <time datetime="2023-03-04T1:30PM-07:00">1:30PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Student Session at 1:30PM - 3:00PM MST">
                        <div class="mx-auto mb-4 h-px w-48 bg-indigo-500/10"></div>
                        <h4 class="text-lg md:text-xl font-semibold tracking-tight text-secondary">Student Session</h4>
                        <p class="mt-1 tracking-tight text-secondary"></p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T11:00PM-07:00">1:30PM</time>
                            -
                            <time datetime="2023-03-04T12:00PM-07:00">3:00PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Afternoon Session at 3:00PM - 4:30PM MST">
                        <div class="mx-auto mb-8 h-px w-48 bg-indigo-500/10"></div>
                        <h4 class="text-lg md:text-xl font-semibold tracking-tight text-secondary">Afternoon Session</h4>
                        <p class="mt-1 tracking-tight text-secondary"></p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T3:00PM-07:00">3:00PM</time>
                            -
                            <time datetime="2023-03-04T4:30PM-07:00">4:30PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Special Guest Presentation at 4:30PM - 5:30PM MST">
                        <div class="mx-auto mb-4 h-px w-48 bg-indigo-500/10"></div>
                        <h4 class="text-lg md:text-xl font-semibold tracking-tight text-secondary">Special Guest Presentation</h4>
                        <p class="mt-1 tracking-tight text-secondary"></p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T4:30PM-07:00">4:30PM</time>
                            -
                            <time datetime="2023-03-04T5:30PM-07:00">5:30PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Break at 5:30PM - 6:00PM MST">
                        <div class="mx-auto mb-4 h-px w-48 bg-indigo-500/10"></div>
                        <h4 class="text-lg md:text-xl font-semibold tracking-tight text-secondary">Break</h4>
                        <p class="mt-1 tracking-tight text-secondary"></p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T5:30PM-07:00">5:30PM</time>
                            -
                            <time datetime="2023-03-04T6:00PM-07:00">6:00PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="Dinner at 6:00PM - 7:30PM MST">
                        <div class="mx-auto mb-4 h-px w-48 bg-indigo-500/10"></div>
                        <h4 class="text-lg md:text-xl font-semibold tracking-tight text-secondary">Dinner</h4>
                        <p class="mt-1 tracking-tight text-secondary"></p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T6:00PM-07:00">6:00PM</time>
                            -
                            <time datetime="2023-03-04T7:30PM-07:00">7:30PM</time>
                            MST
                        </p>
                    </li>
                    <li aria-label="VIP Reception - By Invitation Only at 7:30PM MST">
                        <div class="mx-auto mb-4 h-px w-48 bg-indigo-500/10"></div>
                        <h4 class="text-lg md:text-xl font-semibold tracking-tight text-secondary">Special Guest Presentation</h4>
                        <p class="mt-1 tracking-tight text-secondary">By Invitation Only</p>
                        <p class="mt-1 text-base text-slate-500">
                            <time datetime="2023-03-04T7:30PM-07:00">7:30PM</time>
                            MST
                        </p>
                    </li>
                </ol>
            </section>
        </div>
    </div>

</x-guest-layout>
