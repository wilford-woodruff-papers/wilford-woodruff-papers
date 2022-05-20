<div>
    <div class="mt-4 max-w-7xl mx-auto">

        <div class="">
            <form wire:submit.prevent="saveTargetDate">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="mt-8 flex flex-col bg-white">
                        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg px-4">
                                    <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
                                        <label for="publish_at"
                                               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 sm:col-span-1">
                                            Target Publish Date
                                        </label>
                                        <div class="mt-1 sm:mt-0 sm:col-span-3">
                                            <input wire:model="targetDate.publish_at"
                                                type="date"
                                                name="publish_at"
                                                id="publish_at"
                                                class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Save
                                        </button>
                                        <button wire:click="editTargetDate(-1)" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-400 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                                            Clear
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="mt-8 flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Target Publish Dates</th>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($dates as $date)
                                        <tr id="date_{{ $date->id }}"
                                            class="border-t border-gray-200">
                                            <th class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                                <span wire:click="editTargetDate({{ $date->id }})"
                                                   class="cursor-pointer font-medium text-indigo-600 capitalize"
                                                >
                                                    {{ $date->publish_at->toFormattedDateString() }}
                                                </span>
                                            </th>
                                            <th class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6 w-20">
                                                <button wire:click="deleteTargetDate({{ $date->id }})"
                                                        class="flex"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-800 hover:text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
