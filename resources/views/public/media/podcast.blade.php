<x-guest-layout>
    <x-slot name="title">
        {{ $podcast->title }} | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 content">
                        <div class="grid grid-cols-1 gap-16 px-4 pt-0 mt-4 lg:gap-y-12">
                            <div>
                                <p class="text-sm text-gray-500">
                                    <time datetime="{{ $podcast->date }}">{{ $podcast->date->format('j M Y') }}</time>
                                </p>
                                <a href="{{ $podcast->link }}" class="block mt-2" target="_podcast">
                                    <p class="text-xl font-semibold text-primary">
                                        {{ $podcast->title }}
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
                                @if(strlen($podcast->transcript) > 10)
                                    <div class="pt-6">
                                        <p class="text-xl font-semibold text-gray-900">
                                            Transcript
                                        </p>
                                        <div class="mt-8">
                                            {!! $podcast->transcript !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
