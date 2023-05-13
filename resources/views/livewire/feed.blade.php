<div x-data="{
        observe () {
            let observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        @this.call('loadMore')
                    }
                })
            }, {
                root: null
            })

            observer.observe(this.$el)
        }
    }"
     x-init="observe">
    <div class="grid grid-cols-3 gap-x-3">
        <div class="col-span-3 sm:col-span-2">
            <form wire:submit.prevent="submit">
                <div class="mb-6">
                <label for="email" class="sr-only">Search candidates</label>
                <div class="flex mt-1 rounded-md shadow-sm">
                    <div class="flex relative flex-grow items-stretch focus-within:z-10">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <!-- Heroicon name: solid/search -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <label for="search" class="sr-only">Search Articles, Videos, and Pocasts</label>
                        <input wire:model.defer="filters.search"
                               type="search"
                               name="search"
                               id="search"
                               class="block pl-10 w-full border-gray-300 sm:text-sm focus:ring-secondary focus:border-secondary"
                               placeholder="">
                    </div>
                    <div x-data="{
                                                        open: false,
                                                        toggle() {
                                                            if (this.open) {
                                                                return this.close()
                                                            }

                                                            this.$refs.button.focus()

                                                            this.open = true
                                                        },
                                                        close(focusAfter) {
                                                            if (! this.open) return

                                                            this.open = false

                                                            focusAfter && focusAfter.focus()
                                                        }
                                                    }"
                         x-on:keydown.escape.prevent.stop="close($refs.button)"
                         x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                         x-id="['dropdown-button']"
                         class="relative">
                        <button x-ref="button"
                                x-on:click="toggle()"
                                :aria-expanded="open"
                                :aria-controls="$id('dropdown-button')"
                                type="button"
                                class="inline-flex relative items-center py-2 px-4 -ml-px space-x-2 text-sm font-medium text-gray-700 bg-gray-50 border border-gray-300 hover:bg-gray-100 focus:ring-1 focus:outline-none focus:ring-secondary focus:border-secondary"
                        >
                            <span class="sr-only">Toggle filter options</span>
                            <!-- Heroicon name: solid/adjustments -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </button>
                        <!-- Panel -->
                        <div
                            x-ref="panel"
                            x-show="open"
                            x-transition.origin.top.left
                            x-on:click.outside="close($refs.button)"
                            :id="$id('dropdown-button')"
                            style="display: none;"
                            class="absolute right-0 top-10 z-20 mt-2 w-56 bg-white ring-1 ring-black ring-opacity-5 shadow-lg focus:outline-none"
                        >
                            <div class="py-2 px-4">
                                Types
                            </div>

                            <div class="px-2 pb-4 border-t border-gray-400">
                                <fieldset class="space-y-4">
                                    <legend class="sr-only">Types</legend>
                                    @foreach(['Article', 'News', 'Podcast', 'Instagram', 'Video'] as $type)
                                        <div class="flex relative items-start">
                                            <div class="flex items-center h-5">
                                                <input wire:model="filters.type"
                                                       id="{{ $type }}"
                                                       aria-describedby="{{ $type }}-description"
                                                       name="type[]"
                                                       type="checkbox"
                                                       value="{{ $type }}"
                                                       class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="{{ $type }}" class="font-medium text-gray-700">{{ $type }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </fieldset>
                            </div>
                        </div>
                    </div>


                    {{--<button type="button" class="inline-flex relative items-center py-2 px-4 -ml-px space-x-2 text-sm font-medium text-gray-700 bg-gray-50 border border-gray-300 hover:bg-gray-100 focus:ring-1 focus:outline-none focus:ring-secondary focus:border-secondary">
                        <!-- Heroicon name: solid/adjustments -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <span class="sr-only">Filter</span>
                    </button>--}}
                </div>
            </div>
            </form>
            <div class="grid grid-flow-row gap-y-4">
                @foreach ($articles as $media)
                    <div class="flex overflow-hidden flex-col w-full h-full shadow-lg shrink-0">
                        @if($media->external_link_only)
                            <a href="{{ $media->link }}"
                               target="_blank"
                            >
                        @else
                            <div wire:click="$emit('openModal', 'press-modal', {{ json_encode(["press" => $media->id]) }})"
                                 class="flex-shrink-0 cursor-pointer">
                        @endif

                            {{--<a href="{{ route('media.'.Str::of($media->type)->lower(), $media->slug) }}">--}}
                                {{--<img class="object-cover w-full h-48"
                                     src="{{ \Illuminate\Support\Facades\Storage::disk('media')->url($media->cover_image)  }}"
                                     alt="{{ $media->title }}">--}}
                                <div class="inline-block flex overflow-hidden relative items-center w-full image-parent h-128 bg-primary-50">
                                    <div class="absolute z-0 z-10 w-full h-full bg-center bg-cover image-child"
                                         @if(! empty($media->cover_image))
                                             style="background-image: url({{ ($media->type == 'Instagram' ? $media->cover_image : \Illuminate\Support\Facades\Storage::disk('media')->url($media->cover_image)) }})"
                                         @endif

                                    >

                                    </div>
                                    <div class="flex z-10 flex-row justify-center items-center py-3 w-full text-xl font-medium uppercase text-secondary bg-white-80">
                                        {!! $media->icon !!}
                                        {{ $media->call_to_action }}
                                    </div>
                                </div>
                            {{--</a>--}}
                        @if($media->external_link_only)
                            </a>
                        @else
                            </div>
                        @endif

                        <div class="flex flex-col flex-1 justify-between p-6 bg-white">
                            @if($media->external_link_only)
                                <a href="{{ $media->link }}"
                                   target="_blank"
                                >
                            @else
                                <div wire:click="$emit('openModal', 'press-modal', {{ json_encode(["press" => $media->id]) }})"
                                     class="flex-1 cursor-pointer">
                            @endif
                                <div class="flex justify-between">
                                    <p class="text-sm font-medium text-secondary">
                                        {{--<a href="{{ route('media.'.Str::of($media->type)->lower(), $media->slug) }}" class="hover:underline">--}}
                                            {{ $media->type }}
                                        {{--</a>--}}
                                    </p>
                                    <div class="flex space-x-1 text-sm text-gray-500">
                                        <time datetime="{{ $media->date?->toDateString() }}">
                                            {{ $media->date?->toFormattedDateString() }}
                                        </time>
                                    </div>
                                </div>
                                {{--<a href="{{ route('media.'.Str::of($media->type)->lower(), $media->slug) }}" class="block mt-2">--}}
                                    <p class="text-lg font-semibold text-gray-900">
                                        @if($media->type == 'Instagram')
                                            {{ Str::of($media->excerpt)->limit(75, '...') }}
                                        @else
                                            {{ Str::of($media->title)->limit(75, '...') }}
                                        @endif
                                    </p>
                                {{--</a>--}}
                            @if($media->external_link_only)
                                </a>
                            @else
                                </div>
                            @endif
                            <div class="flex justify-between items-center mt-3">
                                <div wire:click="$emit('openModal', 'press-modal', {{ json_encode(["press" => $media->id]) }})"
                                     class="ml-3 cursor-pointer">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $media->subtitle }}
                                    </p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $media->publisher }}
                                    </p>
                                </div>

                                <x-press.share :media="$media" :showCommentIcon="true"/>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center">
                @if($articles->hasMorePages())
                    <div x-intersect:enter="@this.call('loadMore')">
                        <div class="py-6 text-2xl" wire:loading>...</div>
                    </div>
                @endif
            </div>
        </div>
        <div class="hidden pt-1 sm:block sm:col-span-1">
            @if($popular->count() > 0)
                <div class="sticky top-10 px-2 border border-gray-200">
                    <h2 class="pt-4 pl-4 text-xl font-medium text-gray-800">
                        Popular
                    </h2>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($popular as $article)
                            @if($article->external_link_only)
                                <a href="{{ $article->link }}"
                                   target="_blank"
                                >
                            @else
                                <div wire:click="$emit('openModal', 'press-modal', {{ json_encode(["press" => $article->id]) }})"
                                     class="cursor-pointer">
                            @endif
                                {{--<a href="{{ route('landing-areas.ponder.press', $article->slug) }}">--}}
                                    <div class="flex relative items-center py-5 px-2 space-x-3 bg-white shadow-sm focus-within:ring-2 focus-within:ring-offset-2 hover:border-gray-400 focus-within:ring-secondary">
                                        <div class="flex-shrink-0 w-14 h-14 bg-center bg-cover"
                                             @if(! empty($article->cover_image))
                                                 style="background-image: url({{ ($article->type == 'Instagram' ? $article->cover_image : \Illuminate\Support\Facades\Storage::disk('media')->url($article->cover_image))  }})"
                                             @endif
                                        >

                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            <p class="text-sm font-medium text-secondary">{{ $article->type }}</p>
                                            <p class="text-base font-medium text-gray-900">
                                                @if($article->type == 'Instagram')
                                                    {{ Str::of($article->excerpt)->limit(52, '...') }}
                                                @else
                                                    {{ Str::of($article->title)->limit(52, '...') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                {{--</a>--}}
                            @if($article->external_link_only)
                                </a>
                            @else
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    @push('styles')
        <link href="https://vjs.zencdn.net/7.19.2/video-js.css" rel="stylesheet" />
    @endpush
    @push('scripts')
        <script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>
        <script src="https://vjs.zencdn.net/7.19.2/video.min.js"></script>
        @if($showPress)
            <script>
                Livewire.emit( 'openModal', 'press-modal', {"press": '{{ $showPress }}' });
            </script>
        @endif
    @endpush
</div>
