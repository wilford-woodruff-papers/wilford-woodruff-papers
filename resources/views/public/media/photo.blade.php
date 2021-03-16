<x-guest-layout>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="content col-span-12 md:col-span-9">
                        <h2>{{ $photo->title }}</h2>
                        <img class="max-w-4xl w-full md:w-1/2 mx-auto"
                             src="{{ optional($photo->getFirstMedia())->getUrl('web') }}"
                        />
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div class="flex flex-col mt-12">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <tbody>

                                                <!-- Odd row -->
                                                <tr class="bg-white">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        Description
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        {{ $photo->description }}
                                                    </td>
                                                </tr>

                                                <!-- Even row -->
                                                <tr class="bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        Date
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        {{ optional($photo->date)->format('m d, Y') }}
                                                    </td>
                                                </tr>

                                                <!-- Odd row -->
                                                <tr class="bg-white">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        Artist or Photographer
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        {{ $photo->artist_or_photographer }}
                                                    </td>
                                                </tr>

                                                <!-- Even row -->
                                                <tr class="bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        Location
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        {{ $photo->location }}
                                                    </td>
                                                </tr>

                                                <!-- Odd row -->
                                                <tr class="bg-white">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        Journal Reference
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        {{ $photo->journal_reference }}
                                                    </td>
                                                </tr>

                                                <!-- Even row -->
                                                <tr class="bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        Identification / Source of Image
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        {{ $photo->identification_source }}
                                                    </td>
                                                </tr>

                                                <!-- Odd row -->
                                                <tr class="bg-white">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        Photo Editor
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        {{ $photo->editor }}
                                                    </td>
                                                </tr>

                                                <!-- Even row -->
                                                <tr class="bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        Notes
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        {{ $photo->notes }}
                                                    </td>
                                                </tr>


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
</x-guest-layout>
