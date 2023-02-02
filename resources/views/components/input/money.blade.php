{{--
-- Important note:
--
-- This template is based on an example from Tailwind UI, and is used here with permission from Tailwind Labs
-- for educational purposes only. Please do not use this template in your own projects without purchasing a
-- Tailwind UI license, or they’ll have to tighten up the licensing and you’ll ruin the fun for everyone.
--
-- Purchase here: https://tailwindui.com/
--}}

<div class="relative mt-1 rounded-md shadow-sm">
    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
        <span class="text-gray-500 sm:text-sm sm:leading-5">
            $
        </span>
    </div>

    <input {{ $attributes }} class="block pr-12 pl-7 w-full sm:text-sm sm:leading-5 form-input" placeholder="0.00" aria-describedby="price-currency">

    <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
        <span class="text-gray-500 sm:text-sm sm:leading-5" id="price-currency">
            USD
        </span>
    </div>
</div>
