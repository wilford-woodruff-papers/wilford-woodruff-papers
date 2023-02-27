<div wire:init="loadStats">

    <div class="mx-auto mt-4 max-w-7xl">
        <div class="py-4 px-4 bg-white">

            <h1 class="mb-2 text-2xl font-semibold">
                Progress Matrix
            </h1>

            <form wire:submit.prevent="update" class="flex gap-x-4">
                <div>
                    <label for="user" class="block text-sm font-medium text-gray-700">Completed By</label>
                    <div class="mt-1">
                        <select wire:model="currentUserId"
                                id="currentUserId"
                                class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">-- Select Person --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="pr-8 mr-8">
                    <label for="user" class="block text-sm font-medium text-gray-700">Stage</label>
                    <div class="mt-1">
                        <select wire:model="stage"
                                id="stage"
                                class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">-- Select Stage --</option>
                            <option value="3">Stage 3</option>
                            <option value="2">Stage 2</option>
                            <option value="1">Stage 1</option>
                        </select>
                    </div>
                </div>
            </form>

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
                @if(! empty($pageStats))
                    <table class="divide-y divide-gray-30">
                        <thead class="bg-black">
                            <tr>
                                <th class="justify-center py-3.5 text-sm font-semibold text-white border border-black">
                                   Category
                                </th>
                                <th class="justify-center py-3.5 text-sm font-semibold text-white border border-black">
                                    Steps
                                </th>
                                <th class="py-1.5 pr-3 pl-4 text-sm font-semibold text-center text-white border border-black sm:pl-6">Letters<br/>(pages)</th>
                                <th class="py-1.5 pr-3 pl-4 text-sm font-semibold text-center text-white border border-black sm:pl-6">Discourses<br/>(pages)</th>
                                <th class="py-1.5 pr-3 pl-4 text-sm font-semibold text-center text-white border border-black sm:pl-6">Journals<br/>(pages)</th>
                                <th class="py-1.5 pr-3 pl-4 text-sm font-semibold text-center text-white border border-black sm:pl-6">Additional<br/>(pages)</th>
                                <th class="py-1.5 pr-3 pl-4 text-sm font-semibold text-center text-white border border-black sm:pl-6">Daybooks<br/>(pages)</th>
                                <th class="py-1.5 pr-3 pl-4 text-sm font-semibold text-center text-white border border-black sm:pl-6">Autobiographies<br/>(pages)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">

                            <tr>
                                <td rowspan="1" class="py-3.5 pr-3 pl-1 text-sm font-semibold text-left text-gray-900 border border-black">
                                    Preparation
                                </td>
                                <td class="py-3.5 pr-3 pl-1 text-sm font-semibold text-left text-gray-900 border border-black">
                                    Access/Organize
                                </td>
                                @foreach($docTypes as $docType)
                                    <td class="text-sm font-semibold text-center text-gray-900 border border-black">
                                        {{ number_format($pageCounts[$docType]) }}
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td rowspan="1" colspan="2" class="py-3.5 pr-3 pl-1 text-sm font-semibold text-left text-gray-900 border border-black">
                                    Published Prior to Current Stage
                                </td>
                                @foreach($docTypes as $docType)
                                    <td class="text-sm font-semibold text-center text-gray-900 border border-black">
                                        <livewire:admin.progress-matrix.past-work
                                            :document_type="$this->typesMap[$docType]"
                                            :action_type="'Publish'"
                                            :dates="$dates"
                                            :wire:key="$docType.'Publish'"
                                        />
                                    </td>
                                @endforeach
                            </tr>

                            <tr class="bg-[#cccccc]">
                                <td colspan="2" class="pl-1 text-sm font-semibold text-left text-black border border-black">
                                    STAGE {{ $stage }} ({{ Carbon\Carbon::parse($dates['start'])->format('M Y') }} - {{ Carbon\Carbon::parse($dates['end'])->format('M Y') }})
                                </td>
                                <td class="text-sm text-center text-black border border-black">Actual / Goal</td>
                                <td class="text-sm text-center text-black border border-black">Actual / Goal</td>
                                <td class="text-sm text-center text-black border border-black">Actual / Goal</td>
                                <td class="text-sm text-center text-black border border-black">Actual / Goal</td>
                                <td class="text-sm text-center text-black border border-black">Actual / Goal</td>
                                <td class="text-sm text-center text-black border border-black">Actual / Goal</td>
                            </tr>

                            @foreach($pageStats as $key => $stat)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="4" class="py-3.5 pr-3 pl-1 text-sm font-semibold text-left text-gray-900 border border-black">
                                            Processing
                                        </td>
                                    @endif

                                    <td class="py-2.5 pr-3 pl-1 text-sm font-semibold text-left text-gray-900 border border-black">
                                        {{ str($key) }}
                                    </td>

                                    @foreach($docTypes as $docType)
                                        <td class="text-sm font-semibold text-center text-gray-900 border border-black">
                                            <div>
                                                @if(
                                                    ($stat->whereIn('document_type', $this->typesMap[$docType])->sum('total') ?? 0) == 0
                                                    && $goals[$key][$docType] == 0)
                                                    <div>

                                                    </div>
                                                @else
                                                    <div class="flex flex-col">
                                                        <div>
                                                            <a href="{{ route('admin.page-activity', ['type' => $docType, 'activity' => $key, 'start_date' => $dates['start'], 'end_date' => $dates['end']]) }}"
                                                               target="_blank"
                                                               title="Click to view page activity"
                                                            >
                                                                {{ number_format($stat->whereIn('document_type', $this->typesMap[$docType])->sum('total')) ?? 0}} / {{ number_format($goals[$key][$docType]) }}
                                                            </a>
                                                        </div>
                                                        <div @class([
                                                      'bg-[#e06666]' =>  (($goalPercentages[$key][$docType] <= 70) && ($goalPercentages[$key][$docType] > 0)),
                                                      'bg-[#ffd966]' => (($goalPercentages[$key][$docType] >= 70) && ($goalPercentages[$key][$docType] <= 99)),
                                                      'bg-[#93c47d]' => (($goalPercentages[$key][$docType] >= 100) && ($goalPercentages[$key][$docType] <= 119)),
                                                      'bg-[#ff50c5]' => ($goalPercentages[$key][$docType] >= 120),
                                                      'bg-[#93c47e]' => ($goals[$key][$docType] == 0),
                                                    ])>
                                                            @if($goals[$key][$docType] == 0) N/A @else {{ $goalPercentages[$key][$docType] }}% @endif
                                                        </div>
                                                    </div>
                                                @endif
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
                                <td class="py-2 px-2 text-sm text-center text-white bg-black border border-black">Identify People</td>
                                <td class="py-2 px-2 text-sm text-center text-white bg-black border border-black">Write Biographies</td>
                                <td class="py-2 px-2 text-sm text-center text-white bg-black border border-black">Identify Places</td>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr class="bg-[#cccccc]">
                                <td class="text-sm text-center text-black border border-black">Category</td>
                                <td class="text-sm text-center text-black border border-black">Steps</td>
                                <td class="text-sm text-center text-black border border-black">Actual/Goal</td>
                                <td class="text-sm text-center text-black border border-black">Actual/Goal</td>
                                <td class="text-sm text-center text-black border border-black">Actual/Goal</td>
                            </tr>
                            <tr>
                                <td rowspan="3" class="py-3.5 pr-4 pl-1 text-sm font-semibold text-left text-gray-900 border border-black">
                                    Research
                                </td>
                                <td class="py-3.5 pr-4 pl-1 text-sm font-semibold text-left text-gray-900 border border-black">
                                    Access/Organize
                                </td>
                                <td class="text-sm font-semibold text-center text-gray-900 border border-black">
                                    <div class="flex flex-col">
                                        <div>
                                            {{ number_format($subjectStats['identify_people']['actual']) }} / {{ number_format($subjectStats['identify_people']['goal']) }}
                                        </div>
                                        <div @class([
                                                      'bg-[#e06666]' =>  ($subjectStats['identify_people']['percentage'] <= 70),
                                                      'bg-[#ffd966]' => (($subjectStats['identify_people']['percentage'] >= 70) && ($subjectStats['identify_people']['percentage'] <= 99)),
                                                      'bg-[#93c47d]' => (($subjectStats['identify_people']['percentage'] >= 100) && ($subjectStats['identify_people']['percentage'] <= 119)),
                                                      'bg-[#ff50c5]' => ($subjectStats['identify_people']['percentage'] >= 120),
                                                    ])>
                                            {{ $subjectStats['identify_people']['percentage'] }}%
                                        </div>
                                    </div>
                                </td>
                                <td class="text-sm font-semibold text-center text-gray-900 border border-black">
                                    <div class="flex flex-col">
                                        <div>
                                            {{ $subjectStats['write_biographies']['actual'] }} / {{ $subjectStats['write_biographies']['goal'] }}
                                        </div>
                                        <div @class([
                                                      'bg-[#e06666]' =>  ($subjectStats['write_biographies']['percentage'] <= 70),
                                                      'bg-[#ffd966]' => (($subjectStats['write_biographies']['percentage'] >= 70) && ($subjectStats['write_biographies']['percentage'] <= 99)),
                                                      'bg-[#93c47d]' => (($subjectStats['write_biographies']['percentage'] >= 100) && ($subjectStats['write_biographies']['percentage'] <= 119)),
                                                      'bg-[#ff50c5]' => ($subjectStats['write_biographies']['percentage'] >= 120),
                                                    ])>
                                            {{ $subjectStats['write_biographies']['percentage'] }}%
                                        </div>
                                    </div>
                                </td>
                                <td class="text-sm font-semibold text-center text-gray-900 border border-black">
                                    <div class="flex flex-col">
                                        <div>
                                            {{ $subjectStats['identify_places']['actual'] }} / {{ $subjectStats['identify_places']['goal'] }}
                                        </div>
                                        <div @class([
                                                      'bg-[#e06666]' =>  ($subjectStats['identify_places']['percentage'] <= 70),
                                                      'bg-[#ffd966]' => (($subjectStats['identify_places']['percentage'] >= 70) && ($subjectStats['identify_places']['percentage'] <= 99)),
                                                      'bg-[#93c47d]' => (($subjectStats['identify_places']['percentage'] >= 100) && ($subjectStats['identify_places']['percentage'] <= 119)),
                                                      'bg-[#ff50c5]' => ($subjectStats['identify_places']['percentage'] >= 120),
                                                    ])>
                                            {{ $subjectStats['identify_places']['percentage'] }}%
                                        </div>
                                    </div>
                                </td>
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
                            <td class="text-sm text-center text-white bg-black border border-black">Color Key</td>
                            <td colspan="3" class="pl-8 text-sm">

                            </td>
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
