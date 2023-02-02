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
