<x-guest-layout>
    <x-slot name="title">
        Meet the Team | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="About"/>
                    </div>
                    <div class="col-span-12 md:col-span-9">
                        <div class="content">
                            <h2>Meet the Team</h2>
                        </div>
                        {{--<div class="grid grid-cols-1 md:grid-cols-2">
                            @foreach($teams as $team)
                                @if($team->boardmembers->count() > 0)
                                    <div class="col-span-1">
                                        <h3 class="text-primary text-2xl font-serif mt-4 mb-8 border-b border-gray-300">
                                            {{ $team->name }}
                                        </h3>
                                        <div class="divide-y divide-gray-200">
                                            @foreach($team->boardmembers->sortBy('order') as $person)
                                                <div class="pt-4 pb-4 flex items-center">
                                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                    <a href="#{{ Str::of($person->name)->slug() }}" class="ml-3 cursor-pointer">
                                                    <span class="text-base font-medium text-secondary">
                                                        {{ $person->name }}@if(! empty($person->title)), {{ $person->title }}@endif
                                                    </span>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>--}}

                        <div class="grid grid-cols-1 gap-x-4 mb-12">
                            @foreach($teams as $team)
                                @if($team->boardmembers->count() > 0)
                                    <div class="h-16 mt-4 mb-16">
                                        <div class="max-w-7xl mx-auto px-4">
                                            <div class="relative">
                                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                                    <div class="w-full border-t-2 border-gray-300" style="height: 0px"></div>
                                                </div>
                                                <div class="relative flex justify-center">
                                                    <div class="inline-flex items-center shadow-sm px-8 py-4 border-2 border-gray-300 text-2xl leading-5 font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <h3 class="uppercase">{{ $team->name }}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <ul role="list" class="space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:grid-cols-3 lg:gap-x-8 mb-16">
                                        @foreach($team->boardmembers as $person)
                                            <li class="group relative">
                                                <div class="space-y-4">
                                                    <div class="aspect-w-3 aspect-h-2">
                                                        <img class="object-cover shadow-lg" src="{{ Storage::disk('board_members')->url($person->image) }}" alt="">
                                                    </div>

                                                    <div class="space-y-2">
                                                        <div class="space-y-1 text-lg font-medium leading-6">
                                                            <h3>{{ $person->name }}</h3>
                                                            @if(! empty($person->title))
                                                                <p class="text-secondary serif">
                                                                    {{ $person->title }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hidden group-hover:block absolute bg-white z-50 w-[440px] shadow-lg ease-in-out p-4 origin-center md:-right-1/4 top-0">
                                                    <div class="text-secondary pt-2 pb-4 text-lg">About {{ $person->name }}</div>
                                                    <div class="text-black text-base">
                                                        {!! $person->bio !!}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    {{--@foreach($team->boardmembers->sortBy('order') as $person)
                                        <div class="mt-12 px-8 md:px-2">
                                            <div class="space-y-12 sm:divide-y sm:divide-gray-200 sm:space-y-0 sm:-mt-8 lg:gap-x-8 lg:space-y-0" x-max="1">

                                                <div class="sm:py-8"
                                                     id="{{ Str::of($person->name)->slug() }}"
                                                >
                                                    <div class="flex items-center space-y-4 sm:grid sm:grid-cols-3 sm:items-start sm:gap-6 sm:space-y-0">
                                                        <!-- Image -->
                                                        <div class="aspect-w-3 aspect-h-2 sm:aspect-w-3 sm:aspect-h-4 hidden md:block">
                                                            <img class="object-cover shadow-lg rounded-full h-80 w-80" src="{{ Storage::disk('board_members')->url($person->image) }}" alt="">
                                                        </div>
                                                        <div class="col-span-3 md:col-span-2">
                                                            <div class="space-y-4">
                                                                <div class="text-lg leading-6 font-medium space-y-1">
                                                                    <h3 class="text-3xl text-primary font-semibold serif"
                                                                    >{{ $person->name }}</h3>
                                                                    @if(! empty($person->title))
                                                                        <p class="text-gray-600 uppercase serif">{{ $person->title }}</p>
                                                                    @endif
                                                                </div>
                                                                <div class="text-lg">
                                                                    <img class="object-cover shadow-lg rounded-full h-40 w-40 md:hidden block" src="{{ Storage::disk('board_members')->url($person->image) }}" alt="">
                                                                    <p class="text-gray-500">{!! $person->bio !!}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach--}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
