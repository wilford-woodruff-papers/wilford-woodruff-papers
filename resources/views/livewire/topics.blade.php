<div>
    <div class="-12">
        <div class="max-w-7xl text-center">
            <form wire:submit.prevent="submit">
                <input wire:model.defer="search"
                       class="max-w-xl w-full shadow-sm sm:max-w-xl sm:text-sm border-gray-300"
                       type="search"
                       name="q"
                       value=""
                       placeholder="Search Topics"
                       aria-label="Search Topics"
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
             class="grid grid-cols-1 sm:grid-cols-2 gap-1 mb-4 px-2">
            @forelse($topics as $key => $topic)
                <div class="">
                    <a class="text-secondary popup"
                       href="{{ route('subjects.show', ['subject' => $topic])  }}"
                    >
                        {{ $topic->name }}
                    </a>
                    @if($topic->children->count() > 0)
                        <ul class="ml-1 flex flex-col gap-y-1">
                            @foreach($topic->children->sortBy('name') as $subTopic)
                                <li>
                                    <a class="text-secondary popup"
                                       href="{{ route('subjects.show', ['subject' => $subTopic])  }}"
                                    >
                                        {{ $subTopic->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @empty
                <div class="px-2 text-secondary">
                    No results
                </div>
            @endforelse
        </div>
        <div wire:loading.grid
             class="grid grid-cols-1 sm:grid-cols-2 mb-4 px-2">
            @foreach(range(1, 10) as $placeholder)
                <div class="col-span-1">
                    <div data-placeholder class="mr-2 h-6 w-80 overflow-hidden relative bg-gray-200 animate-pulse">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @push('styles')
        <style>
            .content ul {
                list-style-type: none;
            }
            .content ul li:before {
                content: '\2014';
                position: absolute;
                margin-left: -20px;
            }
        </style>
    @endpush
</div>
