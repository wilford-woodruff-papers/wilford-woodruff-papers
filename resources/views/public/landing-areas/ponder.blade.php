<x-guest-layout>
    <x-slot name="title">
        Ponder | {{ config('app.name') }}
    </x-slot>
    <div class="py-12 px-2 mx-auto max-w-7xl">

        <div class="mx-auto max-w-5xl">
            <div class="content">
                <h2>Ponder</h2>
            </div>
        </div>

        <div class="mx-auto max-w-5xl">
            <div class="">

            </div>
        </div>

        {{--<div class="mx-auto mt-12 max-w-5xl">
            <div class="grid grid-cols-3 pb-4 mb-6">
                <div class="col-start-2 font-extrabold">
                    <h2 class="pb-1 text-2xl text-center uppercase border-b-4 border-highlight">Explore</h2>
                </div>
            </div>
            <x-ponder-page-buttons />
        </div>--}}

        <div class="mx-auto mt-12 max-w-5xl">
            <livewire:feed :press="$press"/>
        </div>

    </div>

</x-guest-layout>
