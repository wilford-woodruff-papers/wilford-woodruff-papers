
    {{--<a href="{{ route('media.'.Str::of($media->type)->lower(), $media->slug) }}" title="{{ $media->title }}">--}}
    <div class="flex overflow-hidden flex-col w-full h-full shadow-lg shrink-0">
        <div class="flex-shrink-0">
            <a href="{{ route('landing-areas.ponder.press', ['press' => $media->slug]) }}">
                <div class="inline-block flex overflow-hidden relative items-center w-full h-72 image-parent bg-primary-50">
                    <div class="absolute z-0 z-10 w-full h-full bg-center bg-cover image-child" style="background-image: url({{ $media->cover_image }})">

                    </div>
                    <div class="flex z-10 flex-row justify-center items-center py-3 w-full text-xl font-medium uppercase text-secondary bg-white-80">
                        {!! $media->icon !!}
                        {{ $media->call_to_action }}
                    </div>
                </div>
            </a>
        </div>
        <div class="flex flex-col flex-1 justify-between p-6 bg-white">
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
                        {{ Str::of($media->excerpt)->limit(50, '...') }}
                    </p>
                </a>
            </div>
            {{--<div class="flex items-center mt-6">
                <div class="flex-shrink-0">
                    <img class="w-10 h-10 rounded-full" src="{{ asset('img/logo.png') }}" alt="">
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
    {{--<button x-bind="focusableWhenVisible" class="py-2 px-4 text-sm">Do Something</button>--}}

