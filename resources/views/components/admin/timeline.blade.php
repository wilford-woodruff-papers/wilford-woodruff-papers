<section aria-labelledby="timeline-title" class="lg:col-span-1 lg:col-start-3">
    <div class="py-5 px-4 bg-white shadow sm:px-6 sm:rounded-lg">
        <h2 id="timeline-title" class="text-lg font-medium text-gray-900">Timeline</h2>

        <!-- Activity Feed -->
        <div class="flow-root mt-6">
            <ul role="list" class="mb-2">
                @foreach($model->activities as $activity)
                    <li>
                        <div class="relative pb-8">
                            <span class="absolute top-4 left-4 -ml-px w-0.5 h-full bg-gray-200" aria-hidden="true"></span>
                            <div class="flex relative space-x-3">
                                <div>
                                    @switch($activity->event)
                                        @case('assigned')
                                            <span class="flex justify-center items-center w-8 h-8 bg-gray-400 rounded-full ring-8 ring-white">
                                                <!-- Heroicon name: solid/user -->
                                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        @break
                                        @case('completed')
                                            <span class="flex justify-center items-center w-8 h-8 bg-green-500 rounded-full ring-8 ring-white">
                                                <!-- Heroicon name: solid/check -->
                                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        @break
                                        @default

                                    @endswitch

                                </div>
                                <div class="flex flex-1 justify-between pt-1.5 space-x-4 min-w-0">
                                    <div>
                                        <p class="text-sm text-gray-500 activity">{!! $activity->description !!}</p>
                                    </div>
                                    <div class="text-sm text-right text-gray-500 whitespace-nowrap">
                                        <time datetime="{{ $activity->created_at?->toDateString() }}">{{ $activity->created_at?->toFormattedDateString() }}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
