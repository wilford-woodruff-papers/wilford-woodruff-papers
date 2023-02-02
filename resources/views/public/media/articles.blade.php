<x-guest-layout>
    <x-slot name="title">
        Articles | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="col-span-12 md:col-span-9">
                        <div class="content">
                            <h2>Articles</h2>
                        </div>

                        <div class="grid gap-16 mt-4 lg:grid-cols-1 lg:gap-y-12">

                            @foreach($articles as $article)

                                <div>
                                    <p class="text-sm text-gray-500">
                                        <time datetime="{{ $article->date }}">{{ $article->date->format('M j, Y') }}</time>
                                    </p>
                                    <a href="{{ $article->url() }}" class="block mt-2"
                                        @if(! empty($article->link)) target="_blank" @endif
                                    >
                                        <h3 class="text-xl font-semibold text-primary">
                                            {{ $article->title }}
                                        </h3>
                                        @if($article->authors->count())
                                            <p class="text-base font-normal text-primary">
                                                by {{ $article->authors->pluck('name')->join(', ', ' and ') }}
                                            </p>
                                        @elseif(! empty($article->subtitle))
                                            <p class="text-base font-normal text-primary">
                                                by {{ $article->subtitle }}
                                            </p>
                                        @endif
                                        <p class="mt-3 text-base text-gray-500">
                                            @if(! empty($article->excerpt))
                                                {!! $article->excerpt !!}
                                            @else
                                                {!! \Illuminate\Support\Str::of(strip_tags($article->description))->limit(500, ' ...') !!}
                                            @endif
                                        </p>
                                    </a>
                                    <div class="mt-3">
                                        <a href="{{ $article->url() }}"
                                           class="text-base font-semibold text-secondary hover:text-highlight"
                                           @if(! empty($article->link)) target="_blank" @endif
                                        >
                                            @if(! empty($article->publisher))
                                                Read more on {{ $article->publisher }} &gt;
                                            @else
                                                Read more &gt;
                                            @endif

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
