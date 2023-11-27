<div>
    <div class="property">
        <label for="event" class="block text-sm font-medium leading-6 text-gray-900"><h4>Event</h4></label>
        <div class="p-2 border-spacing-y-2">
            <div class="mb-4">
                <div id="eventAttachedToPage" class="hidden">
                    <div class="p-4 bg-green-50 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-green-800">Event attached to page</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="eventRemovedFromPage" class="hidden">
                    <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm text-yellow-700">
                                    Event detached from page
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($page->events as $event)
                <div class="flex gap-x-4 items-center">
                    <div>
                        <span class="font-semibold">{{ $event->display_date }}</span> - {{ $event->text }}
                    </div>
                    <div>
                        <button wire:click="dettachEvent({{ $event->id }})"
                                type="button"
                                class="p-1 text-white bg-red-600 rounded-full shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex gap-x-4 items-center">
            <div>
                <select wire:model.live="selectedEventId"
                        id="event"
                        class="block py-1.5 pr-10 pl-3 mt-2 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6 focus:ring-2 focus:ring-indigo-600"
                >
                    <option>-- Select Event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}">
                            {{ $event->display_date }} - {{ $event->text }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="items-center pt-3 flex-0">

            </div>
        </div>
    </div>
</div>
