
    <x-admin.quotes.row wire:loading.class.delay="opacity-50">
        <x-admin.quotes.cell class="pr-0">
            <x-input.checkbox wire:model="selected" value="{{ $quote->id }}" />
        </x-admin.quotes.cell>

        <x-admin.quotes.cell class="max-w-3xl">
                            <span href="#" class="text-sm leading-5 truncate">
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
                        <span class="font-medium text-cool-gray-900">
                            @foreach($quote->topics as $topic)
                                <div class="py-0.5 px-2.5 text-xs font-medium text-gray-800 bg-gray-100 rounded-full">
                                    <div class="flex gap-x-2 justify-between items-center">
                                        <div>
                                            {{ $topic->name }}
                                        </div>
                                        @if($quote->creator->id == auth()->id() || auth()->user()->hasRole('Approve Quotes'))
                                            <div wire:click="deleteTopic({{ $topic->id }})"
                                                 class="cursor-pointer"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </span>
            <button wire:click="$emit('openModal', 'admin.quotes.add-topic-to-quote', [{{ $quote->id }}])"
                    type="button" class="inline-flex gap-x-2 items-center py-1 px-2 my-2 text-xs font-semibold leading-4 text-white rounded-full border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none bg-secondary hover:bg-secondary focus:ring-secondary">
                <!-- Heroicon name: solid/mail -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Topic
            </button>
        </x-admin.quotes.cell>

        <x-admin.quotes.cell>

            <div class="flex relative items-start py-2">
                <div class="flex items-center h-5">
                    <input wire:model="quote.continued_from_previous_page"
                           id="continuedFromPreviousPage"
                           name="continuedFromPreviousPage"
                           type="checkbox"
                           class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary"
                    >
                </div>
                <div class="ml-3 text-sm">
                    <label for="continuedFromPreviousPage"
                           class="font-medium text-gray-700"
                    >
                        Continued from previous page
                    </label>
                </div>
            </div>

            <span href="#" class="block space-x-2 text-sm leading-5 w-[400px]">
                <p class="text-cool-gray-600 w-[400px]">
                    {!! $quote->text !!}
                </p>

                <div x-data="{
                        show: {{ empty($quote->author) ? 'false' : 'true' }}
                    }">
                    <div x-show="! show"
                         x-cloak
                         class="py-2"
                    >
                        <button x-on:click="show = ! show"
                                class="flex gap-x-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Add Author</span>
                        </button>
                    </div>
                    <div x-show="show"
                         x-cloak
                         class="py-2">
                        <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                        <div class="mt-1">
                            <input wire:model.debounce="quote.author"
                                   type="text"
                                   name="author"
                                   id="author"
                                   class="block w-full border-gray-300 shadow-sm sm:text-sm focus:border-secondary focus:ring-secondary"
                                   placeholder="Add Author's name if not Wilford Woodruff">
                        </div>
                    </div>
                </div>
            </span>

            <div class="flex relative items-start py-2">
                <div class="flex items-center h-5">
                    <input wire:model="quote.continued_on_next_page"
                           id="continuedOnNextPage"
                           name="continuedOnNextPage"
                           type="checkbox"
                           class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary"
                    >
                </div>
                <div class="ml-3 text-sm">
                    <label for="continuedOnNextPage"
                           class="font-medium text-gray-700"
                    >
                        Continued on next page
                    </label>
                </div>
            </div>
            @hasrole('Approve Quotes')
            <div class="flex gap-x-2 pt-2">
                <button wire:click="markActionComplete({{ $quote->id }})"
                        class="inline-flex items-center py-1.5 px-2.5 text-xs font-medium text-gray-700 whitespace-nowrap bg-white rounded border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                        title="Mark Approved"
                >
                    Approve
                </button>
            </div>
            @endif
        </x-admin.quotes.cell>

        <x-admin.quotes.cell>
            @if($quote->actions->count() > 0)
                @foreach($quote->actions as $action)
                    <div class="flex gap-x-2 items-center w-[200px]">
                        <div>
                            <div>
                                {{ $action->type->name }} by {{ $action->finisher->name }}
                            </div>
                            <div>
                                {{ $action->completed_at->toFormattedDateString() }}
                            </div>
                        </div>
                        @if($action->finisher->id == auth()->id())
                            <div wire:click="deleteAction({{ $action->id }})"
                                 class="cursor-pointer"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                @endforeach
            @endif
        </x-admin.quotes.cell>

        <x-admin.quotes.cell>
            @if($quote->creator->id == auth()->id() || auth()->user()->hasRole('Approve Quotes'))
                <button wire:click="deleteQuote()"
                        type="button" class="inline-flex gap-x-2 items-center py-1 px-2 my-2 text-xs font-semibold leading-4 text-white bg-red-700 rounded-full border border-transparent shadow-sm hover:bg-red-700 focus:ring-2 focus:ring-red-700 focus:ring-offset-2 focus:outline-none">
                    <!-- Heroicon name: solid/trash -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            @endif
        </x-admin.quotes.cell>
    </x-admin.quotes.row>

