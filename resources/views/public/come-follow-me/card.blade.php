<a href="{{ route('come-follow-me.show', ['book' => $bookSlug, 'week' => $lesson->week]) }}">
    <div class="flex flex-col gap-y-4">
        <div class="overflow-hidden aspect-[16/8] filter drop-shadow-lg">
            <img src="{{ $lesson->getFirstMediaUrl('cover_image') }}"
                 alt="{{ $lesson->title }}"
                 class="w-full h-auto" />
        </div>
        <div class="flex flex-col px-2 text-xl">
            <div class="flex justify-center items-center">
                Week {{ $lesson->week }}
            </div>
            <div class="flex justify-center items-center font-semibold">
                {{ $lesson->reference }}
            </div>
        </div>
    </div>
</a>
