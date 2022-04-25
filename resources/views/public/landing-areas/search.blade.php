<x-guest-layout>

    <div class="max-w-7xl py-12 mx-auto">

        <div class="max-w-5xl mx-auto">
            <div class="content">
                <h2>Search</h2>
            </div>
        </div>

        <div class="max-w-5xl mx-auto bg-primary py-4 px-8">
            <div class="">
                <x-search />
            </div>
        </div>

        <div class="max-w-5xl mx-auto mt-12">
            <div class="grid grid-cols-3 pb-4 -mb-12">
                <div class="font-extrabold col-start-2">
                    <h2 class="text-2xl uppercase pb-1 border-b-4 border-highlight text-center">Explore</h2>
                </div>
            </div>
            <x-search-page-buttons />
        </div>

    </div>

</x-guest-layout>
