<div {{ (($checked < $total) ? 'wire:poll.5s' : '' ) }} >
    <div class="flex items-center">
        @if($checked < $total)
            <div class="flex-1 py-1 px-4 whitespace-nowrap">
                {{ \Illuminate\Support\Number::format($checked) }} checked / {{ \Illuminate\Support\Number::format($total) }} total
            </div>
            <div class="overflow-hidden relative mr-4 w-full h-2 bg-gray-100">
                <span :style="'width:{{ $progress }}%'" class="absolute w-24 h-full bg-green-500 duration-300 animate-pulse ease"></span>
            </div>
            <div class="flex-1 py-1 px-4 whitespace-nowrap">
                {{ \Illuminate\Support\Number::format($total - $checked) }} remaining
            </div>
        @endif
    </div>
</div>
