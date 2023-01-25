<x-admin-layout>
    <main class="relative mt-8">
        <div class="mx-auto max-w-screen-xl px-4 pb-6 sm:px-6 lg:px-8 lg:pb-16">
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="divide-y divide-gray-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">
                    <form action="{{ route('admin.dashboard.document.update', ['item' => $item->uuid]) }}"
                          method="POST"
                          class="divide-y divide-gray-200 lg:col-span-12">
                        @csrf()

                        <div class="sticky top-0">
                            <div class="divide-y divide-gray-200 pt-6">
                                <div class="mt-4 flex justify-end py-4 px-4 sm:px-6">
                                    <a href="{{ route('admin.dashboard.document', ['item' => $item->uuid]) }}"
                                       class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">Cancel</a>
                                    <button type="submit" class="ml-5 inline-flex justify-center rounded-md border border-transparent bg-sky-700 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">Save</button>
                                </div>
                            </div>
                        </div>

                        <!-- Fields section -->
                        <div class="py-6 px-4 sm:p-6 lg:pb-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">{{ $item->name }}</h2>
                                <p class="mt-1 text-sm text-gray-500"></p>
                            </div>

                            <div class="mt-6 grid grid-cols-12 gap-6">
                                <div class="col-span-12">
                                    <label for="name"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        Name
                                    </label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           value="{{ $item->name }}"
                                           class="mt-1 block w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-sky-500 sm:text-sm"
                                    >
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-12 gap-6">
                                {{--<div class="col-span-12 sm:col-span-6">
                                    <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
                                    <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-sky-500 sm:text-sm">
                                </div>--}}

                                @foreach($item->type->template->properties as $property)
                                    <div class="col-span-12">
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>
