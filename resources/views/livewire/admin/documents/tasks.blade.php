<div>
    @if($assignedItems->count())
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="pt-4 sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">Your Assigned Tasks</h1>
                </div>
            </div>
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table x-data="{
                                    open: $persist(null)
                                }"
                                   class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th></th>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Document</th>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Pending Task(s)</th>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Date Claimed</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($assignedItems as $item)
                                    <tr
                                        id="assigned_item_{{ $item->id }}"
                                        class="border-t border-gray-200">
                                        <th class="bg-gray-50">
                                            @if($item->pending_page_actions->count() > 0)
                                                <div class="flex items-center justify-center">
                                                    <button x-on:click="open = {{ $item->id }}"
                                                            title="Click to expand pages"
                                                            x-show="open != {{ $item->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                    <button x-on:click="open = null"
                                                            title="Click to hide pages"
                                                            x-show="open == {{ $item->id }}" x-cloak>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif
                                        </th>
                                        <th scope="colgroup" class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                            <a href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
                                               class="font-medium text-indigo-600 capitalize"
                                            >
                                                {{ $item->name }}
                                            </a>
                                        </th>
                                        <th class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                            @foreach($item->pending_actions as $action)
                                                @if($item->pending_page_actions->doesntContain('action_type_id', $action->action_type_id))
                                                    <button wire:click="markActionComplete({{ $action->id }})"
                                                            class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap"
                                                            title="Mark complete"
                                                    >
                                                        {{ $action->type->name }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </th>
                                        <th class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                            {{ $item->pending_actions->first()?->assigned_at?->tz('America/Denver')?->toDayDateTimeString() }}
                                        </th>
                                    </tr>
                                    @forelse($item->page_actions->groupBy('actionable_id') as $pageActions)
                                        <tr x-show="open == {{ $item->id }}"
                                            x-cloak
                                            class="border-t border-gray-300">
                                            <td></td>
                                            <td id="assigned_page_{{ $pageActions->first()->actionable->id }}"
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-12">
                                                <div>
                                                    <a href="{{ route('admin.dashboard.page', ['item' => $item, 'page' => $pageActions->first()->actionable]) }}"
                                                       class="font-medium text-indigo-600 capitalize"
                                                    >
                                                        Page {{ $pageActions->first()->actionable->order }}
                                                    </a>
                                                </div>
                                                <div class="pt-2 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
                                                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                                      <a href="{{ route('pages.show', ['item' => $item, 'page' => $pageActions->first()->actionable]) }}" class="relative inline-flex items-center px-2 py-1 rounded-l-md border border-gray-300 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" target="_blank">Website</a>
                                                      <a href="{{ $pageActions->first()->actionable->ftp_link }}" class="-ml-px relative inline-flex items-center px-2 py-1 border border-gray-300 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" target="_blank">FTP</a>
                                                        @hasanyrole('Admin|Super Admin')
                                                            <a href="/nova/resources/pages/{{ $pageActions->first()->actionable->id }}" class="-ml-px relative inline-flex items-center px-2 py-1 rounded-r-md border border-gray-300 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" target="_blank">Nova</a>
                                                        @endhasanyrole
                                                    </span>
                                                </div>

                                            </td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                @foreach($pageActions->whereNull('completed_at') as $action)
                                                    @if($action->assigned_to == auth()->id())
                                                        <button wire:click="markActionComplete({{ $action->id }})"
                                                                class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap"
                                                                title="Mark complete"
                                                        >
                                                            {{ $action->type->name }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                {{--{{ $pageActions->first()->assigned_at->tz('America/Denver')->toDayDateTimeString() }}--}}
                                                <div>
                                                    @foreach($pageActions->first()->actionable->completed_actions as $a)
                                                        <div class="grid grid-cols-9 items-center gap-x-2">
                                                            <div class="col-span-2 font-semibold">
                                                                {{ $a->type->name }}
                                                            </div>
                                                            <div class="col-span-3">
                                                                {{ $a->completed_at->tz('America/Denver')->toDayDateTimeString() }}
                                                            </div>
                                                            <div class="col-span-2">
                                                                {{ $a->finisher->name }}
                                                            </div>
                                                            <div class="col-span-1">
                                                                @if($a->finisher->id == auth()->id() || auth()->user()->hasAnyRole($a->type->roles))
                                                                    <button wire:click="markActionInComplete({{ $a->id }})"
                                                                            type="button" class="inline-flex items-center px-2 py-1 my-2 gap-x-2 border border-transparent shadow-sm text-xs leading-4 font-semibold rounded-full text-white bg-red-700 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700">
                                                                        <!-- Heroicon name: solid/x -->
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
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
    @endif

    @if($unassignedItems->count())
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="pt-16 sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">Available Tasks</h1>
                </div>
            </div>
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Document</th>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"></th>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Available Task(s)</th>
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
                                            <span class="font-normal">
                                                ({{ $item->pages->count() }} Pages)
                                            </span>
                                        </th>
                                        <th class="bg-gray-50 px-4 py-2 text-left text-sm text-gray-900 sm:px-6">

                                        </th>
                                        <th class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                            @foreach($item->unassigned_actions as $action)
                                                @if(empty($action->type->action_type_id) || in_array($action->type->action_type_id, $item->completed_actions->pluck('type.id')->all()) )
                                                    @if(auth()->user()->hasRole($action->type->roles->pluck('name')->all()))
                                                        <button wire:click="claimItemAction({{ $action->id }})"
                                                                class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap">
                                                            {{ $action->type->name }}
                                                        </button>
                                                    @endif
                                                @endif
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
            <div class="my-4">
                {{ $unassignedItems->links() }}
            </div>
        </div>
    @endif
</div>
