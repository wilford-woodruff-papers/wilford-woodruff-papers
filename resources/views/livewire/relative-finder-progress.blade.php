<div x-data="progress"
     @update-checked.window="function(e) {
            totalChecked++;
            callsCompleted++;
            remaining--;
            timeRemaining = estimateTimeRemaining(totalCalls, callsCompleted, startTime);
        }"
    class="bg-gray-50 border-l-4 border-gray-400">
    <div>
        @if($checked < $total)
            <div class="py-2">
                <div class="flex gap-x-2 justify-between items-center text-base text-black">
                    <div class="pl-4">
                        Thank you for your patience while we cross-check your family tree with Wilford Woodruff's papers. Feel free to browse the people below while you wait.
                    </div>
                    <div class="pr-4">
                        <span x-show="timeRemaining.minutes > 0 && showEstimate" x-cloak>(Estimated time: <span x-text="timeRemaining.minutes"></span> min)</span>
                        <span x-show="! showEstimate">
                            <x-heroicon-o-arrow-path class="w-4 h-4 animate-spin" />
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="flex items-center">
        @if($checked < $total)
            <div class="flex-1 py-1 px-4 whitespace-nowrap">
                <span x-text="Math.min(totalChecked, {{ $total }}).toLocaleString()">{{ $checked }}</span> checked / {{ \Illuminate\Support\Number::format($total) }} total
            </div>
            <div class="overflow-hidden relative mr-4 w-full h-2 bg-gray-100">
                <span :style="'width:{{ $progress }}%'" class="absolute w-24 h-full bg-green-500 duration-300 animate-pulse ease"></span>
            </div>
            <div class="flex-1 py-1 px-4 whitespace-nowrap">
                <span x-text="Math.max(remaining, 0).toLocaleString()">{{ $total - $checked }}</span> remaining
            </div>
        @endif
    </div>
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('progress', () => ({
                    totalChecked: {{ $checked }},
                    remaining: {{ $total - $checked }},
                    totalCalls: {{ $total - $checked }},
                    callsCompleted: 0,
                    timeRemaining: 0,
                    startTime: new Date(),
                    showEstimate: false,
                    init () {
                        setTimeout(()=> {
                            this.showEstimate = true;
                        }, 10000);
                    },
                    estimateTimeRemaining(totalCalls, callsCompleted, startTime) {
                        // Calculate the time elapsed
                        const currentTime = new Date();
                        const elapsedMilliseconds = currentTime - startTime;
                        const elapsedSeconds = elapsedMilliseconds / 1000;

                        // Calculate the average time taken per API call
                        const averageTimePerCall = elapsedSeconds / callsCompleted;

                        // Estimate the time remaining for the remaining calls
                        const remainingCalls = totalCalls - callsCompleted;
                        const estimatedTimeRemaining = remainingCalls * averageTimePerCall;

                        // Format the time in minutes and seconds
                        const minutesRemaining = Math.floor(estimatedTimeRemaining / 60);
                        const secondsRemaining = Math.round(estimatedTimeRemaining % 60);
                        return {
                            minutes: minutesRemaining,
                            seconds: secondsRemaining
                        };
                    },
                }))
            })
        </script>
    @endpush
</div>
