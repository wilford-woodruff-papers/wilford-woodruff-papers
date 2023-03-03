<div x-data="{
    actionType: @entangle('actionType'),
    type: @entangle('type')
}">
    @if($assignedItems->count())
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="pt-4 sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">Your Assigned Tasks</h1>
                </div>
            </div>
            <div class="flex flex-col mt-8">
                <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden bg-white shadow sm:rounded-md">
                            <ul role="list" class="divide-y divide-gray-200">
                                @foreach($assignedItems as $item)
                                    @if(! empty($item->pcf_unique_id))
                                        <li>
                                            <livewire:admin.documents.task :item="$item" :wire:key="'item-'.$item->id" />
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            {{--<table x-data="{
                                    open: $persist(null)
                                }"
                                   class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th></th>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">Document</th>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">Pending Task(s)</th>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">Date Claimed</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">

                                </tbody>
                            </table>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if( ($unassignedItems->count() > 0 || ($unassignedItems->count() < 1)
         && (! empty($type)) || ($unassignedItems->count() < 1)
         && (! empty($actionType)) || ($unassignedItems->count() < 1)
         && (! empty($search)))
    )
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="pt-16 sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">Available Tasks</h1>
                </div>
            </div>
            <div class="">
                <div class="pt-4 sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <input wire:model="search"
                               placeholder="Search..."
                               type="search"
                               class="block flex-1 w-80 w-full border-cool-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 form-input"
                        />
                    </div>
                </div>
            </div>
            <div class="flex flex-col mt-4">
                <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden ring-1 ring-black ring-opacity-5 shadow md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6"></th>
                                    <x-admin.quotes.heading sortable multi-column wire:click="applySort('pcf_unique_id', '{{ $sortDirection }}')" :direction="$sortBy == 'pcf_unique_id' ? $sortDirection : null" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">ID</x-admin.quotes.heading>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">
                                        <select wire:model="type" class="text-sm">
                                            <option value="">-- Select Document Type --</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">Document</th>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6"></th>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">
                                        <select wire:model="actionType" class="text-sm">
                                            <option value="">-- Select Task Type --</option>
                                            @foreach($actionTypes as $actionType)
                                                <option value="{{ $actionType->id }}">{{ $actionType->name }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class.delay="opacity-50"
                                       class="bg-white divide-y divide-gray-200">
                                @foreach($unassignedItems as $item)
                                    <tr id="unassigned_item_{{ $item->id }}"
                                        class="border-t border-gray-200">
                                        <x-admin.quotes.cell class="bg-gray-50">
                                            <x-icon.status :status="$item->enabled" />
                                        </x-admin.quotes.cell>
                                        <th class="py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                            <span href="#" class="inline-flex space-x-2 text-sm leading-5 truncate">
                                                {{ $item->pcf_unique_id_full }}
                                            </span>
                                        </th>
                                        <th class="py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                            {{ str($item->type->name)->singular() }}
                                        </th>
                                        <th class="py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                            <a href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
                                               class="font-medium text-indigo-600 capitalize"
                                            >
                                                {{ $item->name }}
                                            </a>
                                            <span class="font-normal">
                                                ({{ $item->pages_count }} Pages)
                                            </span>
                                        </th>
                                        <th class="py-2 px-4 text-sm text-left text-gray-900 bg-gray-50 sm:px-6">

                                        </th>
                                        <th class="py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                            @foreach($item->unassigned_actions as $action)
                                                @if(empty($action->type->action_type_id) || in_array($action->type->action_type_id, $item->completed_actions->pluck('type.id')->all()) )
                                                    @if(auth()->user()->hasRole($action->type->roles->pluck('name')->all()))
                                                        <button wire:click="claimItemAction({{ $action->id }})"
                                                                class="inline-flex items-center py-1.5 px-2.5 text-xs font-medium text-gray-700 whitespace-nowrap bg-white rounded border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
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
                                            <td class="py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-12">
                                                <a href="{{ route('admin.dashboard.page', ['item' => $item, 'page' => $pageActions->first()->actionable]) }}"
                                                   class="font-medium text-indigo-600 capitalize"
                                                >
                                                    Page {{ $pageActions->first()->actionable->order }}
                                                </a>
                                            </td>
                                            <td class="py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                {{ $pageActions->pluck('description')->join(' | ') }}
                                            </td>
                                            <td class="py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
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
                {!! $unassignedItems->links() !!}
            </div>
        </div>
    @endif

    @push('scripts')
        <script>
            Livewire.on('scroll-to-top', postId => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        </script>
    @endpush
</div>
