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
                            @if($tags = \Spatie\Tags\Tag::withType('articles')->get())
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
                        </div>

                        <div class="grid gap-16 px-4 mt-4 lg:grid-cols-1 lg:gap-y-12">

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

                                        @if($article->tags->count() > 0)
                                            <p class="mt-1">
                                                @foreach($article->tags as $tag)
                                                    <a href="{{ route('media.articles', ['tag[]' => $tag->name]) }}"
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
