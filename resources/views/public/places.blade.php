<x-guest-layout>
    <x-slot name="title">
        Places | {{ config('app.name') }}
    </x-slot>

    <x-banner-image :image="asset('img/banners/places.png')"
                    :text="'Places'"
    />

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
