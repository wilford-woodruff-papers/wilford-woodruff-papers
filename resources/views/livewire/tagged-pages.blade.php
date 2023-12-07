<div>
    <div
        x-data="{
            selectedId: '{{ ($quotes->total() > 0 ? 'tab-1-2' : 'tab-1-1') }}',
            init() {
                // Set the first available tab on the page on page load.
                // this.$nextTick(() => this.determineDefaultTab())
                this.$nextTick(() => this.select(this.$id('tab', 1)))
            },
            determineDefaultTab() {
                if(Array.from(document.getElementById('subject-tablist').children).length == 1){
                    this.select('tab-1-1');
                }
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
        class="mx-auto max-w-7xl"
    >
        <!-- Tab List -->
        <ul
            id="subject-tablist"
            x-ref="tablist"
            @keydown.right.prevent.stop="$focus.wrap().next()"
            @keydown.home.prevent.stop="$focus.first()"
            @keydown.page-up.prevent.stop="$focus.first()"
            @keydown.left.prevent.stop="$focus.wrap().prev()"
            @keydown.end.prevent.stop="$focus.last()"
            @keydown.page-down.prevent.stop="$focus.last()"
            role="tablist"
            class="flex items-stretch -mb-px"
        >
            <!-- Tab -->
            @if($quotes->total() > 0)
                <li>
                    <button
                        :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
                        @click="select($el.id)"
                        @mousedown.prevent
                        @focus="select($el.id)"
                        type="button"
                        :tabindex="isSelected($el.id) ? 0 : -1"
                        :aria-selected="isSelected($el.id)"
                        :class="isSelected($el.id) ? 'border-gray-200 bg-white' : 'border-transparent'"
                        class="inline-flex py-2.5 px-5 font-semibold border-t border-r border-l"
                        role="tab"
                    >Selected Quotes</button>
                </li>
            @endif

            <li>
                <button
                    :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
                    @click="select($el.id)"
                    @mousedown.prevent
                    @focus="select($el.id)"
                    type="button"
                    :tabindex="isSelected($el.id) ? 0 : -1"
                    :aria-selected="isSelected($el.id)"
                    :class="isSelected($el.id) ? 'border-gray-200 bg-white' : 'border-transparent'"
                    class="inline-flex py-2.5 px-5 font-semibold border-t border-r border-l"
                    role="tab"
                >Mentioned In</button>
            </li>
        </ul>


{{--            <div wire:loading.flex--}}
{{--                class="flex z-20 justify-center items-center w-full bg-white opacity-50 h-128">--}}
{{--                <div class="animate-ping">--}}
{{--                    Loading...--}}
{{--                </div>--}}
{{--            </div>--}}

        <!-- Panels -->
        <div
             role="tabpanels" class="bg-white rounded-b-md border border-gray-200">
            <!-- Panel -->
            @if($quotes->total() > 0)
                <section
                    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                    role="tabpanel"
                    class="p-8"
                >
                    <ul  wire:loading.remove
                         class="divide-y divide-gray-200"
                         id="quotes">
                        @foreach($quotes as $quote)

                            <x-quote-summary :quote="$quote" />

                        @endforeach
                    </ul>
                    <div id="quote-pagination">
                        {!! $quotes->withQueryString()->links() !!}
                    </div>
                </section>
            @endif

            <section
                x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                role="tabpanel"
                class="p-8"
            >
                <ul  wire:loading.remove
                     class="divide-y divide-gray-200"
                     id="pages">
                    @foreach($pages as $page)

                        <x-page-summary :page="$page" />

                    @endforeach
                </ul>
                <div id="page-pagination">
                    {!! $pages->withQueryString()->links() !!}
                </div>
            </section>
        </div>
    </div>
</div>
