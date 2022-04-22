<header x-data="{
                mobileMenuOpen: false,
            }"
        class="bg-primary"
>
    <div class="relative max-w-7xl mx-auto">

        <div class="justify-between items-center px-4 py-2 xl:py-6 sm:px-6 md:justify-start md:space-x-10">
            <!--<div class="relative max-w-7xl mx-auto flex justify-between items-center px-4 py-6 sm:px-6 md:justify-start md:space-x-10">-->
            <div class="md:flex-1 md:flex md:items-center md:justify-between">
                <div class="hidden md:flex space-x-10">
                    <a href="/" class="flex">
                        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                        @if(app()->environment(['production']))
                            <img class="h-10 md:h-20 xl:h-36 w-auto "
                                 src="{{ asset('img/logo.png') }}"
                                 alt="{{ config('app.name', 'Laravel') }}" />
                        @endif
                        @if(app()->environment(['local','development']))
                            <img class="h-10 md:h-20 xl:h-36 w-auto "
                                 src="{{ asset('img/image-logo.png') }}"
                                 alt="{{ config('app.name', 'Laravel') }}" />
                        @endif
                    </a>
                </div>
                <!--<div class="flex items-center md:ml-12">-->
                <div class=" md:space-x-10">
                    <div class="relative">
                        <div class="relative">
                            <div class="grid grid-cols-1 md:flex justify-center md:justify-end">
                                <div class="md:-mt-0 xl:-mt-6 md:mb-2 md:mb-12 md:pr-8 py-0.5">
                                    <a class="bg-highlight px-4 py-2 text-white text-lg hover:text-secondary block md:inline text-center uppercase"
                                       data-formkit-toggle="7ce7f1665b"
                                       href="https://wilford-woodruff-papers.ck.page/7ce7f1665b">
                                        Subscribe for Updates
                                    </a>
                                </div>
                                <div class="md:-mt-2 xl:-mt-8 mb-12 mr-0"
                                     id="search">
                                    <div>
                                        <form action="{{ route('advanced-search') }}" id="search-form">
                                            <div class="mt-1 flex shadow-sm max-w-full">
                                                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                                    <input class="block w-full rounded-none pl-2 sm:text-sm border-white"
                                                           type="search"
                                                           name="q"
                                                           value="{{ request('q') }}"
                                                           placeholder="Search website"
                                                           aria-label="Search website">
                                                    <input type="hidden" name="people" value="1" />
                                                    @foreach(\App\Models\Type::all() as $type)
                                                        <input type="hidden"
                                                               name="types[]"
                                                               type="checkbox"
                                                               value="{{ $type->id }}" />
                                                    @endforeach
                                                </div>
                                                <button class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2">
                                                    <svg class="h-5 w-5 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                    <span class="sr-only">Search website</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="-mr-2 -my-2 md:hidden absolute right-4">
                                <button x-on:click="mobileMenuOpen = ! mobileMenuOpen;"
                                        type="button"
                                        class="bg-secondary p-2 inline-flex items-center justify-center text-white hover:text-highlight focus:outline-none">
                                    <span class="sr-only">Open menu</span>
                                    <!-- Heroicon name: menu -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                            </div>
                            @if(app()->environment(['production']))
                                <h1 class="font-serif text-2xl md:text-3xl xl:text-6xl font-medium text-highlight">
                                    {{ config('app.name', 'Laravel') }}
                                </h1>
                            @endif
                        </div>
                    </div>
                </div>
                <!--</div>-->
            </div>
        </div>


        <!--
          Mobile menu, show/hide based on mobile menu state.

          Entering: "duration-200 ease-out"
            From: "opacity-0 scale-95"
            To: "opacity-100 scale-100"
          Leaving: "duration-100 ease-in"
            From: "opacity-100 scale-100"
            To: "opacity-0 scale-95"
        -->
        <div class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden z-20 md:hidden"
             x-show="mobileMenuOpen"
             x-cloak
        >
            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                <div class="pt-5 pb-6 px-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <a href="/" class="flex">
                                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                                <img class="h-10 md:h-36 w-auto "
                                     src="{{ asset('img/logo.png') }}"
                                     alt="{{ config('app.name', 'Laravel') }}" />
                            </a>
                        </div>
                        <div class="-mr-2">
                            <button @click="mobileMenuOpen = ! mobileMenuOpen;"
                                    type="button"
                                    class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                <span class="sr-only">Close menu</span>
                                <!-- Heroicon name: x -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="mt-6">
                        <nav class="grid gap-6">
                            <a href="{{ route('documents') }}">Documents</a>
                            <a href="{{ route('people') }}">People</a>
                            <a href="{{ route('places') }}">Places</a>
                            <a href="{{ route('timeline') }}">Timeline</a>
                            <a href="{{ route('advanced-search') }}">Search</a>
                            <a href="{{ route('donate.online') }}">Donate</a>
                            <a href="{{ route('volunteer') }}">Get Involved</a>
                        </nav>
                    </div>
                </div>
                <div class="py-6 px-5 space-y-6">
                    <div class="grid grid-cols-2 gap-y-4 gap-x-8">

                        <div class="grid grid-cols-1 gap-y-6">
                            <a href="{{ route('about') }}" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                About
                            </a>

                            <a href="{{ route('volunteer') }}" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                Volunteer
                            </a>

                            <a href="{{ route('about.meet-the-team') }}" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                Meet the Team
                            </a>

                            <a href="{{ route('about.editorial-method') }}" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                Editorial Method
                            </a>
                        </div>

                        <div class="grid grid-cols-1 gap-y-6">
                            <a href="{{ route('media.articles') }}" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                Articles
                            </a>

                            <a href="{{ route('media.photos') }}" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                Photos
                            </a>

                            <a href="{{ route('media.podcasts') }}" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                Podcasts
                            </a>

                            <a href="https://updates.wilfordwoodruffpapers.org/posts"
                               class="text-base font-medium text-gray-900 hover:text-gray-700"
                               target="_newsletter"
                            >
                                Updates
                            </a>

                            <a href="{{ route('media.videos') }}" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                Videos
                            </a>

                            <a href="{{ route('media.news') }}" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                Newsroom
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div x-data="{
                dropdown: null
             }"
         class="bg-secondary py-2 hidden md:block">
        <div class="relative max-w-7xl mx-auto">
            <nav class="md:flex md:items-center md:justify-between md:ml-4 px-4">
                <div class="flex space-x-4 md:space-x-10 flex-1 min-w-0">
                    <?php
                    /*                        echo $site->publicNav()->menu()->setPartial('common/navigation/link')->render(null, [
                                                'maxDepth' => $this->themeSetting('nav_depth') - 1
                                            ]);
                                            */?>
                    <a href="{{ route('documents') }}">Documents</a>
                    <div class="relative inline-block text-left">
                        <span x-on:mouseenter="dropdown = 'people'"
                              x-on:click="dropdown = 'people'"
                              x-on:click.away="dropdown = null"
                              class="text-base font-medium text-primary md:text-white md:hover:text-highlight uppercase"
                        >
                            People
                        </span>
                        <div x-show="dropdown == 'people'"
                             x-on:mouseleave="dropdown = null"
                             x-cloak
                             class="origin-top-right absolute -right-4 mt-2 w-72 shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="{{ route('people') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    People Mentioned in Wilford Woodruff's Papers
                                </a>
                                <a href="{{ route('wives-and-children') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Wilford Woodruff's Wives and Children
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('places') }}">Places</a>
                    <div class="relative inline-block text-left">
                        <span x-on:mouseenter="dropdown = 'timeline'"
                              x-on:click="dropdown = 'timeline'"
                              x-on:click.away="dropdown = null"
                              class="text-base font-medium text-primary md:text-white md:hover:text-highlight uppercase"
                        >
                            Timeline
                        </span>
                        <div x-show="dropdown == 'timeline'"
                             x-on:mouseleave="dropdown = null"
                             x-cloak
                             class="origin-top-right absolute -right-4 mt-2 w-72 shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="{{ route('timeline') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Timeline of Events
                                </a>
                                <a href="{{ route('miraculously-preserved-life') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Wilford Woodruff’s Miraculously Preserved Life
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('advanced-search') }}">Search</a>
                </div>
                <div class="flex space-x-4 md:space-x-10  mt-4 flex md:mt-0 md:ml-4">
                    {{--<a href="/s/wilford-woodruff-papers/page/about">About</a>--}}

                    <div class="relative inline-block text-left">
                            <span x-on:mouseenter="dropdown = 'about'"
                                  x-on:click="dropdown = 'about'"
                                  x-on:click.away="dropdown = null"
                                  class="text-base font-medium text-primary md:text-white md:hover:text-highlight uppercase"
                            >
                                About
                            </span>
                        <div x-show="dropdown == 'about'"
                             x-on:mouseleave="dropdown = null"
                             x-cloak
                             class="origin-top-right absolute -right-4 mt-2 w-72 shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="{{ route('about') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Mission
                                </a>
                                <a href="{{ route('about.meet-the-team') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Meet the Team
                                </a>
                                <a href="{{ route('about.editorial-method') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Editorial Method
                                </a>
                                <a href="{{ route('about.frequently-asked-questions') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Frequently Asked Questions
                                </a>
                                <a href="{{ route('contact-us') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Contact Us
                                </a>
                                {{--<a href="{{ route('') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Contact Us
                                </a>--}}
                            </div>
                        </div>
                    </div>

                    <div class="relative inline-block text-left">
                            <span x-on:mouseenter="dropdown = 'get-involved'"
                                  x-on:click="dropdown = 'get-involved'"
                                  x-on:click.away="dropdown = null"
                                  class="text-base font-medium text-primary md:text-white md:hover:text-highlight uppercase"
                            >
                                Get Involved
                            </span>
                        <div x-show="dropdown == 'get-involved'"
                             x-on:mouseleave="dropdown = null"
                             x-cloak
                             class="origin-top-right absolute -right-4 mt-2 w-72 shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="{{ route('volunteer') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Volunteer
                                </a>
                                <a href="/work-with-us/internship-opportunities"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Internships
                                </a>
                                <a href="{{ route('work-with-us') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Career
                                </a>
                                <a href="{{ route('contribute-documents') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Contribute Documents
                                </a>
                            </div>
                        </div>
                    </div>

                    <!--<div class="relative inline-block text-left">
                        <span x-on:mouseenter="showAbout = true; showMedia = false; showDonate = false; showGetInvolved = false;"
                              x-on:click="showAbout = true; showMedia = false; showDonate = false; showGetInvolved = false;"
                              x-on:click.away="showAbout = false"
                              class="text-base font-medium text-primary md:text-white md:hover:text-highlight uppercase"
                        >
                            About
                        </span>
                        <div x-show="showAbout"
                             x-on:mouseleave="showAbout = false"
                             x-cloak
                             class="origin-top-right absolute -right-4 mt-2 w-60 shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a x-on:mouseenter="showMedia = false; showDonate = false; showGetInvolved = false;"
                                   href="/s/wilford-woodruff-papers/page/about"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">Mission</a>
                                <hr class="border-t border-gray-200 my-5" aria-hidden="true">
                                <h3 class="px-4 py-1 text-base font-bold text-primary uppercase tracking-wider" id="media-library-headline">
                                    Get Involved
                                </h3>
                                <span x-on:mouseenter="showMedia = false; showDonate = false; showGetInvolved = true;"
                                      x-on:click="showMedia = false; showDonate = false; showGetInvolved = true;"
                                      x-on:click.away="showGetInvolved = false"
                                      class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100 uppercase"
                                      role="menuitem"
                                >
                                    Get Involved
                                </span>
                                <a href="/s/wilford-woodruff-papers/page/volunteer"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Volunteer
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/contribute-documents"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Contribute Documents
                                </a>

                            </div>
                        </div>
                    </div>-->




                    <div class="relative inline-block text-left">
                            <span x-on:mouseenter="dropdown = 'media'"
                                  x-on:click="dropdown = 'media'"
                                  x-on:click.away="dropdown = null"
                                  class="text-base font-medium text-primary md:text-white md:hover:text-highlight uppercase hidden lg:inline-block"
                            >
                                Media
                            </span>
                        <div x-show="dropdown == 'media'"
                             x-on:mouseleave="dropdown = null"
                             x-cloak
                             class="origin-top-right absolute -right-4 mt-2 w-72 shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20 p-4">
                            {{--<div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="{{ route('media.articles') }}"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Articles
                                </a>
                                <a href="/s/wilford-woodruff-papers/photos"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Photos
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/podcasts"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Podcasts
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/videos"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Videos
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/media-kit"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Media Kit
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/newsroom"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Newsroom
                                </a><!--
                                    <a href="/s/wilford-woodruff-papers/page/news-releases"
                                       class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                       role="menuitem">
                                        News Releases
                                    </a>-->
                            </div>--}}

                            <h3 class="px-3 text-xs font-semibold text-primary uppercase tracking-wider" id="media-library-headline">
                                Media Library
                            </h3>
                            <div class="mt-1 space-y-1 pb-4 pl-4" aria-labelledby="media-library-headline">
                                <a href="{{ route('media.articles') }}"
                                   class="group flex items-center px-3 py-2 text-sm font-medium text-secondary @if(request()->is('media/articles*')) active @else @endif">
                                    <span class="truncate">
                                        Articles
                                    </span>
                                </a>
                                <a href="{{ route('media.photos') }}"
                                   class="group flex items-center px-3 py-2 text-sm font-medium text-secondary @if(request()->is('media/photos*')) active @else @endif">
                                    <span class="truncate">
                                        Photos
                                    </span>
                                </a>
                                <a href="{{ route('media.podcasts') }}"
                                   class="group flex items-center px-3 py-2 text-sm font-medium text-secondary @if(request()->is('media/podcasts')) active @else @endif">
                                    <span class="truncate">
                                        Podcasts
                                    </span>
                                </a>
                                <a href="https://updates.wilfordwoodruffpapers.org/posts"
                                   class="group flex items-center px-3 py-2 text-sm font-medium text-secondary"
                                   target="_newletter"
                                >
                                    <span class="truncate">
                                        Updates
                                    </span>
                                </a>
                                <a href="{{ route('media.videos') }}"
                                   class="group flex items-center px-3 py-2 text-sm font-medium text-secondary @if(request()->is('media/videos')) active @else @endif">
                                    <span class="truncate">
                                        Videos
                                    </span>
                                </a>
                            </div>
                            <h3 class="px-3 text-xs font-semibold text-primary uppercase tracking-wider" id="media-press-center-headline">
                                Media Center
                            </h3>
                            <div class="mt-1 space-y-1 pb-4 pl-4" aria-labelledby="media-press-center-headline">
                                <a href="{{ route('media.kit') }}"
                                   class="group flex items-center px-3 py-2 text-sm font-medium text-secondary @if(request()->is('media/media-kit')) active @else @endif">
                                    <span class="truncate">
                                        Media Kit
                                    </span>
                                </a>
                                <a href="{{ route('media.requests') }}"
                                   class="group flex items-center px-3 py-2 text-sm font-medium text-secondary @if(request()->is('media/requests')) active @else @endif">
                                    <span class="truncate">
                                        Media Requests
                                    </span>
                                </a>
                            <!--
                <a href="/s/wilford-woodruff-papers/page/news-releases"
                   class="group flex items-center px-3 py-2 text-sm font-medium <?php /*if(strpos($this->serverUrl(true), '/page/news-releases')){ echo 'text-white bg-secondary hover:text-gray-900 hover:bg-gray-50'; } else { echo 'text-secondary hover:text-gray-900 hover:bg-gray-50'; } */?>">
                                <span class="truncate">
                                    News Releases
                                </span>
                </a>-->
                                <a href="{{ route('media.news') }}"
                                   class="group flex items-center px-3 py-2 text-sm font-medium text-secondary @if(request()->is('media/news')) active @else @endif">
                                    <span class="truncate">
                                        Newsroom
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="relative inline-block text-left">
                        <a href="{{ route('donate.online') }}"
                           class="text-base font-medium text-primary md:text-white md:hover:text-highlight uppercase border-2 border-white md:hover:border-highlight rounded-md py-1 px-2"
                        >Donate</a>
                    </div>

                    <!--<div class="relative inline-block text-left">

                        <span x-on:mouseenter="showAbout = false; showMedia = false; showDonate = true; showGetInvolved = false;"
                              x-on:click="showMedia = false; showDonate = true; showGetInvolved = false;"
                              x-on:click.away="showDonate = false"
                              class="text-base font-medium text-primary md:text-white md:hover:text-highlight uppercase border-2 border-white md:hover:border-highlight rounded-md py-1 px-2"
                        >
                            Donate
                        </span>
                        <div x-show="showDonate"
                             x-on:mouseleave="showDonate = false"
                             x-cloak
                             class="origin-top-right absolute -right-4 mt-2 w-40 shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="/s/wilford-woodruff-papers/page/donate-online"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Donate Online
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/check-or-wire"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Check or Wire
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/donation-questions"
                                   class="block px-4 py-2 text-secondary font-medium hover:bg-gray-100"
                                   role="menuitem">
                                    Contact
                                </a>
                            </div>
                        </div>
                    </div>-->
                    <!--<div class="relative inline-block text-left">

                    </div>-->
                </div>
            </nav>
        </div>
    </div>




</header>
