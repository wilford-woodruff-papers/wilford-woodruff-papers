<div>
    @if($links)
        <div class="px-4 pt-4 pb-4 mx-auto max-w-7xl md:pt-4 md:pb-8 xl:pt-4">
            <div class="grid grid-cols-1 pb-4 sm:grid-cols-2 md:grid-cols-3">
                <div class="font-extrabold">
                    <h2 class="pb-1 text-3xl uppercase border-b-4 border-highlight">Get Involved</h2>
                </div>
            </div>
        </div>
        <div class="grid gap-8 px-4 mx-auto mb-12 max-w-md sm:px-6 sm:max-w-lg lg:grid-cols-4 lg:px-8 lg:max-w-7xl">
            @foreach($links as $link)
                <div class="flex overflow-hidden flex-col shadow-lg">
                    <div class="flex-shrink-0">
                        <a href="{{ $link['link'] }}" title="{{ $link['title'] }}">
                            <div class="inline-block flex overflow-hidden relative items-center w-full h-48 image-parent bg-primary-50">
                                <div class="absolute z-0 z-10 w-full h-full bg-center bg-cover image-child" style="background-image: url({{ $link['image'] }})">

                                </div>
                                <div class="flex z-10 flex-row justify-start items-end py-3 px-4 w-full h-full text-lg font-medium text-white uppercase bg-gradient-to-t from-primary">
                                    <div>
                                        <p>{{ $link['title'] }}</p>
                                        <p>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
