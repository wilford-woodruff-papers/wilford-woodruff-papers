<x-guest-layout>
    <x-slot name="title">Find My Relatives | Wilford Woodruff Papers</x-slot>
    <div class="bg-gradient-to-b from-primary via-primary-50 md:via-[#ffffff] to-[#ffffff] min-h-screen">
        <div class="px-12 mx-auto max-w-7xl sm:py-8 lg:py-16">
            <div class="grid order-last sm:gap-8 lg:order-first lg:grid-cols-5">
                <div class="flex flex-col gap-y-8 justify-between px-4 lg:col-span-3">
                    <div class="flex z-50 flex-col gap-y-2 text-center lg:text-left">
                        <h1 class="text-xl text-white md:text-4xl lg:text-5xl xl:text-6xl">
                            <div class="mx-auto max-w-xl lg:mx-0">
                                Discover Your Relatives in Wilford Woodruff's Papers
                            </div>
                        </h1>
                        <div class="gap-x-3 justify-center items-end text-xl text-white lg:justify-start lg:pl-2">
                            <span>with the help of</span> <a href="https://www.familysearch.org/"
                                                target="_blank"
                                                class="inline ml-1 sm:ml-4"
                            >
                                <img src="{{ asset('img/familytree-logo.png') }}" alt=""
                                     class="inline mb-1 w-28 h-auto"
                                />
                            </a>

                        </div>
                    </div>
                    <div class="text-center lg:text-left">
                        <a href="{{ route('my-relatives') }}"
                           class="inline-block py-3 px-6 text-xl font-semibold text-white bg-secondary hover:bg-secondary-500"
                        >
                            Find Your Relatives
                        </a>
                    </div>
                    <div class="flex flex-col gap-y-4 justify-between text-lg lg:w-3/4">
                        <div>
                            <p>
                                <span class="font-semibold">Create an account</span> on the Wilford Woodruff Papers website.
                            </p>
                        </div>
                        <div>
                            <p>
                                <span class="font-semibold">Connect your account to FamilySearch</span> and we'll use FamilySearch to find your relatives in Wilford Woodruff's papers.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="order-first sm:mt-4 lg:order-last lg:col-span-2 lg:mt-20 min-h-[200px] sm:min-h-[300px]">
                    <div class="flex relative justify-center">
                        <div class="absolute w-28 h-auto sm:w-48 xl:w-64 z-[3]">
                            <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/relative-finder/example-image-1.jpg"
                                class="w-full h-auto border-8 border-white shadow-xl"
                            />
                        </div>
                        <div class="absolute mt-12 ml-36 w-28 h-auto rotate-12 sm:w-52 xl:w-72 n z-[2]">
                            <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/relative-finder/example-image-3.jpg"
                                 class="w-full h-auto border-8 border-white shadow-xl"
                            />
                        </div>
                        <div class="absolute mt-8 -ml-36 w-28 h-auto -rotate-12 sm:w-48 xl:w-64 z-[1]">
                            <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/relative-finder/example-image-2.jpg"
                                 class="w-full h-auto border-8 border-white shadow-xl"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-24 md:mx-16">
                <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/relative-finder/my-relatives.png"
                     alt=""
                    class="w-full h-auto shadow-2xl"
                />
            </div>
        </div>
    </div>
</x-guest-layout>
