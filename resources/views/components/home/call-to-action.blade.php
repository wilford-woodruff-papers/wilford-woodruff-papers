<div>
    @if($links)
        <div class="my-12 mx-auto max-w-md px-4 grid gap-8 sm:max-w-lg sm:px-6 lg:px-8 lg:grid-cols-3 lg:max-w-7xl">

            @foreach($links as $link)
                <div class="flex flex-col shadow-lg overflow-hidden">
                    <div class="flex-shrink-0">
                        <a href="{{ $link['link'] }}" title="{{ $link['title'] }}">
                            <div class="image-parent relative h-48 w-full overflow-hidden inline-block flex items-center bg-primary-50">
                                <div class="image-child absolute h-full w-full z-10 bg-cover bg-center z-0" style="background-image: url({{ $link['image'] }})">

                                </div>
                                <div class="h-full w-full py-3 pr-4 z-10 text-white text-2xl font-medium bg-gradient-to-l via-primary from-primary uppercase flex flex-row items-center justify-end">
                                    {{ $link['title'] }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    @endif
</div>
