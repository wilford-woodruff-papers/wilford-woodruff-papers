

<div class="relative @if($child->gender == 'F') rounded-lg border-t-2 border-pink-400 @else rounded-lg border-t-2 border-blue-500 @endif">
    <div class="flex relative items-center py-2 px-3 space-x-3 bg-white rounded-lg border-r border-b border-l border-gray-300 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400" x-on:mouseenter="flyoutOpen = 'child_{{ $child->id }}'" x-on:mouseleave="flyoutOpen = null">
        <div class="flex-1 min-w-0">
            <p class="text-lg font-medium text-gray-900"><a class="focus:outline-none" href="/subjects/{{ optional($child->person)->slug }}">{{ $child->name }}</a></p>

            <p class="text-sm text-gray-500 truncate"><a class="focus:outline-none" href="#"><span>{{ $child->birthdate }}</span> - <span>{{ $child->deathdate }}</span> </a></p>
        </div>
    </div>

    <div class="absolute left-2 z-10 px-2 mt-3 w-screen max-w-md sm:px-0" x-description="" x-show="flyoutOpen == 'child_{{ $child->id }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-end="opacity-100 translate-y-0" x-transition:enter-start="opacity-0 translate-y-1" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 translate-y-1" x-transition:leave-start="opacity-100 translate-y-0"
         x-cloak
    >
        <div class="overflow-hidden ring-1 ring-black ring-opacity-5 shadow-lg">
            <div class="grid relative gap-2 py-6 px-5 bg-white sm:gap-2 sm:p-8">
                <a class="text-lg font-medium border-b border-gray-200 text-primary" href="/subjects/{{ optional($child->person)->slug }}">
                    {{ $child->name }}
                </a>
                <div class="grid relative grid-cols-7">
                    <div class="col-span-2 pr-2 text-right text-gray-400">Birth</div>

                    <div class="col-span-5 text-left">
                        <p>{{ $child->birthdate }}</p>

                        <p>{{ $child->birthplace }}</p>
                    </div>
                </div>

                <div class="grid relative grid-cols-7">
                    <div class="col-span-2 pr-2 text-right text-gray-400">Death</div>

                    <div class="col-span-5 text-left">
                        <p>{{ $child->deathdate }}</p>

                        <p>{{ $child->deathplace }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
