<x-guest-layout>

    <x-slot name="openGraph">
        <meta property="og:title" content="{{ $lesson->title }}">
        <meta property="og:description" content="{{ $lesson->title }}">
        <meta property="og:type" content="article">
        <meta property="og:image" content="{{ route('come-follow-me.ogimage', ['book' => $bookSlug, 'week' => $lesson->week]) }}">
        <meta property="og:url" content="{{ route('come-follow-me.show', ['book' => $bookSlug, 'week' => $lesson->week]) }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $lesson->title }}">
    </x-slot>

    <div>
        <div class="text-white bg-primary">
            <a href="{{ route('come-follow-me.index') }}/{{ $bookSlug }}">
                <div class="py-3 px-8 mx-auto max-w-7xl">
                    <div class="flex flex-col justify-between md:flex-row item-center">
                        <div class="">
                            <h1 class="text-3xl">
                                <span class="italic">Come, Follow Me</span> Insights
                            </h1>
                            <h2 class="text-xl">
                                Magnify your <span class="italic">Come, Follow Me</span> study through Wilford Woodruff’s records
                            </h2>
                        </div>
                        <div class="flex items-center flex-0">
                            <x-heroicon-c-chevron-double-left class="pr-2 w-8 h-8 text-white" />
                            <span class="text-2xl text-white">
                                Back
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="flex flex-col gap-y-12 px-8 mx-auto max-w-7xl">
            <div class="flex gap-x-4 justify-center items-center mt-12 md:hidden">
                <a href="{{ $churchLink }}"
                   title="Open Come, Follow Me Lesson on churchofjesuschrist.org"
                   target="_blank"
                   class="text-3xl underline text-primary"
                >
                    Week {{ $lesson->week }}: {{ $lesson->reference }}
                </a>
                <x-heroicon-c-arrow-top-right-on-square class="w-6 h-6 text-primary" />
            </div>
            <div class="flex justify-between md:hidden">
                <div>
                    @if($lesson->week > 1)
                        <div class="flex gap-x-2 items-center">
                            <x-heroicon-c-chevron-left class="w-12 h-12 text-secondary" />
                            <a href="{{ route('come-follow-me.show', ['book' => $bookSlug, 'week' => $lesson->week - 1]) }}"
                               class="text-2xl text-secondary">
                                Week {{ $lesson->week - 1 }}
                            </a>
                        </div>
                    @endif
                </div>
                <div>
                    @if($lesson->week < now('America/Denver')->week && $lesson->week < 52)
                        <div class="flex gap-x-2 items-center">
                            <a href="{{ route('come-follow-me.show', ['book' => $bookSlug, 'week' => $lesson->week + 1]) }}"
                               class="text-2xl text-secondary">
                                Week {{ $lesson->week + 1 }}
                            </a>
                            <x-heroicon-c-chevron-right class="w-12 h-12 text-secondary" />
                        </div>
                    @endif
                </div>
            </div>
            <div class="hidden justify-between mt-12 md:flex">
                <div>
                    @if($lesson->week > 1)
                        <div class="flex gap-x-2 items-center">
                            <x-heroicon-c-chevron-left class="w-12 h-12 text-secondary" />
                            <a href="{{ route('come-follow-me.show', ['book' => $bookSlug, 'week' => $lesson->week - 1]) }}"
                               class="text-xl text-secondary">
                                Week {{ $lesson->week - 1 }}
                            </a>
                        </div>
                    @endif
                </div>
                <div class="flex gap-x-4 items-center">
                    <a href="{{ $churchLink }}"
                       title="Open Come, Follow Me Lesson on churchofjesuschrist.org"
                       target="_blank"
                        class="text-3xl underline text-primary"
                    >
                        Week {{ $lesson->week }}: {{ $lesson->reference }}
                    </a>
                    <x-heroicon-c-arrow-top-right-on-square class="w-6 h-6 text-primary" />
                </div>
                <div>
                    @if($lesson->week < now('America/Denver')->week && $lesson->week < 52)
                        <div class="flex gap-x-2 items-center">
                            <a href="{{ route('come-follow-me.show', ['book' => $bookSlug, 'week' => $lesson->week + 1]) }}"
                            class="text-xl text-secondary">
                                Week {{ $lesson->week + 1 }}
                            </a>
                            <x-heroicon-c-chevron-right class="w-12 h-12 text-secondary" />
                        </div>
                    @endif
                </div>
            </div>
            @if($lesson->page)
                <div class="grid grid-cols-1 pb-4 md:grid-cols-7">
                    <div class="order-2 p-8 md:order-1 md:col-span-5 bg-secondary">
                        <div class="flex flex-col gap-y-4 pb-4 border-b border-white">
                            <div class="pb-2 font-serif text-4xl text-white">
                                &ldquo;{{ $lesson->title }}&rdquo;
                            </div>
                            <div class="flex flex-col">
                                <div class="my-2 text-2xl text-white line-clamp-6">
                                    {!! $lesson->quote !!}
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <a href="{{ route('pages.show', ['item' => $lesson->page->parent, 'page' => $lesson->page]) }}"
                                   target="_blank"
                                   class="py-1 px-4 text-2xl text-white">
                                    <span class="flex gap-x-1 items-center underline underline-offset-2">
                                        {{ str($lesson->page->parent->name)->stripBracketedID() }}
                                        <x-heroicon-c-chevron-right class="w-6 h-6 text-white" />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 bg-center bg-no-repeat bg-cover md:order-2 md:col-span-2"
                         style="background-image: url('{{ $lesson->getFirstMediaUrl('cover_image') }}');">
                        <img src="{{ $lesson->getFirstMediaUrl('cover_image') }}" alt="" class="w-full md:hidden aspect-[16/8]" />
                    </div>
                </div>
            @endif
            @if(! empty($lesson->video_link))
                <iframe src="{{ $lesson->video_embed_url }}"
                        class="w-full aspect-[16/9]"
                        frameborder="0"
                        allowfullscreen>
                </iframe>
            @endif

            @if($article = $lesson->getArticle())
                <div class="p-8 border-2 border-secondary">
                    @if(empty($article->link))
                        <div x-data="{ }"
                             class="space-y-4 w-full">
                            <div x-data="{
                                expanded: false,
                            }"
                                 role="region"
                                 class="bg-white">
                                <h2>
                                    <button
                                        x-on:click="expanded = !expanded"
                                        :aria-expanded="expanded"
                                        class="flex flex-col py-4 px-6 w-full"
                                    >
                                        <div class="flex gap-x-8 justify-between items-center w-full">
                                            <span class="font-sans text-3xl text-left underline text-secondary">
                                                {{ $article->title }}
                                            </span>
                                            <span x-show="expanded"
                                                  aria-hidden="true"
                                                  class="ml-4 text-3xl font-semibold text-secondary">&minus;</span>
                                            <span x-show="!expanded"
                                                  aria-hidden="true"
                                                  class="ml-4 text-3xl font-semibold text-secondary">&plus;</span>
                                        </div>
                                        <div class="mt-2 text-xl text-primary">
                                            by {{ $article->subtitle }}
                                        </div>
                                        <div x-show="!expanded"
                                             class="mt-4">
                                            <div class="text-2xl text-left line-clamp-3">
                                                {!! $article->description !!}
                                            </div>
                                        </div>
                                    </button>
                                </h2>

                                <div x-show="expanded"
                                     x-collapse
                                     x-cloak
                                >
                                    <div class="px-6 pb-4 text-2xl text-left">
                                        {!! $article->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div>
                            <a href="{{ $article->link }}"
                               class="font-sans text-3xl underline text-secondary"
                               target="_blank"
                            >
                                {{ $article->title }}
                            </a>
                            <div class="mt-2 text-xl text-primary">
                                by {{ $article->subtitle }}
                            </div>
                            @if(! empty($article->description))
                                <div class="mt-4 text-2xl line-clamp-3">
                                    {!! $article->description !!}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            <div class="relative p-8 bg-primary">
                <div class="mb-6 font-sans text-3xl text-white">
                    Wilford Woodruff’s Related Documents & Events
                </div>
                @foreach($lesson->events as $event)
                    @if($event->page?->parent)
                        <a href="{{ route('pages.show', ['item' => $event->page->parent, 'page' => $event->page]) }}"
                           target="_blank"
                           class="">
                            <div class="flex flex-col gap-y-4 p-4 md:w-[75%] z-20">
                                <div class="flex flex-col">
                                    <div class="text-2xl font-semibold text-white">
                                        {{ $event->description }}
                                    </div>
                                    <div class="flex gap-x-1 items-center text-2xl text-white underline">
                                        {{ str($event->page->parent->name)->stripBracketedID() }}
                                        <x-heroicon-c-chevron-right class="w-6 h-6 text-white" />
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
                <div class="hidden absolute right-0 bottom-0 md:block">
                    <img src="{{ asset('img/come-follow-me/wilford-woodruff.png') }}"
                         class="h-auto w-[400px]"
                    />
                </div>
            </div>

            {{-- TODO: Scripture References --}}
            <livewire:cfm.scriptures :lesson="$lesson" />

            @if($previous->count() > 0)
                <div>
                    <h2 class="font-sans text-3xl text-primary">
                        Study More <span class="italic">Come, Follow Me</span>
                    </h2>
                    <div class="grid grid-cols-2 gap-x-6 gap-y-8 mt-8 md:grid-cols-4">
                        @foreach($previous->merge($next) as $lesson)
                            @include('public.come-follow-me.card')
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mb-12 w-full">
                <h2 class="mb-8 font-sans text-3xl text-primary">
                    Other Resources
                </h2>
                {{--<a href="https://www.fairlatterdaysaints.org/cfm2025"--}}
                <a href="https://www.fairlatterdaysaints.org/come-follow-me-doctrine-covenants-church-history"
                   target="_blank"
                    class=""
                >
                    <img src="{{ asset('img/come-follow-me/fair-latter-day-saints.png') }}"
                         alt="Dive Deeper Into Come, Follow Me on FAIR Latter-day Saints"
                         class="w-full h-auto"
                    />
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
