<div>

    <div class="">

        <div class="max-w-7xl hidden sm:flex gap-x-4 pb-8">
            @foreach(['All', 'Apostles', 'British Converts', 'Family', 'Scriptural Figures', 'Southern Converts'] as $categoryOption)
                <span wire:click="$set('category', '{{ $categoryOption }}')"
                      @class([
                        'inline-flex items-center px-3 py-0.5 text-lg cursor-pointer',
                        'bg-white text-secondary border border-secondary' => $category != $categoryOption,
                        'bg-secondary text-white' => $category == $categoryOption,
                      ])
                >
                    {{ $categoryOption }}
                </span>
            @endforeach
        </div>

        <div class="max-w-7xl block sm:hidden pb-8">
            <label for="category-select" class="block text-sm font-medium text-gray-700"> Category </label>
            <select wire:model="category"
                    id="category-select"
                    class="focus:ring-secondary focus:border-secondary relative block w-full bg-transparent focus:z-10 sm:text-base border-gray-300"
            >
                @foreach(['All', 'Apostle', 'British Convert', 'Family', 'Scriptural Figures', 'Southern Converts'] as $categoryOption)
                    <option wire:click="$set('category', '{{ $categoryOption }}')"
                            value="{{ $categoryOption }}"
                    >
                    {{ $categoryOption }}
                </option>
                @endforeach
            </select>

        </div>

        <div class="max-w-7xl text-center">
            <form wire:submit.prevent="submit">
                <input wire:model.defer="search"
                       class="max-w-xl w-full shadow-sm sm:max-w-xl sm:text-base border-gray-300 pb-2"
                       type="search"
                       name="q"
                       value=""
                       placeholder="Search People"
                       aria-label="Search People"
                >
            </form>
        </div>

        <div>
            @if($category == 'All')
                <div class="h-16">
                    <div class="grid grid-flow-col auto-cols-max gap-4 mb-4 overflow-x-scroll no-scrollbar"
                    >
                        @foreach(range('A', 'Z') as $l)
                            <div wire:click="$set('letter', '{{ $l }}')"
                                 class="text-xl font-semibold cursor-pointer px-2 pb-1 hover:text-secondary hover:border-b-2 hover:border-secondary @if($l == $letter) text-secondary border-b-2 border-secondary @endif">
                                {{ $l }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div wire:loading.remove
             class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-1 mb-4 px-2">
            @forelse($people as $key => $person)
                <div class="">
                    <a class="text-secondary popup"
                       href="{{ route('subjects.show', ['subject' => $person])  }}"
                    >
                        @if(! empty($person->last_name) && $person->last_name != $person->first_name){{ $person->last_name }}, @endif {{ $person->first_name }} ({{ $person->pages_count }})
                    </a>
                </div>
            @empty
                <div class="px-2 text-secondary">
                    No results
                </div>
            @endforelse
        </div>
        <div wire:loading.grid
             class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 mb-4 px-2">
            @foreach(range(1, 15) as $placeholder)
                <div class="">
                    <div data-placeholder class="mr-2 h-6 w-80 overflow-hidden relative bg-gray-200 animate-pulse">
                        <a class="text-secondary popup"
                           href="#"
                        >
                            &nbsp;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
