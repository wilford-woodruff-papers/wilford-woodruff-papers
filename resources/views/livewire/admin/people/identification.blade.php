<div x-data="{
            shadow: false,
            perPage: @entangle('perPage'),
            selectedColumns: $persist({{ json_encode(array_values($columns)) }}).as('people-identification-columns'),
        }">
    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-12 pr-8">
            <div class="pt-2 pr-4">
                <div class="grid grid-cols-5 gap-x-2 justify-between py-2">
                    <div class="col-span-3 px-4 w-full">
                        <div class="w-full">
                            <h1 class="mb-4 text-2xl font-bold leading-6 text-gray-900">Search Unidentified People</h1>
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
                                       class="block py-1.5 pl-10 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary" placeholder="Search people...">
                            </div>
                        </div>
                        <div class="pl-4">
                            <div class="flex gap-x-4 gap-y-4 items-center">
                                <div class="flex gap-x-1 items-center pr-2">
                                    <x-input.group borderless for="filter-type" label="Researcher">
                                        <x-input.select wire:model="filters.researcher" id="filter-type">
                                            <option value=""> -- All -- </option>
                                            <option value="unassigned"> -- Unassigned -- </option>
                                            @foreach($researchers as $researcher)
                                                <option value="{{ $researcher->id }}" @if(data_get('', $filters) == $researcher->id) selected @endif>{{ $researcher->name }}</option>
                                            @endforeach
                                        </x-input.select>
                                    </x-input.group>
                                    <div>
                                        @if(! empty(data_get($filters, 'researcher')))
                                            <button wire:click="$set('filters.researcher', '')"
                                                    class="inline-flex justify-center py-1 px-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500"
                                            >
                                                All
                                            </button>

                                        @else
                                            <button wire:click="$set('filters.researcher', {{ auth()->id() }})"
                                                    class="inline-flex justify-center py-1 px-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500"
                                            >
                                                Assigned to Me
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="pr-2 space-y-4">
                                    <x-input.group borderless for="filter-type" label="Status">
                                        <x-input.select wire:model="filters.completed" id="filter-type">
                                            <option value=""> -- Any -- </option>
                                            <option value="false"> Not Completed </option>
                                            <option value="true"> Completed </option>
                                        </x-input.select>
                                    </x-input.group>
                                </div>
                                <div class="pr-2 space-y-4">
                                    <x-input.group borderless for="filter-type" label="Corrections">
                                        <x-input.select wire:model="filters.corrections" id="filter-type">
                                            <option value=""> -- Any -- </option>
                                            <option value="true"> Needs Correction </option>
                                        </x-input.select>
                                    </x-input.group>
                                </div>
                                <div class="pr-2 space-y-4">
                                    <x-input.group borderless for="filter-type" label="Identifiable">
                                        <x-input.select wire:model="filters.cant_be_identified" id="filter-type">
                                            <option value=""> -- Any -- </option>
                                            <option value="false"> Yes </option>
                                            <option value="true"> No </option>
                                        </x-input.select>
                                    </x-input.group>
                                </div>
                            </div>
                        </div>
                        {{--<div class="pl-4">
                            <div class="flex gap-x-4 gap-y-4 items-center">
                                <div class="pr-2 space-y-4">
                                    <x-input.group borderless for="filter-type" label="Status">
                                        <x-input.select wire:model="filters.tagged" id="filter-type">
                                            <option value=""> -- Any -- </option>
                                            <option value="false"> Not tagged </option>
                                            <option value="true"> Tagged </option>
                                        </x-input.select>
                                    </x-input.group>
                                </div>
                            </div>
                        </div>--}}
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

                            <div class="py-2">
                                <a href="{{ route('admin.dashboard.identification.people.create') }}"
                                   class="py-2 px-4 text-white bg-indigo-600 border-indigo-600 hover:bg-indigo-500 active:bg-indigo-700"
                                   target="_blank"
                                ><x-icon.plus/> New</a>
                            </div>
                        </div>
                        <div x-data="{
                            show: false
                        }"
                             class="flex justify-end items-center mt-4"
                             x-on:mouseleave="show = false"
                        >
                            <div>
                                <div class="inline-block relative text-left">
                                    <div>
                                        <button x-on:click="show = ! show"
                                                type="button" class="inline-flex gap-x-1.5 justify-center py-2 px-3 w-full text-sm font-semibold text-gray-900 bg-white rounded-md ring-1 ring-inset ring-gray-300 shadow-sm hover:bg-gray-50" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                            Displayed Columns
                                            <svg class="-mr-1 w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!--
                                      Dropdown menu, show/hide based on menu state.

                                      Entering: "transition ease-out duration-100"
                                        From: "transform opacity-0 scale-95"
                                        To: "transform opacity-100 scale-100"
                                      Leaving: "transition ease-in duration-75"
                                        From: "transform opacity-100 scale-100"
                                        To: "transform opacity-0 scale-95"
                                    -->
                                    <div x-show="show"
                                         class="absolute right-0 mt-0 w-56 bg-white rounded-md divide-y divide-gray-100 ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right focus:outline-none z-100"
                                         x-cloak
                                         role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1"
                                    >
                                        <div class="py-1 px-4" role="none">
                                            @foreach($columns as $column)
                                                <div class="flex relative items-start">
                                                    <div class="flex items-center h-6">
                                                        <input x-model="selectedColumns"
                                                               id="columns-{{  $column }}"
                                                               value="{{  $column }}"
                                                               type="checkbox"
                                                               class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-600">
                                                    </div>
                                                    <div class="ml-3 text-sm leading-6">
                                                        <label for="columns-{{  $column }}"
                                                               class="font-medium text-gray-900 uppercase">{{ str($column)->replace('_', ' ') }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div id="top-pagination"
                 class="pl-4"
            >
                {{ $people->links() }}
            </div>

            <div class="relative space-y-4 shadow">
                <div wire:loading
                     class="absolute z-10 w-full h-screen bg-white opacity-75"
                >
                    <div class="flex justify-center py-40">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 animate-spin">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>

                    </div>
                </div>
                <div x-intersect:leave="shadow = true"
                     x-intersect:enter="shadow = false"
                ></div>
                <x-admin.quotes.table>
                    <x-slot name="head">
                        <x-admin.quotes.heading class="pr-0 w-8">
                            <x-input.checkbox wire:model="selectPage" />
                        </x-admin.quotes.heading>
                        <x-admin.quotes.heading sortable multi-column wire:click="sortBy('pcf_unique_id')"
                                                :direction="$sorts['name'] ?? null"
                                                class="sticky left-0 z-50 py-3.5 pr-3 pl-4 w-24 w-full text-sm font-semibold text-left text-gray-900 bg-gray-100 sm:pl-6">
                            ID
                        </x-admin.quotes.heading>
                        {{--<x-admin.quotes.heading sortable
                                                multi-column
                                                wire:click="sortBy('editorial_assistant')"
                                                :direction="$sorts['editorial_assistant'] ?? null"
                                                class="sticky left-0 z-50 w-full bg-gray-100">
                            Name
                        </x-admin.quotes.heading>--}}
                        @foreach($columns as $key => $column)
                            <x-admin.quotes.heading class="whitespace-nowrap"
                                                    sortable
                                                    multi-column
                                                    wire:click="sortBy('{{ $key }}')"
                                                    :direction="$sorts[$key] ?? null"
                                                    x-show="selectedColumns.includes('{{$column}}')">
                                {{ str($column)->replace('_', ' ') }}
                            </x-admin.quotes.heading>
                        @endforeach
                        <x-admin.quotes.heading class="whitespace-nowrap"
                                                sortable
                                                multi-column
                                                wire:click="sortBy('updated_at')"
                                                :direction="$sorts['updated_at'] ?? null">
                            Last Updated
                        </x-admin.quotes.heading>
                    </x-slot>

                    <x-slot name="body">
                        @if ($selectPage)
                            <x-admin.quotes.row class="bg-cool-gray-200" wire:key="row-message">
                                <x-admin.quotes.cell colspan="6">
                                    @unless ($selectAll)
                                        <div>
                                            <span>You have selected <strong>{{ $people->count() }}</strong> quotes, do you want to select all <strong>{{ $people->total() }}</strong>?</span>
                                            <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                                        </div>
                                    @else
                                        <span>You are currently selecting all <strong>{{ $people->total() }}</strong> items.</span>
                                    @endif
                                </x-admin.quotes.cell>
                            </x-admin.quotes.row>
                        @endif

                        @forelse ($people as $person)
                            <x-admin.quotes.row wire:loading.class.delay="opacity-50"
                                                wire:key="row-{{ $person->id }}"
                                                class="h-6"
                            >
                                <x-admin.quotes.cell class="bg-gray-50 border border-gray-400">
                                    <x-input.checkbox wire:model="selected" value="{{ $person->id }}" />
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="sticky left-0 py-0 px-0 w-24 bg-gray-50 border border-gray-400">
                                    <div class="flex justify-center space-x-2 text-sm leading-5 whitespace-nowrap">
                                        <a class="font-medium text-indigo-600 break-word"
                                           href="{{ route('admin.dashboard.identification.people.edit', ['identification' => $person]) }}"
                                           target="_blank">
                                                {{ $person->id }}
                                        </a>
                                    </div>
                                </x-admin.quotes.cell>

                                {{--<x-admin.quotes.cell class="sticky left-0 py-0 px-0 bg-gray-50 border border-gray-400">
                                    <div class="w-full h-full border-r-2 border-gray-400">
                                        <div href="#" class="py-2 px-6 space-x-2 text-sm leading-5">
                                            --}}{{--<x-icon.cash class="text-cool-gray-400"/>--}}{{--

                                            <p class="flex gap-x-1 items-center w-96 text-cool-gray-600">
                                                <a class="font-medium text-indigo-600 break-word"
                                                   href="{{ route('admin.dashboard.identification.people.edit', ['identification' => $person]) }}"
                                                   target="_blank">
                                                    {{ $person->title }} {{ str($person->first_middle_name)->replace('_', ' ') }} {{ str($person->last_name)->replace('_', ' ') }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </x-admin.quotes.cell>--}}

                                @foreach($columns as $key => $column)
                                    <x-admin.quotes.cell class="bg-gray-50 border border-gray-400" x-show="selectedColumns.includes('{{$column}}')">
                                        <div class="whitespace-nowrap">
                                            @if(str($person->{$key})->startsWith('http'))
                                                <a href="{!! str($person->{$key}) !!}"
                                                   class="text-secondary"
                                                   target="_blank"
                                                >
                                                    {!! str($person->{$key})->after('//')->before('/') !!}
                                                </a>
                                            @elseif($column == 'researcher')
                                                @if(! empty($person->researcher_id))
                                                    {{ $person->researcher?->name }}
                                                @else
                                                    <livewire:admin.claim-identification :subject="$person" :wire:key="$person->id"/>
                                                @endif
                                            @elseif($column == 'identifiable')
                                                <x-icon.status :status="!$person->cant_be_identified"/>
                                            @elseif(in_array($key, ['correction_needed']))
                                                @if($person->{$key})
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-yellow-600">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                    </svg>
                                                @endif
                                            @elseif(in_array($key, ['completed_at']))
                                                {{ $person->{$key}?->toFormattedDayDateString() }}
                                            @else
                                                {!! str($person->{$key})->limit(150, '...') !!}
                                            @endif
                                        </div>
                                    </x-admin.quotes.cell>
                                @endforeach

                                <x-admin.quotes.cell class="bg-gray-50 border border-gray-400">
                                    <div class="whitespace-nowrap">
                                        {{ $person->updated_at?->tz(auth()->user()->timzone ?? 'America/Denver')->toDayDateTimeString() }}
                                    </div>
                                </x-admin.quotes.cell>

                            </x-admin.quotes.row>
                        @empty
                            <x-admin.quotes.row>
                                <x-admin.quotes.cell colspan="6">
                                    <div class="flex justify-center items-center space-x-2">
                                        {{--<x-icon.inbox class="w-8 h-8 text-cool-gray-400" />--}}
                                        <span class="py-8 text-xl font-medium text-cool-gray-400">No people found...</span>
                                    </div>
                                </x-admin.quotes.cell>
                            </x-admin.quotes.row>
                        @endforelse
                    </x-slot>
                </x-admin.quotes.table>

                <div id="bottom-pagination"
                     class="pl-4"
                >
                    {{ $people->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
