<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8">
            <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                @foreach($typesMap as $docKey => $docType)
                    <div class="block py-2 w-full align-middle sm:px-6 lg:px-8">
                        <table class="relative w-full">
                            <thead class="bg-white">
                                <tr class="border-gray-200 border-y">
                                    <th colspan="7"
                                        scope="colgroup"
                                        class="py-3 pr-3 pl-4 text-xl font-semibold text-left text-gray-900 bg-white sm:pl-3">
                                        {{ $docKey }} <span class="text-base font-normal">({{ Number::format($totalPages[$docKey]) }})</span>
                                    </th>
                                </tr>
                                <tr class="bg-gray-50">
                                    <th scope="col"
                                        class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-3">
                                        Task
                                    </th>
                                    @foreach($statuses as $status)
                                        <th scope="col"
                                            class="py-3.5 px-3 text-left">
                                            <span class="text-sm font-semibold text-gray-900">{{ $status }}</span> @if($status == 'In Progress') / <span class="text-xs text-red-700 hover:text-red-900">(Overdue)</span> @endif
                                        </th>
                                    @endforeach
                                    <th scope="col"
                                        class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900">
                                        Total Remaining
                                    </th>
                                    <th  scope="col"
                                         class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900">
                                    </th>
                                </tr>

                            </thead>
                            <tbody class="bg-white">

                                    @foreach($types as $type)
                                        <tr class="border-t border-gray-300">
                                            <td class="py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-3">
                                                {{ $type->name }}
                                            </td>
                                            @foreach($statuses as $statusKey => $status)
                                                <td class="py-4 px-3 text-lg text-gray-500 whitespace-nowrap">
                                                    @if($status == 'Not Started')
                                                        <a href="{{ \App\Filament\Resources\PageResource::getUrl() }}?{{ collect([
                                                            'tableFilters[not_started][tasks_not_started][0]='.$type->id,
                                                            collect($docTypes->whereIn('name', $typesMap[$docKey])->all())->map(function($item, $key){
                                                                return 'tableFilters[document_type][values]['.$key.']='.$item->id;
                                                            })->join('&'),
                                                        ])->join('&') }}"
                                                           target="_blank"
                                                           class="text-primary-600 hover:text-primary-900"
                                                        >
                                                            {{ Number::format($stats[$docKey][$type->name][$status]) }}
                                                        </a>
                                                    @else
                                                        <a href="{{ \App\Filament\Resources\TaskReportingResource::getUrl() }}?{{ collect([
                                                            '&activeTab='.$statusMap[$status],
                                                            'tableFilters[task_type][value]='.$type->id,
                                                            collect($docTypes->whereIn('name', $typesMap[$docKey])->all())->map(function($item, $key){
                                                                return 'tableFilters[document_type][values]['.$key.']='.$item->id;
                                                            })->join('&'),
                                                        ])->join('&') }}"
                                                           target="_blank"
                                                           class="text-primary-600 hover:text-primary-900"
                                                        >
                                                            {{ Number::format($stats[$docKey][$type->name][$status]) }}

                                                        </a>
                                                        @if($status == 'In Progress' && $stats[$docKey][$type->name]['Overdue'] > 0)
                                                            <span class="text-xs">/ (</span><a href="{{ \App\Filament\Resources\TaskReportingResource::getUrl() }}?{{ collect([
                                                                '&activeTab='.$statusMap['Overdue'],
                                                                'tableFilters[task_type][value]='.$type->id,
                                                                collect($docTypes->whereIn('name', $typesMap[$docKey])->all())->map(function($item, $key){
                                                                    return 'tableFilters[document_type][values]['.$key.']='.$item->id;
                                                                })->join('&'),
                                                            ])->join('&') }}"
                                                                   target="_blank"
                                                                   class="text-xs text-red-700 hover:text-red-900"
                                                            >{{ Number::format($stats[$docKey][$type->name]['Overdue']) }}</a><span class="text-xs">)</span>
                                                        @endif

                                                    @endif
                                                </td>
                                            @endforeach

                                            <td class="py-4 px-3 text-lg text-gray-500 whitespace-nowrap">
                                                {{ Number::format($totalPages[$docKey] - $stats[$docKey][$type->name]['Completed']) }}
                                            </td>

                                            @if($type->name == 'Transcription')
                                                <td rowspan="4" class="px-4 text-lg text-gray-500 whitespace-nowrap" style="max-width: 250px;">
                                                    @livewire(\App\Filament\Pages\Widgets\PageOverviewChart::class, ['statuses' => $publishingStatus[$docKey]])
                                                </td>
                                                {{--<td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap"></td>--}}
                                            @elseif(in_array($type->name, ['Verification','Subject Tagging','Date Tagging']))
                                            @else
                                                <td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap"></td>
                                            @endif
                                        </tr>
                                    @endforeach

                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
