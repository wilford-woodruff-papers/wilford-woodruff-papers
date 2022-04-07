<x-admin-layout>

    <div class="mt-4 max-w-7xl mx-auto">

        <div class="">

            <div class="px-4 sm:px-6 lg:px-8">
                <div class="mt-8 flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Tasks</th>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach($items as $item)
                                            <tr class="border-t border-gray-200">
                                                <th colspan="2" scope="colgroup" class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                                    <a href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
                                                       class="font-medium text-indigo-600 capitalize"
                                                    >
                                                        {{ $item->name }}
                                                    </a>
                                                </th>
                                                <th class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                                    Assigned
                                                </th>
                                            </tr>
                                            @forelse($item->pending_page_actions->groupBy('actionable_id') as $pageActions)
                                                <tr class="border-t border-gray-300">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-12">
                                                        <a href="{{ route('admin.dashboard.page', ['item' => $item, 'page' => $pageActions->first()->actionable]) }}"
                                                           class="font-medium text-indigo-600 capitalize"
                                                        >
                                                            Page {{ $pageActions->first()->actionable->order }}
                                                        </a>
                                                    </td>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                        {{ $pageActions->pluck('description')->join(' | ') }}
                                                    </td>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                        {{ $pageActions->first()->assigned_at->tz('America/Denver')->toDayDateTimeString() }}
                                                    </td>
                                                </tr>
                                            @empty

                                            @endforelse
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</x-admin-layout>
