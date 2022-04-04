<div>
    @if($links)
        <div class="max-w-7xl mx-auto pt-4 md:pt-4 px-4 pb-4 xl:pt-4 md:pb-8 hidden md:block">
            <div class="grid grid-cols-3 pb-4">
                <div class="font-extrabold">
                    <h2 class="text-3xl uppercase pb-1 border-b-4 border-highlight">Get Involved</h2>
                </div>
            </div>
        </div>
        <div class="mb-12 mx-auto max-w-md px-4 grid gap-8 sm:max-w-lg sm:px-6 lg:px-8 lg:grid-cols-5 lg:max-w-7xl">
            @foreach($links as $link)
                <div class="flex flex-col shadow-lg overflow-hidden">
                    <div class="flex-shrink-0">
                        <a href="{{ $link['link'] }}" title="{{ $link['title'] }}">
                            <div class="image-parent relative h-48 w-full overflow-hidden inline-block flex items-center bg-primary-50">
                                <div class="image-child absolute h-full w-full z-10 bg-cover bg-center z-0" style="background-image: url({{ $link['image'] }})">

                                </div>
                                <div class="h-full w-full py-3 px-4 z-10 text-white text-3xl font-medium bg-gradient-to-t from-primary uppercase flex flex-row items-end justify-start">
                                    <div>
                                        <p>{{ $link['title'] }}</p>
                                        <p>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    @endif
</div>
