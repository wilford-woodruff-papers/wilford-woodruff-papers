{{--
-- Important note:
--
-- This template is based on an example from Tailwind UI, and is used here with permission from Tailwind Labs
-- for educational purposes only. Please do not use this template in your own projects without purchasing a
-- Tailwind UI license, or they’ll have to tighten up the licensing and you’ll ruin the fun for everyone.
--
-- Purchase here: https://tailwindui.com/
--}}

<div
    x-data="{ value: @entangle($attributes->wire('model')).live }"
    class="flex rounded-md shadow-sm"
>
    <input
        type="date"
        {{ $attributes->whereDoesntStartWith('wire:model.live') }}
        x-ref="input"
        x-bind:value="value"
        class="block flex-1 w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5 form-input"
        min="1807-02-28"
        max="1898-09-03"
    />
</div>
