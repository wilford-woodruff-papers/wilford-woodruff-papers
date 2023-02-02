<x-guest-layout>
    <x-slot name="title">
        Testify | {{ config('app.name') }}
    </x-slot>
    <div class="py-12 mx-auto max-w-7xl">

        <div class="mx-auto max-w-5xl">
            <div class="content">
                <h2>Testify</h2>
            </div>
        </div>

        <div class="mx-auto max-w-5xl">
            <div class="">

            </div>
        </div>

        <div class="mx-auto mt-12 max-w-5xl">
            <div class="px-6 pb-4">
                <div class="mx-auto max-w-3xl font-extrabold">
                    <h2 class="pb-1 text-2xl text-center uppercase border-b-4 border-highlight">Share Your Testimony of Wilford Woodruff and his Teachings</h2>
                </div>
            </div>
            <livewire:forms.testify />
        </div>

    </div>

</x-guest-layout>
