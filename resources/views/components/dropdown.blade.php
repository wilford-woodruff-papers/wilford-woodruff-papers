{{--
-- Important note:
--
-- This template is based on an example from Tailwind UI, and is used here with permission from Tailwind Labs
-- for educational purposes only. Please do not use this template in your own projects without purchasing a
-- Tailwind UI license, or they’ll have to tighten up the licensing and you’ll ruin the fun for everyone.
--
-- Purchase here: https://tailwindui.com/
--}}

@props(['label' => ''])

<div x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false" class="inline-block relative z-10 text-left">
    <div>
        <span class="rounded-md shadow-sm">
            <button @click="open = !open" type="button" class="inline-flex justify-center py-2 px-4 w-full text-sm font-medium leading-5 text-gray-700 bg-white rounded-md border border-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:outline-none active:text-gray-800 active:bg-gray-50 focus:shadow-outline-blue" id="options-menu" aria-haspopup="true" x-bind:aria-expanded="open" aria-expanded="true">
                {{ $label }}

                <svg class="ml-2 -mr-1 w-5 h-5" x-description="Heroicon name: chevron-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </span>
    </div>

    <div x-show="open" style="display: none;" x-description="Dropdown panel, show/hide based on dropdown state." x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-56 rounded-md shadow-lg origin-top-right">
        <div class="bg-white rounded-md shadow-xs">
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
