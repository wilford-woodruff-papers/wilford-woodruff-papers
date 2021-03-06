<div class="">
    <div class="mx-auto px-4 max-w-7xl sm:px-6 lg:px-8 mt-4">
        <div class="space-y-12">
            <ul role="list" class="grid grid-cols-2 sm:grid-cols-4 sm:gap-3 sm:space-y-0 lg:gap-4">
                @foreach($pages as $page)
                    <li class="group py-4 px-4 text-center xl:px-4">
                        <a href="{{ $page['link'] }}" title="{{ $page['title'] }}">
                            {{-- md:h-48 md:w-48 --}}
                            <div class="mx-auto image-parent relative {{ $buttonSize ?? 'w-32 h-32 md:h-40 md:w-40 lg:h-64 lg:w-64' }} overflow-hidden inline-block grid items-center rounded-full shadow-lg bg-primary-50">
                                <div class="image-child absolute h-full w-full z-10 bg-cover bg-center z-0" style="background-image: url({{ $page['image'] }})">

                                </div>
                                <div class="text-center w-full h-full grid items-center py-3 z-10 text-white {{ $textSize ?? 'text-xl md:text-5xl' }} font-medium bg-primary-30 ">
                                    <div class="p-0">
                                    <div class="py-2 px-4 w-auto bg-primary-60">
                                        <div class="@if(array_key_exists('description', $page)) group-hover:hidden @endif text-xl md:text-2xl uppercase">
                                            {{ $page['title'] }}
                                        </div>
                                        @if(array_key_exists('description', $page))
                                            <div class="hidden uppercase group-hover:block text-lg md:text-xl">
                                                {!! $page['description'] !!}
                                            </div>
                                        @endif
                                    </div>
                                    </div>
                                </div>
                            </div>
                            {{--<img class="mx-auto xl:w-56 xl:h-56  z-0" src="{{ $page['image'] }}" alt="">--}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

