@if(! empty($section['items']) && $section['items']->count() > 0)
    <div>
        <div class="relative">
            <div id="{{ str($section['name'])->slug() }}" class="absolute -top-32"></div>
            <h2 class="text-2xl font-thin uppercase border-b-4 md:text-3xl lg:text-4xl border-highlight">
                {{ $section['name'] }}
            </h2>
            <p class="mt-4 mb-8 text-xl">
                Browse people Wilford Woodruff mentioned on this day in his journal.
            </p>
        </div>
        <div class="grid grid-cols-1 gap-2 lg:grid-cols-3">
            @foreach($section['items'] as $person)
                <div class="flex flex-col justify-between p-4 border border-gray-300 shadow-lg">
                    <div>
                        <a href="{{ route('subjects.show', ['subject' => $person->slug]) }}"
                           class="text-xl text-secondary popup"
                           target="_blank"
                        >
                            {{ $person->display_name }}
                        </a>
                    </div>
                    <div class="flex justify-between items-center pt-2 text-gray-900">
                        {{ $person->tagged_count }} {{ str('mention')->plural($person->tagged_count) }}
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <div class="font-medium text-gray-900">
                            <div>
                                @if(! empty($person->life_years))
                                    {{ $person->life_years }}
                                @endif
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
@endif
