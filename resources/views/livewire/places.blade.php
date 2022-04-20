<div>
    <div class="-12">
        <div class="max-w-7xl text-center">
            <form wire:submit.prevent="submit">
                <input wire:model.defer="search"
                       class="max-w-xl w-full shadow-sm sm:max-w-xl sm:text-sm border-gray-300"
                       type="search"
                       name="q"
                       value=""
                       placeholder="Search Places"
                       aria-label="Search Places"
                >
            </form>
        </div>

        <div class="h-16">
            <div class="grid grid-flow-col auto-cols-max gap-4 mb-4"
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
             class="grid grid-cols-1 gap-1 mb-4 px-2">
            @forelse($places as $key => $place)
                <div class="">
                    <a class="text-secondary popup"
                       href="{{ route('subjects.show', ['subject' => $place])  }}"
                    >
                        {{ $place->name }}
                    </a>
                </div>
            @empty
                <div class="px-2 text-secondary">
                    No results
                </div>
            @endforelse
        </div>
        <div wire:loading
             class="grid grid-cols-1 gap-4 mb-4 px-2">
            @foreach([1, 2, 3, 4, 5] as $placeholder)
                <div class="col-span-1">
                    <div data-placeholder class="mr-2 my-2 h-6 w-80 overflow-hidden relative bg-gray-200">

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
