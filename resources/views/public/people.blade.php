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
        <div class="flex flex-col col-span-12 gap-y-4 py-6 px-8 mt-4">
            <p class="text-lg text-black">
                Explore information on thousands of people who are included in Wilford Woodruff's records. Discover their stories through his daily journal entries and their correspondence with him.
            </p>


            <a href="{{ route('relative-finder') }}">
                <div class="flex flex-col gap-4 justify-center items-center py-4 pr-2 pl-2 border border-gray-200 shadow-xl sm:flex-row sm:gap-8 bg-primary">
                    <div class="flex gap-x-4 items-center text-lg font-semibold text-white md:text-xl">
                        <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/relative-finder/example-image-1.jpg"
                             class="w-auto h-20 border-2 border-white shadow-xl md:flex-shrink md:h-12"
                        />
                        <div class="gap-3 items-center">
                            Discover your family connections in Wilford Woodruff's papers with the help of
                            <img src="https://wilfordwoodruffpapers.org/img/familytree-logo.png" alt="FamilySearch" class="inline ml-2 -mt-2 w-auto h-8">
                        </div>
                    </div>
                </div>
            </a>

            <p class="text-lg text-black">
                These short biographies identify individuals by name; birth date and location; parentage; marriage date and location (if applicable); baptism date and location (if applicable); death date and location; and a brief description of their association with Wilford Woodruff. A biographical reference is included for individuals who are mentioned in the Papers but may not have associated directly with him, such as historical and scriptural figures.
            </p>

            <p class="text-lg text-black">
                This list is regularly updated as new documents are transcribed and published on this site.
            </p>

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
