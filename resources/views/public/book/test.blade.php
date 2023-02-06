<x-test-layout>
    <noscript>
        <div class="page-cover">
            <h1 class="cover-title">This webpage requires JavaScript</h1>
        </div>
    </noscript>

    <!-- Mobile is not supported for this webpage because I'm lazy and it's pretty much pointless -->
    <div class="page-cover mobile">
        <h1 class="cover-title">This webpage is best seen on a desktop or a laptop. <br><br> Slickscroll still works on mobile, however this webpage doesn't.</h1>
    </div>



    <!-- Landing image and title -->
    <div class="section" id="landing" style="">
        <div class="back-image slow-parallax">
            <img src="{{ asset('img/book/book-cover-mockup-paperback.jpg') }}"
                 class="-mt-8 w-full h-auto"
            >
        </div>
        <div class="align-wrapper">
            <div class="mt-0 content">
                <div class="max-w-7xl mx-auto pb-8 px-8 !mt-0 z-10">
                    <div class="flex justify-end gap-x-2 !mt-0">
                        <div>
                            <a href=""
                               class="text-dark-blue"
                            >
                                {{ __('book.English') }}
                            </a>
                        </div>
                        <div class="text-dark-blue">|</div>
                        <div>
                            <a href=""
                               class="text-dark-blue"
                            >
                                {{ __('book.Spanish') }}
                            </a>
                        </div>
                    </div>
                    <h1 class="font-serif text-6xl text-center leading-[3.0rem] text-dark-blue-500">
                        {{ __('book.Wilford Woodruff\'s Witness') }}<br/>
                        <small class="text-3xl">{{ __('book.The Development of Temple Doctrine') }}</small>
                    </h1>
                </div>

            </div>
        </div>

        <div class="align-wrapper">
            <div class="mt-0 content">
                <div class="max-w-7xl mx-auto pb-8 px-8 !mt-0 z-10">
                    <div class="grid grid-cols-2 gap-x-2 !mt-0">
                        <div class="">
                            <h2 class="py-8 font-serif text-3xl text-dark-blue-500">
                                {{ __('book.Purchase from Deseret Book') }}
                            </h2>
                            <div class="grid gap-4 md:grid-cols-3">
                                <a href=""
                                   class="py-4 px-4 font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg">
                                    {{ __('book.Paperback') }}
                                </a>
                                <a href=""
                                   class="py-4 px-4 font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg">
                                    {{ __('book.Audiobook') }}
                                </a>
                                <a href=""
                                   class="py-4 px-4 font-sans text-center text-white uppercase rounded-3xl bg-secondary drop-shadow-lg">
                                    {{ __('book.eBook') }}
                                </a>
                            </div>
                            <div class="grid grid-cols-2 py-8">
                                <div>

                                </div>
                                <div class="text-sm text-right text-dark-blue-500">
                                    {{ __('book.All sales of the eBook and Audiobook go to support the Wilford Woodruff Papers Foundation') }}
                                </div>
                            </div>
                            <div class="pt-8 pb-16">
                                <h2 class="py-8 font-serif text-3xl text-dark-blue-500">
                                    {{ __('book.About the book') }}
                                </h2>
                                <div class="flex flex-col gap-y-4 font-sans text-xl text-dark-blue-600">
                                    {!! __('book.Book Summary') !!}
                                </div>
                                <div class="h-32"></div>
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Images for slower parallax & details -->
    <div id="content" class="section">
        <div class="back-image-slide">
            <div class="stack slow-parallax">
                <img src="https://slickscroll.musabhassan.com/imgs/back/2.jpg">
                <img src="https://slickscroll.musabhassan.com/imgs/back/3.jpg">
            </div>
            <div class="stack offset faster-parallax">
                <img src="https://slickscroll.musabhassan.com/imgs/back/4.jpg">
                <img src="https://slickscroll.musabhassan.com/imgs/back/5.jpg">
            </div>
            <div class="stack slow-parallax">
                <img src="https://slickscroll.musabhassan.com/imgs/back/6.jpg">
                <img src="https://slickscroll.musabhassan.com/imgs/back/7.jpg">
            </div>
        </div>
        <div class="aligner">
            <div class="right">
                <h3>Supports <span>Vertical</span> & <br> <span>Horizontal</span> Scrolling</h3>
            </div>
            <div class="left">
                <h3>Offset Speeds for <br> making it <span>Parallax</span></h3>
            </div>
            <div class="right">
                <h3><span>Lightweight</span> <br> with no gimmicks</h3>
            </div>
            <div class="left subsection">
                <h2><span>Open Source,</span><br> check it out on Github</h2>
                <a class="button" href="https://github.com/Musab-Hassan/slickscroll" target="_blank">View on Github</a>
            </div>
            <div class="left">
                <p class="subtext">Made by <a class="sublink" href="https://musabhassan.com" target="blank"><span>Musab Hassan</span></a> with
                    <svg class="heart" viewBox="0 0 32 29.6">
                        <path d="M23.6,0c-3.4,0-6.3,2.7-7.6,5.6C14.7,2.7,11.8,0,8.4,0C3.8,0,0,3.8,0,8.4c0,9.4,9.5,11.9,16,21.2
                            c6.1-9.3,16-12.1,16-21.2C32,3.8,28.2,0,23.6,0z"/>
                    </svg>
                </p>
            </div>
        </div>
    </div>
</x-test-layout>
