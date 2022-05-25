
    {{--<a href="{{ route('media.'.Str::of($media->type)->lower(), $media->slug) }}" title="{{ $media->title }}">--}}
    <div class="flex flex-col shrink-0 shadow-lg overflow-hidden w-full h-full">
        <div class="flex-shrink-0">
            <a href="{{ route('landing-areas.ponder.press', ['press' => $media->slug]) }}">
                <div class="image-parent relative h-72 w-full overflow-hidden inline-block flex items-center bg-primary-50">
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
                        <a href="{{ route('landing-areas.ponder.press', ['press' => $media->slug]) }}" class="hover:underline">
                            {{ $media->type }}
                        </a>
                    </p>
                    <div class="flex space-x-1 text-sm text-gray-500">
                        <time datetime="{{ $media->date?->toDateString() }}">
                            {{ $media->date?->toFormattedDateString() }}
                        </time>
                    </div>
                </div>
                <a href="{{ route('landing-areas.ponder.press', ['press' => $media->slug]) }}" class="block mt-2">
                    <p class="text-xl font-semibold text-gray-900">
                        {{ Str::of($media->title)->limit(50, '...') }}
                    </p>
                </a>
            </div>
            {{--<div class="mt-6 flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="{{ asset('img/logo.png') }}" alt="">
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">
                        {{ $media->subtitle }}
                    </p>
                </div>
            </div>--}}
        </div>
    </div>
    {{--<img class="mt-2 w-full" src="{{ \Illuminate\Support\Facades\Storage::disk('media')->url($media->cover_image)  }}" alt="{{ $media->title }}">--}}
    {{--</a>--}}
    {{--<button x-bind="focusableWhenVisible" class="px-4 py-2 text-sm">Do Something</button>--}}

