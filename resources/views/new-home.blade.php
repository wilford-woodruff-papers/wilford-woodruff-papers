<x-new-guest-layout>
{{--    <div class="inset-1 w-full h-full bg-gradient-to-t from-transparent to-white z-1">--}}

{{--    </div>--}}
    <video autoplay loop muted playsinline
           poster="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/files/video/time-machine.jpeg"
           class="object-cover absolute top-0 left-0 z-0 w-full h-auto opacity-40 aspect-[8/3]"

    >
        <source src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/files/video/time-machine.mp4">
{{--        <source src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/files/video/time-machine.webm">--}}
    </video>
    <div class="flex relative z-10 items-center px-8 mx-auto w-full max-w-7xl h-auto aspect-[8/3]">
        <div class="flex flex-col gap-y-4">
            <h1 class="text-7xl">
                Wilford Woodruff Papers
            </h1>
            <p class="text-3xl">
                Search Wilford Woodruff's <span class="font-semibold">documents</span>, as well as <span class="font-semibold">locations</span>, <span class="font-semibold">events</span>, and <span class="font-semibold">people</span> in his records.
            </p>
            <div class="">
                <form action="{{ route('search') }}"
                class=""
                >
                    <div>
                        <label for="q" class="block text-sm font-medium leading-6 text-gray-900 sr-only">Search</label>
                        <div class="flex mt-2 rounded-md shadow-sm">
                            <div class="flex relative flex-grow items-stretch focus-within:z-10">
                                <input type="text" name="q" id="q" class="block py-1.5 pl-4 w-full text-gray-900 rounded-none border-0 ring-1 ring-inset ring-gray-300 sm:text-lg sm:leading-8 focus:ring-2 focus:ring-inset placeholder:text-primary-70 focus:ring-secondary" placeholder="Search Peoples, Events, Locations and more...">
                            </div>
                            <button type="button" class="inline-flex relative gap-x-1.5 items-center py-2 px-6 -ml-px text-sm font-semibold text-gray-900 ring-1 ring-inset ring-secondary bg-secondary hover:bg-secondary-400">
                                <x-heroicon-o-magnifying-glass class="-ml-0.5 w-5 h-5 text-white" />
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-new-guest-layout>
