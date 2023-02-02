<x-admin-layout>

    <main x-data="{
                tab: $persist('activity')
            }"
          class="py-10">
        <!-- Page header -->
        <div class="px-4 mx-auto max-w-3xl sm:px-6 md:flex md:justify-between md:items-center md:space-x-5 lg:px-8 lg:max-w-7xl">
            <div class="flex items-center space-x-5">
                <div class="flex-shrink-0">
                    <div class="relative">
                        <img class="w-16 h-16 rounded-full" src="{{ $page->getFirstMediaUrl('thumb') }}" alt="">
                        <span class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></span>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Page {{ $page->order }}: <a href="{{ route('admin.dashboard.document', ['item' => $item]) }}" class="font-medium text-indigo-600 capitalize">{{ $item->name }}</a>
                        <div class="inline-block">
                            <div class="flex flex-1 justify-start ml-4">
                                @if($previousPage = $page->previous())
                                    <a href="{{ route('admin.dashboard.page', ['item' => $item, 'page' => $previousPage]) }}" class="inline-flex relative items-center py-1 px-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-50"> Previous </a>
                                @endif
                                @if($nextPage = $page->next())
                                    <a href="{{ route('admin.dashboard.page', ['item' => $item, 'page' => $nextPage]) }}" class="inline-flex relative items-center py-1 px-2 ml-3 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-50"> Next </a>
                                @endif
                            </div>
                        </div>
                    </h1>
                    <p class="text-sm font-medium text-gray-500">
                        Item ID: {{ $item->id }} | Page ID: {{ $page->id }}
                    </p>
                </div>
            </div>
            <div class="flex flex-col-reverse mt-6 space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-y-0 sm:space-x-3 sm:space-x-reverse md:flex-row md:mt-0 md:space-x-3 justify-stretch">
                    <span class="inline-flex relative z-0 rounded-md shadow-sm">
                      <a href="{{ route('pages.show', ['item' => $item, 'page' => $page]) }}" class="inline-flex relative items-center py-2 px-4 text-sm font-medium text-gray-700 bg-white rounded-l-md border border-gray-300 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none" target="_blank">Website</a>
                      <a href="{{ $page->ftp_link }}" class="inline-flex relative items-center py-2 px-4 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none" target="_blank">FTP</a>
                      <a href="/nova/resources/pages/{{ $page->id }}" class="inline-flex relative items-center py-2 px-4 -ml-px text-sm font-medium text-gray-700 bg-white rounded-r-md border border-gray-300 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none" target="_blank">Nova</a>
                    </span>
            </div>
        </div>


        <div class="mx-auto mt-4 max-w-7xl">
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                <select x-model="tab"
                        id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="activity">Activity</option>

                    <option value="transcript">Transcript</option>

                    <option value="tags">Tags</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px" aria-label="Tabs">
                        <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
                        <span x-on:click="tab = 'activity'"
                              :class="tab =='activity' ? 'border-indigo-500 text-indigo-600' : 'cursor-pointer border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 '"
                              class="py-4 px-1 w-1/4 text-sm font-medium text-center border-b-2" aria-current="page">
                            Activity </span>

                        <span x-on:click="tab = 'transcript'"
                              :class="tab =='transcript' ? 'border-indigo-500 text-indigo-600' : 'cursor-pointer border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 '"
                              class="py-4 px-1 w-1/4 text-sm font-medium text-center border-b-2"> Transcript </span>

                        <span x-on:click="tab = 'tags'"
                              :class="tab =='tags' ? 'border-indigo-500 text-indigo-600' : 'cursor-pointer border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 '"
                              class="py-4 px-1 w-1/4 text-sm font-medium text-center border-b-2"> Tags </span>
                    </nav>
                </div>
            </div>
        </div>

        <div x-show="tab == 'activity'"
             x-cloak
        >
            <div class="grid grid-cols-1 gap-6 mx-auto mt-8 max-w-3xl sm:px-6 lg:grid-cols-3 lg:grid-flow-col-dense lg:max-w-7xl">
                <div class="space-y-6 lg:col-span-2 lg:col-start-1">
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
            <div class="mx-auto mt-4 max-w-7xl">

                <div class="flex grid gap-5 md:grid-cols-2">

                    <div>
                        <img src="{{ $page->getFirstMediaUrl() }}" alt="" />
                    </div>

                    <div x-data="{
                           transcript: $persist('raw')
                    }">
                        <div class="grid grid-cols-2 mb-4 space-x-4">
                            <div x-on:click="transcript='raw'"
                                 class="py-2 px-3 text-sm font-medium text-center rounded-md"
                                 :class="transcript=='raw' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700 cursor-pointer'"
                            >
                                Raw Transcript
                            </div>
                            <div x-on:click="transcript='linked'"
                                 class="py-2 px-3 text-sm font-medium text-center rounded-md"
                                 :class="transcript=='linked' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700 cursor-pointer'"
                            >
                                Linked Transcript
                            </div>
                        </div>
                        <div>
                            <div x-show="transcript=='raw'"
                                 x-cloak
                            >
                                {!! $page->transcript !!}
                            </div>
                            <div x-show="transcript=='linked'"
                                 x-cloak
                            >
                                {!! $page->text() !!}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div x-show="tab == 'tags'"
             x-cloak
        >
            <div class="mx-auto mt-4 max-w-7xl">

                <div class="flex grid gap-5 md:grid-cols-3">

                    <div>
                        <div class="px-4 sm:px-6 lg:px-8">
                            <div class="flex flex-col mt-8">
                                <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block py-2 min-w-full align-middle md:px-6 lg:px-8">
                                        <div class="overflow-hidden ring-1 ring-black ring-opacity-5 shadow md:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">Dates</th>
                                                </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($page->dates as $date)
                                                    <tr>
                                                        <td class="py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
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
                            <div class="flex flex-col mt-8">
                                <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block py-2 min-w-full align-middle md:px-6 lg:px-8">
                                        <div class="overflow-hidden ring-1 ring-black ring-opacity-5 shadow md:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">People & Places</th>
                                                </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($page->subjects->sortBy('name') as $subject)
                                                    <tr>
                                                        <td class="py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                            <a href="{{ route('subjects.show', ['subject' => $subject->slug ]) }}"
                                                               target="_blank"
                                                               class="text-secondary"
                                                            >
                                                                {{ $subject->name }}
                                                            </a>
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
