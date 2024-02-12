<div wire:poll.5s>
    @if($checked < $total)
        <div class="flex items-center">
            <div class="flex-1 py-1 px-4 whitespace-nowrap">
                {{ $checked }} / {{ $total }}
            </div>
            <div class="overflow-hidden relative mr-4 w-full h-2 bg-gray-100">
                <span :style="'width:{{ $progress }}%'" class="absolute w-24 h-full bg-green-500 duration-300 animate-pulse ease"></span>
            </div>
        </div>
    @endif
</div>
