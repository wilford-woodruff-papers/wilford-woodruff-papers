<x-new-guest-layout>
{{--    <div class="inset-1 w-full h-full bg-gradient-to-t from-transparent to-white z-1">--}}

{{--    </div>--}}
    <video autoplay loop muted playsinline
           poster="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/files/video/time-machine.jpeg"
           class="object-cover absolute left-0 top-20 w-full h-auto opacity-40 -z-1 aspect-[8/5] lg:aspect-[8/3]"

    >
        <source src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/files/video/time-machine.mp4">
{{--        <source src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/files/video/time-machine.webm">--}}
    </video>

    <div class="flex relative items-center px-8 mx-auto w-full max-w-7xl h-auto z-1 aspect-[7/3]">
        <div class="flex flex-col gap-y-4 mt-6 w-full text-center md:text-left lg:mt-0 lg:-mt-20">
            <h1 class="hidden text-3xl md:block lg:text-7xl">
                Wilford Woodruff Papers
            </h1>
            <p class="text-xl lg:text-2xl">
                Search Wilford Woodruff's <span class="font-semibold">documents</span>, as well as the <span class="font-semibold">locations</span>, <span class="font-semibold">events</span>, and <span class="font-semibold">people</span> in his records.
            </p>
            <div class="mb-10">
                <form action="{{ route('advanced-search') }}"
                class="lg:px-20 lg:pt-8"
                >
                    <div>
                        <label for="q" class="block text-sm font-medium leading-6 text-gray-900 sr-only">Search</label>
                        <div class="flex mt-2 rounded-md shadow-sm">
                            <div class="flex relative flex-grow items-stretch focus-within:z-10">
                                <input type="text" name="q" id="q" class="block py-1.5 pl-4 w-full text-gray-900 rounded-none border-0 ring-1 ring-inset ring-gray-300 sm:text-lg sm:leading-8 focus:ring-2 focus:ring-inset placeholder:text-primary-70 focus:ring-secondary" placeholder="Search People, Events, Locations and more...">
                            </div>
                            <button type="button" class="inline-flex relative gap-x-1.5 items-center py-2 px-6 -ml-px text-sm font-semibold text-gray-900 ring-1 ring-inset ring-secondary bg-secondary hover:bg-secondary-400">
                                <x-heroicon-o-magnifying-glass class="-ml-0.5 w-5 h-5 text-white" />
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex justify-end mb-2 lg:px-20">
                <button onclick="Livewire.dispatch('openModal', {component: 'full-screen-video', arguments: {url: 'https://www.youtube.com/embed/jSUuwwyWW6E?rel=0'}})"
                        class="flex gap-2 items-center py-2 px-3 font-semibold uppercase bg-white text-secondary"
                >
                    <span>Watch Full Video</span>
                    <x-heroicon-o-arrows-pointing-out class="w-6 h-6"/>
                </button>
            </div>
        </div>
    </div>

    <div class="relative z-10 px-8 mx-auto max-w-7xl">
        <x-new-announcements :position="'top'"/>
{{--        <div x-data="{--}}
{{--                height: 160,--}}
{{--            }"--}}
{{--             class="mb-8 w-full">--}}
{{--            <div class="flex justify-center items-center w-full bg-gray-400 h-[160px]"--}}
{{--                 style="resize: vertical; overflow:auto;"--}}
{{--                 x-resize="height = $height"--}}
{{--            >--}}
{{--                <p x-text="'Height: ' + height + 'px'" class="text-white"></p>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <x-new-day-in-the-life />
            <x-new-relative-finder />
            <x-new-come-follow-me />
        </div>
    </div>

    <div class="px-8 my-12 mx-auto max-w-7xl h-48">
        <div class="flex relative justify-center items-center h-full border-t-2 border-b-2 border-primary">
            <div class="absolute top-[50%] left-[55%] transform-gpu -translate-x-1/2 -translate-y-1/2 w-128 h-auto opacity-30">
                <img src="{{ asset('img/logo-opacity-25.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
            </div>
            <p class="mx-auto max-w-5xl text-2xl text-center">
                Our purpose in making Wilford Woodruff’s records universally accessible is to inspire all people, especially the rising generation, to study and <span class="font-semibold">increase their faith in Jesus Christ</span>.
            </p>
        </div>
    </div>

    <div class="relative px-8 mx-auto mt-8 max-w-7xl">
        <x-new-content />
    </div>

    <div class="relative px-8 mx-auto mt-8 max-w-7xl">
        <div class="text-white bg-right-bottom bg-no-repeat bg-contain bg-secondary lg:bg-[url('https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/wilford-woodruff-colorized-no-background.png')]"
        >
            <div class="grid lg:grid-cols-5">
                <div class="col-span-3">
                    <div class="flex flex-col gap-y-8 p-12">
                        <h2 class="pb-2 text-3xl font-semibold">
                            Who is Wilford Woodruff?
                        </h2>
                        <p class="text-xl">
                            Wilford Woodruff was the fourth President of The Church of Jesus Christ of Latter-day Saints. He is known for his success as a missionary and his meticulous record keeping. For more than 64 years, he kept a daily journal of his interactions with thousands of individuals, the inspired discourses of early Church leaders, his missionary efforts in the United States and Great Britain, and his service as an apostle, and later prophet, from 1839 to 1898. Over 25,000 people are mentioned in his Papers.
                        </p>
                        <div class="text-center">
                            <a href="{{ url('wilford-woodruff') }}"
                               class="inline-block py-2 px-8 text-base lg:text-xl !no-underline uppercase bg-white text-secondary font-semibold"
                            >
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-span-2">

                </div>
            </div>
        </div>
    </div>

    <div class="relative px-8 my-16 mx-auto max-w-7xl">
        <x-new-testimonies />
    </div>

</x-new-guest-layout>
