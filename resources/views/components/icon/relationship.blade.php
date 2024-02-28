<div
    x-data="{
        tooltipVisible: false,
        tooltipText: '{{ $title }}',
        tooltipArrow: true,
        tooltipPosition: 'top',
    }"
    x-init="$refs.content.addEventListener('mouseenter', () => { tooltipVisible = true; }); $refs.content.addEventListener('mouseleave', () => { tooltipVisible = false; });"
    class="relative">

    <div x-ref="tooltip" x-show="tooltipVisible" :class="{ 'top-0 left-1/2 -translate-x-1/2 -mt-0.5 -translate-y-full' : tooltipPosition == 'top', 'top-1/2 -translate-y-1/2 -ml-0.5 left-0 -translate-x-full' : tooltipPosition == 'left', 'bottom-0 left-1/2 -translate-x-1/2 -mb-0.5 translate-y-full' : tooltipPosition == 'bottom', 'top-1/2 -translate-y-1/2 -mr-0.5 right-0 translate-x-full' : tooltipPosition == 'right' }" class="absolute w-auto text-sm" x-cloak>
        <div x-show="tooltipVisible" x-transition class="relative px-2 text-white bg-black bg-opacity-90">
            <p x-text="tooltipText" class="block flex-shrink-0 py-0.5 text-base whitespace-nowrap"></p>
            <div x-ref="tooltipArrow" x-show="tooltipArrow" :class="{ 'bottom-0 -translate-x-1/2 left-1/2 w-2.5 translate-y-full' : tooltipPosition == 'top', 'right-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px translate-x-full' : tooltipPosition == 'left', 'top-0 -translate-x-1/2 left-1/2 w-2.5 -translate-y-full' : tooltipPosition == 'bottom', 'left-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px -translate-x-full' : tooltipPosition == 'right' }" class="inline-flex overflow-hidden absolute justify-center items-center">
                <div :class="{ 'origin-top-left -rotate-45' : tooltipPosition == 'top', 'origin-top-left rotate-45' : tooltipPosition == 'left', 'origin-bottom-left rotate-45' : tooltipPosition == 'bottom', 'origin-top-right -rotate-45' : tooltipPosition == 'right' }" class="w-1.5 h-1.5 bg-black bg-opacity-90 transform"></div>
            </div>
        </div>
    </div>

    <div x-ref="content" class="text-xs cursor-pointer">
        <svg id="{{ $name }} : {{ $title }}" xmlns="http://www.w3.org/2000/svg"
             {{ $attributes->merge(['class' => '']) }}
             viewBox="0 0 84.5 98.75">
            <defs>
                <style>.cls-1{fill:#792310;fill-rule:evenodd;stroke-width:0px;}</style>
            </defs>
            <path class="cls-1" d="M45.5,29.14c6.58-1.48,11.5-7.36,11.5-14.39,0-8.15-6.6-14.75-14.75-14.75s-14.75,6.6-14.75,14.75c0,6.94,4.79,12.76,11.25,14.33v16.92H11.25v23.67c-6.46,1.57-11.25,7.39-11.25,14.33,0,8.15,6.6,14.75,14.75,14.75s14.75-6.6,14.75-14.75c0-7.03-4.92-12.91-11.5-14.39v-16.86h48.25v16.92c-6.46,1.57-11.25,7.39-11.25,14.33,0,8.15,6.6,14.75,14.75,14.75s14.75-6.6,14.75-14.75c0-7.03-4.92-12.91-11.5-14.39v-23.61h-27.5v-16.86Z"/>
        </svg>
    </div>

</div>

