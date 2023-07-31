<div wire:init="loadStats"
    x-data="{

    }"
>

    <div class="mx-auto mt-4 max-w-7xl">
        <div class="py-4">

            <h1 class="mb-2 text-2xl font-semibold">
                WWPF Objectives & Key Results: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $dates['start'])->format('F Y') }} - {{ \Carbon\Carbon::createFromFormat('Y-m-d', $dates['end'])->format('F Y') }}
            </h1>

            <div class="flex gap-x-12">

                <button wire:click="$set('stage', 4)"
                        class="inline-flex justify-center items-center py-2 px-8 mt-6 text-sm font-medium rounded-md border shadow-sm sm:ml-3 xl:ml-0 xl:w-full hover:bg-gray-50 focus:ring-2 focus:ring-[#792310] focus:ring-offset-2 focus:outline-none @if($stage === 4) bg-[#792310] border-[#792310] text-white hover:text-gray-700 @else bg-white border-gray-300 text-gray-700 @endif"
                >
                    Stage 4
                </button>

                <button wire:click="$set('stage', 3)"
                        class="inline-flex justify-center items-center py-2 px-8 mt-6 text-sm font-medium rounded-md border shadow-sm sm:ml-3 xl:ml-0 xl:w-full hover:bg-gray-50 focus:ring-2 focus:ring-[#792310] focus:ring-offset-2 focus:outline-none @if($stage === 3) bg-[#792310] border-[#792310] text-white hover:text-gray-700 @else bg-white border-gray-300 text-gray-700 @endif"
                >
                    Stage 3
                </button>

                <button wire:click="$set('stage', 2)"
                        class="inline-flex justify-center items-center py-2 px-8 mt-6 text-sm font-medium rounded-md border shadow-sm sm:ml-3 xl:ml-0 xl:w-full hover:bg-gray-50 focus:ring-2 focus:ring-[#792310] focus:ring-offset-2 focus:outline-none @if($stage === 2) bg-[#792310] border-[#792310] text-white hover:text-gray-700 @else bg-white border-gray-300 text-gray-700 @endif"
                >
                    Stage 2
                </button>

                <button wire:click="$set('stage', 1)"
                        class="inline-flex justify-center items-center py-2 px-8 mt-6 text-sm font-medium rounded-md border shadow-sm sm:ml-3 xl:ml-0 xl:w-full hover:bg-gray-50 focus:ring-2 focus:ring-[#792310] focus:ring-offset-2 focus:outline-none @if($stage === 1) bg-[#792310] border-[#792310] text-white hover:text-gray-700 @else bg-white border-gray-300 text-gray-700 @endif"
                >
                    Stage 1
                </button>
            </div>
        </div>
        <div class="hidden">
            <div>
                <div class="hidden sm:block">
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px space-x-8" aria-label="Tabs">
                            <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
                            <span x-on:click="tab = 'documents'"
                                  :class="tab =='documents' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                  class="py-4 px-1 text-sm font-medium text-gray-500 whitespace-nowrap border-b-2 cursor-pointer">Documents</span>

                            <span x-on:click="tab = 'subjects'"
                                  :class="tab =='subjects' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                  class="py-4 px-1 text-sm font-medium text-gray-500 whitespace-nowrap border-b-2 cursor-pointer">People / Places / Topics</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-8">
        <div class="">
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
                    <thead class="sticky top-0 text-white bg-black">
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

                            <th class="px-3 w-14 bg-[#b6d7a8] text-black">Goal</th>
                            <th class="px-3 w-14 bg-[#b6d7a8] text-black">Completed (All)</th>
                            <th class="px-3 w-14 bg-[#b6d7a8] text-black">Completed Crowd</th>
                            <th class="px-3 w-14 bg-[#b6d7a8] text-black">% of Goal</th>

                            <th class="px-3 w-14 bg-[#f9cb9c] text-black">Goal</th>
                            <th class="px-3 w-14 bg-[#f9cb9c] text-black">Completed</th>
                            <th class="px-3 w-14 bg-[#f9cb9c] text-black">% of Goal</th>

                            <th class="px-3 w-14 bg-[#a4c2f4] text-white">Goal</th>
                            <th class="px-3 w-14 bg-[#a4c2f4] text-white">Completed</th>
                            <th class="px-3 w-14 bg-[#a4c2f4] text-white">% of Goal</th>

                            <th class="px-3 w-14 bg-[#b4a7d6] text-white">Goal</th>
                            <th class="px-3 w-14 bg-[#b4a7d6] text-white">Completed</th>
                            <th class="px-3 w-14 bg-[#b4a7d6] text-white">% of Goal</th>

                            <th class="px-3 w-14 bg-[#d5a6bd] text-white">Goal</th>
                            <th class="px-3 w-14 bg-[#d5a6bd] text-white">Completed</th>
                            <th class="px-3 w-14 bg-[#d5a6bd] text-white">% of Goal</th>

                            <th class="px-3 w-14 bg-[#ea9999] text-black">Goal</th>
                            <th class="px-3 w-14 bg-[#ea9999] text-black">Completed</th>
                            <th class="px-3 w-14 bg-[#ea9999] text-black">% of Goal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($stats as $docTypeName => $docType)
                            <tr class="text-white bg-black">
                                <td class="px-2 text-center uppercase">{{ str($docTypeName)->before(' Sections') }}</td>
                                <td colspan="19" class="pl-2 text-left">Pages</td>
                            </tr>
                            @foreach($docType as $monthName => $monthData)
                                <tr class="text-center">
                                    <td>
                                        {{ $monthName }}
                                    </td>
                                    @foreach($monthData as $actionName => $actionType)
                                        <td @class([
                                              'bg-[#b6d7a8]' =>  ($actionName == 'Transcription'),
                                              'bg-[#f9cb9c]' =>  ($actionName == 'Verification'),
                                              'bg-[#a4c2f4]' =>  ($actionName == 'Subject Tagging'),
                                              'bg-[#b4a7d6]' =>  ($actionName == 'Topic Tagging'),
                                              'bg-[#d5a6bd]' =>  ($actionName == 'Stylization'),
                                              'bg-[#ea9999]' =>  ($actionName == 'Publish'),
                                        ])>
                                            {{ $actionType['goal'] }}
                                        </td>
                                        <td title="{{ $actionName }}"
                                            @class([
                                              'bg-[#b6d7a8]' =>  ($actionName == 'Transcription'),
                                              'bg-[#f9cb9c]' =>  ($actionName == 'Verification'),
                                              'bg-[#a4c2f4]' =>  ($actionName == 'Subject Tagging'),
                                              'bg-[#b4a7d6]' =>  ($actionName == 'Topic Tagging'),
                                              'bg-[#d5a6bd]' =>  ($actionName == 'Stylization'),
                                              'bg-[#ea9999]' =>  ($actionName == 'Publish'),
                                        ])>
                                            {{ $actionType['completed'] }}
                                        </td>
                                        @if($actionName == 'Transcription')
                                            <td @class([
                                              'bg-[#b6d7a8]' =>  ($actionName == 'Transcription'),
                                              'bg-[#f9cb9c]' =>  ($actionName == 'Verification'),
                                              'bg-[#a4c2f4]' =>  ($actionName == 'Subject Tagging'),
                                              'bg-[#b4a7d6]' =>  ($actionName == 'Topic Tagging'),
                                              'bg-[#d5a6bd]' =>  ($actionName == 'Stylization'),
                                              'bg-[#ea9999]' =>  ($actionName == 'Publish'),
                                        ])>
                                                {{ $actionType['completed_crowd'] ?? 0 }}
                                            </td>
                                        @endif
                                        <td @class([
                                              'bg-[#b6d7a8]' =>  ($actionName == 'Transcription'),
                                              'bg-[#f9cb9c]' =>  ($actionName == 'Verification'),
                                              'bg-[#a4c2f4]' =>  ($actionName == 'Subject Tagging'),
                                              'bg-[#b4a7d6]' =>  ($actionName == 'Topic Tagging'),
                                              'bg-[#d5a6bd]' =>  ($actionName == 'Stylization'),
                                              'bg-[#ea9999]' =>  ($actionName == 'Publish'),
                                        ])>
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
                                            @php
                                                $goal = collect($docType)->sum(function($tasks) use ($actionName){
                                                    return $tasks[$actionName]['goal'];
                                                });
                                            @endphp
                                            {{ $goal }}
                                        </td>
                                        <td>
                                            @php
                                                $completed = collect($docType)->sum(function($tasks) use ($actionName){
                                                return $tasks[$actionName]['completed'];
                                            });
                                            @endphp
                                            {{ $completed }}
                                        </td>
                                        @if($actionName == 'Transcription')
                                            <td>
                                                {{ $crowdCompleted = collect($docType)->sum(function($tasks) use ($actionName){
                                                    return $tasks[$actionName]['completed_crowd'];
                                                }) }}
                                            </td>
                                        @endif
                                        <td>

                                            @php
                                                $percentage = (($goal > 0) ? (intval(($completed / $goal) * 100)) : 0);
                                            @endphp
                                            {{ $percentage }}%
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
