<x-guest-layout>
    <x-slot name="title">
        {{ $photo->title }} | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 content">
                        <h2>{{ $photo->title }}</h2>
                        @if($photo->tags->count() > 0)
                            <p class="mt-3 mb-4">
                                @foreach($photo->tags as $tag)
                                    <a href="{{ route('media.photos', ['tag[]' => $tag->name]) }}"
                                       class="inline-flex items-center py-0.5 px-2 text-xs font-medium text-white bg-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-0.5 w-2 h-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </p>
                        @endif
                        <img class="mx-auto w-full max-w-4xl md:w-1/2"
                             src="{{ $photo->getFirstMedia()?->getUrl('web') }}"
                        />
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div class="flex flex-col mt-12">
                            <div class="overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
                                <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8">
                                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <tbody>
                                                @if(! empty($photo->description))
                                                    <!-- Odd row -->
                                                    <tr class="bg-white">
                                                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                            Description
                                                        </td>
                                                        <td class="py-4 px-6 text-sm text-gray-500">
                                                            {{ $photo->description }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->date))
                                                    <!-- Even row -->
                                                    <tr class="bg-gray-50">
                                                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                            Date
                                                        </td>
                                                        <td class="py-4 px-6 text-sm text-gray-500">
                                                            @if(str($photo->date)->contains('-'))
                                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $photo->date)->format('M d, Y') }}
                                                            @else
                                                                {{ $photo->date  }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->artist_or_photographer))
                                                    <!-- Odd row -->
                                                    <tr class="bg-white">
                                                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                            Artist or Photographer
                                                        </td>
                                                        <td class="py-4 px-6 text-sm text-gray-500">
                                                            {{ $photo->artist_or_photographer }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->location))
                                                    <!-- Even row -->
                                                    <tr class="bg-gray-50">
                                                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                            Location
                                                        </td>
                                                        <td class="py-4 px-6 text-sm text-gray-500">
                                                            {{ $photo->location }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->journal_reference))
                                                    <!-- Odd row -->
                                                    <tr class="bg-white">
                                                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                            Journal Reference
                                                        </td>
                                                        <td class="py-4 px-6 text-sm text-gray-500">
                                                            {{ $photo->journal_reference }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->identification))
                                                    <!-- Even row -->
                                                    <tr class="bg-gray-50">
                                                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                            Identification of Image
                                                        </td>
                                                        <td class="py-4 px-6 text-sm text-gray-500">
                                                            {{ $photo->identification }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->source))
                                                    <!-- Even row -->
                                                    <tr class="bg-gray-50">
                                                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                            Source of Image
                                                        </td>
                                                        <td class="py-4 px-6 text-sm text-gray-500">
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
                                                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                            Photo Editor
                                                        </td>
                                                        <td class="py-4 px-6 text-sm text-gray-500">
                                                            {{ $photo->editor }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(! empty($photo->notes))
                                                    <!-- Even row -->
                                                    <tr class="bg-gray-50">
                                                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                            Notes
                                                        </td>
                                                        <td class="py-4 px-6 text-sm text-gray-500">
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
