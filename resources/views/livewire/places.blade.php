<div>
    <div class="-12">
        <div class="max-w-7xl text-center">
            <form wire:submit="submit">
                <input wire:model="search"
                       class="w-full max-w-xl border-gray-300 shadow-sm sm:max-w-xl sm:text-sm"
                       type="search"
                       name="q"
                       value=""
                       placeholder="Search Places"
                       aria-label="Search Places"
                >
            </form>
        </div>

        <div class="h-16">
            <div class="grid overflow-x-scroll grid-flow-col auto-cols-max gap-4 mb-4 no-scrollbar"
            >
                @foreach(range('A', 'Z') as $l)
                    <div wire:click="$set('letter', '{{ $l }}')"
                         class="text-xl font-semibold cursor-pointer pt-2 px-2 pb-1 hover:text-secondary hover:border-b-2 hover:border-secondary @if($l == $letter) text-secondary border-b-2 border-secondary @endif">
                        {{ $l }}
                    </div>
                @endforeach
            </div>
        </div>

        <div wire:loading.remove
             class="grid grid-cols-1 gap-1 px-2 mb-4 sm:grid-cols-2">
            @forelse($places as $key => $place)
                <div class="">
                    <a class="text-secondary popup"
                       href="{{ route('subjects.show', ['subject' => $place])  }}"
                    >
                        {{ $place->name }} ({{ $place->tagged_count }})
                    </a>
                </div>
            @empty
                <div class="px-2 text-secondary">
                    No results
                </div>
            @endforelse
        </div>
        <div wire:loading.grid
             class="grid grid-cols-1 px-2 mb-4 sm:grid-cols-2">
            @foreach(range(1, 10) as $placeholder)
                <div class="col-span-1">
                    <div data-placeholder class="overflow-hidden relative mr-2 w-80 h-6 bg-gray-200 animate-pulse">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
