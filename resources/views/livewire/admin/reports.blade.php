<div>
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

            <div class="my-12">
                <div wire:loading
                     class="absolute w-full h-full bg-white opacity-25"
                >

                </div>
                <div class="grid grid-cols-3 gap-4 my-16">
                    <div class="font-semibold">Action</div>
                    <div class="font-semibold">Type</div>
                    <div class="font-semibold">Completed</div>

                    @foreach($stats as $stat)

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
            </div>
        </div>
    </div>
</div>
