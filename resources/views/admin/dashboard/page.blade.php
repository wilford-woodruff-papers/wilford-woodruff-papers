<x-admin-layout>

    <main x-data="{
                tab: 'activity'
            }"
          class="py-10">
        <!-- Page header -->
        <div class="max-w-3xl mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
            <div class="flex items-center space-x-5">
                <div class="flex-shrink-0">
                    <div class="relative">
                        <img class="h-16 w-16 rounded-full" src="{{ $page->getFirstMediaUrl('thumb') }}" alt="">
                        <span class="absolute inset-0 shadow-inner rounded-full" aria-hidden="true"></span>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Page {{ $page->order }}: <a href="{{ route('admin.dashboard.document', ['item' => $item]) }}" class="font-medium text-indigo-600 capitalize">{{ $item->name }}</a>
                        <div class="inline-block">
                            <div class="flex-1 flex justify-start ml-4">
                                @if($previousPage = $page->previous())
                                    <a href="{{ route('admin.dashboard.page', ['item' => $item, 'page' => $previousPage]) }}" class="relative inline-flex items-center px-2 py-1 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                                @endif
                                @if($nextPage = $page->next())
                                    <a href="{{ route('admin.dashboard.page', ['item' => $item, 'page' => $nextPage]) }}" class="ml-3 relative inline-flex items-center px-2 py-1 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
                                @endif
                            </div>
                        </div>
                    </h1>
                    <p class="text-sm font-medium text-gray-500">
                        Item ID: {{ $item->id }} | Page ID: {{ $page->id }}
                    </p>
                </div>
            </div>
            <div class="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                      <a href="{{ route('pages.show', ['item' => $item, 'page' => $page]) }}" class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" target="_blank">Website</a>
                      <a href="{{ $page->ftp_link }}" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" target="_blank">FTP</a>
                      <a href="/nova/resources/pages/{{ $page->id }}" class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" target="_blank">Nova</a>
                    </span>
            </div>
        </div>


        <div class="mt-4 max-w-7xl mx-auto">
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                <select x-model="tab"
                        id="tabs" name="tabs" class="block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                    <option value="activity">Activity</option>

                    <option value="transcript">Transcript</option>

                    <option value="tags">Tags</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex" aria-label="Tabs">
                        <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
                        <span x-on:click="tab = 'activity'"
                              :class="tab == 'activity' ? 'border-indigo-500 text-indigo-600' : 'cursor-pointer border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 '"
                              class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page">
                            Activity </span>

                        <span x-on:click="tab = 'transcript'"
                              :class="tab == 'transcript' ? 'border-indigo-500 text-indigo-600' : 'cursor-pointer border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 '"
                              class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"> Transcript </span>

                        <span x-on:click="tab = 'tags'"
                              :class="tab == 'tags' ? 'border-indigo-500 text-indigo-600' : 'cursor-pointer border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 '"
                              class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"> Tags </span>
                    </nav>
                </div>
            </div>
        </div>

        <div x-show="tab == 'activity'">
            <div class="mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
                <div class="space-y-6 lg:col-start-1 lg:col-span-2">
                    <!-- Description list-->
                    <section aria-labelledby="applicant-information-title">
                        <x-admin.actions-table :model="$page" />
                    </section>

                    <!-- Comments-->
                    <livewire:admin.comments :model="$page"/>
                </div>

                <x-admin.timeline :model="$page"/>

            </div>
        </div>

        <div x-show="tab == 'transcript'"
             x-cloak
        >
            <div class="mt-4 max-w-7xl mx-auto">

                <div class="flex grid md:grid-cols-2 gap-5">

                    <div>
                        <img src="{{ $page->getFirstMediaUrl() }}" alt="" />
                    </div>

                    <div>
                        {!! $page->transcript !!}
                    </div>

                </div>

            </div>

        </div>

        <div x-show="tab == 'tags'"
             x-cloak
        >
            <div class="mt-4 max-w-7xl mx-auto">

                <div class="flex grid md:grid-cols-3 gap-5">

                    <div>
                        <div class="px-4 sm:px-6 lg:px-8">
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Dates</th>
                                                </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 bg-white">
                                                @foreach($page->dates as $date)
                                                    <tr>
                                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                            {{ $date->date->format('F j, Y') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div>
                        <div class="px-4 sm:px-6 lg:px-8">
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">People & Places</th>
                                                </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 bg-white">
                                                @foreach($page->subjects->sortBy('name') as $subject)
                                                    <tr>
                                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                            {{ $subject->name }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </main>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    @endpush
</x-admin-layout>
