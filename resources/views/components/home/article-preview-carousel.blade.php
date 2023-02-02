<div>
    @if($medias->count() > 0)
        <div class="hidden px-4 pt-8 pb-4 mx-auto max-w-7xl md:block md:pt-12 md:pb-8 xl:pt-12">
            <div class="grid grid-cols-1 pb-8 sm:grid-cols-2 md:grid-cols-3">
                <div class="font-extrabold">
                    <h2 class="pb-1 text-3xl uppercase border-b-4 border-highlight">What's New</h2>
                </div>
            </div>
            <div
                x-data="{
                skip: 3,
                atBeginning: false,
                atEnd: false,
                next() {
                    this.to((current, offset) => current + (offset * this.skip))
                },
                prev() {
                    this.to((current, offset) => current - (offset * this.skip))
                },
                to(strategy) {
                    let slider = this.$refs.slider
                    let current = slider.scrollLeft
                    let offset = slider.firstElementChild.getBoundingClientRect().width
                    slider.scrollTo({ left: strategy(current, offset), behavior: 'smooth' })
                },
                focusableWhenVisible: {
                    'x-intersect:enter'() {
                        this.$el.removeAttribute('tabindex')
                    },
                    'x-intersect:leave'() {
                        this.$el.setAttribute('tabindex', '-1')
                    },
                },
                disableNextAndPreviousButtons: {
                    'x-intersect:enter'() {
                        let slideEls = this.$el.parentElement.children

                        // If this is the first slide.
                        if (slideEls[0] === this.$el) {
                            this.atBeginning = true
                        // If this is the last slide.
                        } else if (slideEls[slideEls.length-1] === this.$el) {
                            this.atEnd = true
                        }
                    },
                    'x-intersect:leave'() {
                        let slideEls = this.$el.parentElement.children

                        // If this is the first slide.
                        if (slideEls[0] === this.$el) {
                            this.atBeginning = false
                        // If this is the last slide.
                        } else if (slideEls[slideEls.length-1] === this.$el) {
                            this.atEnd = false
                        }
                    },
                },
            }"
                class="flex flex-col w-full article-preview-carousel"
            >
                <div
                    x-on:keydown.right="next"
                    x-on:keydown.left="prev"
                    tabindex="0"
                    role="region"
                    aria-labelledby="carousel-label"
                    class="flex space-x-3"
                >
                    <h2 id="carousel-label" class="sr-only" hidden>Carousel</h2>

                    <!-- Prev Button -->
                    <button
                        x-on:click="prev"
                        class="text-3xl"
                        :aria-disabled="atBeginning"
                        :tabindex="atEnd ? -1 : 0"
                        :class="{ 'opacity-50 cursor-not-allowed': atBeginning }"
                    >
                        <span class="p-4 font-extrabold text-secondary"
                              aria-hidden="true">❮</span>
                        <span class="sr-only">Skip to previous slide page</span>
                    </button>

                    <span id="carousel-content-label" class="sr-only" hidden>Recent Media</span>

                    <ul
                        x-ref="slider"
                        tabindex="0"
                        role="listbox"
                        aria-labelledby="carousel-content-label"
                        class="flex overflow-x-scroll w-full snap-x snap-mandatory"
                    >
                        @foreach($medias as $media)
                            <li x-bind="disableNextAndPreviousButtons" class="flex flex-col justify-center items-center p-2 w-1/3 snap-start shrink-0" role="option">
                                @if($media->type == 'Instagram')
                                    <x-home.media.social-media-card :media="$media" />
                                @else
                                    <x-home.media.generic-card :media="$media" />
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <!-- Next Button -->
                    <button
                        x-on:click="next"
                        class="text-3xl"
                        :aria-disabled="atEnd"
                        :tabindex="atEnd ? -1 : 0"
                        :class="{ 'opacity-50 cursor-not-allowed': atEnd }"
                    >
                        <span class="p-4 font-extrabold text-secondary"
                              aria-hidden="true">❯</span>
                        <span class="sr-only">Skip to next slide page</span>
                    </button>
                </div>
            </div>
            @push('scripts')
                <script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>
            @endpush
        </div>

        <div class="px-2 pt-8 pb-4 mx-auto max-w-7xl md:hidden md:px-24 md:pt-16 md:pb-8 xl:pt-16">
            <div class="grid grid-cols-1 pb-8 sm:grid-cols-2 md:grid-cols-3">
                <div class="font-extrabold">
                    <h2 class="pb-1 text-3xl uppercase border-b-4 border-highlight">What's New</h2>
                </div>
            </div>
            <div
                x-data="{
                skip: 1,
                atBeginning: false,
                atEnd: false,
                next() {
                    this.to((current, offset) => current + (offset * this.skip))
                },
                prev() {
                    this.to((current, offset) => current - (offset * this.skip))
                },
                to(strategy) {
                    let slider = this.$refs.slider
                    let current = slider.scrollLeft
                    let offset = slider.firstElementChild.getBoundingClientRect().width
                    slider.scrollTo({ left: strategy(current, offset), behavior: 'smooth' })
                },
                focusableWhenVisible: {
                    'x-intersect:enter'() {
                        this.$el.removeAttribute('tabindex')
                    },
                    'x-intersect:leave'() {
                        this.$el.setAttribute('tabindex', '-1')
                    },
                },
                disableNextAndPreviousButtons: {
                    'x-intersect:enter'() {
                        let slideEls = this.$el.parentElement.children

                        // If this is the first slide.
                        if (slideEls[0] === this.$el) {
                            this.atBeginning = true
                        // If this is the last slide.
                        } else if (slideEls[slideEls.length-1] === this.$el) {
                            this.atEnd = true
                        }
                    },
                    'x-intersect:leave'() {
                        let slideEls = this.$el.parentElement.children

                        // If this is the first slide.
                        if (slideEls[0] === this.$el) {
                            this.atBeginning = false
                        // If this is the last slide.
                        } else if (slideEls[slideEls.length-1] === this.$el) {
                            this.atEnd = false
                        }
                    },
                },
            }"
                class="flex flex-col w-full article-preview-carousel"
            >
                <div
                    x-on:keydown.right="next"
                    x-on:keydown.left="prev"
                    tabindex="0"
                    role="region"
                    aria-labelledby="carousel-label"
                    class="flex space-x-6"
                >
                    <h2 id="carousel-label" class="sr-only" hidden>Carousel</h2>

                    <!-- Prev Button -->
                    <button
                        x-on:click="prev"
                        class="text-3xl"
                        :aria-disabled="atBeginning"
                        :tabindex="atEnd ? -1 : 0"
                        :class="{ 'opacity-50 cursor-not-allowed': atBeginning }"
                    >
                        <span class="p-3 text-white bg-secondary"
                              aria-hidden="true">❮</span>
                        <span class="sr-only">Skip to previous slide page</span>
                    </button>

                    <span id="carousel-content-label" class="sr-only" hidden>Recent Media</span>

                    <ul
                        x-ref="slider"
                        tabindex="0"
                        role="listbox"
                        aria-labelledby="carousel-content-label"
                        class="flex overflow-x-scroll w-full snap-x snap-mandatory"
                    >
                        @foreach($medias as $media)
                            <li x-bind="disableNextAndPreviousButtons" class="flex flex-col justify-center items-center p-2 w-full snap-start shrink-0" role="option">
                                @if($media->type == 'Instagram')
                                    <x-home.media.social-media-card :media="$media" />
                                @else
                                    <x-home.media.generic-card :media="$media" />
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <!-- Next Button -->
                    <button
                        x-on:click="next"
                        class="text-3xl"
                        :aria-disabled="atEnd"
                        :tabindex="atEnd ? -1 : 0"
                        :class="{ 'opacity-50 cursor-not-allowed': atEnd }"
                    >
                        <span class="p-3 text-white bg-secondary"
                              aria-hidden="true">❯</span>
                        <span class="sr-only">Skip to next slide page</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="pb-4 mx-auto max-w-7xl text-center md:pb-8">
            <x-links.primary href="{{ route('landing-areas.ponder') }}">
                View More
            </x-links.primary>
        </div>
    @endif


</div>
