<x-guest-layout>
    <x-slot name="title">
        Topics | {{ config('app.name') }}
    </x-slot>

    <x-banner-image :image="asset('img/banners/places.png')"
                    :text="'Topics'"
    />

    <div class="px-4 mx-auto max-w-7xl">

        <div class="col-span-12 py-6 px-8">
            <p class="text-black">
                Increase understanding of the historical and doctrinal depth of the Wilford Woodruff Papers through the 250 topics and 1,200 subtopics tagged and hyperlinked in the documents.
            </p>
        </div>

    </div>

    <div class="px-4 mx-auto max-w-7xl">

        <div class="col-span-12 py-6 px-8 content">
            <livewire:topics />
        </div>
    </div>

</x-guest-layout>
