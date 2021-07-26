<x-guest-layout>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="content col-span-12 md:col-span-9">
                        <h2>Articles</h2>

                        <div class="mt-4 grid gap-16 lg:grid-cols-1 lg:gap-y-12">

                            @foreach($articles as $article)

                                <div>
                                    <p class="text-sm text-gray-500">
                                        <time datetime="{{ $article->date }}">{{ $article->date->format('M j, Y') }}</time>
                                    </p>
                                    <a href="{{ route('media.article', ['article' => $article]) }}" class="mt-2 block">
                                        <p class="text-xl font-semibold text-primary">
                                            {{ $article->title }}
                                        </p>
                                        <p class="mt-3 text-base text-gray-500">
                                            @if(! empty($article->excerpt))
                                                {!! $article->excerpt !!}
                                            @else
                                                {!! \Illuminate\Support\Str::of(strip_tags($article->description))->limit(500, ' ...') !!}
                                            @endif
                                        </p>
                                    </a>
                                    <div class="mt-3">
                                        <a href="{{ route('media.article', ['article' => $article]) }}"
                                           class="text-base font-semibold text-secondary hover:text-highlight"
                                        >
                                            Read more &gt;
                                        </a>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                        <div class="browse-controls flex flex-wrap grid grid-cols-1 lg:grid-cols-2 mt-8">
                            <div class="items-center col-span-2 px-8">
                                {!! $articles->withQueryString()->links('vendor.pagination.tailwind') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
