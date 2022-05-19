<div>

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table x-data="{
                                open: null
                            }"
                               class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th></th>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Tasks</th>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"></th>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Assigned</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($assignedItems as $item)
                                <tr
                                    id="assigned_item_{{ $item->id }}"
                                    class="border-t border-gray-200">
                                    <th>
                                        @if($item->pending_page_actions->count() > 0)
                                            <div class="flex items-center justify-center">
                                                <button x-on:click="open = {{ $item->id }}"
                                                        title="Click to expand pages">
                                                    <svg x-show="open != {{ $item->id }}" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                                <button x-on:click="open = null"
                                                        title="Click to hide pages">
                                                    <svg x-show="open == {{ $item->id }}" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </th>
                                    <th colspan="2" scope="colgroup" class="flex items-center bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                        <a href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
                                           class="font-medium text-indigo-600 capitalize"
                                        >
                                            {{ $item->name }}
                                        </a>
                                    </th>
                                    <th class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                        @foreach($item->pending_actions as $action)
                                            <button wire:click="markActionComplete({{ $action->id }})"
                                                    class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap"
                                                    title="Mark complete"
                                            >
                                                {{ $action->type->name }}
                                            </button>
                                        @endforeach
                                    </th>
                                    <th class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                        {{ $item->pending_actions->first()->assigned_at->tz('America/Denver')->toDayDateTimeString() }}
                                    </th>
                                </tr>
                                @forelse($item->pending_page_actions->groupBy('actionable_id') as $pageActions)
                                    <tr x-show="open == {{ $item->id }}"
                                        x-cloak
                                        class="border-t border-gray-300">
                                        <td></td>
                                        <td id="assigned_page_{{ $pageActions->first()->actionable->id }}"
                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-12">
                                            <a href="{{ route('admin.dashboard.page', ['item' => $item, 'page' => $pageActions->first()->actionable]) }}"
                                               class="font-medium text-indigo-600 capitalize"
                                            >
                                                Page {{ $pageActions->first()->actionable->order }}
                                            </a>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            @foreach($pageActions as $action)
                                                <button wire:click="markActionComplete({{ $action->id }})"
                                                        class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap"
                                                        title="Mark complete"
                                                >
                                                    {{ $action->type->name }}
                                                </button>
                                            @endforeach
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


    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Available Tasks</th>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"></th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($unassignedItems as $item)
                                <tr id="unassigned_item_{{ $item->id }}"
                                    class="border-t border-gray-200">
                                    <th class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                        <a href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
                                           class="font-medium text-indigo-600 capitalize"
                                        >
                                            {{ $item->name }}
                                        </a>
                                    </th>
                                    <th class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                        @foreach($item->unassigned_actions as $action)
                                            <button wire:click="claimItemAction({{ $action->id }})"
                                                    class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap">
                                                {{ $action->type->name }}
                                            </button>
                                        @endforeach
                                    </th>
                                </tr>
                                {{--@forelse($item->pending_page_actions->groupBy('actionable_id') as $pageActions)
                                    <tr id="page_action_{{ $item->id }}"
                                        class="border-t border-gray-300">
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

                                @endforelse--}}
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
