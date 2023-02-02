<x-guest-layout>
    <x-slot name="title">
        Newsroom | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 content">
                        <h2>Newsroom</h2>

                        <div class="grid gap-16 mt-4 lg:grid-cols-1 lg:gap-y-12">

                            @foreach($articles as $article)

                                <div>
                                    <p class="text-sm text-gray-500">
                                        <time datetime="{{ $article->date }}">{{ $article->date->format('M j, Y') }}</time>
                                    </p>
                                    <a href="{{ $article->link }}" class="block mt-2" target="_news">
                                        <p class="text-xl font-semibold text-primary">
                                            {{ $article->title }}
                                        </p>
                                        <p class="mt-3 text-base text-gray-500">
                                            {!! strlen($article->excerpt) > 6 ? $article->excerpt : $article->description !!}
                                        </p>
                                    </a>
                                    <div class="mt-3">
                                        <a href="{{ $article->link }}"
                                           class="text-base font-semibold text-secondary hover:text-highlight"
                                           target="_news"
                                        >
                                            More on {{ $article->publisher }} &gt;
                                        </a>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                        <div class="flex grid flex-wrap grid-cols-1 mt-8 lg:grid-cols-2 browse-controls">
                            <div class="col-span-2 items-center px-8">
                                {!! $articles->withQueryString()->links('vendor.pagination.tailwind') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
