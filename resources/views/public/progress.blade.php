<x-guest-layout>
    <x-slot name="title">
        Progress | {{ config('app.name') }}
    </x-slot>

    <div class="px-4 mx-auto max-w-7xl">
        <x-progress />
    </div>

</x-guest-layout>
