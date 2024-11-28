<header x-data="{
        scrollAtTop: true,
        showMobileMenu: false,
        init: function(){
            // scrollAtTop = (window.pageYOffset > 15) ? false : true;
        }
    }"
        class="relative z-100 bg-primary">
    {{--    <div class="absolute w-full h-20 bg-white z-1"></div>--}}
    <nav class="flex relative z-50 justify-between items-center p-3 mx-auto max-w-7xl lg:px-8" aria-label="Global">
        <a href="{{ route('home') }}" class="p-1.5 -mb-1.5">
            <span class="sr-only">Wilford Woodruff Papers</span>
            <img class="-mt-4 w-auto h-16" src="{{ asset('img/image-logo.png') }}" alt="">
        </a>
        <button x-on:click="showMobileMenu = ! showMobileMenu"
                class="lg:hidden">
            <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"></path>
            </svg>
        </button>
        <div class="hidden pt-3 font-sans lg:flex lg:gap-x-1">
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
                        :aria-expanded="open"
                        :aria-controls="$id('dropdown-button')"
                        type="button"
                        class="flex gap-2 items-center py-2.5 px-2 text-base font-medium leading-6 text-white uppercase cursor-pointer group"
                    >
                        <span class="group-hover:text-highlight">Study</span>

                        <!-- Heroicon: chevron-down -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-200 group-hover:text-highlight" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Panel -->
                    <div
                        x-ref="panel"
                        x-show="open"
                        x-transition.origin.top.left
                        x-on:click.outside="close($refs.button)"
                        :id="$id('dropdown-button')"
                        style="display: none;"
                        class="absolute left-0 z-50 mt-2 w-80 bg-white shadow-md"
                    >
                        <a href="{{ route('documents') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Documents
                        </a>

                        <a href="{{ route('topics') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Index
                        </a>

                        <a href="{{ route('come-follow-me.index') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            <span class="italic">Come, Follow Me</span> Insights
                        </a>

                        <a href="{{ route('advanced-search', ['currentIndex' => 'Scriptures']) }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Scriptures
                        </a>

                        <a href="{{ route('places') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Places
                        </a>

                        <a href="{{ route('people') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            People
                        </a>

                        <a href="{{ route('wives-and-children') }}" class="flex gap-2 items-center py-2.5 pr-4 pl-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Wilford Woodruff's Family
                        </a>

                        <a href="{{ url('wilford-woodruff') }}" class="flex gap-2 items-center py-2.5 pr-4 pl-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            About Wilford Woodruff
                        </a>

                        <a href="{{ url('phebe-woodruff') }}" class="flex gap-2 items-center py-2.5 pr-4 pl-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            About Phebe Woodruff
                        </a>

                        <a href="{{ route('book.product-page') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Wilford Woodruff's Witness: The Development of Temple Doctrine
                        </a>

                    </div>
                </div>
            </div>
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
                        :aria-expanded="open"
                        :aria-controls="$id('dropdown-button')"
                        type="button"
                        class="flex gap-2 items-center py-2.5 px-2 text-base font-medium leading-6 text-white uppercase cursor-pointer group"
                    >
                        <span class="group-hover:text-highlight">Explore</span>

                        <!-- Heroicon: chevron-down -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-200 group-hover:text-highlight" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Panel -->
                    <div
                        x-ref="panel"
                        x-show="open"
                        x-transition.origin.top.left
                        x-on:click.outside="close($refs.button)"
                        :id="$id('dropdown-button')"
                        style="display: none;"
                        class="absolute left-0 z-50 mt-2 w-80 bg-white shadow-md"
                    >
                        <a href="{{ route('relative-finder') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Relative Finder
                        </a>

                        <a href="{{ route('map') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Browse Map
                        </a>

                        <a href="{{ route('day-in-the-life') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Day in the Life
                        </a>

                        <a href="{{ route('timeline') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Timeline
                        </a>

                        <a href="{{ route('miraculously-preserved-life') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Miraculously Preserved Life
                        </a>

                        <div x-data="{ active: null }"
                             class="mx-auto space-y-4 w-full max-w-3xl">
                            <div x-data="{
                                    id: 1,
                                    get expanded() {
                                        return this.active === this.id
                                    },
                                    set expanded(value) {
                                        this.active = value ? this.id : null
                                    },
                                }"
                                 role="region"
                                 class="bg-white"
                            >
                                <h2>
                                    <button
                                        type="button"
                                        x-on:click="expanded = !expanded"
                                        :aria-expanded="expanded"
                                        class="flex justify-between items-center py-4 px-4 w-full text-sm uppercase hover:bg-gray-50 disabled:text-gray-500 text-primary md:hover:text-highlight"
                                    >
                                        <span>Media</span>
                                        <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
                                        <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
                                    </button>
                                </h2>

                                <div x-show="expanded" x-collapse>
                                    <div class="pb-4">
                                        <ul>
                                            <li>
                                                <a href="{{ route('media.articles') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                    Articles
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('media.photos') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                    Photos
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('media.podcasts') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                    Podcasts
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('updates.index') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                    Updates
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('updates.index') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                    Videos
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('conference.landing-page') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                    2023 Conference
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('media.copyright') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                    Copyright
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                        :aria-expanded="open"
                        :aria-controls="$id('dropdown-button')"
                        type="button"
                        class="flex gap-2 items-center py-2.5 px-2 text-base font-medium leading-6 text-white uppercase cursor-pointer group"
                    >
                        <span class="group-hover:text-highlight">Get Involved</span>

                        <!-- Heroicon: chevron-down -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-200 group-hover:text-highlight" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Panel -->
                    <div
                        x-ref="panel"
                        x-show="open"
                        x-transition.origin.top.left
                        x-on:click.outside="close($refs.button)"
                        :id="$id('dropdown-button')"
                        style="display: none;"
                        class="absolute left-0 z-50 mt-2 w-80 bg-white shadow-md"
                    >
                        <a href="{{ route('volunteer') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Volunteer
                        </a>

                        <a href="{{ url('work-with-us/internship-opportunities') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Internships
                        </a>

                        <a href="{{ route('contribute-documents') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Contribute Documents
                        </a>

                        <a href="{{ route('work-with-us') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Career
                        </a>

                    </div>
                </div>
            </div>
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
                        :aria-expanded="open"
                        :aria-controls="$id('dropdown-button')"
                        type="button"
                        class="flex gap-2 items-center py-2.5 px-2 text-base font-medium leading-6 text-white uppercase cursor-pointer group"
                    >
                        <span class="group-hover:text-highlight">About</span>

                        <!-- Heroicon: chevron-down -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-200 group-hover:text-highlight" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Panel -->
                    <div
                        x-ref="panel"
                        x-show="open"
                        x-transition.origin.top.left
                        x-on:click.outside="close($refs.button)"
                        :id="$id('dropdown-button')"
                        style="display: none;"
                        class="absolute left-0 z-50 mt-2 w-80 bg-white shadow-md"
                    >
                        <a href="{{ route('about') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Mission
                        </a>

                        <a href="{{ route('about.meet-the-team') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Meet the Team
                        </a>

                        <a href="{{ route('testimonies.index') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Testimonies
                        </a>

                        <a href="{{ route('about.partners') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Partners
                        </a>

                        <a href="{{ url('impact') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Impact
                        </a>

                        <a href="{{ route('progress') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Progress
                        </a>

                        <a href="{{ route('about.editorial-method') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Editorial Method
                        </a>

                        <a href="{{ route('figures') }}" class="flex gap-2 items-center py-2.5 pr-4 pl-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Figures
                        </a>

                        <a href="{{ route('about.frequently-asked-questions') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Frequently Asked Questions
                        </a>

                        <a href="{{ route('contact-us') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                            Contact Us
                        </a>

                        <div x-data="{ active: null }"
                             class="mx-auto space-y-4 w-full max-w-3xl">
                            <div x-data="{
                                    id: 1,
                                    get expanded() {
                                        return this.active === this.id
                                    },
                                    set expanded(value) {
                                        this.active = value ? this.id : null
                                    },
                                }"
                                 role="region"
                                 class="bg-white"
                            >
                                <h2>
                                    <button
                                        type="button"
                                        x-on:click="expanded = !expanded"
                                        :aria-expanded="expanded"
                                        class="flex justify-between items-center py-4 px-4 w-full text-sm uppercase hover:bg-gray-50 disabled:text-gray-500 text-primary md:hover:text-highlight"
                                    >
                                        <span>Media Kit</span>
                                        <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
                                        <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
                                    </button>
                                </h2>

                                <div x-show="expanded" x-collapse>
                                    <div class="pb-4">
                                        <ul>
                                            <li>
                                                <a href="{{ route('media.kit') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                    Media Kit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('media.requests') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                    Media Requests
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('media.news') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                    Newsroom
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <a href="{{ route('donate') }}" class="py-2.5 text-base font-medium leading-6 text-white hover:text-highlight">
                Donate
            </a>

            <a href="{{ route('advanced-search') }}" class="py-2.5 pl-2 text-base font-semibold leading-6 text-white hover:text-highlight">
                <x-heroicon-o-magnifying-glass class="w-6 h-6" />
            </a>
        </div>
    </nav>
    <div x-show="showMobileMenu" class="fixed top-0 right-0 left-0 min-h-screen bg-white lg:hidden z-[100]" style="display: none;">
        <nav class="overflow-y-auto h-screen">
            <div class="absolute right-2 top-5 h-20 lg:hidden">
                <button x-on:click="showMobileMenu = ! showMobileMenu">
                    <svg class="w-10 h-10 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="px-4 pt-0.5 pb-8 ml-0.5">
                <a aria-label="Homepage" href="/" class="">
                    <img class="w-auto h-[60px] PageLogo-image" src="{{ asset('img/image-logo.png') }}" alt="Wilford Woodruff Papers Logo">
                </a>
            </div>
            <ul x-data="{ active: null }"
                class="flex flex-col gap-4 pl-12 mt-2 text-primary">
                <li x-data="{
                            id: 1,
                            get expanded() {
                                return this.active === this.id
                            },
                            set expanded(value) {
                                this.active = value ? this.id : null
                            },
                        }"
                    role="region"
                    class="px-4 w-full text-primary">
                    <div>
                        <button
                            type="button"
                            x-on:click="expanded = !expanded"
                            :aria-expanded="expanded"
                            class="flex justify-between items-center w-full text-2xl uppercase cursor-pointer hover:bg-gray-50 text-primary"
                        >
                            <span>Study</span>
                            <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
                            <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
                        </button>
                    </div>

                    <div x-show="expanded" x-collapse>
                        <div class="px-6 pb-4">
                            <a href="{{ route('documents') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Documents
                            </a>

                            <a href="{{ route('topics') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Index
                            </a>

                            <a href="{{ route('come-follow-me.index') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                <span class="italic">Come, Follow Me</span> Insights
                            </a>

                            <a href="{{ route('advanced-search', ['currentIndex' => 'Scriptures']) }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Scriptures
                            </a>

                            <a href="{{ route('places') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Places
                            </a>

                            <a href="{{ route('people') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                People
                            </a>

                            <a href="{{ url('wives-and-children') }}" class="flex gap-2 items-center py-2.5 pr-4 pl-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Family
                            </a>

                            <a href="{{ url('wilford-woodruff') }}" class="flex gap-2 items-center py-2.5 pr-4 pl-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                About Wilford Woodruff
                            </a>

                            <a href="{{ url('phebe-woodruff') }}" class="flex gap-2 items-center py-2.5 pr-4 pl-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                About Phebe Woodruff
                            </a>

                            <a href="{{ route('book.product-page') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Wilford Woodruff's Witness: The Development of Temple Doctrine
                            </a>
                        </div>
                    </div>
                </li>

                <li x-data="{
                            id: 2,
                            get expanded() {
                                return this.active === this.id
                            },
                            set expanded(value) {
                                this.active = value ? this.id : null
                            },
                        }"
                    role="region"
                    class="px-4 w-full text-primary">
                    <div>
                        <button
                            type="button"
                            x-on:click="expanded = !expanded"
                            :aria-expanded="expanded"
                            class="flex justify-between items-center w-full text-2xl uppercase cursor-pointer hover:bg-gray-50 text-primary"
                        >
                            <span>Explore</span>
                            <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
                            <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
                        </button>
                    </div>

                    <div x-show="expanded" x-collapse>
                        <div class="px-6 pb-4">
                            <a href="{{ route('relative-finder') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Relative Finder
                            </a>

                            <a href="{{ route('map') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Browse Map
                            </a>

                            <a href="{{ route('day-in-the-life') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Day in the Life
                            </a>

                            <a href="{{ route('timeline') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Timeline
                            </a>

                            <a href="{{ route('miraculously-preserved-life') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Miraculously Preserved Life
                            </a>

                            <div x-data="{ active: null }"
                                 class="mx-auto space-y-4 w-full">
                                <div x-data="{
                                    id: 1,
                                    get expanded() {
                                        return this.active === this.id
                                    },
                                    set expanded(value) {
                                        this.active = value ? this.id : null
                                    },
                                }"
                                     role="region"
                                     class="bg-white"
                                >
                                    <h2>
                                        <button
                                            type="button"
                                            x-on:click="expanded = !expanded"
                                            :aria-expanded="expanded"
                                            class="flex justify-between items-center py-4 px-4 w-full text-sm uppercase hover:bg-gray-50 disabled:text-gray-500 text-primary md:hover:text-highlight"
                                        >
                                            <span>Media</span>
                                            <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
                                            <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
                                        </button>
                                    </h2>

                                    <div x-show="expanded" x-collapse>
                                        <div class="pb-4">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('media.articles') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                        Articles
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('media.photos') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                        Photos
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('media.podcasts') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                        Podcasts
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('updates.index') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                        Updates
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('updates.index') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                        Videos
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('conference.landing-page') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                        2023 Conference
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('media.copyright') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                        Copyright
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li x-data="{
                        id: 3,
                        get expanded() {
                            return this.active === this.id
                        },
                        set expanded(value) {
                            this.active = value ? this.id : null
                        },
                    }"
                    role="region"
                    class="px-4 w-full text-primary">
                    <div>
                        <button
                            type="button"
                            x-on:click="expanded = !expanded"
                            :aria-expanded="expanded"
                            class="flex justify-between items-center w-full text-2xl uppercase cursor-pointer hover:bg-gray-50 text-primary"
                        >
                            <span>Get Involved</span>
                            <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
                            <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
                        </button>
                    </div>

                    <div x-show="expanded" x-collapse>
                        <div class="px-6 pb-4">
                            <a href="{{ route('volunteer') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Volunteer
                            </a>

                            <a href="{{ url('work-with-us/internship-opportunities') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Internships
                            </a>

                            <a href="{{ route('contribute-documents') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Contribute Documents
                            </a>

                            <a href="{{ route('work-with-us') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Career
                            </a>
                        </div>
                    </div>
                </li>

                <li x-data="{
                        id: 4,
                        get expanded() {
                            return this.active === this.id
                        },
                        set expanded(value) {
                            this.active = value ? this.id : null
                        },
                    }"
                    role="region"
                    class="px-4 w-full text-primary">
                    <div>
                        <button
                            type="button"
                            x-on:click="expanded = !expanded"
                            :aria-expanded="expanded"
                            class="flex justify-between items-center w-full text-2xl uppercase cursor-pointer hover:bg-gray-50 text-primary"
                        >
                            <span>About</span>
                            <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
                            <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
                        </button>
                    </div>

                    <div x-show="expanded" x-collapse>
                        <div class="px-6 pb-4">
                            <a href="{{ route('about') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Mission
                            </a>

                            <a href="{{ route('about.meet-the-team') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Meet the Team
                            </a>

                            <a href="{{ route('testimonies.index') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Testimonies
                            </a>

                            <a href="{{ route('about.partners') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Partners
                            </a>

                            <a href="{{ url('impact') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Impact
                            </a>

                            <a href="{{ route('progress') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Progress
                            </a>

                            <a href="{{ route('about.editorial-method') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Editorial Method
                            </a>

                            <a href="{{ route('figures') }}" class="flex gap-2 items-center py-2.5 pr-4 pl-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Figures
                            </a>

                            <a href="{{ route('about.frequently-asked-questions') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Frequently Asked Questions
                            </a>

                            <a href="{{ route('contact-us') }}" class="flex gap-2 items-center py-2.5 px-4 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                Contact Us
                            </a>

                            <div x-data="{ active: null }"
                                 class="mx-auto space-y-4 w-full max-w-3xl">
                                <div x-data="{
                                    id: 1,
                                    get expanded() {
                                        return this.active === this.id
                                    },
                                    set expanded(value) {
                                        this.active = value ? this.id : null
                                    },
                                }"
                                     role="region"
                                     class="bg-white"
                                >
                                    <h2>
                                        <button
                                            type="button"
                                            x-on:click="expanded = !expanded"
                                            :aria-expanded="expanded"
                                            class="flex justify-between items-center py-4 px-4 w-full text-sm uppercase hover:bg-gray-50 disabled:text-gray-500 text-primary md:hover:text-highlight"
                                        >
                                            <span>Media Kit</span>
                                            <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
                                            <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
                                        </button>
                                    </h2>

                                    <div x-show="expanded" x-collapse>
                                        <div class="pb-4">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('media.kit') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                        Media Kit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('media.requests') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                        Media Requests
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('media.news') }}" class="flex gap-2 items-center py-2.5 px-8 w-full text-sm text-left hover:bg-gray-50 disabled:text-gray-500 text-primary first-of-type:rounded-t-md last-of-type:rounded-b-md">
                                                        Newsroom
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <a href="{{ route('donate') }}" class="py-2 px-4 text-2xl cursor-pointer hover:bg-gray-50 text-primary">
                        Donate
                    </a>
                </li>

                <li>
                    <a href="{{ route('advanced-search') }}" class="py-2 px-4 text-2xl cursor-pointer hover:bg-gray-50 text-primary">
                        Search
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <x-admin-bar />
</header>

