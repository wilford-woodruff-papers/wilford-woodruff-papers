<x-guest-layout>
    <x-slot name="title">
        People | {{ config('app.name') }}
    </x-slot>

    <x-banner-image :image="asset('img/banners/people.png')"
                    :text="'People'"
    />

    <div class="px-4 mx-auto max-w-7xl">
        @if(session()->has('status'))
            <div class="col-span-12 py-6 px-8">
                <div class="relative py-3 px-4 text-green-700 bg-green-100 rounded border border-green-400" role="alert">
                    <span class="block sm:inline">{{ session()->get('status') }}</span>
                </div>
            </div>

        @endif
        <div class="col-span-12 py-6 px-8 mt-4">
            <p class="text-lg text-black">
                Explore the biographical information on thousands of people who interacted with Wilford Woodruff. Discover their stories through Wilford Woodruff's daily journal entries and their correspondence with him. This list reflects only those people identified in published documents. The information in this list is updated quarterly as new documents are published on this site.
            </p>

            @hasanyrole('Super Admin')
                <p class="py-4 text-lg text-black">
                    Login to FamilySearch to view your family connections in the Wilford Woodruff Papers.
                </p>
                <div class="mx-auto w-48">
                    <a href="{{ route('login.familysearch') }}" class="block px-2 pt-2 pb-4 mx-auto text-sm bg-white rounded-md border border-gray-200">
                        <img src="https://wilfordwoodruffpapers.org/img/familytree-logo.png" alt="FamilySearch" class="mx-auto w-auto h-6">
                    </a>
                </div>
            @endhasanyrole

        </div>

    </div>

    <div class="px-4 mx-auto max-w-7xl">

        <div class="col-span-12 py-6 px-8">
            <livewire:people />
        </div>
    </div>

</x-guest-layout>
