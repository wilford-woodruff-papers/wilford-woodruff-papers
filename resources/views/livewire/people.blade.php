<div>

    <div class="">

        <div class="hidden gap-x-4 pb-8 max-w-7xl sm:flex">
            @foreach(['All', 'Apostles', '1840 British Converts', 'Family', 'Scriptural Figures', '1835 Southern Converts'] as $categoryOption)
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

        <div class="block pb-8 max-w-7xl sm:hidden">
            <label for="category-select" class="block text-sm font-medium text-gray-700"> Category </label>
            <select wire:model="category"
                    id="category-select"
                    class="block relative w-full bg-transparent border-gray-300 sm:text-base focus:z-10 focus:ring-secondary focus:border-secondary"
            >
                @foreach(['All', 'Apostles', '1840 British Converts', 'Family', 'Scriptural Figures', '1835 Southern Converts'] as $categoryOption)
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
                       class="pb-2 w-full max-w-xl border-gray-300 shadow-sm sm:max-w-xl sm:text-base"
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
                    <div class="grid overflow-x-scroll grid-flow-col auto-cols-max gap-4 mb-4 no-scrollbar"
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
             class="grid grid-cols-1 gap-1 px-2 mb-4 sm:grid-cols-2 md:grid-cols-3">
            @forelse($people as $key => $person)
                <div class="">
                    <a class="text-secondary popup"
                       href="{{ route('subjects.show', ['subject' => $person])  }}"
                    >
                        {{ $person->display_name }} ({{ $person->tagged_count }})
                    </a>
                </div>
            @empty
                <div class="px-2 text-secondary">
                    No results
                </div>
            @endforelse
        </div>
        <div wire:loading.grid
             class="grid grid-cols-1 px-2 mb-4 sm:grid-cols-2 md:grid-cols-3">
            @foreach(range(1, 15) as $placeholder)
                <div class="">
                    <div data-placeholder class="overflow-hidden relative mr-2 w-80 h-6 bg-gray-200 animate-pulse">
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
