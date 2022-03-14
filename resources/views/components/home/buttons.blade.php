<div class="mx-auto py-12 px-4 max-w-7xl sm:px-6 lg:px-8 lg:py-12">
    <div class="space-y-12">
        <ul role="list" class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-4 lg:gap-8">
            @foreach($pages as $page)
                <li class="py-10 px-6 text-center xl:px-10">
                    <a href="{{ $page['link'] }}" title="{{ $page['title'] }}">
                        <div class="space-y-6 xl:space-y-10">
                            <img class="mx-auto h-40 w-40 rounded-full xl:w-56 xl:h-56" src="{{ $page['image'] }}" alt="">
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
