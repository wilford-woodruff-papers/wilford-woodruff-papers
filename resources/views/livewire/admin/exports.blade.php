<div>
    <div class="mx-auto max-w-7xl">
        <div>
            @if(! empty($message))
                <div class="p-4 mt-12 bg-green-50 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ $message }}</p>
                        </div>
                        {{--<div class="pl-3 ml-auto">
                            <div class="-my-1.5 -mx-1.5">
                                <button type="button" class="inline-flex p-1.5 text-green-500 bg-green-50 rounded-md hover:bg-green-100 focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50 focus:outline-none">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </button>
                            </div>
                        </div>--}}
                    </div>
                </div>
            @endif
        </div>
        <div class="flex gap-12 items-center py-12">
            <div>
                <div>
                    <label for="export" class="block text-sm font-medium leading-6 text-gray-900 sr-only">Export</label>
                    <select
                        wire:model="export"
                        id="export"
                        name="export"
                        class="block py-1.5 pr-10 pl-3 mt-2 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6 focus:ring-2 focus:ring-indigo-600">
                        <option value="">-- Select Export --</option>
                        @foreach($reports as $key => $name)
                            <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="pt-2">
                <button
                    wire:click="export"
                    type="button"
                    class="py-1.5 px-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Run
                </button>
            </div>
        </div>

        <div class="py-8">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                    <tr>
                        <th class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900">Export Name</th>
                        <th class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900">Date</th>
                        <th class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900">Download Export</th>
                        <th class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900">User</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exports as $export)
                        <tr>
                            <td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap">
                                {{ $export->name }}
                            </td>
                            <td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap">
                                {{ $export->exported_at->toDateTimeString() }}
                            </td>
                            <td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap">
                                <a href="{{ \Illuminate\Support\Facades\Storage::disk('exports')->url($export->filename) }}" target="_blank" class="font-semibold text-secondary hover:text-secondary">
                                    Download
                                </a>
                            </td>
                            <td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap">
                                {{ $export->user?->name }}
                            </td>
                            <td class="justify-end py-4 px-3 text-sm whitespace-nowrap">
                                <button
                                    wire:click="delete({{ $export->id }})"
                                    type="button"
                                    class="inline-flex gap-x-1.5 items-center py-2 px-3 text-sm font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-0.5 w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
