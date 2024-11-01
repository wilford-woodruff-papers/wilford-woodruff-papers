<div class="overflow-hidden relative shadow">
    <div class="absolute -bottom-40 w-[150%] h-full inset -rotate-[7deg] bg-secondary -ml-[20%] z-0"></div>
    <div class="h-2/5 bg-primary z-1">
        <img src="{{  $cfm->getFirstMediaUrl('cover_image') }}" alt="" />
    </div>
    <div class="flex relative z-10 flex-col gap-y-4 px-4 h-1/2">
        <h2 class="pb-2 w-full text-3xl text-white border-b border-white">
            Come Follow Me Insights
        </h2>
        <div>
            <p class="font-semibold text-white">
                Week {{ $cfm->week }} -  &ldquo;{{ $cfm->title }}&rdquo;
            </p>
        </div>
        <div class="!text-white line-clamp-5 flex-grow">
            {!! str($cfm->quote)->limit(250) !!}
        </div>
        <div class="flex w-full">
            <a href="{{ route('come-follow-me.show', ['book' => $bookSlug, 'week' => $cfm->week]) }}"
               class="block py-2 px-4 w-full text-base font-semibold text-center bg-white text-primary"
            >
                Study Come Follow Me
            </a>
        </div>
    </div>
</div>
