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
                        @if($photo->tags->count() > 0)
                            <p class="mt-3 mb-4">
                                @foreach($photo->tags as $tag)
                                    <a href="{{ route('media.photos', ['tag[]' => $tag->name]) }}"
                                       class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-secondary text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-2 w-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </p>
                        @endif
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
                                                @if(! empty($photo->description))
                                                    <!-- Odd row -->
                                                    <tr class="bg-white">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            Description
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500">
                                                            {{ $photo->description }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->date))
                                                    <!-- Even row -->
                                                    <tr class="bg-gray-50">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            Date
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500">
                                                            {{ optional($photo->date)->format('m d, Y') ?? $photo->date  }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->artist_or_photographer))
                                                    <!-- Odd row -->
                                                    <tr class="bg-white">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            Artist or Photographer
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500">
                                                            {{ $photo->artist_or_photographer }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->location))
                                                    <!-- Even row -->
                                                    <tr class="bg-gray-50">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            Location
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500">
                                                            {{ $photo->location }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->journal_reference))
                                                    <!-- Odd row -->
                                                    <tr class="bg-white">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            Journal Reference
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500">
                                                            {{ $photo->journal_reference }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->identification))
                                                    <!-- Even row -->
                                                    <tr class="bg-gray-50">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            Identification of Image
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500">
                                                            {{ $photo->identification }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->source))
                                                    <!-- Even row -->
                                                    <tr class="bg-gray-50">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            Source of Image
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500">
                                                            <a href="{{ $photo->source }}"
                                                               class="text-secondary"
                                                               target="_photo_source"
                                                            >
                                                                {{ $photo->source }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->editor))
                                                    <!-- Odd row -->
                                                    <tr class="bg-white">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            Photo Editor
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500">
                                                            {{ $photo->editor }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->notes))
                                                    <!-- Even row -->
                                                    <tr class="bg-gray-50">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            Notes
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500">
                                                            {{ $photo->notes }}
                                                        </td>
                                                    </tr>
                                                @endif

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
