<x-guest-layout>
    <x-slot name="title">
        Job & Volunteer Opportunities | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="Get Involved"/>
                    </div>
                    <div class="content col-span-12 md:col-span-9">
                        <h2>Job & Volunteer Opportunities</h2>

                        <div class="mt-4 grid gap-16 lg:grid-cols-1 lg:gap-y-12">

                            @if($opportunities->count() > 0)

                                @foreach($opportunities as $opportunity)

                                    <div>
                                        <a href="{{ route('work-with-us.opportunity', ['opportunity' => $opportunity]) }}" class="mt-2 block">
                                            <p class="text-xl font-semibold text-primary">
                                                {{ $opportunity->title }}
                                            </p>
                                            <p class="mt-3 text-base text-gray-500">
                                                @if(! empty($opportunity->summary))
                                                    {!! $opportunity->summary !!}
                                                @else
                                                    {!! \Illuminate\Support\Str::of(strip_tags($opportunity->description))->limit(500, ' ...') !!}
                                                @endif
                                            </p>
                                        </a>
                                        <div class="mt-3">
                                            <a href="{{ route('work-with-us.opportunity', ['opportunity' => $opportunity]) }}"
                                               class="text-base font-semibold text-secondary hover:text-highlight"
                                            >
                                                More information &gt;
                                            </a>
                                        </div>
                                    </div>

                                @endforeach

                            @else
                                <div class="mt-3">
                                    <p class="font-bold">
                                        We don't have any open positions at this time. If you'd like to submit your resume to have on file for future opportunities send it to us at <a href="mailto:contact@wilfordwoodruffpapers.org" class="text-base font-semibold text-secondary hover:text-highlight">contact@wilfordwoodruffpapers.org</a>.
                                    </p>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
