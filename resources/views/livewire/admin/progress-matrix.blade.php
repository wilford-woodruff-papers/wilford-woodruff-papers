<div wire:init="loadStats">

    <div class="mt-4 max-w-7xl mx-auto">
        <div class="py-4">

            <h1 class="text-2xl font-semibold mb-2">
                Progress Matrix
            </h1>

            <form wire:submit.prevent="update" class="flex gap-x-4">
                <div>
                    <label for="user" class="block text-sm font-medium text-gray-700">Completed By</label>
                    <div class="mt-1">
                        <select wire:model="currentUserId"
                                id="currentUserId"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                            <option value="">-- Select Person --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label for="start" class="block text-sm font-medium text-gray-700">Starting Date</label>
                    <div class="mt-1">
                        <input wire:model.defer="dates.start"
                               id="start"
                               type="date"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                    </div>
                </div>
                <div>
                    <label for="end" class="block text-sm font-medium text-gray-700">Ending Date</label>
                    <div class="mt-1">
                        <input wire:model.defer="dates.end"
                               id="end"
                               type="date"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                    </div>
                </div>
                <div>
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-8 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 xl:ml-0 xl:w-full mt-6"
                    >
                        Update
                    </button>
                </div>
            </form>

            <div class="relative mt-12 mb-4">
                <div wire:loading
                     class="absolute w-full h-full bg-white opacity-75"
                >
                    <div class="flex justify-center py-40">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="animate-spin w-24 h-24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>

                    </div>
                </div>
                @if(! empty($pageStats))
                    <table class="divide-y divide-gray-30">
                        <thead class="bg-black">
                            <tr>
                                <th colspan="2" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6 border border-black"></th>
                                <th class="py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-white sm:pl-6 border border-black">Letters<br/>(pages)</th>
                                <th class="py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-white sm:pl-6 border border-black">Discourses<br/>(pages)</th>
                                <th class="py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-white sm:pl-6 border border-black">Journals<br/>(pages)</th>
                                <th class="py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-white sm:pl-6 border border-black">Additional<br/>(pages)</th>
                                <th class="py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-white sm:pl-6 border border-black">Autobiographies<br/>(pages)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr class="bg-[#cccccc]">
                                <td class="text-center text-sm text-black border border-black">Category</td>
                                <td class="text-center text-sm text-black border border-black">Steps</td>
                                <td class="text-center text-sm text-black border border-black">Actual/Goal</td>
                                <td class="text-center text-sm text-black border border-black">Actual/Goal</td>
                                <td class="text-center text-sm text-black border border-black">Actual/Goal</td>
                                <td class="text-center text-sm text-black border border-black">Actual/Goal</td>
                                <td class="text-center text-sm text-black border border-black">Actual/Goal</td>
                            </tr>

                            <tr>
                                <td rowspan="1" class="py-3.5 pl-1 pr-3 text-left text-sm font-semibold text-gray-900 border border-black">
                                    Preparation
                                </td>
                                <td class="py-3.5 pl-1 pr-3 text-left text-sm font-semibold text-gray-900 border border-black">
                                    Access/Organize
                                </td>
                                <td class=" border border-black"></td>
                                <td class=" border border-black"></td>
                                <td class=" border border-black"></td>
                                <td class=" border border-black"></td>
                                <td class=" border border-black"></td>
                            </tr>

                            @foreach($pageStats as $key => $stat)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="3" class="py-3.5 pl-1 pr-3 text-left text-sm font-semibold text-gray-900 border border-black">
                                            Processing
                                        </td>
                                    @endif

                                    <td class="py-2.5 pl-1 pr-3 text-left text-sm font-semibold text-gray-900 border border-black">
                                        {{ str($key) }}
                                    </td>

                                    @foreach($docTypes as $docType)
                                        <td class="text-center text-sm font-semibold text-gray-900 border border-black">
                                            <div class="flex flex-col">
                                                <div>
                                                    {{ $stat->where('document_type', $docType)->first()?->total ?? 0}} / {{ $goals[$key][$docType] }}
                                                </div>
                                                <div @class([
                                                      'bg-[#e06666]' =>  ($goalPercentages[$key][$docType] <= 70),
                                                      'bg-[#ffd966]' => (($goalPercentages[$key][$docType] >= 70) && ($goalPercentages[$key][$docType] <= 99)),
                                                      'bg-[#93c47d]' => (($goalPercentages[$key][$docType] >= 100) && ($goalPercentages[$key][$docType] <= 119)),
                                                      'bg-[#ff50c5]' => ($goalPercentages[$key][$docType] >= 120),
                                                    ])>
                                                    {{ $goalPercentages[$key][$docType] }}
                                                </div>
                                            </div>
                                        </td>
                                    @endforeach

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                @endif


                <div class="my-2">
                    <table>
                        <thead>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="py-2 px-2 text-center text-sm text-white bg-black border border-black">Identify People</td>
                                <td class="py-2 px-2 text-center text-sm text-white bg-black border border-black">Write Biographies</td>
                                <td class="py-2 px-2 text-center text-sm text-white bg-black border border-black">Identify Places</td>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr class="bg-[#cccccc]">
                                <td class="text-center text-sm text-black border border-black">Category</td>
                                <td class="text-center text-sm text-black border border-black">Steps</td>
                                <td class="text-center text-sm text-black border border-black">Actual/Goal</td>
                                <td class="text-center text-sm text-black border border-black">Actual/Goal</td>
                                <td class="text-center text-sm text-black border border-black">Actual/Goal</td>
                            </tr>
                            <tr>
                                <td rowspan="3" class="py-3.5 pl-1 pr-4 text-left text-sm font-semibold text-gray-900 border border-black">
                                    Research
                                </td>
                                <td class="py-3.5 pl-1 pr-4 text-left text-sm font-semibold text-gray-900 border border-black">
                                    Access/Organize
                                </td>
                                <td class=" border border-black"></td>
                                <td class=" border border-black"></td>
                                <td class=" border border-black"></td>
                            </tr>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>

            </div>



            <div class="my-2">
                <table>
                    <thead>
                        <tr>
                            <td class="text-center text-sm text-white bg-black border border-black">Color Key</td>
                            <td colspan="3"></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="pl-1 pr-12 text-sm text-black bg-[#e06666] border border-black">Under 70% of annual goal</td>
                            <td class="pl-1 pr-12 text-sm text-black bg-[#ffd966] border border-black">71-99% of annual goal</td>
                            <td class="pl-1 pr-12 text-sm text-black bg-[#93c47d] border border-black">100-119% of annual goal</td>
                            <td class="pl-1 pr-12 text-sm text-black bg-[#ff50c5] border border-black">120%+ of annual goal</td>
                        </tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
