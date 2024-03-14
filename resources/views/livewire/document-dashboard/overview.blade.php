<div class="">
    <div
        class="grid gap-y-8 py-12 px-12 mx-auto max-w-7xl">

        @include('livewire.document-dashboard.sections.banner')

        <!-- Tabs -->
        <div  x-data="{
                scrolledFromTop: false,
                currentIndex: 'Pages',
                selectedId: 'tab-1-1',
                init() {
                    // Set the first available tab on the page on page load.
                    this.$nextTick(() => this.select(this.$id('tab', 1)))
                },
                select(id) {
                    this.selectedId = id
                },
                isSelected(id) {
                    return this.selectedId === id
                },
                whichChild(el, parent) {
                    return Array.from(parent.children).indexOf(el) + 1
                }
            }"
              x-id="['tab']"
              @scroll.window="$refs.nav.getBoundingClientRect().top <= 10 ? scrolledFromTop = true : scrolledFromTop = false"
        >
            @include('livewire.document-dashboard.sections.toggle')
            <!-- Tab List -->


            <!-- Panels -->
            <div role="tabpanels" class="-mt-8 bg-white">
                <!-- Panel -->
                <section
                    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                    role="tabpanel"
                    class="grid gap-y-8 px-2"

                >
                    @include('livewire.document-dashboard.sections.nav')

                    @include('livewire.document-dashboard.sections.metadata')

                    @include('livewire.document-dashboard.sections.people')

                    @include('livewire.document-dashboard.sections.places')

                    @include('livewire.document-dashboard.sections.topics')

                    @include('livewire.document-dashboard.sections.quotes')

                    @include('livewire.document-dashboard.sections.events')
                </section>

                <section
                    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                    role="tabpanel"
                    class="grid w-full"
                >
                    @include('livewire.document-dashboard.sections.browse')
                </section>
            </div>
        </div>
    </div>
</div>
