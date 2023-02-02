<x-guest-layout>
    <x-slot name="title">
        {{ $article->title }} | {{ config('app.name') }}
    </x-slot>
    @if(! empty($article->link))
        <x-slot name="canonical">
            <link rel="canonical" href="{{ $article->link }}" />
        </x-slot>
    @endif
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 article content">
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
                                @if(! empty($article->link))
                                    <p class="p-4 mt-3 text-base text-center text-gray-500 border border-gray-200">
                                        This article first appeared on <a href="{!! $article->link !!}" target="_blank">{!! str($article->link)->after('//')->before('/') !!}</a>
                                    </p>
                                @endif
                                <p class="mt-3 text-base text-gray-500">
                                    {!! $article->description !!}
                                </p>
                            </div>
                        </div>
                        @if($article->authors->count() > 0)
                            <div class="col-span-12 p-4 my-8 bg-gray-100 divide-y">
                                @foreach($article->authors as $author)
                                    <div class="grid grid-cols-4 gap-4 items-center">
                                        <div class="col-span-4 p-4 md:col-span-1">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('authors')->url($author->image) }}"
                                                 class="mx-auto w-64 h-auto md:w-full"
                                                 alt="{{ $author->name }}"
                                            />
                                        </div>
                                        <div class="col-span-4 px-4 md:col-span-3">
                                            {!! $author->description !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if(! empty($article->footnotes))
                            <div class="mt-4">
                                <div class="text-sm text-gray-500">
                                    {!! $article->footnotes !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
