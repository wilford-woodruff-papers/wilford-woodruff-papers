<x-guest-layout>
    <div>
        <div class="mx-auto max-w-7xl">
            <div class="flex justify-between">
                <div>
                    @if($lesson->week > 1)
                        <a href="{{ route('come-follow-me.show', ['book' => $bookSlug, 'week' => $lesson->week - 1]) }}">
                            Week {{ $lesson->week - 1 }}
                        </a>
                    @endif
                </div>
                <div class="text-2xl underline">
                    Week {{ $lesson->week }}: {{ $lesson->reference }}
                </div>
                <div>
                    @if($lesson->week < 52)
                        <a href="{{ route('come-follow-me.show', ['book' => $bookSlug, 'week' => $lesson->week + 1]) }}">
                            Week {{ $lesson->week + 1 }}
                        </a>
                    @endif
                </div>

            </div>
            <div class="grid grid-cols-5">
                <div class="col-span-4 p-4 bg-secondary">
                    <div class="flex flex-col">
                        <div class="text-4xl text-white border-b border-white">
                            "{{ $lesson->title }}"
                        </div>
                        <div class="text-lg text-white line-clamp-4">
                            {!! $lesson->quote !!}
                        </div>
                        <div>
                            <a href="{{ route('come-follow-me.show', $lesson) }}"
                               class="py-3 px-8 font-semibold underline bg-white text-secondary">
                                {{ $lesson->page->parent->name }} >>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-span-1 bg-center bg-no-repeat bg-cover"
                     style="background-image: url('{{ $lesson->getFirstMediaUrl() }}');">
                </div>
            </div>
            @if(! empty($lesson->video_embed_url))
                <iframe src="{{ $lesson->video_embed_url }}"
                        class="w-full aspect-[16/9]"
                        frameborder="0"
                        allowfullscreen>
                </iframe>
            @endif

            {{-- TODO: ARTICLE --}}

            <div class="bg-primary">
                <div class="text-2xl text-white">
                    Wilford Woodruff’s Related Documents & Events
                </div>
                @foreach($lesson->events as $event)
                    <div class="flex flex-col gap-y-4 p-4">
                        <div class="text-lg font-semibold text-white">
                            {{ $event->description }}
                        </div>
                        <a class="text-lg text-white underline">
                            {{ $event->page->parent->name }}
                        </a>
                    </div>
                @endforeach
                <div class="absolute relative right-0 bottom-0">
                    <img src="{{ asset('come-follow-me/wilford-woodruff.png') }}"
                        class="w-48 h-auto"
                    />
                </div>
            </div>

            {{-- TODO: Scripture References --}}

            {{-- TODO: Study More --}}

            {{-- TODO: FAIR --}}

        </div>
    </div>
</x-guest-layout>
