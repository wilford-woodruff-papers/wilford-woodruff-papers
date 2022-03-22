<div class="mx-auto py-12 px-4 max-w-7xl sm:px-6 lg:px-8 lg:py-12 mt-4">
    <div class="space-y-12">
        <ul role="list" class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-3 sm:space-y-0 lg:grid-cols-4 lg:gap-4">
            @foreach($pages as $page)
                <li class="py-4 px-4 text-center xl:px-4">
                    <a href="{{ $page['link'] }}" title="{{ $page['title'] }}">
                        <div class="image-parent relative h-64 w-64 overflow-hidden inline-block flex items-center rounded-full shadow-lg bg-primary-50">
                            <div class="image-child absolute h-full w-full z-10 bg-cover bg-center z-0" style="background-image: url({{ $page['image'] }})">

                            </div>
                            <div class="text-center w-full py-3 z-10 text-white text-xl font-medium bg-primary-50 uppercase">
                                {{ $page['title'] }}
                            </div>
                        </div>
                        {{--<img class="mx-auto xl:w-56 xl:h-56  z-0" src="{{ $page['image'] }}" alt="">--}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
