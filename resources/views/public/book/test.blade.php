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
    <div class="section" id="landing" style="height: 100vh;">
        <div class="back-image slow-parallax">
            <img src="{{ asset('img/book/book-cover-mockup-paperback.jpg') }}"
                 class="w-full h-auto -mt-8"
            >
        </div>
        <div class="align-wrapper">
            <div class="content mt-0">
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
                    <h1 class="text-6xl leading-[3.0rem] text-dark-blue-500 font-serif text-center">
                        {{ __('book.Wilford Woodruff\'s Witness') }}<br/>
                        <small class="text-3xl">{{ __('book.The Development of Temple Doctrine') }}</small>
                    </h1>
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
