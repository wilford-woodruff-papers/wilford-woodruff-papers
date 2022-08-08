<div>
    <x-admin.quotes.table>
        <x-slot name="head">
            <x-admin.quotes.heading class="pr-0 w-8">
                <x-input.checkbox wire:model="selectPage" />
            </x-admin.quotes.heading>
            <x-admin.quotes.heading sortable multi-column wire:click="sortBy('title')" :direction="$sorts['title'] ?? null" class="max-w-3xl">Document</x-admin.quotes.heading>
            <x-admin.quotes.heading sortable multi-column wire:click="sortBy('amount')" :direction="$sorts['amount'] ?? null">Topics</x-admin.quotes.heading>
            <x-admin.quotes.heading sortable multi-column wire:click="sortBy('title')" :direction="$sorts['title'] ?? null" class="w-full">Quote</x-admin.quotes.heading>
            <x-admin.quotes.heading sortable multi-column wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">Status</x-admin.quotes.heading>
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

            @forelse ($quotes as $quote)
                <x-admin.quotes.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $quote->id }}">
                    <x-admin.quotes.cell class="pr-0">
                        <x-input.checkbox wire:model="selected" value="{{ $quote->id }}" />
                    </x-admin.quotes.cell>

                    <x-admin.quotes.cell class="max-w-3xl">
                            <span href="#" class="truncate text-sm leading-5">
                                {{--<x-icon.cash class="text-cool-gray-400"/>--}}

                                <div class="block text-cool-gray-600 truncate">
                                    <a href="{{ route('pages.show', ['item' => $quote->page->item, 'page' => $quote->page]) }}"
                                       target="_blank"
                                       class="text-secondary"
                                    >
                                        {{ $quote->page->full_name }}
                                    </a>
                                </div>
                                <div class="block my-2 text-cool-gray-600 truncate">
                                    Tagged by <span class="font-semibold">{{ $quote->creator->name }}</span> on {{ $quote->created_at->toFormattedDateString() }}
                                </div>
                            </span>
                    </x-admin.quotes.cell>

                    <x-admin.quotes.cell>
                        <span class="text-cool-gray-900 font-medium">
                            {!! $quote->topics->pluck('name')->transform(function($topic){
                                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">' . $topic . '</span>';
}                           )->join('') !!}
                        </span>
                    </x-admin.quotes.cell>

                    <x-admin.quotes.cell>
                            <span href="#" class="block space-x-2 w-[400px] text-sm leading-5">
                                <p class="text-cool-gray-600 w-[400px]">
                                    {!! $quote->text !!}
                                </p>
                            </span>
                    </x-admin.quotes.cell>

                    <x-admin.quotes.cell>
                        @if($quote->actions->count() > 0)
                            @foreach($quote->actions as $action)
                                {{ $action->type->name }} by {{ $action->finisher->name }}
                            @endforeach
                        @else
                            <button wire:click="markActionComplete({{ $quote->id }})"
                                    class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap"
                                    title="Mark Approved"
                            >
                                Approve
                            </button>
                        @endif
                    </x-admin.quotes.cell>

                    <x-admin.quotes.cell>
                        {{--<x-button.link wire:click="edit({{ $quote->id }})">Edit</x-button.link>--}}
                    </x-admin.quotes.cell>
                </x-admin.quotes.row>
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
