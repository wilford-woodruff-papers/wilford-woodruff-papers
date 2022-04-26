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
        <div class="col-span-2">
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
                        <div class="flex-shrink-0">
                            <a href="{{ route('media.'.Str::of($media->type)->lower(), $media->slug) }}">
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
                            </a>
                        </div>
                        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <p class="text-sm font-medium text-secondary">
                                        <a href="{{ route('media.'.Str::of($media->type)->lower(), $media->slug) }}" class="hover:underline">
                                            {{ $media->type }}
                                        </a>
                                    </p>
                                    <div class="flex space-x-1 text-sm text-gray-500">
                                        <time datetime="{{ $media->date?->toDateString() }}">
                                            {{ $media->date?->toFormattedDateString() }}
                                        </time>
                                    </div>
                                </div>
                                <a href="{{ route('media.'.Str::of($media->type)->lower(), $media->slug) }}" class="block mt-2">
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ Str::of($media->title)->limit(75, '...') }}
                                    </p>
                                </a>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $media->subtitle }}
                                    </p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $media->publisher }}
                                    </p>
                                </div>

                                <div class="grid grid-flow-row">
                                    <div class="flex gap-x-4">
                                        <div>
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
                                                        class=""
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer hover:text-green-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
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
                                                    class="absolute z-10 right-0 bottom-10 mt-2 w-56 shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                >
                                                    <div class="px-4 py-2">
                                                        Share
                                                    </div>

                                                    <div class="border-t border-gray-400 px-2">
                                                        <div class="flex gap-x-1 items-center px-6 hover:bg-gray-100">
                                                            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" class="w-6 h-6"><path d="M 50.0625 10.4375 C 48.214844 11.257813 46.234375 11.808594 44.152344 12.058594 C 46.277344 10.785156 47.910156 8.769531 48.675781 6.371094 C 46.691406 7.546875 44.484375 8.402344 42.144531 8.863281 C 40.269531 6.863281 37.597656 5.617188 34.640625 5.617188 C 28.960938 5.617188 24.355469 10.21875 24.355469 15.898438 C 24.355469 16.703125 24.449219 17.488281 24.625 18.242188 C 16.078125 17.8125 8.503906 13.71875 3.429688 7.496094 C 2.542969 9.019531 2.039063 10.785156 2.039063 12.667969 C 2.039063 16.234375 3.851563 19.382813 6.613281 21.230469 C 4.925781 21.175781 3.339844 20.710938 1.953125 19.941406 C 1.953125 19.984375 1.953125 20.027344 1.953125 20.070313 C 1.953125 25.054688 5.5 29.207031 10.199219 30.15625 C 9.339844 30.390625 8.429688 30.515625 7.492188 30.515625 C 6.828125 30.515625 6.183594 30.453125 5.554688 30.328125 C 6.867188 34.410156 10.664063 37.390625 15.160156 37.472656 C 11.644531 40.230469 7.210938 41.871094 2.390625 41.871094 C 1.558594 41.871094 0.742188 41.824219 -0.0585938 41.726563 C 4.488281 44.648438 9.894531 46.347656 15.703125 46.347656 C 34.617188 46.347656 44.960938 30.679688 44.960938 17.09375 C 44.960938 16.648438 44.949219 16.199219 44.933594 15.761719 C 46.941406 14.3125 48.683594 12.5 50.0625 10.4375 Z"/></svg>
                                                            <a href="https://twitter.com/share?text={{ $media->title }}&via=subjecttoclimat&url={{ route('media.'.Str::of($media->type)->lower(), $media->slug) }}"
                                                               class="block w-full px-4 py-2 text-left text-sm"
                                                               target="_blank"
                                                            >
                                                                Twitter
                                                            </a>
                                                        </div>

                                                        <div class="flex gap-x-1 items-center px-6 hover:bg-gray-100">
                                                            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" class="w-6 h-6">    <path d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M37,19h-2c-2.14,0-3,0.5-3,2 v3h5l-1,5h-4v15h-5V29h-4v-5h4v-3c0-4,2-7,6-7c2.9,0,4,1,4,1V19z"/></svg>
                                                            <a href="https://facebook.com/sharer.php?u={{ route('media.'.Str::of($media->type)->lower(), $media->slug) }}"
                                                               class="block w-full px-4 py-2 text-left text-sm"
                                                               target="_blank"
                                                            >
                                                                Facebook
                                                            </a>
                                                        </div>

                                                        <div class="flex gap-x-1 items-center px-6 hover:bg-gray-100">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                            </svg>
                                                            <a href="mailto:?subject={{ $media->title }}&body={{ route('media.'.Str::of($media->type)->lower(), $media->slug) }}"
                                                               class="block w-full px-4 py-2 text-left text-sm"
                                                               target="_blank">
                                                                Email
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                        </div>
                                        <div class="grid grid-flow-row">
                                            <div>
                                                @guest()
                                                    <button wire:click="login()">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer hover:text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                        </svg>
                                                    </button>
                                                @else
                                                    <button wire:click="toggleLike({{ $media->id }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer hover:text-red-700 @if(\Maize\Markable\Models\Like::has($media, \Illuminate\Support\Facades\Auth::user())) text-red-700 @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                        </svg>
                                                    </button>
                                                @endguest
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid justify-items-end">
                                        @if(($count = \Maize\Markable\Models\Like::count($media)) > 0)
                                            {{ $count }} {{ str('Like')->plural($count) }}
                                        @endif
                                    </div>
                                </div>
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
        <div class="pt-1">
            @if($popular->count() > 0)
                <div class="border border-gray-200 px-2">
                    <h2 class="text-xl font-medium pt-4 text-gray-800 pl-4">
                        Popular
                    </h2>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($popular as $article)
                            <div>
                                <a href="{{ route('media.'.Str::of($article->type)->lower(), $article->slug) }}">
                                    <div class="relative bg-white px-2 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-secondary">
                                        <div class="flex-shrink-0 h-14 w-14"
                                             style="background-image: url({{ \Illuminate\Support\Facades\Storage::disk('media')->url($article->cover_image)  }})"
                                        >

                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <a href="#" class="focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-secondary">{{ $article->type }}</p>
                                                <p class="text-base font-medium text-gray-900">{{ Str::of($article->title)->limit(52, '...') }}</p>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
