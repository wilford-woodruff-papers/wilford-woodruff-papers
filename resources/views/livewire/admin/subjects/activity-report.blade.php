<div wire:init="loadStats">

    <div class="mx-auto mt-4 max-w-7xl">
        <div class="py-4">

            <h1 class="mb-2 text-2xl font-semibold">
                Subject Activity Report
            </h1>

            <form wire:submit="update" class="flex gap-x-4">
                <div>
                    <label for="start" class="block text-sm font-medium text-gray-700">Starting Date</label>
                    <div class="mt-1">
                        <input wire:model="dates.start"
                               id="start"
                               type="date"
                               class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                </div>
                <div>
                    <label for="end" class="block text-sm font-medium text-gray-700">Ending Date</label>
                    <div class="mt-1">
                        <input wire:model="dates.end"
                               id="end"
                               type="date"
                               class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                </div>
                <div>
                    <button type="submit"
                            class="inline-flex justify-center items-center py-2 px-8 mt-6 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm sm:ml-3 xl:ml-0 xl:w-full hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                    >
                        Update
                    </button>
                </div>
            </form>

            <div class="relative my-12">
                <div wire:loading
                     class="absolute w-full h-full bg-white opacity-75"
                >
                    <div class="flex justify-center py-40">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 animate-spin">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>

                    </div>
                </div>
                @if(! empty($overallStats))
                    <table class="mb-12">
                        <thead>
                            <tr class="font-semibold">
                                <td class="p-4">Total</td>
                                <td class="p-4">Count</td>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2">
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="p-4 text-left">
                                    Biographies Completed
                                </td>
                                <td class="p-4 text-right">
                                    {{ $overallStats['biographies']['completed'] }}
                                </td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="p-4 text-left">
                                    Biographies Approved
                                </td>
                                <td class="p-4 text-right">
                                    {{ $overallStats['biographies']['approved'] }}
                                </td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="p-4 text-left">
                                    Places Confirmed
                                </td>
                                <td class="p-4 text-right">
                                    {{ $overallStats['places']['confirmed'] }}
                                </td>
                            </tr>
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="p-4 text-left">
                                    Unknown People Removed
                                </td>
                                <td class="p-4 text-right">
                                    {{ $overallStats['unknown_people']['removed'] }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                @endif

                @if(! empty($individualStats['biographies']['completed']))
                    <table class="">
                        <thead>
                            <tr class="font-semibold">
                                <td class="p-4">Researcher</td>
                                <td class="p-4">Biographies Completed</td>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2">
                            @foreach($individualStats['biographies']['completed']->groupBy('name') as $individualStat)
                                <tr class="odd:bg-white even:bg-gray-50">
                                    @foreach($individualStat as $stat)
                                        <td class="p-4 text-left">
                                            {{ $stat->name }}
                                        </td>
                                        <td class="p-4 text-right">
                                            {{ $stat->completed }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                @endif

                @if(! empty($individualStats['unknown_people']['removed']))
                    <table class="">
                        <thead>
                            <tr class="font-semibold">
                                <td class="p-4">Researcher</td>
                                <td class="p-4">Unknown People Removed</td>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2">
                            @foreach($individualStats['unknown_people']['removed']->groupBy('name') as $individualStat)
                                <tr class="odd:bg-white even:bg-gray-50">
                                    @foreach($individualStat as $stat)
                                        <td class="p-4 text-left">
                                            {{ $stat->name }}
                                        </td>
                                        <td class="p-4 text-right">
                                            {{ $stat->completed }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
