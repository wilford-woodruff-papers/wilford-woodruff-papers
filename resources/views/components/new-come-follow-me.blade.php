<div class="flex overflow-hidden flex-col shadow">
    <div class="relative z-0 w-full bg-center bg-cover bg-primary aspect-[16/9]"
         style="background-image: url('{{ app()->environment('local') ? 'https://wilford-woodruff-papers.nyc3.digitaloceanspaces.com/come-follow-me/581248/October-28-November-3.webp' : $image }}'); background-size: 160%;"
    >
        <div class="absolute -bottom-32 w-[150%] h-full inset -rotate-[7deg] bg-secondary -ml-[20%] z-1"></div>
    </div>
    <div class="flex relative flex-col justify-between h-full bg-secondary">
        <div class="flex flex-col gap-y-2 px-4">
            <h2 class="pb-2 w-full text-2xl text-white border-b border-white">
                Come Follow Me Insights
            </h2>
            <p class="mt-2 font-semibold text-white">
                Week {{ $cfm->week }} -  &ldquo;{{ $cfm->title }}&rdquo;
            </p>
            <div class="!text-white line-clamp-5">
                {!! str($cfm->quote)->limit(250) !!}
            </div>
        </div>
        <div class="px-4 pt-6 pb-4">
            <a href="{{ route('come-follow-me.show', ['book' => $bookSlug, 'week' => $cfm->week]) }}"
               class="block py-2 px-4 w-full text-base font-semibold text-center bg-white text-primary"
            >
                Study Come Follow Me
            </a>
        </div>
    </div>
</div>
