<div wire:init="loadStats">

    <div class="mx-auto mt-4 max-w-7xl">
        <div class="py-4">

            <h1 class="mb-2 text-2xl font-semibold">
                Stage
            </h1>

            <div class="flex">
                <button wire:click="$set('stage', 3)"
                        class="inline-flex justify-center items-center py-2 px-8 mt-6 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm sm:ml-3 xl:ml-0 xl:w-full hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                >
                    Stage 3
                </button>
            </div>

            {{--<form wire:submit.prevent="update" class="flex gap-x-4">
                            <div>
                                <label for="start" class="block text-sm font-medium text-gray-700">Starting Date</label>
                                <div class="mt-1">
                                    <input wire:model.defer="dates.start"
                                           id="start"
                                           type="date"
                                           class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>
                            </div>
                            <div>
                                <label for="end" class="block text-sm font-medium text-gray-700">Ending Date</label>
                                <div class="mt-1">
                                    <input wire:model.defer="dates.end"
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
                        </form>--}}

            <div class="relative mt-12 mb-4">
                <div wire:loading
                     class="absolute w-full h-full bg-white opacity-75"
                >
                    <div class="flex justify-center py-40">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 animate-spin">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>

                    </div>
                </div>
                <table class="divide-y divide-gray-30">
                    <thead class="text-white bg-black">
                        <tr>
                            <th class="bg-white"></th>
                            <th colspan="4" class="bg-[#93c47d]">Transcription</th>
                            <th colspan="3" class="bg-[#f6b26b]">2LV</th>
                            <th colspan="3" class="bg-[#6d9eeb]">Subject Tag</th>
                            <th colspan="3" class="bg-[#8e7cc3]">Topic Tag</th>
                            <th colspan="3" class="bg-[#c27ba0]">Stylize</th>
                            <th colspan="3" class="bg-[#e06666]">Publish</th>
                        </tr>
                        <tr>
                            <th class="py-3.5 text-base font-semibold text-center text-black bg-white">
                                Month
                            </th>

                            <th class="px-2 w-14 bg-[#b6d7a8] text-black">Goal</th>
                            <th class="px-2 w-14 bg-[#b6d7a8] text-black">Completed (All)</th>
                            <th class="px-2 w-14 bg-[#b6d7a8] text-black">Completed Crowd</th>
                            <th class="px-2 w-14 bg-[#b6d7a8] text-black">% of Goal</th>

                            <th class="px-2 w-14 bg-[#f9cb9c] text-black">Goal</th>
                            <th class="px-2 w-14 bg-[#f9cb9c] text-black">Completed</th>
                            <th class="px-2 w-14 bg-[#f9cb9c] text-black">% of Goal</th>

                            <th class="px-2 w-14 bg-[#a4c2f4] text-white">Goal</th>
                            <th class="px-2 w-14 bg-[#a4c2f4] text-white">Completed</th>
                            <th class="px-2 w-14 bg-[#a4c2f4] text-white">% of Goal</th>

                            <th class="px-2 w-14 bg-[#b4a7d6] text-white">Goal</th>
                            <th class="px-2 w-14 bg-[#b4a7d6] text-white">Completed</th>
                            <th class="px-2 w-14 bg-[#b4a7d6] text-white">% of Goal</th>

                            <th class="px-2 w-14 bg-[#d5a6bd] text-white">Goal</th>
                            <th class="px-2 w-14 bg-[#d5a6bd] text-white">Completed</th>
                            <th class="px-2 w-14 bg-[#d5a6bd] text-white">% of Goal</th>

                            <th class="px-2 w-14 bg-[#ea9999] text-black">Goal</th>
                            <th class="px-2 w-14 bg-[#ea9999] text-black">Completed</th>
                            <th class="px-2 w-14 bg-[#ea9999] text-black">% of Goal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($stats as $docTypeName => $docType)
                            <tr class="text-white bg-black">
                                <td class="text-center uppercase">{{ $docTypeName }}</td>
                                <td colspan="19" class="pl-2 text-left">Pages</td>
                            </tr>
                            @foreach($docType as $monthName => $monthData)
                                <tr class="text-center">
                                    <td>
                                        {{ $monthName }}
                                    </td>
                                    @foreach($monthData as $actionName => $actionType)
                                        <td>
                                            {{ $actionType['goal'] }}
                                        </td>
                                        <td title="{{ $actionName }}">
                                            {{ $actionType['completed'] }}
                                        </td>
                                        @if($actionName == 'Transcription')
                                            <td>
                                                {{ $actionType['completed_crowd'] ?? 0 }}
                                            </td>
                                        @endif
                                        <td>
                                            {{ $actionType['percentage'] }}%
                                        </td>
                                    @endforeach
                                </tr>
                            @if(($loop->index + 1)  % 3 == 0)
                                <tr class="text-center bg-[#d9d9d9] font-semibold">
                                    <td class="">
                                        Q{{ ($loop->index + 1) / 3 }}
                                    </td>
                                    @foreach($monthData as $actionName => $actionType)
                                        <td>
                                            {{ $actionType['summary']['goal'] }}
                                        </td>
                                        <td>
                                            {{ $actionType['summary']['completed'] }}
                                        </td>
                                        @if($actionName == 'Transcription')
                                            <td>
                                                {{ $actionType['summary']['completed_crowd'] ?? 0 }}
                                            </td>
                                        @endif
                                        <td>
                                            {{ $actionType['summary']['percentage'] }}%
                                        </td>
                                    @endforeach
                                </tr>
                            @endif
                            @if($loop->last)
                                <tr class="text-center bg-[#999999] text-white font-semibold">
                                    <td class="">
                                        Stage {{ $stage }}
                                    </td>
                                    @foreach($monthData as $actionName => $actionType)
                                        <td>
                                            {{ $goal = collect($docType)->sum(function($tasks) use ($actionName){
                                                return $tasks[$actionName]['goal'];
                                            }) }}
                                        </td>
                                        <td>
                                            {{ $completed = collect($docType)->sum(function($tasks) use ($actionName){
                                                return $tasks[$actionName]['completed'];
                                            }) }}
                                        </td>
                                        @if($actionName == 'Transcription')
                                            <td>
                                                0
                                            </td>
                                        @endif
                                        <td>
                                            {{ (($goal > 0) ? intval($completed / $goal) * 100 : 0) }}%
                                        </td>
                                    @endforeach
                                </tr>
                                <tr class="bg-white">
                                    <td colspan="20">
                                        &nbsp;
                                    </td>
                                </tr>
                            @endif
                            @endforeach
                        @endforeach
                        {{--<tr class="text-center">
                            <td>
                                Stage {{ $stage }}
                            </td>
                        </tr>--}}
                    </tbody>
                    <tfoot></tfoot>
                </table>

            </div>

        </div>
    </div>
</div>
