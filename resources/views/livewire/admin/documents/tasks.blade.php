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
                        <div class="overflow-hidden bg-white shadow sm:rounded-md">
                            <ul role="list" class="divide-y divide-gray-200">
                                @foreach($assignedItems as $item)
                                    <li>
                                        <livewire:admin.documents.task :item="$item" :wire:key="'item-'.$item->id" />
                                    </li>
                                @endforeach
                            </ul>
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

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($unassignedItems->count() > 0 || ($unassignedItems->count() < 1 && ! empty($type)))
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
                                    <x-admin.quotes.heading sortable multi-column wire:click="applySort('pcf_unique_id', '{{ $sortDirection }}')" :direction="$sortBy == 'pcf_unique_id' ? $sortDirection : null" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID</x-admin.quotes.heading>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        <select wire:model="type">
                                            @foreach(\App\Models\Type::query()->orderBy('name')->get() as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </th>
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
                                            {{ $item->pcf_unique_id }}
                                        </th>
                                        <th class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                            {{ str($item->type->name)->singular() }}
                                        </th>
                                        <th class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
                                            <a href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
                                               class="font-medium text-indigo-600 capitalize"
                                            >
                                                {{ $item->name }}
                                            </a>
                                            <span class="font-normal">
                                                ({{ $item->pages_count }} Pages)
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
