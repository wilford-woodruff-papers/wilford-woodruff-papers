<div wire:init="load">
    <div x-data="{}"
         class="grid grid-cols-12 gap-x-4">
        <div class="col-span-12 pr-8">
            <h1 class="px-4 my-4 text-2xl font-bold leading-6 text-gray-900">Browse People by Date</h1>
            <div class="py-4 px-4">
                <div class="flex gap-8">
                    <div>
                        <div>
                            <label for="start" class="block text-sm font-medium leading-6 text-gray-900">Start Date</label>
                            <div class="mt-2">
                                <input wire:model.live="dates.start"
                                    type="date" name="start" id="start" class="block py-1.5 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset focus:ring-indigo-600 placeholder:text-gray-400">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div>
                            <label for="end" class="block text-sm font-medium leading-6 text-gray-900">End Date</label>
                            <div class="mt-2">
                                <input wire:model.live="dates.end"
                                        type="date" name="end" id="end" class="block py-1.5 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset focus:ring-indigo-600 placeholder:text-gray-400">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($readyToLoad)
                <table class="mt-8 w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th>Person</th>
                        <th>Pages</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($people as $person)
                            <tr class="">
                                <td class="py-3.5 pr-3 pl-4 max-w-lg text-lg text-left text-gray-900 font-base">
                                    <div class="">
                                        <a href="{{ route('subjects.show', ['subject' => $person->slug]) }}"
                                           target="_blank"
                                           class="text-secondary"
                                        >
                                            {{ $person->name }}
                                        </a>
                                    </div>
                                    <div>
                                        @if(! empty($person->bio))
                                            <div>
                                                {!! str($person->bio)->limit(120, '...') !!}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 pr-3 pl-4 text-lg text-left text-gray-900 font-base">
                                    <table class="mt-8 w-full">
                                        <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody class="">
                                            @foreach($person->pages as $page)
                                                <tr class="py-2">
                                                    <td>
                                                        <a href="{{ route('short-url.page', ['hashid' => $page->hashid]) }}"
                                                           target="_blank"
                                                           class="text-secondary"
                                                        >
                                                            {{ $page->full_name }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="sticky bottom-0 bg-gray-100">
                        <tr>
                            <td colspan="3">
                                <div class="px-4 my-4 w-full">
                                    {!! $people->links() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>
    </div>
    @push('scripts')
        <script>
            window.addEventListener('load', event => {
                Livewire.on('scroll-to-top', postId => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });
        </script>
    @endpush
</div>
