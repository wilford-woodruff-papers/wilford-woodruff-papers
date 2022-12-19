<x-guest-layout>
    <x-slot name="title">
        Meet the Team | {{ config('app.name') }}
    </x-slot>
    @if(auth()->check() && auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
        {{--<div id="content" role="main">
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
                                                <li x-data="{
                                                        show: false,
                                                    }"
                                                    x-on:mouseover="show = true"
                                                    x-on:mouseover.outside="show = false"
                                                    class="group relative"
                                                >
                                                    <div class="space-y-4 cursor-pointer">
                                                        <div class="aspect-w-3 aspect-h-3">
                                                            <img class="object-cover shadow-lg" src="{{ Storage::disk('board_members')->url($person->image) }}" alt="">
                                                        </div>

                                                        <div class="space-y-2">
                                                            <div class="space-y-1 text-lg font-medium leading-6">
                                                                <h3 class="text-secondary font-semibold">{{ $person->name }}</h3>
                                                                @if(! empty($person->title))
                                                                    <p class="text-black serif">
                                                                        {{ $person->title }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div x-show="show == true"
                                                         class="absolute bg-white z-50 w-[440px] shadow-lg ease-in-out p-4 origin-center md:-right-1/4 top-0"
                                                         x-cloak
                                                         x-transition
                                                    >
                                                        <div class="aspect-w-3 aspect-h-3">
                                                            <img class="object-cover shadow-lg" src="{{ Storage::disk('board_members')->url($person->image) }}" alt="">
                                                        </div>
                                                        <div class="text-secondary pt-6 pb-4 text-xl font-semibold">About {{ $person->name }}</div>
                                                        <div class="text-black text-lg">
                                                            {!! $person->bio !!}
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}
        <div id="content" role="main">
            <div class="bg-gradient-to-b from-secondary to-secondary-300 px-4 md:px-0">
                <div class="max-w-7xl mx-auto pt-24 pb-12">
                    <div class="grid grid-cols-12 gap-x-8">
                        <div class="col-span-12 md:col-span-3"></div>
                        <div class="col-span-12 md:col-span-9">
                            <h1 class="text-5xl text-white">Meet the Team</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4">
                <div class="blocks">
                    <div class="grid grid-cols-12 py-12 gap-x-8">
                        <div class="col-span-12 md:col-span-3 px-2 py-16">
                            <x-submenu area="About"/>
                        </div>
                        <div class="col-span-12 md:col-span-9">
                            <div class="grid grid-cols-1 gap-x-4 mb-12">
                                @foreach($teams as $team)
                                    @if($team->boardmembers->count() > 0)
                                        @if($team->name != 'Interns & Volunteers')
                                            <div x-data="{
                                                    show: {{ $team->expanded }},
                                                }"
                                                 role="region">
                                                <div class="max-w-7xl mx-auto px-12 mt-4 mb-12">
                                                    <div class="flex items-center border-b-2 border-[#707070] ">
                                                        <div x-on:click="show = !show"
                                                             class="flex items-center py-4 cursor-pointer">
                                                            <span x-show="show" aria-hidden="true" class="-ml-12">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                                </svg>
                                                            </span>
                                                                <span x-show="!show" aria-hidden="true" class="-ml-12">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                                </svg>

                                                            </span>
                                                        </div>
                                                        <div class="py-4">
                                                            <button
                                                                x-on:click="show = !show"
                                                                :aria-expanded="show"
                                                                class="flex w-full items-center"
                                                            >
                                                                <h3 class="font-serif text-xl md:text-2xl leading-5 font-medium text-black font-medium">
                                                                    {{ $team->name }}
                                                                </h3>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul x-show="show"
                                                    x-collapse
                                                    role="list" class="space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:grid-cols-4 lg:gap-x-8 mb-16">
                                                    @foreach($team->boardmembers as $person)
                                                        <li x-data="{
                                                                show: false,
                                                            }"
                                                            onclick="Livewire.emit('openModal', 'team-member-modal', {{ json_encode(["person" => $person->id, 'backgroundColor' => $team->background_color, 'textColor' => $team->text_color]) }})"
                                                            class="group relative rounded-xl"
                                                            style="background-color: {{ $team->background_color }}; color: {{ $team->text_color }};"
                                                        >
                                                            <div class="space-y-4 cursor-pointer">
                                                                <div class="pt-5 px-7">
                                                                    <div class="aspect-w-3 aspect-h-4">
                                                                        <img class="object-cover object-top" src="{{ Storage::disk('board_members')->url($person->image) }}" alt="">
                                                                    </div>
                                                                </div>

                                                                <div class="space-y-2 pb-2">
                                                                    <div class="space-y-1 text-base font-medium leading-6 text-center px-1">
                                                                        <h3 class="font-semibold">{{ $person->name }}</h3>
                                                                        @if(! empty($person->title))
                                                                            <p class="serif px-4">
                                                                                {{ $person->title }}
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @elseif($team->name == 'Interns & Volunteers')
                                            <div x-data="{
                                                    show: {{ $team->expanded }},
                                                }"
                                                 role="region">
                                                <div class="max-w-7xl mx-auto px-12 mt-4 mb-12">
                                                    <div class="flex items-center border-b-2 border-[#707070] ">
                                                        <div x-on:click="show = !show"
                                                             class="flex items-center py-4 cursor-pointer">
                                                            <span x-show="show" aria-hidden="true" class="-ml-12">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                                </svg>
                                                            </span>
                                                            <span x-show="!show" aria-hidden="true" class="-ml-12">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                                </svg>

                                                            </span>
                                                        </div>
                                                        <div class="py-4">
                                                            <button
                                                                x-on:click="show = !show"
                                                                :aria-expanded="show"
                                                                class="flex w-full items-center"
                                                            >
                                                                <h3 class="font-serif text-xl md:text-2xl leading-5 font-medium text-black font-medium">
                                                                    {{ $team->name }}
                                                                </h3>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div x-show="show"
                                                    x-collapse
                                                    class="grid grid-cols-10 mb-16">
                                                    @foreach($team->boardmembers->shuffle() as $person)
                                                        <div class="flex">
                                                            <img class="object-cover object-top object-center aspect-[3/4]" src="{{ Storage::disk('board_members')->url($person->image) }}" alt="">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            {{--<div>
                                <div class="h-16 mt-4 mb-12">
                                    <div class="max-w-7xl mx-auto px-12">
                                        <div class="py-4 border-b-2 border-[#707070]">
                                            <h3 class="font-serif text-xl md:text-2xl leading-5 font-medium text-black font-medium">Volunteers</h3>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <img src="{{ asset('img/about/volunteers.png') }}"
                                         alt=""
                                         class="w-full h-auto"
                                    />
                                </div>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div id="content" role="main">
            <div class="max-w-7xl mx-auto px-4">
                <div class="blocks">
                    <div class="grid grid-cols-12 py-12">
                        <div class="col-span-12 md:col-span-3 px-2 py-16">
                            <x-submenu area="About"/>
                        </div>
                        <div class="content col-span-12 md:col-span-9">
                            <h2>Meet the Team</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                @foreach($teams as $team)
                                    @if($team->boardmembers->count() > 0 && $team->name != 'Interns & Volunteers')
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
                            </div>

                            <div class="grid grid-cols-1 gap-x-4 mt-12">
                                @foreach($teams as $team)
                                    @if($team->boardmembers->count() > 0 && $team->name != 'Interns & Volunteers')
                                        <div class="h-16">
                                            <div class="max-w-7xl mx-auto px-4">
                                                <div class="relative">
                                                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                                        <div class="w-full border-t-2 border-gray-300" style="height: 0px"></div>
                                                    </div>
                                                    <div class="relative flex justify-center">
                                                        <div class="inline-flex items-center shadow-sm px-8 py-4 border-2 border-gray-300 text-4xl leading-5 font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                            <h1 class="uppercase">{{ $team->name }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @foreach($team->boardmembers->sortBy('order') as $person)
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
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-guest-layout>
