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
                <div class="pt-12 pb-24 bg-white sm:py-16">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">People Progress by Category</h1>
                    </div>
                    @if(! empty($stats))
                        <div class="px-6 pt-12 mx-auto max-w-7xl sm:py-16 lg:px-8">

                            <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-4">
                                @foreach($stats as $category => $stat)
                                    <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                        <dt class="text-base leading-7 text-gray-600">{{ $category }}</dt>
                                        <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                            <a href="{{ route('admin.people.index', ['filters[category]' => $category, 'filters[completed]' => 'true']) }}"
                                               class="text-secondary"
                                               target="_people"
                                            >
                                                {{ number_format($stat['bio_completed']) }}
                                            </a>
                                            /
                                            <a href="{{ route('admin.people.index', ['filters[category]' => $category, 'filters[completed]' => 'false']) }}"
                                               class="text-secondary"
                                               target="_people"
                                            >
                                                {{ number_format($stat['total']) }}
                                            </a>
                                        </dd>
                                    </div>
                                @endforeach
                                <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                    <dt class="text-base leading-7 text-gray-600">Unknown People</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        <a href="{{ route('admin.people.identification', ['filters[completed]' => 'true']) }}"
                                           class="text-secondary"
                                           target="_people"
                                        >
                                            {{ number_format($unknown_people['removed']) }}
                                        </a>
                                        /
                                        <a href="{{ route('admin.people.identification', ['filters[completed]' => 'false']) }}"
                                           class="text-secondary"
                                           target="_people"
                                        >
                                            {{ number_format($unknown_people['total']) }}
                                        </a>
                                    </dd>
                                </div>
                                <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                    <dt class="text-base leading-7 text-gray-600">Biographies Completed</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        <a href="{{ route('admin.people.index', ['filters[approved]' => 'true']) }}"
                                           class="text-secondary"
                                           target="_people"
                                        >
                                            {{ number_format($known_people['bio_completed']) }}
                                        </a>
                                        /
                                        <a href="{{ route('admin.people.index', ['filters[approved]' => 'false']) }}"
                                           class="text-secondary"
                                           target="_people"
                                        >
                                            {{ number_format($known_people['total']) }}
                                        </a>
                                    </dd>
                                </div>
                                <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                    <dt class="text-base leading-7 text-gray-600">People with PID</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        {{ number_format($known_people['pid']) }}
                                        /
                                        <a href="{{ route('admin.people.index') }}"
                                           class="text-secondary"
                                           target="_people"
                                        >
                                            {{ number_format($known_people['total']) }}
                                        </a>
                                    </dd>
                                </div>
                                <div class="flex flex-col gap-y-4 mx-auto max-w-xs">
                                    <dt class="text-base leading-7 text-gray-600">Incomplete Identification</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        <a href="{{ route('admin.people.index', ['filters[incomplete_identification]' => 'true']) }}"
                                           class="text-secondary"
                                           target="_people"
                                        >
                                            {{ number_format($known_people['incomplete_identification']) }}
                                        </a>
                                        /
                                        <a href="{{ route('admin.people.index', ['filters[incomplete_identification]' => 'false']) }}"
                                           class="text-secondary"
                                           target="_people"
                                        >
                                            {{ number_format($known_people['total']) }}
                                        </a>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                   @endif
                </div>
            </div>

        </div>
    </div>
</div>
