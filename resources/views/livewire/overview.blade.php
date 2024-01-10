<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flow-root mt-8">
            <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                <div class="block py-2 w-full align-middle sm:px-6 lg:px-8">
                    <table class="w-full">
                        <thead class="bg-white">
                            <th scope="col"
                                class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-3">
                                Task
                            </th>
                            @foreach($statuses as $status)
                                <th scope="col"
                                    class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900">
                                    {{ $status }}
                                </th>
                            @endforeach
                        </thead>
                        <tbody class="bg-white">
                            @foreach($typesMap as $docKey => $docType)
                                <tr class="border-t border-gray-200">
                                    <th colspan="5"
                                        scope="colgroup"
                                        class="py-2 pr-3 pl-4 text-base font-semibold text-left text-gray-900 bg-gray-50 sm:pl-3">
                                        {{ $docKey }}
                                    </th>
                                </tr>
                                @foreach($types as $type)
                                    <tr class="border-t border-gray-300">
                                        <td class="py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-3">
                                            {{ $type->name }}
                                        </td>
                                        @foreach($statuses as $status)
                                            <td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap">
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
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
