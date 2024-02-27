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


                <a href="{{ route('relative-finder') }}">
                    <div class="flex flex-col gap-4 justify-center items-center py-2 pr-2 pl-2 mt-8 mb-4 border border-gray-200 shadow-xl sm:flex-row sm:gap-8 bg-primary">
                        <div class="flex gap-x-4 items-center text-xl font-semibold text-white">
                            <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/relative-finder/example-image-1.jpg"
                                 class="flex-shrink w-auto h-12 border-2 border-white shadow-xl"
                            />
                            <span class="flex gap-x-3 items-center">
                                Discover your family connections in Wilford Woodruff's papers with the help of <img src="https://wilfordwoodruffpapers.org/img/familytree-logo.png" alt="FamilySearch" class="-mt-2 w-auto h-8">
                            </span>
                        </div>
                    </div>
                </a>


        </div>

            <div class="relative px-8">
                <h2 class="text-xl font-thin uppercase border-b-4 md:text-3xl lg:text-2xl border-highlight">
                    Categories
                </h2>
            </div>

    </div>

    <div class="px-4 mx-auto max-w-7xl">

        <div class="col-span-12 py-6 px-8">
            <livewire:people />
        </div>
    </div>

</x-guest-layout>
