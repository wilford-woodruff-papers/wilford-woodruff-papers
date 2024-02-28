<div>
    <div class="relative">
        <div id="{{ str('People')->slug() }}" class="absolute -top-32"></div>
        <h2 class="text-2xl font-thin uppercase border-b-4 md:text-3xl lg:text-4xl border-highlight">
            People
        </h2>
        <p class="mt-4 mb-8 text-xl">
            Browse people Wilford Woodruff mentioned in this document.
        </p>
    </div>
    <div class="grid grid-cols-1 gap-2 lg:grid-cols-3">
        @foreach($item->people->shift(9) as $person)
            <div class="flex flex-col justify-between p-4 border border-gray-300 shadow-lg">
                <div>
                    <a href="{{ route('subjects.show', ['subject' => $person->slug]) }}"
                       class="text-xl text-secondary popup"
                       target="_blank"
                    >
                        {{ $person->display_name }}
                    </a>
                    @if(! empty($display_life_years = $person->display_life_years))
                        <div>
                            {{ $display_life_years }}
                        </div>
                    @endif
                </div>
                <div class="flex justify-between items-center pt-2">
                    <div class="font-medium text-gray-900">
                        <div class="mb-0.5">
                            {{ $person->tagged_count }} {{ str('mention')->plural($person->tagged_count) }}
                        </div>
                        <div class="text-gray-900">
                            {{
                                $person
                                    ->category
                                    ->filter(fn($category) => $category->name !== 'People')
                                    ->pluck('name')
                                    ->map(fn($name) => str($name)->singular())
                                    ->join(', ')
                            }}
                        </div>
                    </div>
                    <div>
                        @if(! empty($person->pid) && $person->pid !== 'n/a')
                            <a href="https://www.familysearch.org/tree/person/details/{{ $person->pid }}"
                               class="block px-2 pt-1 pb-2 text-sm bg-white rounded-md border border-gray-200"
                               target="_blank"
                            >
                                <img src="{{ asset('img/familytree-logo.png') }}"
                                     alt="FamilySearch"
                                     class="w-auto h-6"
                                />
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div x-data="{ active: 0 }" class="mx-auto space-y-4 w-full">
        <div x-data="{
                id: 1,
                get expanded() {
                    return this.active === this.id
                },
                set expanded(value) {
                    this.active = value ? this.id : null
                },
            }" role="region" class="">
            <h2 class="my-4">
                <button
                    x-on:click="expanded = !expanded"
                    :aria-expanded="expanded"
                    class="flex items-center px-2 w-full text-lg text-secondary"
                >
                    <span x-show="expanded" aria-hidden="true" class="mr-4" x-cloak>&minus;</span>
                    <span x-show="!expanded" aria-hidden="true" class="mr-4">&plus;</span>
                    <span>Show more</span>
                </button>
            </h2>

            <div x-show="expanded" x-collapse x-cloak>
                <div class="">
                    <div class="grid grid-cols-1 gap-2 lg:grid-cols-3">
                        @foreach($item->people as $person)
                            <div class="flex flex-col justify-between p-4 border border-gray-300 shadow-lg">
                                <div>
                                    <a href="{{ route('subjects.show', ['subject' => $person->slug]) }}"
                                       class="text-xl text-secondary popup"
                                       target="_blank"
                                    >
                                        {{ $person->display_name }}
                                    </a>
                                    @if(! empty($display_life_years = $person->display_life_years))
                                        <div>
                                            {{ $display_life_years }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center pt-2">
                                    <div class="font-medium text-gray-900">
                                        <div class="mb-0.5">
                                            {{ $person->tagged_count }} {{ str('mention')->plural($person->tagged_count) }}
                                        </div>
                                        <div class="text-gray-900">
                                            {{
                                                $person
                                                    ->category
                                                    ->filter(fn($category) => $category->name !== 'People')
                                                    ->pluck('name')
                                                    ->map(fn($name) => str($name)->singular())
                                                    ->join(', ')
                                            }}
                                        </div>
                                    </div>
                                    <div>
                                        @if(! empty($person->pid) && $person->pid !== 'n/a')
                                            <a href="https://www.familysearch.org/tree/person/details/{{ $person->pid }}"
                                               class="block px-2 pt-1 pb-2 text-sm bg-white rounded-md border border-gray-200"
                                               target="_blank"
                                            >
                                                <img src="{{ asset('img/familytree-logo.png') }}"
                                                     alt="FamilySearch"
                                                     class="w-auto h-6"
                                                />
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
