<x-guest-layout>
    <x-slot name="title">
        {{ __('book.Wilford Woodruff\'s Witness') }}: {{ __('book.The Development of Temple Doctrine') }} | {{ config('app.name') }}
    </x-slot>

    <div id="cover"
         class="relative bg-[#d9e8ed]"
    >
        <div class="z-10 px-8 pt-8 pb-0 pb-8 mx-auto max-w-7xl md:pb-8">
            <div class="flex gap-x-2 justify-end">
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
            <h1 class="flex flex-col gap-y-1 pt-4 font-serif text-2xl text-center md:text-6xl leading-[2.5rem] text-dark-blue-500 md:leading-[3.0rem]">
                <span>{{ __('book.Wilford Woodruff\'s Witness') }}</span>
                <small class="text-lg md:text-3xl md:leading-[3.0rem]">{{ __('book.The Development of Temple Doctrine') }}</small>
            </h1>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl">
            <div class="grid grid-cols-1 gap-x-8 md:grid-cols-2">
                <div class="order-2 md:order-1">
                    <div class="text-2xl text-dark-blue-500">
                        {!! __('book.Proceeds support the Wilford Woodruff Papers Project') !!}
                    </div>
                    <h2 class="py-8 font-serif text-xl text-center md:text-3xl md:text-left text-dark-blue-500">
                        {{ __('book.Purchase from Deseret Book') }}
                    </h2>
                    <div class="grid gap-4 px-4 md:grid-cols-3">
                        @if(! empty(__('book.Paperback Deseret Link')))
                            <div>
                                <a href="{!! __('book.Paperback Deseret Link') !!}"
                                   class="block py-4 px-4 w-full font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg"
                                   target="_blank"
                                >
                                    {{ __('book.Paperback') }}
                                </a>
                            </div>
                        @else
                            <div>
                                <div class="py-4 px-4 w-full font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg"
                                     target="_blank"
                                >
                                    {{ __('book.Paperback') }}
                                </div>
                                <div class="py-2 text-sm text-center">{{ __('book.Coming Soon') }}</div>
                            </div>
                        @endif
                        @if(! empty(__('book.Audiobook Deseret Link')))
                            <div>
                                <a href="{!! __('book.Audiobook Deseret Link') !!}"
                                   class="block py-4 px-4 w-full font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg"
                                   target="_blank"
                                >
                                    {{ __('book.Audiobook') }}
                                </a>
                            </div>
                        @else
                            <div>
                                <div class="py-4 px-4 w-full font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg"
                                     target="_blank"
                                >
                                    {{ __('book.Audiobook') }}
                                </div>
                                <div class="py-2 text-sm text-center">{{ __('book.Coming Soon') }}</div>
                            </div>
                        @endif
                        @if(! empty(__('book.eBook Deseret Link')))
                            <div>
                                <a href="{!! __('book.eBook Deseret Link') !!}"
                                   class="block py-4 px-4 w-full font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg"
                                   target="_blank"
                                >
                                    {{ __('book.eBook') }}
                                </a>
                            </div>
                        @else
                            <div>
                                <div class="py-4 px-4 w-full font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg"
                                     target="_blank"
                                >
                                    {{ __('book.eBook') }}
                                </div>
                                <div class="py-2 text-sm text-center">{{ __('book.Coming Soon') }}</div>
                            </div>
                        @endif
                    </div>
                    <h2 class="py-8 font-serif text-xl text-center md:text-3xl md:text-left text-dark-blue-500">
                        {{ __('book.Purchase from Amazon') }}
                    </h2>
                    <div class="grid gap-4 px-4 md:grid-cols-3">
                        @if(! empty(__('book.Paperback Amazon Link')))
                            <div>
                                <a href="{!! __('book.Paperback Amazon Link') !!}"
                                   class="block py-4 px-4 w-full font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg"
                                   target="_blank"
                                >
                                    {{ __('book.Paperback') }}
                                </a>
                            </div>
                        @else
                            <div>
                                <div class="py-4 px-4 w-full font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg"
                                     target="_blank"
                                >
                                    {{ __('book.Paperback') }}
                                </div>
                                <div class="py-2 text-sm text-center">{{ __('book.Coming Soon') }}</div>
                            </div>
                        @endif
                        @if(! empty(__('book.Audiobook Amazon Link')))
                            <div>
                                <a href="{!! __('book.Audiobook Amazon Link') !!}"
                                   class="block py-4 px-4 w-full font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg"
                                   target="_blank"
                                >
                                    {{ __('book.Audiobook') }}
                                </a>
                            </div>
                        @else
                            <div>
                                <div class="py-4 px-4 font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg"
                                     target="_blank"
                                >
                                    {{ __('book.Audiobook') }}
                                </div>
                                <div class="py-2 text-sm text-center">{{ __('book.Coming Soon') }}</div>
                            </div>
                        @endif
                        @if(! empty(__('book.eBook Amazon Link')))
                            <div>
                                <a href="{!! __('book.eBook Amazon Link') !!}"
                                   class="block py-4 px-4 w-full font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg"
                                   target="_blank"
                                >
                                    {{ __('book.eBook') }}
                                </a>
                            </div>
                        @else
                            <div>
                                <div class="py-4 px-4 font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg"
                                     target="_blank"
                                >
                                    {{ __('book.eBook') }}
                                </div>
                                <div class="py-2 text-sm text-center">{{ __('book.Coming Soon') }}</div>
                            </div>
                        @endif
                    </div>
                    <div class="px-4 md:px-0 md:pt-8 md:pb-16">
                        <h2 class="py-8 font-serif text-3xl text-dark-blue-500">
                            {{ __('book.About the book') }}
                        </h2>
                        <div class="flex flex-col gap-y-4 font-sans text-xl text-dark-blue-600">
                            {!! __('book.Book Summary') !!}
                        </div>
                        <div class="h-8 md:h-32"></div>
                    </div>
                </div>
                <div class="order-1 pt-16 md:order-2">
                    <img src="{{ asset(__('book.Cover URL')) }}"
                         class="mx-auto w-3/5 md:sticky md:top-10 md:pb-20 drop-shadow-xl"
                    >
                </div>
            </div>
        </div>
    </div>

    <div class="px-4 md:px-0 md:pt-16 md:pb-24 bg-dark-blue-500">
        <div class="mx-auto max-w-7xl">
            <div class="relative">
                <div class="absolute w-full h-full">
                    <div class="grid grid-cols-1 h-full md:grid-cols-3">
                        <div class="hidden relative md:block">
                            <div class="absolute -left-4 top-64 w-4/5">
                                <img src="{{ asset('img/book/wilford-woodruff.png') }}"
                                     class="w-full rounded-3xl drop-shadow-xl"
                                >
                            </div>
                        </div>
                        <div class="relative">
                            <div class="pt-12 pb-8 text-center">
                                <h2 class="font-serif text-3xl text-white md:text-5xl">{{ __('book.Reviews') }}</h2>
                            </div>
                            <div class="absolute bottom-10">
                                <img src="{{ asset('img/book/wilford-woodruff-with-family.png') }}"
                                     class="mx-auto w-4/5 rounded-3xl drop-shadow-xl"
                                >
                            </div>
                        </div>
                        <div class="hidden relative md:block">
                            <div class="absolute -right-4 top-72 w-4/5">
                                <img src="{{ asset('img/book/temple-close-up.png') }}"
                                     class="w-full rounded-3xl drop-shadow-xl"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="grid grid-cols-1 gap-y-4 gap-x-16 md:grid-cols-3 md:gap-y-0">
                        <div class="pt-32 md:pt-4">
                            <div class="rounded-xl drop-shadow-2xl bg-[#E2E9EF] text-[#0E3240] py-4 px-6">
                                <p class="text-lg">{!! __('book.Review 1.Text') !!}</p>
                                <div class="flex justify-end">
                                    <p class="pt-4 text-sm font-semibold">{!! __('book.Review 1.Author') !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="md:pt-48">
                            <div class="rounded-xl drop-shadow-2xl bg-[#E2E9EF] text-[#0E3240] py-4 px-6">
                                <p class="text-lg">{!! __('book.Review 2.Text') !!}</p>
                                <div class="flex justify-end">
                                    <div class="inline">
                                        <p class="pt-4 text-sm font-semibold text-right">{!! __('book.Review 2.Author') !!}</p>
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
                                        <p class="pt-4 text-sm font-semibold text-right">{!! __('book.Review 3.Author') !!}</p>
                                        <p class="text-sm text-right">{!! __('book.Review 3.Position') !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-4 gap-x-64 py-4 md:grid-cols-2 md:gap-y-0 md:py-0">
                        <div class="md:pt-36 md:pl-8">
                            <div class="rounded-xl drop-shadow-2xl bg-[#E2E9EF] text-[#0E3240] py-4 px-6">
                                <p class="text-lg">{!! __('book.Review 4.Text') !!}</p>
                                <div class="flex justify-end">
                                    <p class="pt-4 text-sm font-semibold">{!! __('book.Review 4.Author') !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="md:pt-24 md:pr-8">
                            <div class="rounded-xl drop-shadow-2xl bg-[#E2E9EF] text-[#0E3240] py-4 px-6">
                                <p class="text-lg">{!! __('book.Review 5.Text') !!}</p>
                                <div class="flex justify-end">
                                    <div class="inline">
                                        <p class="pt-4 text-sm font-semibold text-right">{!! __('book.Review 5.Author') !!}</p>
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

    <div class="bg-center bg-cover" style="background-image: url('{{ asset('img/book/search-ancestors-background-fullsize.jpg') }}')">
        <a href="{{ route('people') }}">
            <div class="py-16 px-4 mx-auto max-w-2xl md:py-24 md:px-0">
                <h2 class="text-3xl md:text-5xl text-dark-blue-500 font-serif !leading-[3.0rem] md:!leading-[4.0rem]">
                    {!! __('book.Search for your ancestors') !!}
                </h2>
                <div class="flex justify-end px-16 mt-2 font-serif text-2xl font-semibold md:mt-8 md:text-4xl text-secondary">
                    <span>{!! __('book.Start now') !!} ></span>
                </div>
            </div>
        </a>
    </div>

    @if(app()->getLocale() == 'en')
        <div class="bg-[#DBEAEF] py-8 md:py-16 px-4 md:px-0">
            <div class="mx-auto max-w-7xl">
                <div class="pb-8 text-center md:pb-16">
                    <h2 class="font-serif text-3xl md:text-5xl text-secondary">{{ __('book.Book Interviews') }}</h2>
                </div>
                <div class="grid grid-cols-1 gap-y-12 gap-x-16 md:grid-cols-2">
                    <div>
                        <a href="https://ldsperspectives.com/2017/10/09/temple-doctrine-development/"
                           target="_blank"
                           class="cursor-pointer"
                        >
                            <div class="grid grid-cols-1 gap-y-8 md:grid-cols-3 md:gap-x-8">
                                <div class="">
                                    <img src="{{ asset('img/book/lds-lerspectives.png') }}"
                                         class="mx-auto w-2/3 md:w-full"
                                         alt="LDS Perspectives Podcast"
                                    >
                                </div>
                                <div class="flex col-span-2 items-center">
                                    <div>
                                        <p class="text-lg">
                                            “It was like a puzzle: they were given pieces. Now we have the box with the picture on it; we know what we’re putting together. They had no idea.”
                                        </p>
                                        <div class="flex gap-x-2 items-center my-4">
                                    <span class="pr-1 text-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline mr-2 w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                            <div class="grid grid-cols-1 gap-y-8 md:grid-cols-3 md:gap-x-8">
                                <div class="">
                                    <img src="{{ asset('img/book/reational-faiths-podcast.png') }}"
                                         class="mx-auto w-2/3 md:w-full"
                                         alt="Rational Faiths Podcast"
                                    >
                                </div>
                                <div class="flex col-span-2 items-center">
                                    <div>
                                        <p class="text-lg">
                                            “Looking at Woodruff, the temple, and church policy/development as an interdependent triad is insightful and can even be paradigm shifting.”
                                        </p>
                                        <div class="flex gap-x-2 items-center my-4">
                                    <span class="pr-1 text-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline mr-2 w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

    <div class="py-8 bg-center bg-cover md:py-16" style="background-image: url('{{ asset('img/book/temple-valley.png') }}')">
        <div class="px-4 mx-auto max-w-3xl md:px-4">
            <div>
                {!! __('book.Video') !!}
            </div>
            <div class="mt-16 bg-white text-[#0E3240] px-16 py-8 rounded-3xl">
                <p class="text-lg leading-6 md:text-3xl md:leading-[3.0rem]">
                    {!! __('book.Video Summary') !!}
                </p>
            </div>
        </div>
    </div>

    <div class="bg-[#DBEAEF] py-8 md:py-16 px-4 md:px-0">
        <div class="mx-auto max-w-7xl">
            <div class="pb-8 text-center md:pb-16">
                <h2 class="font-serif text-3xl md:text-5xl text-secondary">{!! __('book.About the Author') !!}</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 md:gap-x-16">
                <div>
                    <img src="{{ asset('img/book/jennifer-mackley.png') }}"
                         class="mx-auto w-3/4 md:w-full"
                    >
                </div>
                <div class="flex flex-col col-span-2 gap-y-4 py-4 text-lg md:text-2xl">
                    {!! __('book.Author Bio') !!}
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>
