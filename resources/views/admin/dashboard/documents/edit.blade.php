<x-admin-layout>
    <main class="relative mt-8"
        x-data="{
            shadow: false,
            showSuccess: true
        }"
        x-init="setTimeout(() => showSuccess = false, 3000)"
    >
        <div class="px-4 pb-6 mx-auto max-w-screen-xl sm:px-6 lg:px-8 lg:pb-16">
            <div class="bg-white rounded-lg shadow">
                <div x-intersect:leave="shadow = true"
                     x-intersect:enter="shadow = false"
                ></div>
                @if(session('success'))
                    <div x-show="showSuccess"
                         x-transition
                         class="p-4 bg-green-50 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Heroicon name: mini/check-circle -->
                                <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{!! session('success') !!}</p>
                            </div>
                            <div class="pl-3 ml-auto">
                                <div class="-my-1.5 -mx-1.5">
                                    <button type="button"
                                            x-on:click="showSuccess = false;"
                                            class="inline-flex p-1.5 text-green-500 bg-green-50 rounded-md hover:bg-green-100 focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50 focus:outline-none">
                                        <span class="sr-only">Dismiss</span>
                                        <!-- Heroicon name: mini/x-mark -->
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="divide-y divide-gray-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">
                    <form action="{{ route('admin.dashboard.document.update', ['item' => $item->uuid]) }}"
                          method="POST"
                          class="divide-y divide-gray-200 lg:col-span-12">
                        @csrf()

                        <div class="sticky top-0 z-10 bg-white"
                             :class="shadow && 'drop-shadow-md'"
                        >
                            <div class="divide-y divide-gray-200">
                                <div class="flex justify-center py-4 px-4 sm:px-6">
                                    <button type="submit" class="inline-flex justify-center py-2 px-12 text-sm font-medium text-white rounded-md border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none bg-sky-700 hover:bg-sky-800 focus:ring-sky-500">Save</button>
                                <a href="{{ route('admin.dashboard.document', ['item' => $item->uuid]) }}"
                                   class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">Cancel</a>
                                </div>
                            </div>
                        </div>

                        <!-- Fields section -->
                        <div class="py-6 px-4 sm:p-6 lg:pb-8">
                            <div>
                                <h2 class="text-xl font-bold leading-6 text-gray-900">
                                    {{ $item->name }}
                                </h2>
                                <p class="mt-1 text-base font-semibold text-gray-500">
                                    {{ $item->pcf_unique_id_full }}
                                </p>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="name"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Name</span>
                                    </label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           value="{{ $item->name }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    >
                                </div>
                            </div>

                            @if($item->pages_count == 0)
                                <div class="grid grid-cols-12 gap-6 mt-6">
                                    <div class="col-span-12">
                                        <label for="manual_page_count"
                                               class="block text-sm font-medium text-gray-700"
                                        >
                                            <span class="font-semibold">Manual Page Count</span>
                                        </label>
                                        <input type="number"
                                               name="manual_page_count"
                                               id="manual_page_count"
                                               value="{{ $item->manual_page_count }}"
                                               class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                        >
                                    </div>
                                </div>
                            @else
                                <div class="grid grid-cols-12 gap-6 mt-6">
                                    <div class="col-span-12">
                                        <label for="auto_page_count"
                                               class="block text-sm font-medium text-gray-700"
                                        >
                                            <span class="font-semibold">Auto Page Count</span>
                                        </label>
                                        <input type="number"
                                               name=""
                                               id="auto_page_count"
                                               value="{{ $item->pages_count }}"
                                               readonly="readonly"
                                               class="block py-2 px-3 mt-1 w-full bg-gray-200 rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                        >
                                    </div>
                                </div>
                            @endif

                            <div class="grid grid-cols-2 gap-6 mt-6">
                                @if(! empty($item->ftp_slug))
                                    <a href="https://fromthepage.com/woodruff/woodruffpapers/{{ $item->ftp_slug }}"
                                       class="inline-flex justify-center items-center py-2 px-3 text-sm font-medium leading-4 text-white bg-amber-700 rounded-md border border-transparent shadow-sm hover:bg-amber-900 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:outline-none"
                                       target="_blank">
                                        View in FTP
                                    </a>
                                @else
                                    <div class="flex gap-x-4 items-center">
                                        <a href="https://fromthepage.com/woodruff/woodruffpapers/new_work"
                                           class="inline-flex gap-x-3 justify-center items-center py-2 px-3 text-sm font-medium leading-4 text-white bg-indigo-600 rounded-md border border-transparent shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                                           target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                            </svg>
                                            Upload to FTP

                                        </a>
                                        <livewire:admin.single-action
                                            :actionTypeName="'Uploaded to FTP'"
                                            :actionTypeNamePrefix="'Mark'"
                                            :modelId="$item->id"
                                            :type="'Research'" />
                                    </div>
                                @endif
                            </div>


                            <div class="grid grid-cols-12 gap-6 mt-6">
                                {{--<div class="col-span-12 sm:col-span-6">
                                    <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
                                    <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500">
                                </div>--}}

                                @php
                                    $template = $item->type->template;
                                    if(! empty($item->type->type_id)) {
                                        $template = $item->type->type->template;
                                    }
                                @endphp

                                @foreach($template->properties as $property)
                                    <div class="col-span-{{ $property->width ?? 12 }}">
                                        @switch($property->type)
                                            @case('link')
                                                <x-admin.document.properties.link :property="$property"
                                                                                  :value="$item->values->where('property_id', $property->id)->first()"
                                                                                  :modelId="$item->id"
                                                />
                                                @break
                                            @case('html')
                                                <x-admin.document.properties.html :property="$property"
                                                                                  :value="$item->values->where('property_id', $property->id)->first()"
                                                                                  :modelId="$item->id"
                                                />
                                                @break
                                            @case('date')
                                                <x-admin.document.properties.date :property="$property"
                                                                                  :value="$item->values->where('property_id', $property->id)->first()"
                                                                                  :modelId="$item->id"
                                                />
                                                @break
                                            @default
                                                <x-admin.document.properties.text :property="$property"
                                                                                  :value="$item->values->where('property_id', $property->id)->first()"
                                                                                  :modelId="$item->id"
                                                />
                                                @break
                                        @endswitch
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-12 divide-y divide-gray-200">
                                <div class="flex justify-center py-4 px-4 sm:px-6">
                                    <button type="submit" class="inline-flex justify-center py-2 px-12 text-sm font-medium text-white rounded-md border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none bg-sky-700 hover:bg-sky-800 focus:ring-sky-500">Save</button>
                                    <a href="{{ route('admin.dashboard.document', ['item' => $item->uuid]) }}"
                                       class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>
