<header x-data="{
                mobileMenuOpen: false,
            }"
        class="bg-primary nav"
>
    <div class="relative mx-auto max-w-7xl">

        <div class="justify-between items-center py-2 px-4 sm:px-6 md:justify-start md:space-x-10 xl:py-6">
            <!--<div class="flex relative justify-between items-center py-6 px-4 mx-auto max-w-7xl sm:px-6 md:justify-start md:space-x-10">-->
            <div class="md:flex md:flex-1 md:justify-between md:items-center">
                <div class="mb-2 md:flex md:mb-0 md:space-x-10">
                    <a href="/" class="flex">
                        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                        <img class="mx-auto w-auto h-20 md:h-20 xl:h-36"
                             src="{{ asset('img/image-logo.png') }}"
                             alt="{{ config('app.name', 'Laravel') }}" />
                    </a>
                </div>
                <!--<div class="flex items-center md:ml-12">-->
                <div class="md:space-x-10">
                    <div class="relative">
                        <div class="relative">
                            <div class="grid grid-cols-1 justify-center md:flex md:justify-end">
                                <div class="py-0.5 md:pr-8 md:mb-2 md:mb-12 md:-mt-0 xl:-mt-6">
                                    {{--<a class="block py-2 px-4 text-lg text-center text-white uppercase whitespace-nowrap md:inline bg-highlight hover:text-secondary"
                                       data-formkit-toggle="7ce7f1665b"
                                       href="https://wilford-woodruff-papers.ck.page/52a6925518">
                                        Subscribe for Updates
                                    </a>--}}
                                </div>
                                <div class="mr-0 mb-12 md:-mt-2 xl:-mt-8"
                                     id="search">
                                    <div>
                                        <form action="{{ route('advanced-search') }}" id="search-form">
                                            <div class="flex mt-1 max-w-full shadow-sm">
                                                <div class="flex relative flex-grow items-stretch focus-within:z-10">
                                                    <input class="block pl-2 w-full rounded-none border-white sm:text-sm"
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
                                                <button class="inline-flex relative items-center py-2 px-4 -ml-px space-x-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none">
                                                    <svg class="w-5 h-5 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                            <div class="absolute right-4 -my-2 -mr-2 md:hidden">
                                <button x-on:click="mobileMenuOpen = ! mobileMenuOpen;"
                                        type="button"
                                        class="inline-flex justify-center items-center p-2 text-white focus:outline-none bg-secondary hover:text-highlight">
                                    <span class="sr-only">Open menu</span>
                                    <!-- Heroicon name: menu -->
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                            </div>
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
        <div class="absolute inset-x-0 top-0 z-20 p-2 transition transform origin-top-right md:hidden"
             x-show="mobileMenuOpen"
             x-cloak
        >
            <div class="bg-white rounded-lg divide-y-2 divide-gray-50 ring-1 ring-black ring-opacity-5 shadow-lg">
                <div class="px-5 pt-5 pb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <a href="/" class="flex">
                                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                                <img class="w-auto h-10 md:h-36"
                                     src="{{ asset('img/image-logo.png') }}"
                                     alt="{{ config('app.name', 'Laravel') }}" />
                            </a>
                        </div>
                        <div class="-mr-2">
                            <button @click="mobileMenuOpen = ! mobileMenuOpen;"
                                    type="button"
                                    class="inline-flex justify-center items-center p-2 text-gray-400 bg-white rounded-md hover:text-gray-500 hover:bg-gray-100 focus:ring-2 focus:ring-inset focus:ring-indigo-500 focus:outline-none">
                                <span class="sr-only">Close menu</span>
                                <!-- Heroicon name: x -->
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
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
                            <a href="{{ route('donate') }}">Donate</a>
                            <a href="{{ route('get-involved.index') }}">Get Involved</a>
                            @auth()
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a href="{{ route('logout') }}"
                                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>
                            @endauth()
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

                            <a href="{{ route('about.partners') }}" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                Partners
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

                            <a href="{{ route('updates.index') }}"
                               class="text-base font-medium text-gray-900 hover:text-gray-700"
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
         class="hidden py-2 md:block bg-secondary">
        <div class="relative mx-auto max-w-7xl">
            <nav class="px-4 md:flex md:justify-between md:items-center md:ml-4">
                <div class="flex flex-1 space-x-4 min-w-0 md:space-x-10">
                    <a href="{{ route('documents') }}">Documents</a>
                    <div class="flex justify-center">
                        <div
                            x-data="{
                                open: false,
                                toggle() {
                                    if (this.open) {
                                        return this.close()
                                    }

                                    this.$refs.button.focus()

                                    this.open = true
                                },
                                show() {
                                    this.$refs.button.focus()

                                    this.open = true
                                },
                                close(focusAfter) {
                                    if (! this.open) return

                                    this.open = false

                                    focusAfter && focusAfter.focus()
                                }
                            }"
                            x-on:keydown.escape.prevent.stop="close($refs.button)"
                            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                            x-id="['dropdown-button']"
                            class="relative"
                        >
                            <!-- Button -->
                            <button
                                x-ref="button"
                                x-on:click="toggle()"
                                x-on:mouseover="show()"
                                :aria-expanded="open"
                                :aria-controls="$id('dropdown-button')"
                                type="button"
                                class="text-base font-medium uppercase md:text-white text-primary md:hover:text-highlight"
                            >
                                <span>People</span>
                                {{--<span aria-hidden="true">&darr;</span>--}}
                            </button>

                            <!-- Panel -->
                            <div
                                x-ref="panel"
                                x-show="open"
                                x-transition.origin.top.left
                                x-on:click.outside="close($refs.button)"
                                :id="$id('dropdown-button')"
                                style="display: none;"
                                class="overflow-hidden absolute left-0 z-20 mt-2 w-auto bg-white shadow-md"
                            >
                                <div>
                                    <a href="{{ route('people') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        People Mentioned in Wilford Woodruff's Papers
                                    </a>

                                    <a href="{{ route('wives-and-children') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Wilford Woodruff's Wives and Children
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<a href="{{ route('documents') }}">Documents</a>
                    <div class="inline-block relative text-left">
                        <span x-on:mouseenter="dropdown = 'people'"
                              x-on:click="dropdown = 'people'"
                              x-on:click.away="dropdown = null"
                              class="text-base font-medium uppercase md:text-white text-primary md:hover:text-highlight"
                        >
                            People
                        </span>
                        <div x-show="dropdown == 'people'"
                             x-on:mouseleave="dropdown = null"
                             x-cloak
                             class="absolute -right-4 z-20 mt-2 w-72 bg-white ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="{{ route('people') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    People Mentioned in Wilford Woodruff's Papers
                                </a>
                                <a href="{{ route('wives-and-children') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Wilford Woodruff's Wives and Children
                                </a>
                            </div>
                        </div>
                    </div>--}}
                    <a href="{{ route('places') }}">Places</a>
                    <div class="flex justify-center">
                        <div
                            x-data="{
                                open: false,
                                toggle() {
                                    if (this.open) {
                                        return this.close()
                                    }

                                    this.$refs.button.focus()

                                    this.open = true
                                },
                                show() {
                                    this.$refs.button.focus()

                                    this.open = true
                                },
                                close(focusAfter) {
                                    if (! this.open) return

                                    this.open = false

                                    focusAfter && focusAfter.focus()
                                }
                            }"
                            x-on:keydown.escape.prevent.stop="close($refs.button)"
                            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                            x-id="['dropdown-button']"
                            class="relative"
                        >
                            <!-- Button -->
                            <button
                                x-ref="button"
                                x-on:click="toggle()"
                                x-on:mouseover="show()"
                                :aria-expanded="open"
                                :aria-controls="$id('dropdown-button')"
                                type="button"
                                class="text-base font-medium uppercase md:text-white text-primary md:hover:text-highlight"
                            >
                                <span>Timeline</span>
                                {{--<span aria-hidden="true">&darr;</span>--}}
                            </button>

                            <!-- Panel -->
                            <div
                                x-ref="panel"
                                x-show="open"
                                x-transition.origin.top.left
                                x-on:click.outside="close($refs.button)"
                                :id="$id('dropdown-button')"
                                style="display: none;"
                                class="overflow-hidden absolute left-0 z-20 mt-2 w-auto bg-white shadow-md"
                            >
                                <div>
                                    <a href="{{ route('timeline') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Timeline of Events
                                    </a>

                                    <a href="{{ route('miraculously-preserved-life') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Wilford Woodruff’s Miraculously Preserved Life
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--<div class="inline-block relative text-left">
                        <span x-on:mouseenter="dropdown = 'timeline'"
                              x-on:click="dropdown = 'timeline'"
                              x-on:click.away="dropdown = null"
                              class="text-base font-medium uppercase md:text-white text-primary md:hover:text-highlight"
                        >
                            Timeline
                        </span>
                        <div x-show="dropdown == 'timeline'"
                             x-on:mouseleave="dropdown = null"
                             x-cloak
                             class="absolute -right-4 z-20 mt-2 w-72 bg-white ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="{{ route('timeline') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Timeline of Events
                                </a>
                                <a href="{{ route('miraculously-preserved-life') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Wilford Woodruff’s Miraculously Preserved Life
                                </a>
                            </div>
                        </div>
                    </div>--}}
                    <a href="{{ route('advanced-search') }}">Search</a>
                </div>
                <div class="flex mt-4 space-x-4 md:mt-0 md:ml-4 md:space-x-10">
                    {{--<a href="/s/wilford-woodruff-papers/page/about">About</a>--}}
                    <div class="flex justify-center">
                        <div
                            x-data="{
                                open: false,
                                toggle() {
                                    if (this.open) {
                                        return this.close()
                                    }

                                    this.$refs.button.focus()

                                    this.open = true
                                },
                                show() {
                                    this.$refs.button.focus()

                                    this.open = true
                                },
                                close(focusAfter) {
                                    if (! this.open) return

                                    this.open = false

                                    focusAfter && focusAfter.focus()
                                }
                            }"
                            x-on:keydown.escape.prevent.stop="close($refs.button)"
                            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                            x-id="['dropdown-button']"
                            class="relative"
                        >
                            <!-- Button -->
                            <button
                                x-ref="button"
                                x-on:click="toggle()"
                                x-on:mouseover="show()"
                                :aria-expanded="open"
                                :aria-controls="$id('dropdown-button')"
                                type="button"
                                class="text-base font-medium uppercase md:text-white text-primary md:hover:text-highlight"
                            >
                                <span>About</span>
                                {{--<span aria-hidden="true">&darr;</span>--}}
                            </button>

                            <!-- Panel -->
                            <div
                                x-ref="panel"
                                x-show="open"
                                x-transition.origin.top.left
                                x-on:click.outside="close($refs.button)"
                                :id="$id('dropdown-button')"
                                style="display: none;"
                                class="overflow-hidden absolute left-0 z-20 mt-2 w-auto bg-white shadow-md"
                            >
                                <div>
                                    <a href="{{ route('about') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Mission
                                    </a>
                                    <a href="{{ route('about.meet-the-team') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Meet the Team
                                    </a>
                                    <a href="{{ route('about.partners') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Partners
                                    </a>
                                    <a href="{{ route('about.editorial-method') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Editorial Method
                                    </a>
                                    <a href="{{ route('about.frequently-asked-questions') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Frequently Asked Questions
                                    </a>
                                    <a href="{{ route('contact-us') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Contact Us
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--<div class="inline-block relative text-left">
                            <span x-on:mouseenter="dropdown = 'about'"
                                  x-on:click="dropdown = 'about'"
                                  x-on:click.away="dropdown = null"
                                  class="text-base font-medium uppercase md:text-white text-primary md:hover:text-highlight"
                            >
                                About
                            </span>
                        <div x-show="dropdown == 'about'"
                             x-on:mouseleave="dropdown = null"
                             x-cloak
                             class="absolute -right-4 z-20 mt-2 w-72 bg-white ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="{{ route('about') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Mission
                                </a>
                                <a href="{{ route('about.meet-the-team') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Meet the Team
                                </a>
                                <a href="{{ route('about.editorial-method') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Editorial Method
                                </a>
                                <a href="{{ route('about.frequently-asked-questions') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Frequently Asked Questions
                                </a>
                                <a href="{{ route('contact-us') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Contact Us
                                </a>
                                --}}{{--<a href="{{ route('') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Contact Us
                                </a>--}}{{--
                            </div>
                        </div>
                    </div>--}}

                    <div class="flex justify-center">
                        <div
                            x-data="{
                                open: false,
                                toggle() {
                                    if (this.open) {
                                        return this.close()
                                    }

                                    this.$refs.button.focus()

                                    this.open = true
                                },
                                show() {
                                    this.$refs.button.focus()

                                    this.open = true
                                },
                                close(focusAfter) {
                                    if (! this.open) return

                                    this.open = false

                                    focusAfter && focusAfter.focus()
                                }
                            }"
                            x-on:keydown.escape.prevent.stop="close($refs.button)"
                            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                            x-id="['dropdown-button']"
                            class="relative"
                        >
                            <!-- Button -->
                            <a href="{{ route('get-involved.index') }}"
                                x-ref="button"
                                x-on:click="toggle()"
                                x-on:mouseover="show()"
                                :aria-expanded="open"
                                :aria-controls="$id('dropdown-button')"
                                type="button"
                                class="text-base font-medium uppercase md:text-white text-primary md:hover:text-highlight"
                            >
                                <span>Get Involved</span>
                                {{--<span aria-hidden="true">&darr;</span>--}}
                            </a>

                            <!-- Panel -->
                            <div
                                x-ref="panel"
                                x-show="open"
                                x-transition.origin.top.left
                                x-on:click.outside="close($refs.button)"
                                :id="$id('dropdown-button')"
                                style="display: none;"
                                class="overflow-hidden absolute left-0 z-20 mt-2 w-auto bg-white shadow-md"
                            >
                                <div>
                                    <a href="{{ route('volunteer') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Volunteer
                                    </a>
                                    <a href="/work-with-us/internship-opportunities"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Internships
                                    </a>
                                    <a href="{{ route('work-with-us') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Career
                                    </a>
                                    <a href="{{ route('contribute-documents') }}"
                                       class="block py-2 px-4 w-full font-medium whitespace-nowrap hover:bg-gray-100 text-secondary" >
                                        Contribute Documents
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--<div class="inline-block relative text-left">
                            <a href="{{ route('get-involved.index') }}"
                               x-on:mouseenter="dropdown = 'get-involved'"
                               x-on:click="dropdown = 'get-involved'"
                               x-on:click.away="dropdown = null"
                               class="text-base font-medium uppercase md:text-white text-primary md:hover:text-highlight"
                               role="menuitem"
                            >
                                Get Involved
                            </a>
                        <div x-show="dropdown == 'get-involved'"
                             x-on:mouseleave="dropdown = null"
                             x-cloak
                             class="absolute -right-4 z-20 mt-2 w-72 bg-white ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="{{ route('volunteer') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Volunteer
                                </a>
                                <a href="/work-with-us/internship-opportunities"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Internships
                                </a>
                                <a href="{{ route('work-with-us') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Career
                                </a>
                                <a href="{{ route('contribute-documents') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Contribute Documents
                                </a>
                            </div>
                        </div>
                    </div>--}}

                    <!--<div class="inline-block relative text-left">
                        <span x-on:mouseenter="showAbout = true; showMedia = false; showDonate = false; showGetInvolved = false;"
                              x-on:click="showAbout = true; showMedia = false; showDonate = false; showGetInvolved = false;"
                              x-on:click.away="showAbout = false"
                              class="text-base font-medium uppercase md:text-white text-primary md:hover:text-highlight"
                        >
                            About
                        </span>
                        <div x-show="showAbout"
                             x-on:mouseleave="showAbout = false"
                             x-cloak
                             class="absolute -right-4 z-20 mt-2 w-60 bg-white ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a x-on:mouseenter="showMedia = false; showDonate = false; showGetInvolved = false;"
                                   href="/s/wilford-woodruff-papers/page/about"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">Mission</a>
                                <hr class="my-5 border-t border-gray-200" aria-hidden="true">
                                <h3 class="py-1 px-4 text-base font-bold tracking-wider uppercase text-primary" id="media-library-headline">
                                    Get Involved
                                </h3>
                                <span x-on:mouseenter="showMedia = false; showDonate = false; showGetInvolved = true;"
                                      x-on:click="showMedia = false; showDonate = false; showGetInvolved = true;"
                                      x-on:click.away="showGetInvolved = false"
                                      class="block py-2 px-4 font-medium uppercase hover:bg-gray-100 text-secondary"
                                      role="menuitem"
                                >
                                    Get Involved
                                </span>
                                <a href="/s/wilford-woodruff-papers/page/volunteer"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Volunteer
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/contribute-documents"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Contribute Documents
                                </a>

                            </div>
                        </div>
                    </div>-->

                    <div class="flex justify-center">
                        <div
                            x-data="{
                                open: false,
                                toggle() {
                                    if (this.open) {
                                        return this.close()
                                    }

                                    this.$refs.button.focus()

                                    this.open = true
                                },
                                show() {
                                    this.$refs.button.focus()

                                    this.open = true
                                },
                                close(focusAfter) {
                                    if (! this.open) return

                                    this.open = false

                                    focusAfter && focusAfter.focus()
                                }
                            }"
                            x-on:keydown.escape.prevent.stop="close($refs.button)"
                            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                            x-id="['dropdown-button']"
                            class="relative"
                        >
                            <!-- Button -->
                            <button
                                x-ref="button"
                                x-on:click="toggle()"
                                x-on:mouseover="show()"
                                :aria-expanded="open"
                                :aria-controls="$id('dropdown-button')"
                                type="button"
                                class="text-base font-medium uppercase md:text-white text-primary md:hover:text-highlight"
                            >
                                <span>Media</span>
                                {{--<span aria-hidden="true">&darr;</span>--}}
                            </button>

                            <!-- Panel -->
                            <div
                                x-ref="panel"
                                x-show="open"
                                x-transition.origin.top.left
                                x-on:click.outside="close($refs.button)"
                                :id="$id('dropdown-button')"
                                style="display: none;"
                                class="overflow-hidden absolute right-0 z-20 p-4 mt-2 w-auto bg-white shadow-md min-w-[300px]"
                            >
                                <div class="pb-4 pl-4 mt-1 space-y-1" aria-labelledby="media-library-headline">
                                    <h3 class="text-xs font-semibold tracking-wider uppercase whitespace-nowrap text-primary" id="media-library-headline">
                                        Media Library
                                    </h3>
                                    <a href="{{ route('media.articles') }}"
                                       class="group flex items-center px-3 py-2 text-sm font-medium text-secondary whitespace-nowrap @if(request()->is('media/articles*')) active @endif">
                                        <span class="truncate">
                                            Articles
                                        </span>
                                    </a>
                                    <a href="{{ route('media.photos') }}"
                                       class="group flex items-center px-3 py-2 text-sm font-medium text-secondary whitespace-nowrap @if(request()->is('media/photos*')) active @endif">
                                        <span class="truncate">
                                            Photos
                                        </span>
                                    </a>
                                    <a href="{{ route('media.podcasts') }}"
                                       class="group flex items-center px-3 py-2 text-sm font-medium text-secondary whitespace-nowrap @if(request()->is('media/podcasts')) active @endif">
                                        <span class="truncate">
                                            Podcasts
                                        </span>
                                    </a>
                                    <a href="{{ route('updates.index') }}"
                                       class="flex items-center py-2 px-3 text-sm font-medium whitespace-nowrap group text-secondary"
                                    >
                                        <span class="truncate">
                                            Updates
                                        </span>
                                    </a>
                                    <a href="{{ route('media.videos') }}"
                                       class="group flex items-center px-3 py-2 text-sm font-medium text-secondary whitespace-nowrap @if(request()->is('media/videos')) active @endif">
                                        <span class="truncate">
                                            Videos
                                        </span>
                                    </a>
                                    <h3 class="pt-4 text-xs font-semibold tracking-wider uppercase whitespace-nowrap text-primary" id="media-library-headline">
                                        Media Center
                                    </h3>
                                    <a href="{{ route('media.kit') }}"
                                       class="group flex items-center px-3 py-2 text-sm font-medium text-secondary whitespace-nowrap @if(request()->is('media/media-kit')) active @endif">
                                        <span class="truncate">
                                            Media Kit
                                        </span>
                                    </a>
                                    <a href="{{ route('media.requests') }}"
                                       class="group flex items-center px-3 py-2 text-sm font-medium text-secondary whitespace-nowrap @if(request()->is('media/requests')) active @endif">
                                        <span class="truncate">
                                            Media Requests
                                        </span>
                                    </a>
                                    <a href="{{ route('media.news') }}"
                                       class="group flex items-center px-3 py-2 text-sm font-medium text-secondary whitespace-nowrap @if(request()->is('media/news')) active @endif">
                                        <span class="truncate">
                                            Newsroom
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{--<div class="inline-block relative text-left">
                            <span x-on:mouseenter="dropdown = 'media'"
                                  x-on:click="dropdown = 'media'"
                                  x-on:click.away="dropdown = null"
                                  class="hidden text-base font-medium uppercase md:text-white lg:inline-block text-primary md:hover:text-highlight"
                            >
                                Media
                            </span>
                        <div x-show="dropdown == 'media'"
                             x-on:mouseleave="dropdown = null"
                             x-cloak
                             class="absolute -right-4 z-20 p-4 mt-2 w-72 bg-white ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right">
                            --}}{{--<div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="{{ route('media.articles') }}"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Articles
                                </a>
                                <a href="/s/wilford-woodruff-papers/photos"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Photos
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/podcasts"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Podcasts
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/videos"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Videos
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/media-kit"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Media Kit
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/newsroom"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Newsroom
                                </a><!--
                                    <a href="/s/wilford-woodruff-papers/page/news-releases"
                                       class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                       role="menuitem">
                                        News Releases
                                    </a>-->
                            </div>--}}{{--

                            <h3 class="px-3 text-xs font-semibold tracking-wider uppercase text-primary" id="media-library-headline">
                                Media Library
                            </h3>
                            <div class="pb-4 pl-4 mt-1 space-y-1" aria-labelledby="media-library-headline">
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
                                <a href="{{ route('updates.index') }}"
                                   class="flex items-center py-2 px-3 text-sm font-medium group text-secondary"
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
                            <h3 class="px-3 text-xs font-semibold tracking-wider uppercase text-primary" id="media-press-center-headline">
                                Media Center
                            </h3>
                            <div class="pb-4 pl-4 mt-1 space-y-1" aria-labelledby="media-press-center-headline">
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
                    </div>--}}

                    <div class="inline-block relative text-left">
                        <a href="{{ route('donate') }}"
                           class="py-1 px-2 text-base font-medium uppercase rounded-md border-2 border-white md:text-white text-primary md:hover:text-highlight md:hover:border-highlight"
                        >Donate</a>
                    </div>

                    @auth()
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    @endauth()

                    <!--<div class="inline-block relative text-left">

                        <span x-on:mouseenter="showAbout = false; showMedia = false; showDonate = true; showGetInvolved = false;"
                              x-on:click="showMedia = false; showDonate = true; showGetInvolved = false;"
                              x-on:click.away="showDonate = false"
                              class="py-1 px-2 text-base font-medium uppercase rounded-md border-2 border-white md:text-white text-primary md:hover:text-highlight md:hover:border-highlight"
                        >
                            Donate
                        </span>
                        <div x-show="showDonate"
                             x-on:mouseleave="showDonate = false"
                             x-cloak
                             class="absolute -right-4 z-20 mt-2 w-40 bg-white ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <a href="/s/wilford-woodruff-papers/page/donate-online"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Donate Online
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/check-or-wire"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Check or Wire
                                </a>
                                <a href="/s/wilford-woodruff-papers/page/donation-questions"
                                   class="block py-2 px-4 font-medium hover:bg-gray-100 text-secondary"
                                   role="menuitem">
                                    Contact
                                </a>
                            </div>
                        </div>
                    </div>-->
                    <!--<div class="inline-block relative text-left">

                    </div>-->
                </div>
            </nav>
        </div>
    </div>




</header>
