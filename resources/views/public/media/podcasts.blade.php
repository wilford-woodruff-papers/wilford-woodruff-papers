<x-guest-layout>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="content col-span-12 md:col-span-9">
                        <h2>Podcasts</h2>

                        @foreach($podcasts as $podcast)
                            <div class="mt-4 pt-0 px-4 grid gap-16 grid-cols-1 lg:gap-y-12">
                                <div>
                                    <p class="text-sm text-gray-500">
                                        <time datetime="{{ $podcast->date }}">{{ $podcast->date->format('j M Y') }}</time>
                                    </p>
                                    <a href="{{ $podcast->link }}" class="mt-2 block" target="_podcast">
                                        <p class="text-xl font-semibold text-primary">
                                            <a href="{{ route('media.podcast', ['podcast' => $podcast]) }}" class="mt-2 block">
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
