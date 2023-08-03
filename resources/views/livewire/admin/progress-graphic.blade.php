<div wire:init="loadStats">

    <div class="mx-auto mt-4 max-w-7xl">
        <div class="py-4">
            <div class="relative mt-12 mb-4">
                <div wire:loading
                     class="absolute w-full h-full bg-white opacity-75"
                >
                    <div class="flex justify-center py-40">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 animate-spin">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>

                    </div>
                </div>

                @if(! empty($pageStats))
                    <div class="pt-12 pb-24 bg-white sm:py-16">
                        <div class="text-center">
                            <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Papers Progress by Page</h1>
                        </div>
                        <div class="px-6 pt-12 mx-auto max-w-7xl sm:py-16 lg:px-8">

                            <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-4">
                                <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                    <dt class="text-base leading-7 text-gray-600">Published</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        {{ number_format($pageStats['published']) }}
                                    </dd>
                                </div>

                                <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                    <dt class="text-base leading-7 text-gray-600">Identified</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        {{ number_format($pageStats['identified']) }}
                                    </dd>
                                </div>

                                <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                    <dt class="text-base leading-7 text-gray-600">In Progress</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        {{ number_format($pageStats['in_progress']) }}
                                    </dd>
                                </div>

                                <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                    <dt class="text-base leading-7 text-gray-600">Total Found</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        {{ number_format($pageStats['total_found']) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                @endif

                @if(! empty($bioStats))
                    <div class="pt-12 pb-24 bg-white sm:py-16">
                        <div class="text-center">
                            <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">People & Places</h1>
                        </div>
                        <div class="px-6 pt-12 mx-auto max-w-7xl sm:py-16 lg:px-8">

                            <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-4">
                                <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                    <dt class="text-base leading-7 text-gray-600">Identified People</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        {{ number_format($bioStats['total_identified_people']) }}
                                    </dd>
                                </div>

                                <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                    <dt class="text-base leading-7 text-gray-600">Bios Approved</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        {{ number_format($bioStats['total_bios_approved']) }}
                                    </dd>
                                </div>

                                <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                    <dt class="text-base leading-7 text-gray-600">Identified Places</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        {{ number_format($bioStats['total_identified_places']) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                @endif

                @if(! empty($quoteStats))
                    <div class="pt-12 pb-24 bg-white sm:py-16">
                        <div class="text-center">
                            <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Quotes</h1>
                        </div>
                        <div class="px-6 pt-12 mx-auto max-w-7xl sm:py-16 lg:px-8">

                            <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-4">
                                <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                    <dt class="text-base leading-7 text-gray-600">Total Tagged</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        {{ number_format($quoteStats['total_tagged_quotes']) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>
