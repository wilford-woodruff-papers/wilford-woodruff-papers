<div>
    <div  id="topics"
          class="absolute -mt-32"
    >

    </div>

    @teleport('#nav-container')
        <li class="flex-1 bg-white divide-y divide-gray-200 hover:bg-gray-100 @if($topics->count() < 1) hidden @endif"
            :class="{'shadow border border-gray-200': !scrolledFromTop, '': scrolledFromTop}">
            <a href="#topics">
                <div class="flex justify-between items-center py-1 px-6 space-x-6 w-full">
                    <div class="flex flex-row flex-1 gap-y-1 gap-x-4 justify-start items-center md:flex-col lg:items-start truncate">
                        <div class="flex items-center space-x-3">
                            <h3 class="text-xl font-semibold text-gray-900 truncate">
                                {{ $topics->count() }}
                            </h3>
                        </div>
                        <p class="text-base font-semibold uppercase text-secondary truncate">
                            {{ str('Topic')->plural($topics->count()) }}
                        </p>
                    </div>
                    <div class="hidden flex-shrink-0 justify-center items-center w-10 h-10 lg:flex bg-secondary">
                        <x-dynamic-component :component="'heroicon-o-tag'" class="w-6 h-6 text-white"/>
                    </div>
                </div>
            </a>
        </li>
    @endteleport

    @if($topics->count() > 0)
        <div class="relative">
            <div id="{{ str('Topics')->slug() }}" class="absolute -top-32"></div>
            <h2 class="text-2xl font-thin uppercase border-b-4 md:text-3xl lg:text-4xl border-highlight">
                Topics
            </h2>
            <p class="mt-4 mb-8 text-xl">
                Browse topics Wilford Woodruff mentioned in this document.
            </p>
        </div>
        <div class="flex gap-x-4 justify-end py-2">
            <div wire:click="toggleSort('name')" class="flex gap-x-1 items-center cursor-pointer">
                <span>Name</span>
                @if($column === 'name')
                    <div>
                        @if($direction === 'asc')
                            <span>
                                <x-heroicon-c-arrow-up class="w-4 h-4 text-cool-gray-500" />
                            </span>
                        @else
                            <span>
                                <x-heroicon-c-arrow-down class="w-4 h-4 text-cool-gray-500" />
                            </span>
                        @endif
                    </div>
                @endif
            </div>
            <div wire:click="toggleSort('tagged_count')" class="flex gap-x-1 items-center cursor-pointer">
                <span>Count</span>
                @if($column === 'tagged_count')
                    <div>
                        @if($direction === 'asc')
                            <span>
                                <x-heroicon-c-arrow-up class="w-4 h-4 text-cool-gray-500" />
                            </span>
                        @else
                            <span>
                                <x-heroicon-c-arrow-down class="w-4 h-4 text-cool-gray-500" />
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-4">
            @php
                $oldLetter = null;
                $letter = null;
            @endphp
            @foreach($topics->split(4) as $group)
                <div>
                    @foreach($group as $topic)
                        @php
                            $letter = str($topic->name)->upper()->split(1)->first();
                        @endphp
                        @if($column === 'name' && ! empty($letter) && $letter !== $oldLetter)
                            <div class="pt-3 pb-1 text-2xl font-semibold text-black">
                                {{ $letter }}
                            </div>
                        @endif
                        <div class="flex gap-x-2">
                            <a href="{{ route('subjects.show', ['subject' => $topic->slug]) }}"
                               class="text-xl"
                               target="_blank"
                            >
                            <span class="underline text-secondary">
                                {{ $topic->name }}
                            </span>
                                <span class="text-base text-black">
                                ({{ \Illuminate\Support\Number::format($topic->tagged_count)}})
                            </span>
                            </a>
                        </div>
                        @php
                            $oldLetter = $letter;
                        @endphp
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif

</div>
