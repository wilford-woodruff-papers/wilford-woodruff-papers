<div wire:init="loadStats">

    <div class="mt-4 max-w-7xl mx-auto">
        <div class="py-4">

            <h1 class="text-2xl font-semibold mb-2">
                Activity Report
            </h1>

            <form wire:submit.prevent="update" class="flex gap-x-4">
                <div>
                    <label for="start" class="block text-sm font-medium text-gray-700">Starting Date</label>
                    <div class="mt-1">
                        <input wire:model.defer="dates.start"
                               id="start"
                               type="date"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                    </div>
                </div>
                <div>
                    <label for="end" class="block text-sm font-medium text-gray-700">Ending Date</label>
                    <div class="mt-1">
                        <input wire:model.defer="dates.end"
                               id="end"
                               type="date"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                    </div>
                </div>
                <div>
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-8 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 xl:ml-0 xl:w-full mt-6"
                    >
                        Update
                    </button>
                </div>
            </form>

            <div class="relative my-12">
                <div wire:loading
                     class="absolute w-full h-full bg-white opacity-75"
                >
                    <div class="flex justify-center py-40">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="animate-spin w-24 h-24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>

                    </div>
                </div>
                @if(! empty($pageStats))
                    <div class="grid grid-cols-3 gap-4 my-16">
                        <div class="font-semibold">Action</div>
                        <div class="font-semibold">Type</div>
                        <div class="font-semibold">Completed</div>

                        @foreach($pageStats as $stat)
                            <div>
                                {{ $stat->name }}
                            </div>
                            <div>
                                {{ str($stat->actionable_type)->afterLast('\\') }}
                            </div>
                            <div>
                                {{ $stat->total }}
                            </div>
                        @endforeach
                    </div>
                @endif
                @if(! empty($documentStats))
                    <div class="grid grid-cols-3 gap-4 my-16">
                        <div class="font-semibold">Action</div>
                        <div class="font-semibold">Type</div>
                        <div class="font-semibold">Completed</div>

                        @foreach($documentStats as $stat)
                            <div>
                                {{ $stat->name }}
                            </div>
                            <div>
                                {{ str($stat->actionable_type)->afterLast('\\') }}
                            </div>
                            <div>
                                {{ $stat->total }}
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(! empty($individualStats))
                    <div class="divide-y-2">
                        @foreach($individualStats->sortBy('user_name')->groupBy('user_id') as $individualStat)
                            <div class="grid grid-cols-4 gap-4 py-4">
                                <div class="font-semibold">Contributor</div>
                                <div class="font-semibold">Action</div>
                                <div class="font-semibold">Type</div>
                                <div class="font-semibold">Completed</div>
                                @foreach($individualStat as $stat)
                                    <div>
                                        {{ $loop->odd ? $stat->user_name : '' }}
                                    </div>
                                    <div>
                                        {{ $stat->name }}
                                    </div>
                                    <div>
                                        {{ str($stat->actionable_type)->afterLast('\\') }}
                                    </div>
                                    <div>
                                        {{ $stat->total }}
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
