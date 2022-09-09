<div>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="flex space-x-4">
                <x-input.text wire:model="filters.search" class="w-80" placeholder="Search Documents..." />

                <x-button.link wire:click="toggleShowFilters">@if ($showFilters) Hide @endif Advanced Search</x-button.link>
            </div>

            <div class="space-x-2 flex items-center">
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
                    </x-dropdown.item>

                    <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')" class="flex items-center space-x-2">
                        <x-icon.trash class="text-cool-gray-400"/> <span>Delete</span>
                    </x-dropdown.item>--}}
                </x-dropdown>

                {{--<livewire:import-transactions />--}}

                <x-button.primary wire:click="create"><x-icon.plus/> New</x-button.primary>
            </div>
        </div>

        <!-- Advanced Search -->
        <div>
            @if ($showFilters)
                <div class="bg-cool-gray-200 p-4 rounded shadow-inner flex relative">
                    <div class="w-1/2 pr-2 space-y-4">
                        <x-input.group inline for="filter-status" label="Status">
                            <x-input.select wire:model="filters.status" id="filter-status">
                                <option value=""> -- Any Status -- </option>
                                <option value="on">Enabled</option>
                                <option value="off">Disabled</option>
                            </x-input.select>
                        </x-input.group>
                    </div>
                    <div class="w-1/2 pr-2 space-y-4">
                        <x-input.group inline for="filter-type" label="Type">
                            <x-input.select wire:model="filters.type" id="filter-type">
                                <option value=""> -- Any Type -- </option>
                                @foreach (App\Models\Type::whereNull('type_id')->orderBy('name')->get() as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>

                    <div class="w-1/2 pl-2 space-y-4">
                        {{--<x-input.group inline for="filter-date-min" label="Minimum Date">
                            <x-input.date wire:model="filters.date-min" id="filter-date-min" placeholder="MM/DD/YYYY" />
                        </x-input.group>

                        <x-input.group inline for="filter-date-max" label="Maximum Date">
                            <x-input.date wire:model="filters.date-max" id="filter-date-max" placeholder="MM/DD/YYYY" />
                        </x-input.group>--}}

                        <div class="flex justify-end">
                            <x-button.link wire:click="resetFilters" class="p-4">Reset Filters</x-button.link>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="space-y-4">
            <x-admin.quotes.table>
                <x-slot name="head">
                    <x-admin.quotes.heading></x-admin.quotes.heading>
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

                            <x-admin.quotes.cell class="bg-gray-50 pr-0">
                                <x-input.checkbox wire:model="selected" value="{{ $item->id }}" />
                            </x-admin.quotes.cell>

                            <x-admin.quotes.cell class="bg-gray-50">
                                <span href="#" class="inline-flex space-x-2 truncate text-sm leading-5">
                                    {{--<x-icon.cash class="text-cool-gray-400"/>--}}

                                    <p class="text-cool-gray-600 truncate">
                                        <a class="text-indigo-600 font-medium"
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
                                <span class="text-cool-gray-900 font-medium"></span>
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
                                    <div class="grid grid-flow-col auto-cols-max items-center gap-x-4">
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
                                                class="flex items-center  gap-x-2 px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap text-gray-700 bg-white hover:bg-gray-50"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Show Sections
                                        </button>
                                        <button x-on:click="open = null"
                                                title="Click to hide pages"
                                                x-show="open == {{ $item->id }}"
                                                x-cloak
                                                class="flex items-center gap-x-2 px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap text-gray-700 bg-white hover:bg-gray-50"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                    <span href="#" class="inline-flex space-x-2 truncate text-sm leading-5">
                                        {{--<x-icon.cash class="text-cool-gray-400"/>--}}

                                        <p class="text-cool-gray-600 truncate">
                                            <a class="text-indigo-600 font-medium"
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
                                    <span class="text-cool-gray-900 font-medium"></span>
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-{{ $section->status_color }}-100 text-{{ $section->status_color }}-800 capitalize">
                                        {{ $section->status }}
                                    </span>
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell>

                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell>
                                    <div class="grid grid-flow-col auto-cols-max items-center gap-x-4">
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
                                    {{--<x-icon.inbox class="h-8 w-8 text-cool-gray-400" />--}}
                                    <span class="font-medium py-8 text-cool-gray-400 text-xl">No quotes found...</span>
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
