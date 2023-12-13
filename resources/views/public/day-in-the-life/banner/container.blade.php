<x-chromeless-layout>
    <div class="overflow-hidden h-[371px] w-[1232px]">
        <div class="flex">
            <img src="{{ asset('img/banners/day-in-the-life-banner-highlight.png') }}"
                 alt=""
                 class="absolute top-0 left-0 z-10 h-[371px]"
            />
            <div class="max-w-[550px] flex-0">
                <div class="flex relative z-10 flex-col gap-y-8 py-16 pr-28 pl-12">
                    <h2 class="text-4xl font-light text-white uppercase border-b border-white leading-[1.4em]">
                        Discover <span class="font-bold">Today</span> in the Life
                    </h2>
                    <p class="text-xl text-white">
                        Explore Wilford Woodruff's journals and other documents from each day of his life.
                    </p>
                    <p class="text-2xl font-semibold text-white">
                        {{ $date->format('F d, Y ~ l') }}
                    </p>
                </div>
            </div>
            <div class="flex-1 z-1">
                {!! $section !!}
            </div>
        </div>
    </div>
</x-chromeless-layout>
