<x-guest-layout>
    <x-slot name="title">
        Places | {{ config('app.name') }}
    </x-slot>
    <div class="bg-top bg-cover" style="background-image: url({{ asset('img/banners/places.png') }})">
        <div class="py-4 mx-auto max-w-7xl xl:py-12">
            <h1 class="text-4xl text-white md:text-6xl xl:text-8xl">
                Places
            </h1>
        </div>
    </div>

    <div class="px-4 mx-auto max-w-7xl">

        <div class="col-span-12 py-6 px-8 content">

            <div class="page-title">Discover Wilford Woodruff's impact in the places he lived, taught, and served</div>

        </div>

    </div>

    <div class="px-4 mx-auto max-w-7xl">

        <div class="col-span-12 py-6 px-8 content">
            <livewire:places />
        </div>
    </div>

</x-guest-layout>
