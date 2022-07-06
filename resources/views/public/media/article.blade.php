<x-guest-layout>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="article content col-span-12 md:col-span-9">
                        <h2 class="text-lg">{{ $article->title }}</h2>
                        @if($article->authors->count())
                            <p class="text-base font-normal text-primary">
                                by {{ $article->authors->pluck('name')->join(', ', ' and ') }}
                            </p>
                        @elseif(! empty($article->subtitle))
                            <p class="text-base font-normal text-primary">
                                by {{ $article->subtitle }}
                            </p>
                        @endif
                        <div class="mt-4">
                            <div>
                                <p class="text-sm text-gray-500">
                                    <time datetime="{{ $article->date }}">{{ $article->date->format('M j, Y') }}</time>
                                </p>
                                <p class="mt-3 text-base text-gray-500">
                                    {!! $article->description !!}
                                </p>
                            </div>
                        </div>
                        @if($article->authors->count() > 0)
                            <div class="col-span-12 my-8 p-4 bg-gray-100 divide-y">
                                @foreach($article->authors as $author)
                                    <div class="grid grid-cols-4 gap-4 items-center">
                                        <div class="col-span-4 md:col-span-1 p-4">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('authors')->url($author->image) }}"
                                                 class="w-64 md:w-full h-auto mx-auto"
                                                 alt="{{ $author->name }}"
                                            />
                                        </div>
                                        <div class="col-span-4 md:col-span-3 px-4">
                                            {!! $author->description !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @if($article->authors->count() > 0)
                        <div class="col-span-12 my-8 p-4 bg-gray-100 divide-y">
                            @foreach($article->authors as $author)
                                <div class="grid grid-cols-4 gap-4 items-center">
                                    <div class="col-span-4 md:col-span-1 p-4">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('authors')->url($author->image) }}"
                                             class="w-64 md:w-full h-auto mx-auto"
                                             alt="{{ $author->name }}"
                                        />
                                    </div>
                                    <div class="col-span-4 md:col-span-3 px-4">
                                        {!! $author->description !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
