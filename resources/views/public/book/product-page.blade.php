<x-guest-layout>
    <x-slot name="title">
        {{ __('book.Wilford Woodruff\'s Witness') }}: {{ __('book.The Development of Temple Doctrine') }} | {{ config('app.name') }}
    </x-slot>

    <div id="cover"
         class="relative bg-[#d9e8ed]"
    >
        <div class="max-w-7xl mx-auto pb-8 px-8 pt-8 md:pb-8 pb-0 z-10">
            <div class="flex justify-end gap-x-2">
                <div>
                    <a href="{{ route('language.locale', ['locale' => 'en']) }}"
                       class="text-dark-blue @if(app()->getLocale() == 'en') font-semibold @endif"
                    >
                        {{ __('book.English') }}
                    </a>
                </div>
                <div class="text-dark-blue">|</div>
                <div>
                    <a href="{{ route('language.locale', ['locale' => 'es']) }}"
                       class="text-dark-blue @if(app()->getLocale() == 'es') font-semibold @endif"
                    >
                        {{ __('book.Spanish') }}
                    </a>
                </div>
            </div>
            <h1 class="flex flex-col gap-y-1 text-2xl md:text-6xl leading-[2.5rem] md:leading-[3.0rem] text-dark-blue-500 font-serif text-center pt-4">
                <span>{{ __('book.Wilford Woodruff\'s Witness') }}</span>
                <small class="text-lg md:text-3xl md:leading-[3.0rem]">{{ __('book.The Development of Temple Doctrine') }}</small>
            </h1>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                <div class="order-2 md:order-1">
                    <h2 class="text-center md:text-left text-xl md:text-3xl font-serif py-8 text-dark-blue-500">
                        {{ __('book.Purchase from Deseret Book') }}
                    </h2>
                    <div class="grid md:grid-cols-3 gap-4 px-4">
                        <a href="https://deseretbook.com/p/wilford-woodruff-s-witness?ref=detailed-card-1&variant_id=200986-paperback"
                            class="px-4 py-4 rounded-3xl bg-secondary text-white text-center font-sans uppercase drop-shadow-lg">
                            {{ __('book.Paperback') }}
                        </a>
                        <a href="https://deseretbook.com/p/wilford-woodruff-s-witness?ref=detailed-card-1&variant_id=200986-paperback"
                            class="px-4 py-4 rounded-3xl bg-secondary text-white text-center font-sans uppercase drop-shadow-lg">
                            {{ __('book.Audiobook') }}
                        </a>
                        <a href="https://deseretbook.com/p/wilford-woodruff-s-witness?ref=detailed-card-1&variant_id=200986-paperback"
                            class="px-4 py-4 rounded-3xl bg-secondary text-white text-center font-sans uppercase drop-shadow-lg">
                            {{ __('book.eBook') }}
                        </a>
                    </div>
                    <div class="flex justify-end py-8 px-4 md:px-0">
                        <div class="text-sm text-right text-dark-blue-500">
                            {!! __('book.All proceeds support the<br />Wilford Woodruff Papers Project') !!}
                        </div>
                    </div>
                    <div class="md:pt-8 md:pb-16 px-4 md:px-0">
                        <h2 class="text-3xl font-serif py-8 text-dark-blue-500">
                            {{ __('book.About the book') }}
                        </h2>
                        <div class="flex flex-col gap-y-4 text-xl font-sans text-dark-blue-600">
                            {!! __('book.Book Summary') !!}
                        </div>
                        <div class="h-8 md:h-32"></div>
                    </div>
                </div>
                <div class="order-1 md:order-2 pt-16">
                    <img src="{{ asset(__('book.Cover URL')) }}"
                         class="md:sticky md:top-10 md:pb-20 drop-shadow-xl w-3/5 mx-auto"
                    >
                </div>
            </div>
        </div>
    </div>

    <div class="bg-dark-blue-500 md:pt-16 md:pb-24 px-4 md:px-0">
        <div class="max-w-7xl mx-auto">
            <div class="relative">
                <div class="absolute w-full h-full">
                    <div class="grid grid-cols-1 md:grid-cols-3 h-full">
                        <div class="hidden md:block relative">
                            <div class="absolute -left-4 top-64 w-4/5">
                                <img src="{{ asset('img/book/wilford-woodruff.png') }}"
                                     class="drop-shadow-xl w-full rounded-3xl"
                                >
                            </div>
                        </div>
                        <div class="relative">
                            <div class="text-center pt-12 pb-8">
                                <h2 class="text-3xl md:text-5xl text-white font-serif">{{ __('book.Reviews') }}</h2>
                            </div>
                            <div class="absolute bottom-10">
                                <img src="{{ asset('img/book/wilford-woodruff-with-family.png') }}"
                                     class="drop-shadow-xl w-4/5 mx-auto rounded-3xl"
                                >
                            </div>
                        </div>
                        <div class="hidden md:block relative">
                            <div class="absolute -right-4 top-64 w-4/5">
                                <img src="{{ asset('img/book/temple-close-up.png') }}"
                                     class="drop-shadow-xl w-full rounded-3xl"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-16 gap-y-4 md:gap-y-0">
                        <div class="pt-32 md:pt-4">
                            <div class="rounded-xl drop-shadow-2xl bg-[#E2E9EF] text-[#0E3240] py-4 px-6">
                                <p class="text-lg">{!! __('book.Review 1.Text') !!}</p>
                                <div class="flex justify-end">
                                    <p class="text-sm font-semibold pt-4">{!! __('book.Review 1.Author') !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="md:pt-48">
                            <div class="rounded-xl drop-shadow-2xl bg-[#E2E9EF] text-[#0E3240] py-4 px-6">
                                <p class="text-lg">{!! __('book.Review 2.Text') !!}</p>
                                <div class="flex justify-end">
                                    <div class="inline">
                                        <p class="text-sm font-semibold pt-4 text-right">{!! __('book.Review 2.Author') !!}</p>
                                        <p class="text-sm text-right">{!! __('book.Review 2.Position') !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:pt-8">
                            <div class="rounded-xl drop-shadow-2xl bg-[#E2E9EF] text-[#0E3240] py-4 px-6">
                                <p class="text-lg">{!! __('book.Review 3.Text') !!}</p>
                                <div class="flex justify-end">
                                    <div class="inline">
                                        <p class="text-sm font-semibold pt-4 text-right">{!! __('book.Review 3.Author') !!}</p>
                                        <p class="text-sm text-right">{!! __('book.Review 3.Position') !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-64 gap-y-4 md:gap-y-0 py-4 md:py-0">
                        <div class="md:pt-36 md:pl-8">
                            <div class="rounded-xl drop-shadow-2xl bg-[#E2E9EF] text-[#0E3240] py-4 px-6">
                                <p class="text-lg">{!! __('book.Review 4.Text') !!}</p>
                                <div class="flex justify-end">
                                    <p class="text-sm font-semibold pt-4">{!! __('book.Review 4.Author') !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="md:pt-8 md:pr-8">
                            <div class="rounded-xl drop-shadow-2xl bg-[#E2E9EF] text-[#0E3240] py-4 px-6">
                                <p class="text-lg">{!! __('book.Review 5.Text') !!}</p>
                                <div class="flex justify-end">
                                    <div class="inline">
                                        <p class="text-sm font-semibold pt-4 text-right">{!! __('book.Review 5.Author') !!}</p>
                                        <p class="text-sm text-right">{!! __('book.Review 5.Position') !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="bg-cover bg-center" style="background-image: url('{{ asset('img/book/search-ancestors-background-fullsize.jpg') }}')">
        <a href="{{ route('people') }}">
            <div class="max-w-2xl mx-auto py-16 md:py-24 px-4 md:px-0">
                <h2 class="text-3xl md:text-5xl text-dark-blue-500 font-serif !leading-[3.0rem] md:!leading-[4.0rem]">
                    {!! __('book.Search for your ancestors') !!}
                </h2>
                <div class="flex justify-end text-secondary font-semibold font-serif text-2xl md:text-4xl mt-2 md:mt-8 px-16">
                    <span>{!! __('book.Start now') !!} ></span>
                </div>
            </div>
        </a>
    </div>

    @if(app()->getLocale() == 'en')
        <div class="bg-[#DBEAEF] py-8 md:py-16 px-4 md:px-0">
            <div class="max-w-7xl mx-auto">
                <div class="text-center pb-8 md:pb-16">
                    <h2 class="text-3xl md:text-5xl text-secondary font-serif">{{ __('book.Book Interviews') }}</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-12">
                    <div>
                        <a href="https://ldsperspectives.com/2017/10/09/temple-doctrine-development/"
                           target="_blank"
                           class="cursor-pointer"
                        >
                            <div class="grid grid-cols-1 md:grid-cols-3 md:gap-x-8 gap-y-8">
                                <div class="">
                                    <img src="{{ asset('img/book/lds-lerspectives.png') }}"
                                         class="mx-auto w-2/3 md:w-full"
                                         alt="LDS Perspectives Podcast"
                                    >
                                </div>
                                <div class="col-span-2 flex items-center">
                                    <div>
                                        <p class="text-lg">
                                            “It was like a puzzle: they were given pieces. Now we have the box with the picture on it; we know what we’re putting together. They had no idea.”
                                        </p>
                                        <div class="flex gap-x-2 items-center my-4">
                                    <span class="text-secondary pr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                            <span>October 9, 2017</span>
                                            <span>|</span>
                                            <span>31 min 14 sec</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="https://rationalfaiths.com/wilford-woodruffs-witness-author-interview/"
                           target="_blank"
                           class="cursor-pointer"
                        >
                            <div class="grid grid-cols-1 md:grid-cols-3 md:gap-x-8 gap-y-8">
                                <div class="">
                                    <img src="{{ asset('img/book/reational-faiths-podcast.png') }}"
                                         class="mx-auto w-2/3 md:w-full"
                                         alt="Rational Faiths Podcast"
                                    >
                                </div>
                                <div class="col-span-2 flex items-center">
                                    <div>
                                        <p class="text-lg">
                                            “Looking at Woodruff, the temple, and church policy/development as an interdependent triad is insightful and can even be paradigm shifting.”
                                        </p>
                                        <div class="flex gap-x-2 items-center my-4">
                                    <span class="text-secondary pr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                            <span>August 31, 2014</span>
                                            <span>|</span>
                                            <span>1 hour 14 min</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-8 md:py-16 bg-cover bg-center" style="background-image: url('{{ asset('img/book/temple-valley.png') }}')">
        <div class="max-w-3xl mx-auto px-4 md:px-4">
            <div>

            </div>
            <div class="mt-16 bg-white text-[#0E3240] px-16 py-8 rounded-3xl">
                <p class="text-lg md:text-3xl leading-6 md:leading-[3.0rem]">
                    {!! __('book.Video Summary') !!}
                </p>
            </div>
        </div>
    </div>

    <div class="bg-[#DBEAEF] py-8 md:py-16 px-4 md:px-0">
        <div class="max-w-7xl mx-auto">
            <div class="text-center pb-8 md:pb-16">
                <h2 class="text-3xl md:text-5xl text-secondary font-serif">{!! __('book.About the Author') !!}</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 md:gap-x-16">
                <div>
                    <img src="{{ asset('img/book/jennifer-mackley.png') }}"
                         class="mx-auto w-3/4 md:w-full"
                    >
                </div>
                <div class="flex flex-col gap-y-4 col-span-2 py-4 text-lg md:text-2xl">
                    {!! __('book.Author Bio') !!}
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>
