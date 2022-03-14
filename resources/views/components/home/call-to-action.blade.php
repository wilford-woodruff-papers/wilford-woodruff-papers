<div>
    @if($links)
        <div class="my-12 mx-auto max-w-md px-4 grid gap-8 sm:max-w-lg sm:px-6 lg:px-8 lg:grid-cols-3 lg:max-w-7xl">

            @foreach($links as $link)
                <div class="flex flex-col shadow-lg overflow-hidden">
                    <div class="flex-shrink-0">
                        <a href="{{ $link['link'] }}" title="{{ $link['title'] }}">
                            <img class="h-48 w-full object-cover" src="{{ $link['image'] }}" alt="">
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    @endif
</div>
