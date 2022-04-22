<div>
    <div class="-12">
        <div class="max-w-7xl text-center">
            <form wire:submit.prevent="submit">
                <input wire:model.defer="search"
                       class="max-w-xl w-full shadow-sm sm:max-w-xl sm:text-sm border-gray-300"
                       type="search"
                       name="q"
                       value=""
                       placeholder="Search People"
                       aria-label="Search People"
                >
            </form>
        </div>

        <div class="h-16">
            <div class="grid grid-flow-col auto-cols-max gap-4 mb-4 overflow-x-scroll no-scrollbar"
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
             class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-1 mb-4 px-2">
            @forelse($people as $key => $person)
                <div class="">
                    <a class="text-secondary popup"
                       href="{{ route('subjects.show', ['subject' => $person])  }}"
                    >
                        {{ $person->last_name }}, {{ $person->first_name }}
                    </a>
                </div>
            @empty
                <div class="px-2 text-secondary">
                    No results
                </div>
            @endforelse
        </div>
        <div wire:loading
             class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4 px-2">
            @foreach(range(1, 15) as $placeholder)
                <div class="">
                    <div data-placeholder class="mr-2 my-2 h-6 w-80 overflow-hidden relative bg-gray-200">
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
