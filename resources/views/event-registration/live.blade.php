<x-guest-layout>
    <div class="my-12 mx-auto max-w-7xl">
        <div class="space-y-6">

            @if(  now()->isAfter(\Carbon\Carbon::create(2023, 6, 25, 19, 0, 0, 'America/Denver')->toAtomString())
                  || (
                        auth()->check()
                        && auth()->user()->hasAnyRole(['Editor', 'Admin'])
                      )
                  || request()->get('preview') === 'true'
            )

                <div class="relative" style="padding:56.25% 0 0 0">
                    <iframe src="https://vimeo.com/event/3458833/embed"
                            frameborder="0"
                            allow="autoplay; fullscreen; picture-in-picture"
                            allowfullscreen
                            style="position:absolute; top:0; left:0; width:100%; height:100%;"></iframe>
                </div>

            @else

                <div x-data="{
                        countDownDate: null,
                        now: null,
                        distance: null,
                        days: 0,
                        hours: 0,
                        minutes: 0,
                        seconds: 0,
                    }"
                     x-init="
                        countDownDate = new Date('{{ \Carbon\Carbon::create(2023, 6, 25, 19, 0, 0, 'America/Denver')->toAtomString() }}').getTime()
                        let timer = setInterval(function(){
                            now = new Date().getTime();
                            distance = countDownDate - now;

                            if (distance < 0) {
                                clearInterval(timer);
                                days = '00';
                                hours = '00';
                                minutes = '00';
                                seconds = '00';
                                window.location.reload();
                            } else {
                                // Time calculations for days, hours, minutes and seconds
                                days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            }
                        }, 1000)
                     "
                     class=""
                     x-cloak
                >
                    <div class="mx-auto max-w-4xl">
                        <div class="grid grid-cols-1 py-4 md:py-0">
                            <div class="py-4 px-4 md:col-span-4">
                                <div class="pb-2 rounded-md">
                                    <div class="px-4 lg:px-16">
                                        <div class="grid grid-cols-4 gap-4">
                                            <div class="flex flex-col py-2 rounded-md bg-primary">
                                                <div x-text="days"
                                                     class="text-2xl font-semibold text-center text-white md:text-4xl">
                                                </div>
                                                <div class="text-sm text-center text-white uppercase md:text-base">
                                                    Days
                                                </div>
                                            </div>
                                            <div class="flex flex-col py-2 rounded-md bg-primary">
                                                <div x-text="hours"
                                                     class="text-2xl font-semibold text-center text-white md:text-4xl">
                                                </div>
                                                <div class="text-sm text-center text-white uppercase md:text-base">
                                                    Hours
                                                </div>
                                            </div>
                                            <div class="flex flex-col py-2 rounded-md bg-primary">
                                                <div x-text="minutes"
                                                     class="text-2xl font-semibold text-center text-white md:text-4xl">
                                                </div>
                                                <div class="text-sm text-center text-white uppercase md:text-base">
                                                    Minutes
                                                </div>
                                            </div>
                                            <div class="flex flex-col py-2 rounded-md bg-primary">
                                                <div x-text="seconds"
                                                     class="text-2xl font-semibold text-center text-white md:text-4xl">
                                                </div>
                                                <div class="text-sm text-center text-white uppercase md:text-base">
                                                    Seconds
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mx-auto max-w-3xl">
                    <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/ama-mission-presidents.png"
                         class="p-4 w-full h-auto"
                         alt="Ask Me Anything Mission President Panel on June 25, 2023"
                    />
                </div>

            @endif

        </div>
    </div>
</x-guest-layout>
