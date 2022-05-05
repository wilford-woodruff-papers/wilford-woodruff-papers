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
                <div class="mt-1 flex rounded-md shadow-sm">
                    <div class="relative flex items-stretch flex-grow focus-within:z-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <!-- Heroicon name: solid/search -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <label for="search" class="sr-only">Search Articles, Videos, and Pocasts</label>
                        <input wire:model.defer="filters.search"
                               type="search"
                               name="search"
                               id="search"
                               class="focus:ring-secondary focus:border-secondary block w-full pl-10 sm:text-sm border-gray-300"
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
                                class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary"
                        >
                            <span class="sr-only">Toggle filter options</span>
                            <!-- Heroicon name: solid/adjustments -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                            class="absolute z-20 right-0 top-10 mt-2 w-56 shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                        >
                            <div class="px-4 py-2">
                                Types
                            </div>

                            <div class="border-t border-gray-400 px-2 pb-4">
                                <fieldset class="space-y-4">
                                    <legend class="sr-only">Types</legend>
                                    @foreach(['Article', 'Podcast', 'Video'] as $type)
                                        <div class="relative flex items-start">
                                            <div class="flex items-center h-5">
                                                <input wire:model="filters.type"
                                                       id="{{ $type }}"
                                                       aria-describedby="{{ $type }}-description"
                                                       name="type[]"
                                                       type="checkbox"
                                                       value="{{ $type }}"
                                                       class="focus:ring-secondary h-4 w-4 text-secondary border-gray-300 rounded">
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


                    {{--<button type="button" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary">
                        <!-- Heroicon name: solid/adjustments -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <span class="sr-only">Filter</span>
                    </button>--}}
                </div>
            </div>
            </form>
            <div class="grid grid-flow-row gap-y-4">
                @foreach ($articles as $media)
                    <div class="flex flex-col shrink-0 shadow-lg overflow-hidden w-full h-full">
                        @if($media->external_link_only)
                            <a href="{{ $media->link }}"
                               target="_blank"
                            >
                        @else
                            <div wire:click="$emit('openModal', 'press-modal', {{ json_encode(["press" => $media->id]) }})"
                                 class="flex-shrink-0 cursor-pointer">
                        @endif

                            {{--<a href="{{ route('media.'.Str::of($media->type)->lower(), $media->slug) }}">--}}
                                {{--<img class="h-48 w-full object-cover"
                                     src="{{ \Illuminate\Support\Facades\Storage::disk('media')->url($media->cover_image)  }}"
                                     alt="{{ $media->title }}">--}}
                                <div class="image-parent relative h-80 w-full overflow-hidden inline-block flex items-center bg-primary-50">
                                    <div class="image-child absolute h-full w-full z-10 bg-cover bg-center z-0" style="background-image: url({{ \Illuminate\Support\Facades\Storage::disk('media')->url($media->cover_image)  }})">

                                    </div>
                                    <div class="w-full py-3 z-10 text-secondary text-xl font-medium bg-white-80 uppercase flex flex-row items-center justify-center">
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

                        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
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
                                        {{ Str::of($media->title)->limit(75, '...') }}
                                    </p>
                                {{--</a>--}}
                            @if($media->external_link_only)
                                </a>
                            @else
                                </div>
                            @endif
                            <div class="mt-3 flex items-center justify-between">
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
                        <div class="text-2xl py-6" wire:loading>...</div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-span-0 sm:col-span-1 pt-1">
            @if($popular->count() > 0)
                <div class="border border-gray-200 px-2 sticky top-10">
                    <h2 class="text-xl font-medium pt-4 text-gray-800 pl-4">
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
                                    <div class="relative bg-white px-2 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-secondary">
                                        <div class="flex-shrink-0 h-14 w-14 bg-cover bg-center"
                                             style="background-image: url({{ \Illuminate\Support\Facades\Storage::disk('media')->url($article->cover_image)  }})"
                                        >

                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            <p class="text-sm font-medium text-secondary">{{ $article->type }}</p>
                                            <p class="text-base font-medium text-gray-900">{{ Str::of($article->title)->limit(52, '...') }}</p>
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
    @push('scripts')
        @if($showPress)
            <script>
                Livewire.emit( 'openModal', 'press-modal', {"press": '{{ $showPress }}' });
            </script>
        @endif
    @endpush
</div>
