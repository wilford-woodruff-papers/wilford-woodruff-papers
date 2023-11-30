<div wire:init="loadStats"
     x-data="{
        tab: 'documents'
    }"
>

    <div class="mx-auto mt-4 max-w-7xl">
        <div class="py-4">

            <h1 class="mb-2 text-2xl font-semibold">
                Supervisor Dashboard: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $dates['start'])->format('F Y') }} - {{ \Carbon\Carbon::createFromFormat('Y-m-d', $dates['end'])->format('F Y') }}
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
                @if(! empty($biographies['assigned']))
                    <table class="mb-12 divide-y divide-gray-30">
                        <thead class="sticky top-0 text-white bg-black">
                        <tr>
                            <th class="px-4">Researcher</th>
                            <th class="px-4">Biographies Currently In Progress</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($biographies['assigned'] as $key => $researcher)
                                <tr class="text-center">
                                    <td class="py-1 px-3.5 text-base font-semibold text-left text-black bg-white">
                                        {{ $researcher->name }}
                                    </td>
                                    <td class="text-black">{{ $researcher->assigned }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                @endif

                <table class="">
                    <thead class="sticky top-0 text-white bg-black">
                    <tr>
                        <th class="px-4 text-left">Month</th>
                        <th class="px-4">Researcher</th>
                        <th class="px-4">Biographies Completed</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-300">
                        @foreach($months as $key => $month)
                            <tr class="text-center">
                                <td class="py-1 px-3.5 text-base font-semibold text-left text-black bg-white">
                                    {{ $month['name'] }}
                                </td>
                                <td colspan="2" class="px-4 text-black">
                                    @if(count($people[$month['name']]['biographies']['completed']) > 0)
                                        <table class="w-full">
                                            <thead></thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($people[$month['name']]['biographies']['completed'] as $key => $researcher)
                                                    <tr class="">
                                                        <td class="text-left text-black">{{ $researcher->name }}</td>
                                                        <td class="text-right text-black">{{ $researcher->completed }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot></tfoot>
                                        </table>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot></tfoot>
                </table>

            </div>

        </div>
    </div>
</div>
