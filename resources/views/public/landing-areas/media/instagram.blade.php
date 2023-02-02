<div class="flex items-center h-full bg-black">
    @if($press->social_type == 'carousel')
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
                    @foreach($press->extra_attributes as $image)
                        @if($image['type'] == 'image')
                            <li x-bind="disableNextAndPreviousButtons" class="flex flex-col justify-center items-center p-2 w-full snap-start shrink-0" role="option">
                                <img src="{{ $image['url'] }}"
                                     class=""
                                     alt="">
                            </li>
                        @endif
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
    @elseif($press->social_type == 'video')
        <video
            id="my-video"
            class="video-js"
            controls
            preload="auto"
            poster="{{ $press->cover_image }}"
            data-setup="{}"
            style="width: 100%; height: 480px;"
        >
            <source src="{{ $press->embed }}" type="video/mp4" />
            <p class="vjs-no-js">
                To view this video please enable JavaScript, and consider upgrading to a
                web browser that
                <a href="https://videojs.com/html5-video-support/" target="_blank"
                >supports HTML5 video</a
                >
            </p>
        </video>
    @else
        <img src="{{ $press->cover_image }}"
             class=""
             alt="">
    @endif
</div>
