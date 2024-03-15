<div class="top-0 z-10 bg-white md:sticky"
     x-show="isSelected($id('tab', 1))"
    wire:ignore>
    <div class="mb-8 -mt-4"
         :class="{'': !scrolledFromTop, 'md:shadow-2xl': scrolledFromTop}">
        <div x-ref="nav"
             class="px-0 mx-auto max-w-7xl">
            <ul id="nav-container"
                role="list"
                class="flex flex-col transition-all duration-200 md:flex-row md:items-center"
                :class="{'gap-6': !scrolledFromTop, 'md:divide-x md:divide-gray-200': scrolledFromTop}"
            >
                {{-- List items are added here using teleport frome each section --}}
            </ul>
        </div>
    </div>
</div>
