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
                <div class="flex">
                    <div class="ml-4">
                        <p class="text-base text-black">
                            Please wait while we cross-check the people mentioned in the Wilford Woodruff Papers with your family tree. <span x-show="timeRemaining.minutes > 0 && showEstimate">(Estimated time remaining: <span x-text="timeRemaining.minutes"></span> minutes)</span>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="flex items-center">
        @if($checked < $total)
            <div class="flex-1 py-1 px-4 whitespace-nowrap">
                <span x-text="totalChecked.toLocaleString()">{{ $checked }}</span> checked / {{ \Illuminate\Support\Number::format($total) }} total
            </div>
            <div class="overflow-hidden relative mr-4 w-full h-2 bg-gray-100">
                <span :style="'width:{{ $progress }}%'" class="absolute w-24 h-full bg-green-500 duration-300 animate-pulse ease"></span>
            </div>
            <div class="flex-1 py-1 px-4 whitespace-nowrap">
                <span x-text="remaining.toLocaleString()">{{ $total - $checked }}</span> remaining
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
