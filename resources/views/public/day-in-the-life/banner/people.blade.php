<div class="w-[120%] h-[120%] pt-12 ml-24">
    <div class="grid grid-cols-1 gap-2 scale-150 lg:grid-cols-3"
        {{--style="transform: perspective(1000px) rotateX(-4deg) rotateY(16deg) rotateZ(-4deg);"--}}
    >
        @foreach($people as $person)
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
