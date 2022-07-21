<x-guest-layout>
    <x-slot name="title">
        Places | {{ config('app.name') }}
    </x-slot>
    <div class="bg-cover bg-top" style="background-image: url({{ asset('img/banners/places.png') }})">
        <div class="max-w-7xl mx-auto py-4 xl:py-12">
            <h1 class="text-white text-4xl md:text-6xl xl:text-8xl">
                Places
            </h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4">

        <div class="content col-span-12 px-8 py-6">

            <div class="page-title">Discover Wilford Woodruff's impact in the places he lived, taught, and served</div>

        </div>

    </div>

    <div class="max-w-7xl mx-auto px-4">

        <div class="content col-span-12 px-8 py-6">
            <livewire:places />
        </div>
    </div>

</x-guest-layout>
