<div>

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
                    <div id="errors-top">
                        @if ($errors->any())
                            <div class="p-4 bg-red-50 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <!-- Heroicon name: solid/x-circle -->
                                        <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h2 class="text-sm font-medium text-red-800">
                                            There were {{ $errors->count() }} error(s) saving this resource
                                        </h2>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul class="pl-5 space-y-1 list-disc">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="divide-y divide-gray-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">
                        <form action="{{ route('admin.dashboard.document.store') }}"
                              method="POST"
                              class="divide-y divide-gray-200 lg:col-span-12">
                            @csrf()

                            <div class="sticky top-0 z-10 bg-white"
                                 :class="shadow && 'drop-shadow-md'"
                            >
                                <div class="divide-y divide-gray-200">
                                    <div class="flex justify-center py-4 px-4 sm:px-6">
                                        <button type="submit" class="inline-flex justify-center py-2 px-12 text-sm font-medium text-white rounded-md border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none bg-sky-700 hover:bg-sky-800 focus:ring-sky-500">Save</button>
                                        <a href="{{ route('admin.dashboard.document.index') }}"
                                           class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">Cancel</a>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2">
                                <div class="py-6 px-4 sm:p-6 lg:pb-8">
                                    <div>
                                        <label for="type" class="block text-sm font-medium text-gray-700">Document Type <span class="text-red-800">*</span></label>
                                        <select wire:model="type"
                                                id="type"
                                                name="type_id"
                                                class="block py-2 pr-10 pl-3 mt-1 w-full text-base rounded-md border-gray-300 sm:text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                                            <option value="">-- Select Document Type --</option>
                                            @foreach($types as $t)
                                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="py-6 px-4 sm:p-6 lg:pb-8 @if(empty($type) && ! empty(\App\Models\Type::query()->with('subType')->firstWhere('id', $type)->subType)) hidden @endif">
                                    <div>
                                        <label for="section_count" class="block text-sm font-medium text-gray-700">Create Sections</label>
                                        <input wire:model="section_count"
                                               type="number"
                                               id="section_count"
                                               name="section_count"
                                               class="block py-2 pr-10 pl-3 mt-1 w-full text-base rounded-md border-gray-300 sm:text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                                               max="40"
                                        />
                                    </div>
                                </div>
                            </div>

                            @if(! empty($type) && is_array($typeName = $prefixes[\App\Models\Type::find($type)->name]))
                                <div class="py-6 px-4 sm:p-6 lg:pb-8">
                                    <div>
                                        <label for="pcf_unique_id_prefix" class="block text-sm font-medium text-gray-700">Prefix <span class="text-red-800">*</span></label>
                                        <select id="pcf_unique_id_prefix"
                                                name="pcf_unique_id_prefix"
                                                class="block py-2 pr-10 pl-3 mt-1 w-full text-base rounded-md border-gray-300 sm:text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                                            <option value="">-- Select Unique ID Prefix --</option>
                                            @foreach($typeName as $key => $prefix)
                                                <option value="{{ $prefix }}">{{ $prefix }} - {{ $key }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @elseif(! empty($type))
                                <input type="hidden"
                                       name="pcf_unique_id_prefix"
                                       value="{{ $prefixes[\App\Models\Type::find($type)->name] }}" />
                            @endif

                            <div>
                                @if(! empty($template))
                                    <!-- Fields section -->
                                    <div class="py-6 px-4 sm:p-6 lg:pb-8">
                                        <div>
                                            <h2 class="text-lg font-medium leading-6 text-gray-900">{{ $item->name }}</h2>
                                            <p class="mt-1 text-sm text-gray-500"></p>
                                        </div>

                                        <div class="grid grid-cols-12 gap-6 mt-6">
                                            <div class="col-span-12">
                                                <label for="name"
                                                       class="block text-sm font-medium text-gray-700"
                                                >
                                                    <span class="font-semibold">Name <span class="text-red-800">*</span></span>
                                                </label>
                                                <input type="text"
                                                       name="name"
                                                       id="name"
                                                       value="{{ $item->name }}"
                                                       class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                                >
                                            </div>
                                        </div>


                                        <div class="grid grid-cols-12 gap-6 mt-6">
                                            <div class="col-span-12">
                                                <label for="manual_page_count"
                                                       class="block text-sm font-medium text-gray-700"
                                                >
                                                    <span class="font-semibold">Page Count <span class="text-red-800">*</span></span>
                                                </label>
                                                <input type="number"
                                                       name="manual_page_count"
                                                       id="manual_page_count"
                                                       value="{{ $item->manual_page_count }}"
                                                       class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                                >
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-12 gap-6 mt-6">
                                            {{--<div class="col-span-12 sm:col-span-6">
                                                <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
                                                <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500">
                                            </div>--}}

                                            @foreach($template->properties as $property)
                                                <div class="col-span-{{ $property->width ?? 12 }}">
                                                    @switch($property->type)
                                                        @case('link')
                                                            <x-admin.document.properties.link :property="$property"
                                                                                              :value="$item->values->where('property_id', $property->id)->first()"
                                                            />
                                                            @break
                                                        @case('html')
                                                            <x-admin.document.properties.html :property="$property"
                                                                                              :value="$item->values->where('property_id', $property->id)->first()"
                                                            />
                                                            @break
                                                        @case('date')
                                                            <x-admin.document.properties.date :property="$property"
                                                                                              :value="$item->values->where('property_id', $property->id)->first()"
                                                            />
                                                            @break
                                                        @default
                                                            <x-admin.document.properties.text :property="$property"
                                                                                              :value="$item->values->where('property_id', $property->id)->first()"
                                                            />
                                                            @break
                                                    @endswitch
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mt-12 divide-y divide-gray-200">
                                            <div class="flex justify-center py-4 px-4 sm:px-6">
                                                <button type="submit" class="inline-flex justify-center py-2 px-12 text-sm font-medium text-white rounded-md border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none bg-sky-700 hover:bg-sky-800 focus:ring-sky-500">Save</button>
                                                <a href="{{ route('admin.dashboard.document.index') }}"
                                                   class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>


</div>
