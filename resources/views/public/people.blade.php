<x-guest-layout>
    <x-slot name="title">
        People Mentioned in Wilford Woodruff's Papers | {{ config('app.name') }}
    </x-slot>
    <div class="bg-top bg-cover" style="background-image: url({{ asset('img/banners/people.png') }})">
        <div class="py-4 mx-auto max-w-7xl xl:py-12">
            <h1 class="text-4xl text-white md:text-6xl xl:text-8xl">
                People Mentioned in Wilford Woodruff's Papers
            </h1>
        </div>
    </div>

    <div class="px-4 mx-auto max-w-7xl">

        <div class="col-span-12 py-6 px-8">

            <div class="page-title">Recognize Wilford's influence in the lives of the individuals he interacted with</div>

            <h2 class="section-title">People Mentioned in Wilford Woodruff's Papers</h2>
            <p class="text-black">Explore the biographical sketches of the many people who interacted with Wilford Woodruff. Discover their stories through Wilford Woodruff's daily journal entries and their correspondence with him. This list reflects only those people identified in published documents. The information in this list is updated quarterly as new documents are published on this site.</p>

        </div>

    </div>

    <div class="max-w-7xl mx-auto px-4">

        <div class="content col-span-12 px-8 py-6">
            <livewire:people />
        </div>
    </div>

</x-guest-layout>
