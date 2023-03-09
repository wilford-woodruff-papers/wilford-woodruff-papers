<div x-data="{
            shadow: false
        }">
    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-12 pr-8">
            <div class="pt-2 pr-4">
                <div class="grid grid-cols-5 gap-x-2 justify-between py-2">
                    <div class="col-span-3 px-4 w-full">
                        <div class="w-full">
                            <label for="search" class="block text-sm font-medium leading-6 text-gray-900 sr-only">Search</label>
                            <div class="relative w-full rounded-md shadow-sm">
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
                    </div>

                    <div class="col-span-2">
                        <div class="flex justify-end items-center">
                            <div>
                                <x-input.group borderless paddingless
                                               for="perPage"
                                               label="Per Page"
                                >
                                    <x-input.select wire:model="perPage" id="perPage">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </x-input.select>
                                </x-input.group>
                            </div>

                            <div>
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
                            </div>



                            {{--<livewire:import-transactions />--}}

                            @if(auth()->user()->hasAnyRole(['Super Admin']))
                                <div class="py-2">
                                    <a href="{{ route('admin.dashboard.document.create') }}"
                                       class="py-2 px-4 text-white bg-indigo-600 border-indigo-600 hover:bg-indigo-500 active:bg-indigo-700"
                                    ><x-icon.plus/> New</a>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <div class="pl-4">
                <div class="flex gap-x-4 gap-y-4 items-center">
                    <div class="pr-2 space-y-4">
                        <x-input.group borderless for="filter-type" label="Type">
                            <x-input.select wire:model="filters.type" id="filter-type">
                                <option value=""> -- Any Type -- </option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                    <div class="pr-2">
                        <x-input.group borderless for="filter-status" label="Status">
                            <x-input.select wire:model="filters.status" id="filter-status">
                                <option value=""> -- Any Status -- </option>
                                <option value="on">Published</option>
                                <option value="off">Not Published</option>
                            </x-input.select>
                        </x-input.group>
                    </div>
                    @if(auth()->user()->hasAnyRole(['Super Admin']))
                        <div class="pr-2">
                            <x-input.group borderless for="filter-needs" label="Needs Task">
                                <x-input.select wire:model="filters.needs" id="filter-needs">
                                    <option value=""> -- Task -- </option>
                                    @foreach($taskTypes as $taskType)
                                        <option value="{{ $taskType->id }}">{{ $taskType->name }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                    @endif
                    <div class="pr-4 pl-2">
                        <div class="flex justify-end">
                            <x-button.link wire:click="resetFilters" class="">Reset Filters</x-button.link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative space-y-4 shadow">
                <div x-intersect:leave="shadow = true"
                     x-intersect:enter="shadow = false"
                ></div>
                <x-admin.quotes.table>
                    <x-slot name="head">
                        <x-admin.quotes.heading class="pr-0 w-8">
                            <x-input.checkbox wire:model="selectPage" />
                        </x-admin.quotes.heading>
                        <x-admin.quotes.heading sortable multi-column wire:click="sortBy('pcf_unique_id')" :direction="$sorts['name'] ?? null" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">ID</x-admin.quotes.heading>
                        <x-admin.quotes.heading class="pr-0 w-8">
                            Type
                        </x-admin.quotes.heading>
                        <x-admin.quotes.heading sortable
                                                multi-column
                                                wire:click="sortBy('name')"
                                                :direction="$sorts['name'] ?? null"
                                                class="sticky left-0 z-50 w-full bg-gray-100">
                            Name
                        </x-admin.quotes.heading>

                        @foreach($columns->reject(function ($value, $key) {
                                    return str($value)->contains('Link');
                        }) as $column)
                            <x-admin.quotes.heading class="whitespace-nowrap">
                                {{ $column->name }}
                            </x-admin.quotes.heading>
                        @endforeach
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
                            <x-admin.quotes.row wire:loading.class.delay="opacity-50"
                                                wire:key="row-{{ $item->id }}"
                                                class="h-12"
                            >
                                <x-admin.quotes.cell class="pr-0 bg-gray-50">
                                    <x-input.checkbox wire:model="selected" value="{{ $item->id }}" />
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="bg-gray-50">
                                    <span href="#" class="inline-flex space-x-2 text-sm leading-5 truncate">
                                        {{ $item->pcf_unique_id_full }}
                                    </span>
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="pr-0 bg-gray-50">
                                    <span class="text-cool-gray-900">{{ str($item->type?->name)->singular() }} </span>
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="sticky left-0 py-0 px-0 bg-gray-50">
                                    <div class="w-full h-full border-r-2 border-gray-200">
                                        <div href="#" class="inline-flex py-4 px-6 space-x-2 text-sm leading-5 truncate">
                                            {{--<x-icon.cash class="text-cool-gray-400"/>--}}

                                            <p class="flex gap-x-1 items-center text-cool-gray-600 truncate">
                                                <x-icon.status :status="$item->enabled"/>
                                                <a class="font-medium text-indigo-600"
                                                   href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
                                                   target="_blank">
                                                    {{ $item->name }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </x-admin.quotes.cell>


                                @foreach($columns->reject(function ($value, $key) {
                                    return str($value)->contains('Link');
                                }) as $column)
                                    <x-admin.quotes.cell class="bg-gray-50">
                                        <div class="whitespace-nowrap">
                                            @switch($column->type)
                                                @case('link')
                                                    <x-admin.document.values.link :property="$column"
                                                                                  :value="$item->values->firstWhere('property_id', $column->id)"
                                                                                  :model="$item"
                                                    />
                                                    @break
                                                @case('html')
                                                    <x-admin.document.values.html :property="$column"
                                                                                  :value="$item->values->firstWhere('property_id', $column->id)"
                                                                                  :model="$item"
                                                    />
                                                    @break
                                                @case('date')
                                                    <x-admin.document.values.date :property="$column"
                                                                                  :value="$item->values->firstWhere('property_id', $column->id)"
                                                                                  :model="$item"
                                                    />
                                                    @break
                                                @default
                                                    <x-admin.document.values.text :property="$column"
                                                                                  :value="$item->values->firstWhere('property_id', $column->id)"
                                                                                  :model="$item"
                                                    />
                                                    @break
                                            @endswitch
                                        </div>
                                    </x-admin.quotes.cell>
                                @endforeach

                                {{--<x-admin.quotes.cell>
                                    --}}{{--<x-button.link wire:click="edit({{ $item->id }})">Edit</x-button.link>--}}{{--
                                    <a class="text-indigo-600"
                                       href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
                                       target="_blank">View</a>
                                </x-admin.quotes.cell>--}}
                            </x-admin.quotes.row>
                        @empty
                            <x-admin.quotes.row>
                                <x-admin.quotes.cell colspan="6">
                                    <div class="flex justify-center items-center space-x-2">
                                        {{--<x-icon.inbox class="w-8 h-8 text-cool-gray-400" />--}}
                                        <span class="py-8 text-xl font-medium text-cool-gray-400">No documents found...</span>
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
