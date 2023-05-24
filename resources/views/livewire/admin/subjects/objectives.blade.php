<div wire:init="loadStats"
    x-data="{

    }"
>

    <div class="mx-auto mt-4 max-w-7xl">
        <div class="py-4">

            <h1 class="mb-2 text-2xl font-semibold">
                WWPF Subject Objectives & Key Results: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $dates['start'])->format('F Y') }} - {{ \Carbon\Carbon::createFromFormat('Y-m-d', $dates['end'])->format('F Y') }}
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
    <div class="mx-auto max-w-7xl">
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
                            <th colspan="4" class="py-3.5 text-black bg-white">Places</th>
                            <th colspan="7" class="py-3.5 text-black bg-white">Research</th>
                        </tr>
                        <tr>
                            <th class="bg-white"></th>
                            <th colspan="1" class="bg-[#cc4125]"></th>
                            <th colspan="3" class="bg-[#e06666]"></th>
                            <th colspan="1" class="bg-[#f6b26b]"></th>
                            <th colspan="3" class="bg-[#ffd966]"></th>
                            <th colspan="3" class="bg-[#76a5af] text-black">Biographies</th>
                        </tr>
                        <tr>
                            <th class="py-3.5 text-base font-semibold text-center text-black bg-white">Month</th>
                            <th class="px-3 w-14 bg-[#dd7e6b] text-black">Added</th>
                            <th class="px-3 w-14 bg-[#ea9999] text-black">Goal</th>
                            <th class="px-3 w-14 bg-[#ea9999] text-black">Confirmed Places</th>
                            <th class="px-3 w-14 bg-[#ea9999] text-black">% of Goal</th>
                            <th class="px-3 w-14 bg-[#f9cb9c] text-black">Added to FTP</th>
                            <th class="px-3 w-14 bg-[#ffe599] text-black">Goal</th>
                            <th class="px-3 w-14 bg-[#ffe599] text-black">People Identified (PID Number Identified)</th>
                            <th class="px-3 w-14 bg-[#ffe599] text-black">% of Goal</th>
                            <th class="px-3 w-14 bg-[#a2c4c9] text-black">Goal</th>
                            <th class="px-3 w-14 bg-[#a2c4c9] text-black">Written</th>
                            <th class="px-3 w-14 bg-[#a2c4c9] text-black">% of Goal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="text-white bg-black">
                            <td class="px-2 text-center uppercase"></td>
                            <td colspan="12" class="pl-2 text-left"></td>
                        </tr>
                        @foreach($months as $month)
                            <tr class="text-center">
                                <td class="py-1 px-3.5 text-base font-semibold text-center text-black bg-white">
                                    {{ $month['name'] }}
                                </td>

                                <td class="bg-[#e6b8af] text-black">{{ $places[$month['name']]['added'] }}</td>
                                <td class="bg-[#f4cccc] text-black">{{ $places[$month['name']]['goal'] }}</td>
                                <td class="bg-[#f4cccc] text-black">{{ $places[$month['name']]['actual'] }}</td>
                                <td class="bg-[#f4cccc] text-black">{{ $places[$month['name']]['goal'] ? $places[$month['name']]['percentage'].'%' : 'N/A' }}</td>

                                <td class="bg-[#fce5cd] text-black">{{ $people[$month['name']]['added_to_ftp'] }}</td>
                                <td class="bg-[#fff2cc] text-black">{{ $people[$month['name']]['goal'] }}</td>
                                <td class="bg-[#fff2cc] text-black">{{ $people[$month['name']]['actual'] }}</td>
                                <td class="bg-[#fff2cc] text-black">{{ $people[$month['name']]['goal'] ? $people[$month['name']]['percentage'] .'%' : 'N/A' }}</td>

                                <td class="bg-[#d0e0e3] text-black">{{ $biographies[$month['name']]['goal'] }}</td>
                                <td class="bg-[#d0e0e3] text-black">{{ $biographies[$month['name']]['actual'] }}</td>
                                <td class="bg-[#d0e0e3] text-black">{{ $biographies[$month['name']]['goal'] ? $biographies[$month['name']]['percentage'] .'%' : 'N/A'  }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot></tfoot>
                </table>

            </div>

        </div>
    </div>
</div>
