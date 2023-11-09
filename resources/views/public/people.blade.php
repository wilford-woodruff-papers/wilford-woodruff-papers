<x-guest-layout>
    <x-slot name="title">
        People | {{ config('app.name') }}
    </x-slot>

    <x-banner-image :image="asset('img/banners/people.png')"
                    :text="'People'"
    />

    <div class="px-4 mx-auto max-w-7xl">

        <div class="col-span-12 py-6 px-8 mt-4">
            <p class="text-lg text-black">
                Explore the biographical information on thousands of people who interacted with Wilford Woodruff. Discover their stories through Wilford Woodruff's daily journal entries and their correspondence with him. This list reflects only those people identified in published documents. The information in this list is updated quarterly as new documents are published on this site.
            </p>

        </div>

    </div>

    <div class="px-4 mx-auto max-w-7xl">

        <div class="col-span-12 py-6 px-8">
            <livewire:people />
        </div>
    </div>

</x-guest-layout>
