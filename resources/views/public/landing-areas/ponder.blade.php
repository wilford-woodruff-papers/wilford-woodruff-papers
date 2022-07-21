<x-guest-layout>
    <x-slot name="title">
        Ponder | {{ config('app.name') }}
    </x-slot>
    <div class="max-w-7xl py-12 mx-auto px-2">

        <div class="max-w-5xl mx-auto">
            <div class="content">
                <h2>Ponder</h2>
            </div>
        </div>

        <div class="max-w-5xl mx-auto">
            <div class="">

            </div>
        </div>

        {{--<div class="max-w-5xl mx-auto mt-12">
            <div class="grid grid-cols-3 pb-4 mb-6">
                <div class="font-extrabold col-start-2">
                    <h2 class="text-2xl uppercase pb-1 border-b-4 border-highlight text-center">Explore</h2>
                </div>
            </div>
            <x-ponder-page-buttons />
        </div>--}}

        <div class="max-w-5xl mx-auto mt-12">
            <livewire:feed :press="$press"/>
        </div>

    </div>

</x-guest-layout>
