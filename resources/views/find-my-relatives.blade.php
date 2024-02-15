<x-guest-layout>
    <div class="bg-gradient-to-b from-primary via-primary-40 to-[#ffffff] min-h-screen">
        <div class="py-8 px-12 mx-auto max-w-7xl lg:py-16">
            <div class="grid order-last gap-8 lg:order-first lg:grid-cols-5">
                <div class="flex flex-col gap-y-8 justify-between px-4 lg:col-span-3">
                    <div class="flex z-50 flex-col gap-y-2 text-center lg:text-left">
                        <h1 class="text-4xl text-white lg:text-6xl">
                            <div class="mx-auto max-w-xl lg:mx-0">
                                Discover your Relatives in Wilford Woodruff's Papers
                            </div>
                        </h1>
                        <div class="text-xl text-white lg:pl-2">
                            with the help of FamilySearch
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
                <div class="order-first mt-4 lg:order-last lg:col-span-2 lg:mt-20 min-h-[300px]">
                    <div class="flex justify-center">
                        <div class="absolute w-48 h-auto xl:w-64 z-[3]">
                            <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/relative-finder/example-image-1.jpg"
                                class="w-full h-auto border-8 border-white shadow-xl"
                            />
                        </div>
                        <div class="absolute mt-12 ml-72 w-52 h-auto rotate-12 xl:w-72 z-[2]">
                            <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/relative-finder/example-image-3.jpg"
                                 class="w-full h-auto border-8 border-white shadow-xl"
                            />
                        </div>
                        <div class="absolute mt-8 -ml-72 w-48 h-auto -rotate-12 xl:w-64 z-[1]">
                            <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/relative-finder/example-image-2.jpg"
                                 class="w-full h-auto border-8 border-white shadow-xl"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-24 mx-16">
                <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/relative-finder/my-relatives.png"
                     alt=""
                    class="w-full h-auto shadow-2xl"
                />
            </div>
        </div>
    </div>
</x-guest-layout>
