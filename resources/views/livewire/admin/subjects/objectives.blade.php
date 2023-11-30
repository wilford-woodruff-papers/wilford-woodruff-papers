<div wire:init="loadStats"
    x-data="{
        tab: 'documents'
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
                            <th colspan="10" class="py-3.5 text-black bg-white">Research</th>
                        </tr>
                        <tr>
                            <th class="bg-white"></th>
                            <th colspan="1" class="bg-[#cc4125]"></th>
                            <th colspan="3" class="bg-[#e06666]"></th>
                            <th colspan="1" class="bg-[#f6b26b]"></th>
                            <th colspan="3" class="bg-[#ffd966]"></th>
                            <th colspan="3" class="bg-[#76a5af] text-black">Biographies</th>
                            <th colspan="3" class="bg-[#61A146]">Unidentified People</th>
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

                            <th class="px-3 w-14 bg-[#82BD69] text-black">Goal</th>
                            <th class="px-3 w-14 bg-[#82BD69] text-black">Removed</th>
                            <th class="px-3 w-14 bg-[#82BD69] text-black">% of Goal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="text-white bg-black">
                            <td class="px-2 text-center uppercase"></td>
                            <td colspan="15" class="pl-2 text-left"></td>
                        </tr>
                        @php
                            $quarter = 1;
                            $quarterlyStats = [
                                'places' => [
                                    'added' => 0,
                                    'goal' => 0,
                                    'confirmed' => 0,
                                ],
                                'people' => [
                                    'added' => 0,
                                    'goal' => 0,
                                    'identified' => 0,
                                ],
                                'biographies' => [
                                    'goal' => 0,
                                    'written' => 0,
                                ],
                                'unknownPeopleIdentified' => [
                                    'goal' => 0,
                                    'removed' => 0,
                                ],
                            ];
                            $annualStats = [
                                'places' => [
                                    'added' => 0,
                                    'goal' => 0,
                                    'confirmed' => 0,
                                ],
                                'people' => [
                                    'added' => 0,
                                    'goal' => 0,
                                    'identified' => 0,
                                ],
                                'biographies' => [
                                    'goal' => 0,
                                    'written' => 0,
                                ],
                                'unknownPeopleIdentified' => [
                                    'goal' => 0,
                                    'removed' => 0,
                                ],
                            ];
                        @endphp
                        @foreach($months as $key => $month)
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

                                <td class="bg-[#D3EAC8] text-black">{{ $unknownPeopleIdentified[$month['name']]['goal'] }}</td>
                                <td class="bg-[#D3EAC8] text-black">{{ $unknownPeopleIdentified[$month['name']]['actual'] }}</td>
                                <td class="bg-[#D3EAC8] text-black">{{ $unknownPeopleIdentified[$month['name']]['goal'] ? $unknownPeopleIdentified[$month['name']]['percentage'] .'%' : 'N/A'  }}</td>

                            </tr>
                            @php
                                $quarterlyStats['places']['added'] += $places[$month['name']]['added'];
                                $quarterlyStats['places']['goal'] += $places[$month['name']]['goal'];
                                $quarterlyStats['places']['confirmed'] += $places[$month['name']]['actual'];

                                $quarterlyStats['people']['added'] += $people[$month['name']]['added_to_ftp'];
                                $quarterlyStats['people']['goal'] += $people[$month['name']]['goal'];
                                $quarterlyStats['people']['identified'] += $people[$month['name']]['actual'];

                                $quarterlyStats['biographies']['goal'] += $biographies[$month['name']]['goal'];
                                $quarterlyStats['biographies']['written'] += $biographies[$month['name']]['actual'];

                                $quarterlyStats['unknownPeopleIdentified']['goal'] += $unknownPeopleIdentified[$month['name']]['goal'];
                                $quarterlyStats['unknownPeopleIdentified']['removed'] += $unknownPeopleIdentified[$month['name']]['actual'];
                            @endphp
                            @if( ($loop->index + 1) % 3 == 0)
                                <tr class="text-center bg-[#d9d9d9] font-semibold">
                                    <td class="">
                                        Q{{ $quarter }}
                                    </td>
                                    <td>
                                        {{ $quarterlyStats['places']['added'] }}
                                    </td>
                                    <td>
                                        {{ $quarterlyStats['places']['goal'] }}
                                    </td>
                                    <td>
                                        {{ $quarterlyStats['places']['confirmed'] }}
                                    </td>
                                    <td>
                                        {{ $quarterlyStats['places']['goal'] ? number_format($quarterlyStats['places']['confirmed'] / $quarterlyStats['places']['goal'] * 100, 0) .'%' : 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $quarterlyStats['people']['added'] }}
                                    </td>
                                    <td>
                                        {{ $quarterlyStats['people']['goal'] }}
                                    </td>
                                    <td>
                                        {{ $quarterlyStats['people']['identified'] }}
                                    </td>
                                    <td>
                                        {{ $quarterlyStats['people']['goal'] ? number_format($quarterlyStats['people']['identified'] / $quarterlyStats['people']['goal'] * 100, 0) .'%' : 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $quarterlyStats['biographies']['goal'] }}
                                    </td>
                                    <td>
                                        {{ $quarterlyStats['biographies']['written'] }}
                                    </td>
                                    <td>
                                        {{ $quarterlyStats['biographies']['goal'] ? number_format($quarterlyStats['biographies']['written'] / $quarterlyStats['biographies']['goal'] * 100, 0) .'%' : 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $quarterlyStats['unknownPeopleIdentified']['goal'] }}
                                    </td>
                                    <td>
                                        {{ $quarterlyStats['unknownPeopleIdentified']['removed'] }}
                                    </td>
                                    <td>
                                        {{ $quarterlyStats['unknownPeopleIdentified']['goal'] ? number_format($quarterlyStats['unknownPeopleIdentified']['removed'] / $quarterlyStats['unknownPeopleIdentified']['goal'] * 100, 0) .'%' : 'N/A' }}
                                    </td>
                                </tr>
                                @php
                                    $annualStats['places']['added'] += $quarterlyStats['places']['added'];
                                    $annualStats['places']['goal'] += $quarterlyStats['places']['goal'];
                                    $annualStats['places']['confirmed'] += $quarterlyStats['places']['confirmed'];

                                    $annualStats['people']['added'] += $quarterlyStats['people']['added'];
                                    $annualStats['people']['goal'] += $quarterlyStats['people']['goal'];
                                    $annualStats['people']['identified'] += $quarterlyStats['people']['identified'];

                                    $annualStats['biographies']['goal'] += $quarterlyStats['biographies']['goal'];
                                    $annualStats['biographies']['written'] += $quarterlyStats['biographies']['written'];

                                    $annualStats['unknownPeopleIdentified']['goal'] += $quarterlyStats['unknownPeopleIdentified']['goal'];
                                    $annualStats['unknownPeopleIdentified']['removed'] += $quarterlyStats['unknownPeopleIdentified']['removed'];

                                    $quarterlyStats['places']['added'] = 0;
                                    $quarterlyStats['places']['goal'] = 0;
                                    $quarterlyStats['places']['confirmed'] = 0;

                                    $quarterlyStats['people']['added'] = 0;
                                    $quarterlyStats['people']['goal'] = 0;
                                    $quarterlyStats['people']['identified'] = 0;

                                    $quarterlyStats['biographies']['goal'] = 0;
                                    $quarterlyStats['biographies']['written'] = 0;

                                    $quarterlyStats['unknownPeopleIdentified']['goal'] = 0;
                                    $quarterlyStats['unknownPeopleIdentified']['removed'] = 0;

                                    $quarter += 1;
                                @endphp
                            @endif

                            @if($loop->last)
                                <tr class="text-center bg-[#999999] text-white font-semibold">
                                    <td class="">
                                        Stage {{ $stage }}
                                    </td>
                                    <td>
                                        {{ $annualStats['places']['added'] }}
                                    </td>
                                    <td>
                                        {{ $annualStats['places']['goal'] }}
                                    </td>
                                    <td>
                                        {{ $annualStats['places']['confirmed'] }}
                                    </td>

                                    <td>
                                        {{ $annualStats['places']['goal'] ? number_format($annualStats['places']['confirmed'] / $annualStats['places']['goal'] * 100, 0) .'%' : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $annualStats['people']['added'] }}
                                    </td>
                                    <td>
                                        {{ $annualStats['people']['goal'] }}
                                    </td>
                                    <td>
                                        {{ $annualStats['people']['identified'] }}
                                    </td>
                                    <td>
                                        {{ $annualStats['people']['goal'] ? number_format($annualStats['people']['identified'] / $annualStats['people']['goal'] * 100, 0) .'%' : 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $annualStats['biographies']['goal'] }}
                                    </td>
                                    <td>
                                        {{ $annualStats['biographies']['written'] }}
                                    </td>
                                    <td>
                                        {{ $annualStats['biographies']['goal'] ? number_format($annualStats['biographies']['written'] / $annualStats['biographies']['goal'] * 100, 0) .'%' : 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $annualStats['unknownPeopleIdentified']['goal'] }}
                                    </td>
                                    <td>
                                        {{ $annualStats['unknownPeopleIdentified']['removed'] }}
                                    </td>
                                    <td>
                                        {{ $annualStats['unknownPeopleIdentified']['goal'] ? number_format($annualStats['unknownPeopleIdentified']['removed'] / $annualStats['unknownPeopleIdentified']['goal'] * 100, 0) .'%' : 'N/A' }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot></tfoot>
                </table>

            </div>

        </div>
    </div>
</div>
