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
    <div class="grid grid-cols-3">
        <div class="col-span-2">
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
                                <div class="flex gap-x-4">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer hover:text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer hover:text-green-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div>
                @if($articles->hasMorePages())
                    <div x-intersect:enter="@this.call('loadMore')">
                        <span wire:loading.remove>Load more</span><span wire:loading>...</span>
                    </div>
                @endif
            </div>
        </div>
        <div>

        </div>
    </div>

</div>
