<div>

    <div class="py-4 space-y-4 px-6">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="flex space-x-4">
                <x-input.text wire:model="filters.search" class="w-128" placeholder="Search quotes..." />
            </div>
        </div>
    </div>
    <x-admin.quotes.table>
        <x-slot name="head">
            <x-admin.quotes.heading class="pr-0 w-8">
                <x-input.checkbox wire:model="selectPage" />
            </x-admin.quotes.heading>
            <x-admin.quotes.heading sortable multi-column class="max-w-3xl">Document</x-admin.quotes.heading>
            <x-admin.quotes.heading sortable multi-column>Topics</x-admin.quotes.heading>
            <x-admin.quotes.heading sortable multi-column class="w-full">Quote</x-admin.quotes.heading>
            <x-admin.quotes.heading sortable multi-column class="w-full">Status</x-admin.quotes.heading>
            <x-admin.quotes.heading />
        </x-slot>

        <x-slot name="body">
            @if ($selectPage)
                <x-admin.quotes.row class="bg-cool-gray-200" wire:key="row-message">
                    <x-admin.quotes.cell colspan="6">
                        @unless ($selectAll)
                            <div>
                                <span>You have selected <strong>{{ $quotes->count() }}</strong> quotes, do you want to select all <strong>{{ $quotes->total() }}</strong>?</span>
                                <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                            </div>
                        @else
                            <span>You are currently selecting all <strong>{{ $quotes->total() }}</strong> quotes.</span>
                        @endif
                    </x-admin.quotes.cell>
                </x-admin.quotes.row>
            @endif

            @forelse ($quotes as $q)
                {{--<livewire:admin.quotes.quote :quote="$q" :wire:key="$q->id"/>--}}
                @livewire('admin.quotes.quote', ['quote' => $q], key($q->id))
            @empty
                <x-admin.quotes.row>
                    <x-admin.quotes.cell colspan="6">
                        <div class="flex justify-center items-center space-x-2">
                            {{--<x-icon.inbox class="h-8 w-8 text-cool-gray-400" />--}}
                            <span class="font-medium py-8 text-cool-gray-400 text-xl">No quotes found...</span>
                        </div>
                    </x-admin.quotes.cell>
                </x-admin.quotes.row>
            @endforelse
        </x-slot>
    </x-admin.quotes.table>

    <div>
        {{ $quotes->links() }}
    </div>
</div>
