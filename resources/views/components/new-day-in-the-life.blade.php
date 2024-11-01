<div class="overflow-hidden relative shadow">
    <div class="absolute -bottom-40 w-[150%] h-full inset -rotate-[7deg] bg-secondary -ml-[20%] z-0"></div>
    <div class="h-2/5 bg-primary z-1">
        <img src="{{ $image }}" alt="" />
    </div>
    <div class="flex relative z-10 flex-col gap-y-4 px-4 h-1/2">
        <h2 class="pb-2 w-full text-3xl text-white border-b border-white">
            Discover <b>Today</b> in the Life
        </h2>
        <div>
            <p class="font-semibold text-white">
                {{ $date->format('F d, Y ~ l') }}
            </p>
        </div>
        <div class="!text-white line-clamp-5 flex-grow">
            {!! str($content)->limit(250) !!}
        </div>
        <div class="flex w-full">
            <a href="{{ route('day-in-the-life', ['date' => $date->format('Y-m-d')]) }}"
               class="block py-2 px-4 w-full text-base font-semibold text-center bg-white text-primary"
            >
                Discover More From This Day
            </a>
        </div>
    </div>
</div>
