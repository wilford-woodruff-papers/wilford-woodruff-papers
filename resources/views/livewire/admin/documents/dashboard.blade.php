<div>
    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-2">
            <div class="pl-4 mt-8">
                <div class="flex flex-col gap-y-4">
                    <div class="pr-4 pl-2 space-y-1">
                        {{--<x-input.group inline for="filter-date-min" label="Minimum Date">
                            <x-input.date wire:model="filters.date-min" id="filter-date-min" placeholder="MM/DD/YYYY" />
                        </x-input.group>

                        <x-input.group inline for="filter-date-max" label="Maximum Date">
                            <x-input.date wire:model="filters.date-max" id="filter-date-max" placeholder="MM/DD/YYYY" />
                        </x-input.group>--}}

                        <div class="flex justify-end">
                            <x-button.link wire:click="resetFilters" class="">Reset Filters</x-button.link>
                        </div>
                    </div>
                    <div class="pr-2 space-y-4">
                        <x-input.group inline for="filter-status" label="Status">
                            <x-input.select wire:model="filters.status" id="filter-status">
                                <option value=""> -- Any Status -- </option>
                                <option value="on">Published</option>
                                <option value="off">Not Published</option>
                            </x-input.select>
                        </x-input.group>
                    </div>
                    <div class="pr-2 space-y-4">
                        <x-input.group inline for="filter-type" label="Type">
                            <x-input.select wire:model="filters.type" id="filter-type">
                                <option value=""> -- Any Type -- </option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                    @if(auth()->user()->hasAnyRole(['Super Admin']))
                        <div class="pr-2 space-y-4">
                            <x-input.group inline for="filter-needs" label="Needs Task">
                                <x-input.select wire:model="filters.needs" id="filter-needs">
                                    <option value=""> -- Task -- </option>
                                    @foreach($taskTypes as $taskType)
                                        <option value="{{ $taskType->id }}">{{ $taskType->name }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-span-10 pr-8">
            <div class="pt-2 pr-4">
                <div class="flex justify-end space-x-2">
                    <x-input.group borderless paddingless for="perPage" label="Per Page">
                        <x-input.select wire:model="perPage" id="perPage">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </x-input.select>
                    </x-input.group>

                    <x-dropdown label="Bulk Actions">
                        {{--<x-dropdown.item type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                            <x-icon.download class="text-cool-gray-400"/> <span>Export</span>
                        </x-dropdown.item>--}}
                        @foreach($taskTypes as $taskType)
                            <x-dropdown.item type="button" wire:click="addTasksInBulk({{ $taskType->id }})" class="flex items-center space-x-2">
                                {{--<x-icon.trash class="text-cool-gray-400"/>--}} <span>Add {{ $taskType->name }} Task</span>
                            </x-dropdown.item>
                        @endforeach

                    </x-dropdown>

                    {{--<livewire:import-transactions />--}}

                    @if(auth()->user()->hasAnyRole(['Super Admin']))
                        <a href="{{ route('admin.dashboard.document.create') }}"
                           class="py-2 px-4 text-white bg-indigo-600 border-indigo-600 hover:bg-indigo-500 active:bg-indigo-700"
                        ><x-icon.plus/> New</a>
                    @endif
                </div>
            </div>
            <div class="px-4 pt-2 pb-6">
                <div>
                    <label for="search" class="block text-sm font-medium leading-6 text-gray-900 sr-only">Search</label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  class="w-5 h-5 text-gray-400" >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <input wire:model.debounce.400="filters.search"
                               type="search"
                               name="search"
                               id="search"
                               class="block py-1.5 pl-10 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary" placeholder="Search documents...">
                    </div>
                </div>
                <div class="flex gap-4 justify-end mt-8 -mb-16">
                    <div class="flex justify-center items-center py-1.5 px-2.5 text-xs font-medium text-gray-700 whitespace-nowrap bg-white rounded border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
                        Not Yet Available
                    </div>
                    <div class="flex justify-center items-center py-1.5 px-2.5 text-xs font-medium text-white whitespace-nowrap bg-gray-500 rounded border border-gray-300 shadow-sm hover:bg-gray-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
                        Not Claimed
                    </div>
                    <div class="flex justify-center items-center py-1.5 px-2.5 text-xs font-medium text-white whitespace-nowrap bg-red-400 rounded border border-gray-300 shadow-sm hover:bg-red-600 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
                        Claimed
                    </div>
                    <div class="flex justify-center items-center py-1.5 px-2.5 text-xs font-medium text-white whitespace-nowrap bg-green-400 rounded border border-gray-300 shadow-sm hover:bg-green-600 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
                        Completed
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <x-admin.quotes.table>
                    <x-slot name="head">
                        <x-admin.quotes.heading>Published</x-admin.quotes.heading>
                        <x-admin.quotes.heading sortable multi-column wire:click="sortBy('pcf_unique_id')" :direction="$sorts['name'] ?? null" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">ID</x-admin.quotes.heading>
                        <x-admin.quotes.heading class="pr-0 w-8">
                            <x-input.checkbox wire:model="selectPage" />
                        </x-admin.quotes.heading>
                        <x-admin.quotes.heading sortable multi-column wire:click="sortBy('name')" :direction="$sorts['name'] ?? null" class="w-full">Name</x-admin.quotes.heading>
                        <x-admin.quotes.heading sortable multi-column wire:click="sortBy('amount')" :direction="$sorts['amount'] ?? null"></x-admin.quotes.heading>
                        <x-admin.quotes.heading sortable multi-column wire:click="sortBy('status')" :direction="$sorts['status'] ?? null"></x-admin.quotes.heading>
                        <x-admin.quotes.heading sortable multi-column wire:click="sortBy('date')" :direction="$sorts['date'] ?? null"></x-admin.quotes.heading>

                        <x-admin.quotes.heading />
                        {{--<x-admin.quotes.heading />--}}
                    </x-slot>

                    <x-slot name="body">
                        @if ($selectPage)
                            <x-admin.quotes.row class="bg-cool-gray-200" wire:key="row-message">
                                <x-admin.quotes.cell colspan="6">
                                    @unless ($selectAll)
                                        <div>
                                            <span>You have selected <strong>{{ $items->count() }}</strong> quotes, do you want to select all <strong>{{ $items->total() }}</strong>?</span>
                                            <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                                        </div>
                                    @else
                                        <span>You are currently selecting all <strong>{{ $items->total() }}</strong> items.</span>
                                    @endif
                                </x-admin.quotes.cell>
                            </x-admin.quotes.row>
                        @endif

                        @forelse ($items as $item)
                            <x-admin.quotes.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $item->id }}">
                                <x-admin.quotes.cell class="bg-gray-50">
                                    <x-icon.status :status="$item->enabled" />
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="bg-gray-50">
                                <span href="#" class="inline-flex space-x-2 text-sm leading-5 truncate">
                                    {{ $item->pcf_unique_id_full }}
                                </span>
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="pr-0 bg-gray-50">
                                    <x-input.checkbox wire:model="selected" value="{{ $item->id }}" />
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="bg-gray-50">
                                <span href="#" class="inline-flex space-x-2 text-sm leading-5 truncate">
                                    {{--<x-icon.cash class="text-cool-gray-400"/>--}}

                                    <p class="text-cool-gray-600 truncate">
                                        <a class="font-medium text-indigo-600"
                                           href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
                                           target="_blank">
                                            {{ $item->name }}
                                        </a>
                                        <br />
                                        <span class="text-cool-gray-900">{{ str($item->type?->name)->singular() }} </span>
                                    </p>
                                </span>
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="bg-gray-50">
                                    <span class="font-medium text-cool-gray-900"></span>
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="bg-gray-50">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-{{ $item->status_color }}-100 text-{{ $item->status_color }}-800 capitalize">
                                        {{ $item->status }}
                                    </span>
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="bg-gray-50">

                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="bg-gray-50">
                                    @if($item->items->count() < 1)
                                        <div class="grid grid-flow-col auto-cols-max gap-x-4 items-center">
                                            <div class="grid grid-cols-3 gap-2">
                                                @foreach($taskTypes as $taskType)
                                                    @if(empty($taskType->action_type_id)
                                                        || (! empty($taskType->action_type_id) && $item->completed_actions->contains('action_type_id', $taskType->action_type_id))
                                                    )
                                                        <button wire:click="addTasks({{ $item->id }}, {{ $taskType->id }})"
                                                                wire:loading.attr="disabled"
                                                            @class([
            "flex items-center justify-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap",
                                                            'text-gray-700 bg-white hover:bg-gray-50' => ! $item->actions->where('action_type_id', $taskType->id)->count(),
                                                            'text-white bg-gray-500 hover:bg-gray-700' => $item->actions->where('action_type_id', $taskType->id)->whereNull('assigned_at')->whereNull('completed_at')->count(),
                                                            'text-white bg-red-400 hover:bg-red-600' => $item->actions->where('action_type_id', $taskType->id)->whereNotNull('assigned_at')->whereNull('completed_at')->count(),
                                                            'text-white bg-green-400 hover:bg-green-600' => $item->actions->where('action_type_id', $taskType->id)->whereNotNull('assigned_at')->whereNotNull('completed_at')->count(),
            ])>
                                                            {{ $taskType->name }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex justify-end">
                                            <button x-on:click="open = {{ $item->id }}"
                                                    title="Click to expand pages"
                                                    x-show="open != {{ $item->id }}"
                                                    class="flex gap-x-2 items-center py-1.5 px-2.5 text-xs font-medium text-gray-700 whitespace-nowrap bg-white rounded border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Show Sections
                                            </button>
                                            <button x-on:click="open = null"
                                                    title="Click to hide pages"
                                                    x-show="open == {{ $item->id }}"
                                                    x-cloak
                                                    class="flex gap-x-2 items-center py-1.5 px-2.5 text-xs font-medium text-gray-700 whitespace-nowrap bg-white rounded border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Hide Sections
                                            </button>
                                        </div>
                                    @endif
                                </x-admin.quotes.cell>

                                {{--<x-admin.quotes.cell>
                                    --}}{{--<x-button.link wire:click="edit({{ $item->id }})">Edit</x-button.link>--}}{{--
                                    <a class="text-indigo-600"
                                       href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
                                       target="_blank">View</a>
                                </x-admin.quotes.cell>--}}
                            </x-admin.quotes.row>
                            @forelse($item->items as $section)
                                <x-admin.quotes.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $section->id }}"
                                                    x-show="open == {{ $item->id }}"
                                                    x-cloak>
                                    <x-admin.quotes.cell>
                                        <x-icon.status :status="$section->enabled" />
                                    </x-admin.quotes.cell>

                                    <x-admin.quotes.cell class="pr-0">
                                        <x-input.checkbox wire:model="selected" value="{{ $section->id }}" />
                                    </x-admin.quotes.cell>

                                    <x-admin.quotes.cell>
                                    <span href="#" class="inline-flex space-x-2 text-sm leading-5 truncate">
                                        {{--<x-icon.cash class="text-cool-gray-400"/>--}}

                                        <p class="text-cool-gray-600 truncate">
                                            <a class="font-medium text-indigo-600"
                                               href="{{ route('admin.dashboard.document', ['item' => $section]) }}"
                                               target="_blank">
                                                {{ $section->name }}
                                            </a>
                                            <br />
                                            <span class="text-cool-gray-900">{{ str($section->type?->name)->singular() }} </span>
                                        </p>
                                    </span>
                                    </x-admin.quotes.cell>

                                    <x-admin.quotes.cell>
                                        <span class="font-medium text-cool-gray-900"></span>
                                    </x-admin.quotes.cell>

                                    <x-admin.quotes.cell>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-{{ $section->status_color }}-100 text-{{ $section->status_color }}-800 capitalize">
                                        {{ $section->status }}
                                    </span>
                                    </x-admin.quotes.cell>

                                    <x-admin.quotes.cell>

                                    </x-admin.quotes.cell>

                                    <x-admin.quotes.cell>
                                        <div class="grid grid-flow-col auto-cols-max gap-x-4 items-center">
                                            <div class="grid grid-cols-3 gap-2">
                                                @foreach($taskTypes as $taskType)
                                                    @if(empty($taskType->action_type_id)
                                                        || (! empty($taskType->action_type_id) && $section->completed_actions->contains('action_type_id', $taskType->action_type_id))
                                                    )
                                                        <button wire:click="addTasks({{ $section->id }}, {{ $taskType->id }})"
                                                            @class([
            "flex items-center justify-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap",
                                                            'text-gray-700 bg-white hover:bg-gray-50' => ! $section->actions->where('action_type_id', $taskType->id)->count(),
                                                            'text-white bg-gray-500 hover:bg-gray-700' => $section->actions->where('action_type_id', $taskType->id)->whereNull('assigned_at')->whereNull('completed_at')->count(),
                                                            'text-white bg-red-400 hover:bg-red-600' => $section->actions->where('action_type_id', $taskType->id)->whereNotNull('assigned_at')->whereNull('completed_at')->count(),
                                                            'text-white bg-green-400 hover:bg-green-600' => $section->actions->where('action_type_id', $taskType->id)->whereNotNull('assigned_at')->whereNotNull('completed_at')->count(),
            ])>
                                                            {{ $taskType->name }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </x-admin.quotes.cell>

                                    {{--<x-admin.quotes.cell>
                                        --}}{{--<x-button.link wire:click="edit({{ $item->id }})">Edit</x-button.link>--}}{{--
                                        <a class="text-indigo-600"
                                           href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
                                           target="_blank">View</a>
                                    </x-admin.quotes.cell>--}}
                                </x-admin.quotes.row>
                            @empty

                            @endforelse
                        @empty
                            <x-admin.quotes.row>
                                <x-admin.quotes.cell colspan="6">
                                    <div class="flex justify-center items-center space-x-2">
                                        {{--<x-icon.inbox class="w-8 h-8 text-cool-gray-400" />--}}
                                        <span class="py-8 text-xl font-medium text-cool-gray-400">No quotes found...</span>
                                    </div>
                                </x-admin.quotes.cell>
                            </x-admin.quotes.row>
                        @endforelse
                    </x-slot>
                </x-admin.quotes.table>

                <div>
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
