<x-guest-layout>
    <x-slot name="title">Access the Wilford Woodruff Papers Developer API</x-slot>
    <div class="overflow-hidden relative py-24 px-6 bg-white sm:py-32 lg:overflow-visible lg:px-0 isolate">
        <div class="overflow-hidden absolute inset-0 -z-10">
            <svg class="absolute left-[max(50%,25rem)] top-0 h-[64rem] w-[128rem] -translate-x-1/2 stroke-gray-200 [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                        <path d="M100 200V.5M.5 .5H200" fill="none" />
                    </pattern>
                </defs>
                <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
                    <path d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z" stroke-width="0" />
                </svg>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)" />
            </svg>
        </div>
        <div class="grid grid-cols-1 gap-x-8 gap-y-16 mx-auto max-w-2xl lg:grid-cols-2 lg:gap-y-10 lg:items-start lg:mx-0 lg:max-w-none">
            <div class="lg:grid lg:grid-cols-2 lg:col-span-2 lg:col-start-1 lg:row-start-1 lg:gap-x-8 lg:px-8 lg:mx-auto lg:w-full lg:max-w-7xl">
                <div class="lg:pr-4">
                    <div class="lg:max-w-lg">
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Developer API</h1>
                        <p class="mt-6 text-xl leading-8 text-gray-700">The Wilford Woodruff Papers API is a read only API that provides access to the contents of the Wilford Woodruff Papers. The API is currently in beta and is available to the public for use.</p>
                    </div>
                </div>
            </div>
            <div class="p-12 -mt-12 -ml-12 lg:overflow-hidden lg:sticky lg:top-4 lg:col-start-2 lg:row-span-2 lg:row-start-1">
                <img class="max-w-none bg-gray-900 rounded-xl ring-1 shadow-xl w-[48rem] ring-gray-400/10 sm:w-[57rem]" src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/code-screenshot.jpg" alt="">
            </div>
            <div class="lg:grid lg:grid-cols-2 lg:col-span-2 lg:col-start-1 lg:row-start-2 lg:gap-x-8 lg:px-8 lg:mx-auto lg:w-full lg:max-w-7xl">
                <div class="lg:pr-4">
                    <div class="max-w-xl text-base leading-7 text-gray-700 lg:max-w-lg">
                        <ul role="list" class="mt-8 space-y-8 text-gray-600">
                            <li class="flex gap-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-none mt-1 w-5 h-5 text-secondary">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>

                                <span><strong class="font-semibold text-gray-900">Export Metadata</strong> Export transcripts along with tagged people, places, topics, and dates.</span>
                            </li>
                            <li class="flex gap-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-none mt-1 w-5 h-5 text-secondary">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>

                                <span><strong class="font-semibold text-gray-900">Search</strong> Filter and search within the documents</span>
                            </li>
                            <li class="flex gap-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-none mt-1 w-5 h-5 text-secondary">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                                </svg>

                                <span><strong class="font-semibold text-gray-900">Analyze</strong> Create visualizations, stories, and share insights with the community.</span>
                            </li>
                        </ul>
                        <p class="mt-8">Before accessing to the API, we ask that you accept the terms of use and provide a brief explanation of you want to use the API.</p>
                        <p class="mt-12">
                            <a href="{{ route('dashboard') }}" class="py-4 px-6 font-semibold text-white bg-secondary hover:bg-secondary-600">
                                Access the Developer API &rarr;
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>
