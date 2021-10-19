<x-guest-layout>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="Media"/>
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
                                        We currently don't have any openings.
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
