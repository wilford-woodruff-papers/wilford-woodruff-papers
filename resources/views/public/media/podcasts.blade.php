<x-guest-layout>
    <x-slot name="title">
        Podcasts | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 content">
                        <h2>Podcasts</h2>
                        @if($tags = \Spatie\Tags\Tag::withType('podcasts')->get())
                            <div class="flex flex-wrap gap-y-2 gap-x-4 px-4">
                                @foreach($tags->sortBy('name') as $tag)
                                    <a href="{{ route('media.articles', ['tag[]' => $tag->name]) }}"
                                       class="inline-flex items-center py-0.5 px-3 text-lg text-white bg-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-0.5 w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                        @foreach($podcasts as $podcast)
                            <div class="grid grid-cols-1 gap-16 px-4 pt-0 mt-4 lg:gap-y-12">
                                <div>
                                    <p class="text-sm text-gray-500">
                                        <time datetime="{{ $podcast->date }}">{{ $podcast->date->format('j M Y') }}</time>
                                    </p>
                                    <a href="{{ $podcast->link }}" class="block mt-2" target="_podcast">
                                        <p class="text-xl font-semibold text-primary">
                                            <a href="{{ route('media.podcast', ['podcast' => $podcast]) }}" class="block mt-2">
                                                {{ $podcast->title }}
                                            </a>
                                        </p>
                                        <p>
                                            {{ $podcast->subtitle }}
                                        </p>
                                        @if($podcast->tags->count() > 0)
                                            <p class="mt-1">
                                                @foreach($podcast->tags as $tag)
                                                    <a href="{{ route('media.podcasts', ['tag[]' => $tag->name]) }}"
                                                       class="inline-flex items-center py-0.5 px-2 text-xs font-medium text-white bg-secondary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-0.5 w-2 h-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                        </svg>
                                                        {{ $tag->name }}
                                                    </a>
                                                @endforeach
                                            </p>
                                        @endif
                                        <p class="mt-3 text-base text-gray-500">
                                            {!! $podcast->description !!}
                                        </p>
                                    </a>
                                    <div class="mt-3">
                                        {!! $podcast->embed !!}
                                    </div>
                                    <div class="mt-3">
                                        @if(empty($podcast->embed))
                                            <a href="{{ $podcast->link }}"
                                               class="text-base font-semibold text-secondary hover:text-highlight"
                                               target="_podcast"
                                            >
                                                Listen now
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="flex grid flex-wrap grid-cols-1 mt-8 lg:grid-cols-2 browse-controls">
                            <div class="col-span-2 items-center px-8">
                                {!! $podcasts->withQueryString()->links('vendor.pagination.tailwind') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
