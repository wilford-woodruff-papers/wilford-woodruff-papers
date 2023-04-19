<div x-data="{
            shadow: false,
            perPage: @entangle('perPage'),
        }">
    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-12 pr-8">
            <div class="pt-2 pr-4">
                <div class="grid grid-cols-5 gap-x-2 justify-between py-2">
                    <div class="col-span-3 px-4 w-full">
                        <div class="w-full">
                            <h1 class="mb-4 text-2xl font-bold leading-6 text-gray-900">Search People</h1>
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

                            <div class="py-2">
                                <a href="{{ route('admin.dashboard.people.create') }}"
                                   class="py-2 px-4 text-white bg-indigo-600 border-indigo-600 hover:bg-indigo-500 active:bg-indigo-700"
                                ><x-icon.plus/> New</a>
                            </div>
                        </div>
                    </div>

                </div>
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
                                                class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">
                            ID
                        </x-admin.quotes.heading>
                        <x-admin.quotes.heading class="whitespace-nowrap">
                            Researcher
                        </x-admin.quotes.heading>
                        <x-admin.quotes.heading sortable
                                                multi-column
                                                wire:click="sortBy('last_name')"
                                                :direction="$sorts['last_name'] ?? null"
                                                class="sticky left-0 z-50 w-full bg-gray-100">
                            Name
                        </x-admin.quotes.heading>
                        @foreach($columns as $key => $column)
                            <x-admin.quotes.heading class="whitespace-nowrap">
                                {{ str($column)->replace('_', ' ') }}
                            </x-admin.quotes.heading>
                        @endforeach
                        <x-admin.quotes.heading class="whitespace-nowrap">
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
                                                class="h-12"
                            >
                                <x-admin.quotes.cell class="bg-gray-50 border border-gray-400">
                                    <x-input.checkbox wire:model="selected" value="{{ $person->id }}" />
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="bg-gray-50 border border-gray-400">
                                    <div class="inline-flex space-x-2 text-sm leading-5 whitespace-nowrap">
                                        {{ $person->unique_id }}
                                    </div>
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="bg-gray-50 border border-gray-400">
                                    <div class="whitespace-nowrap">
                                        @if(! empty($person->researcher_id))
                                            {{ $person->researcher?->name }}
                                        @elseif(! empty($person->researcher_text))
                                            {{ $person->researcher_text }}
                                        @else
                                            <livewire:admin.claim-subject :subject="$person" :wire:key="$person->id"/>
                                        @endif
                                    </div>
                                </x-admin.quotes.cell>

                                <x-admin.quotes.cell class="sticky left-0 py-0 px-0 bg-gray-50 border border-gray-400">
                                    <div class="w-full h-full border-r-2 border-gray-400">
                                        <div href="#" class="py-4 px-6 space-x-2 text-sm leading-5">
                                            {{--<x-icon.cash class="text-cool-gray-400"/>--}}

                                            <p class="flex gap-x-1 items-center w-96 text-cool-gray-600">
                                                <x-icon.status :status="$person->enabled"/>
                                                <a class="font-medium text-indigo-600 break-word"
                                                   href="{{ route('admin.dashboard.people.edit', ['person' => $person]) }}"
                                                   target="_blank">
                                                    {{ str($person->name)->replace('_', ' ') }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </x-admin.quotes.cell>

                                @foreach($columns as $key => $column)
                                    <x-admin.quotes.cell class="bg-gray-50 border border-gray-400">
                                        <div class="whitespace-nowrap">
                                            {!! str($person->{$key})->limit(150, '...') !!}
                                        </div>
                                    </x-admin.quotes.cell>
                                @endforeach

                                <x-admin.quotes.cell class="bg-gray-50 border border-gray-400">
                                    <div class="whitespace-nowrap">
                                        {{ $person->updated_at->toDayDateTimeString() }}
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

                <div>
                    {{ $people->links() }}
                </div>
            </div>
        </div>
    </div>
 </div>
