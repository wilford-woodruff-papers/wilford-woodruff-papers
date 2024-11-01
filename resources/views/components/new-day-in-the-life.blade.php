<div class="flex overflow-hidden flex-col shadow">
    <div class="relative z-0 w-full bg-center bg-cover bg-primary aspect-[16/9]"
         style="background-image: url('{{ app()->environment('local') ? 'https://wilford-woodruff-papers.nyc3.digitaloceanspaces.com/media-library/716547/conversions/default-web.jpg' : $image }}'); background-size: 160%;"
    >
        <div class="absolute -bottom-32 w-[150%] h-full inset -rotate-[7deg] bg-secondary -ml-[20%] z-1"></div>
    </div>
    <div class="flex relative flex-col justify-between h-full bg-secondary">
        <div class="flex flex-col gap-y-2 px-4">
            <h2 class="pb-2 w-full text-2xl text-white border-b border-white">
                Discover <b>Today</b> in the Life
            </h2>
            <p class="mt-2 font-semibold text-white">
                {{ $date->format('F d, Y ~ l') }}
            </p>
            <div class="!text-white line-clamp-5">
                {!! str($content)->limit(250) !!}
            </div>
        </div>
        <div class="px-4 pt-6 pb-4">
            <a href="{{ route('day-in-the-life', ['date' => $date->format('Y-m-d')]) }}"
               class="block py-2 px-4 w-full text-base font-semibold text-center bg-white text-primary"
            >
                Discover More From This Day
            </a>
        </div>
    </div>
</div>
