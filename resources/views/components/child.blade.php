

<div class="relative @if($child->gender == 'F') rounded-lg border-t-2 border-pink-400 @else rounded-lg border-t-2 border-blue-500 @endif">
    <div class="relative rounded-lg border-l border-r border-b border-gray-300 bg-white px-3 py-2 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500" x-on:mouseenter="flyoutOpen = 'child_{{ $child->id }}'" x-on:mouseleave="flyoutOpen = null">
        <div class="flex-1 min-w-0">
            <p class="text-lg font-medium text-gray-900"><a class="focus:outline-none" href="{{ optional($child->person)->slug }}">{{ $child->name }}</a></p>

            <p class="text-sm text-gray-500 truncate"><a class="focus:outline-none" href="#"><span>{{ $child->birthdate }}</span> - <span>{{ $child->deathdate }}</span> </a></p>
        </div>
    </div>

    <div class="absolute z-10 left-2 mt-3 px-2 w-screen max-w-md sm:px-0" x-description="" x-show="flyoutOpen == 'child_{{ $child->id }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-end="opacity-100 translate-y-0" x-transition:enter-start="opacity-0 translate-y-1" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 translate-y-1" x-transition:leave-start="opacity-100 translate-y-0"
         x-cloak
    >
        <div class="shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="relative grid gap-2 bg-white px-5 py-6 sm:gap-2 sm:p-8">
                <a class="text-lg text-primary font-medium border-b border-gray-200" href="{{ optional($child->person)->slug }}">
                    {{ $child->name }}
                </a>
                <div class="relative grid grid-cols-7">
                    <div class="col-span-2 text-right text-gray-400 pr-2">Birth</div>

                    <div class="col-span-5 text-left">
                        <p>{{ $child->birthdate }}</p>

                        <p>{{ $child->birthplace }}</p>
                    </div>
                </div>

                <div class="relative grid grid-cols-7">
                    <div class="col-span-2 text-right text-gray-400 pr-2">Death</div>

                    <div class="col-span-5 text-left">
                        <p>{{ $child->deathdate }}</p>

                        <p>{{ $child->deathplace }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
