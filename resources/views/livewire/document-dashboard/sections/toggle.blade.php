<div class="flex z-10 justify-end mb-4 w-full">
    <ul
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
        <li>
            <button
                :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
                @click="select($el.id)"
                @mousedown.prevent
                @focus="select($el.id)"
                type="button"
                :tabindex="isSelected($el.id) ? 0 : -1"
                :aria-selected="isSelected($el.id)"
                :class="isSelected($el.id) ? 'bg-secondary text-white' : 'bg-white text-secondary hover:bg-secondary-500 hover:text-white'"
                class="inline-flex py-2.5 px-5 border border-secondary"
                role="tab"
                wire:click="$set('tab', 'overview')"
            >
                Document Overview
            </button>
        </li>

        <li>
            <button
                :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
                @click="select($el.id)"
                @mousedown.prevent
                @focus="select($el.id)"
                type="button"
                :tabindex="isSelected($el.id) ? 0 : -1"
                :aria-selected="isSelected($el.id)"
                :class="isSelected($el.id) ? 'bg-secondary text-white' : 'bg-white text-secondary hover:bg-secondary-500 hover:text-white'"
                class="inline-flex py-2.5 px-5 border border-secondary"
                role="tab"
                wire:click="$set('tab', 'search')"
            >
                Search Pages
            </button>
        </li>
    </ul>
</div>
