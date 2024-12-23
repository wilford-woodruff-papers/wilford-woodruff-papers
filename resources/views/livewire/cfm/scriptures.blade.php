<div class="-mt-12">
    @if($show)
        <h2 class="mt-12 text-3xl text-primary">
            Scriptures References in Wilford Woodruff’s Writings
        </h2>
        <h3 class="text-xl text-primary">
            References related to this week’s <span class="italic">Come, Follow Me</span> lesson
        </h3>
        <!-- Tabs -->
        <div
            x-data="{
            selectedId: null,
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
            class="mt-4"
        >

            <div class="grid grid-cols-4 gap-x-8">
                <div class="col-span-1">
                    <!-- Tab List -->
                    <ul
                        x-ref="tablist"
                        @keydown.right.prevent.stop="$focus.wrap().next()"
                        @keydown.home.prevent.stop="$focus.first()"
                        @keydown.page-up.prevent.stop="$focus.first()"
                        @keydown.left.prevent.stop="$focus.wrap().prev()"
                        @keydown.end.prevent.stop="$focus.last()"
                        @keydown.page-down.prevent.stop="$focus.last()"
                        role="tablist"
                        class="flex flex-col gap-y-2 items-stretch -mb-px"
                    >
                        <!-- Tab -->
                        @foreach($lesson->chapters as $chapter)
                            @if($pages->filter(function($page) use ($chapter) {
                                return $page->volumes
                                    ->where('pivot.chapter', $chapter->number)
                                    ->where('pivot.book', $chapter->book->name)
                                    ->count() > 0;
                                })
                                ->count() > 0)
                                <li>
                                    <button
                                        :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
                                        @click="select($el.id)"
                                        @mousedown.prevent
                                        @focus="select($el.id)"
                                        type="button"
                                        :tabindex="isSelected($el.id) ? 0 : -1"
                                        :aria-selected="isSelected($el.id)"
                                        :class="isSelected($el.id) ? 'bg-secondary text-white' : 'bg-white text-secondary'"
                                        class="flex justify-center py-2.5 px-5 w-full text-2xl border border-secondary"
                                        role="tab"
                                    >
                                        {{ $chapter->book->name }} {{ $chapter->number }}
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="col-span-3">
                    <!-- Panels -->
                    <div role="tabpanels" class="overflow-auto bg-white max-h-[400px]">
                        <!-- Panel -->
                        @foreach($lesson->chapters as $chapter)
                            @if($pages->filter(function($page) use ($chapter) {
                                return $page->volumes
                                    ->where('pivot.chapter', $chapter->number)
                                    ->where('pivot.book', $chapter->book->name)
                                    ->count() > 0;
                                })
                                ->count() > 0)
                                <section
                                    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                                    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                                    role="tabpanel"
                                    class="px-8"
                                >
                                    <div class="flex flex-col divide-y divide-solid divide-slate-200">
                                        @foreach($pages as $page)
                                            @if($page->volumes
                                                    ->where('pivot.chapter', $chapter->number)
                                                    ->where('pivot.book', $chapter->book->name)
                                                    ->count() > 0
                                            )
                                                <div class="py-2">
                                                    <div class="text-2xl">
                                                        {!!
                                                            str(
                                                                str(strip_tags($page->transcript))
                                                                ->replace('\n', ' ')
                                                                ->squish()
                                                                ->excerpt($chapter->book->name . ' ' . $chapter->number, [
                                                                    'radius' => 200,
                                                                ]))
                                                                ->addScriptureLinks()
                                                                ->addSubjectLinks()
                                                        !!}
                                                    </div>
                                                    <button x-on:click="Livewire.dispatch('openModal', {component: 'page', arguments: {'pageId': {{ $page->id }} } })"
                                                       class="flex gap-x-2 items-center text-lg text-secondary"
                                                    >
                                                        <span class="text-2xl underline">
                                                            {{ $page->parent->public_name }}
                                                        </span>
                                                        <x-heroicon-c-chevron-right class="w-6 h-6"/>
                                                    </button>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
