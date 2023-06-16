<x-guest-layout>

    <x-banner-image :image="$contentPage->banner_image_url"
                    :text="$contentPage->title"
    />

    @hasanyrole('Admin')
        <div class="flex justify-center my-12 mx-auto max-w-7xl">
            <a href="{{ route('content-page.edit', ['contentPage' => $contentPage]) }}"
               class="py-3 px-6 text-white bg-secondary hover:bg-secondary-500"
            >
                Edit
            </a>
        </div>
    @endhasanyrole

    @php
        $headings = Spatie\Regex\Regex::matchAll('/(?:<h2.*>)(.*)(?:<\/h2>)/', $contentPage->body ?? '')->results();
        $contentPage->body = Spatie\Regex\Regex::replace('/(?:<h2.*>)(.*)(?:<\/h2>)/', function (Spatie\Regex\MatchResult $result) {
            return str($result->result())->replace('h2', 'h2 id="'.str($result->group(1))->slug().'"');
        }, $contentPage->body ?? '')->result();
    @endphp
    <div class="my-12 mx-auto max-w-7xl">
        <div class="grid grid-cols-5 gap-x-4">
            @if(count($headings) > 0)
                <div class="col-span-5 md:col-span-1">
                    <div class="hidden sticky top-10 md:block">
                        <nav class="flex flex-col flex-1 px-2" aria-label="Sidebar">
                            <div class="py-2 mb-2 text-lg font-semibold border-b border-gray-200">
                                Contents
                            </div>
                            <ul role="list" class="pl-2 -mx-2 space-y-1">
                                @foreach($headings as $heading)
                                    <li>
                                        <a href="#{{ str($heading->group(1))->slug() }}"
                                           class="flex gap-x-3 p-2 pl-3 text-sm font-semibold leading-6 hover:bg-gray-50 text-secondary group">
                                            {{ $heading->group(1) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                </div>
            @endif
            <div class="{{ ((count($headings) > 0) ? 'md:col-span-4 col-span-5' : 'col-span-5') }}">
                <div class="content-page">
                    {!! $contentPage->body !!}
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/content-builder-styles.css') }}" />
        <link rel="stylesheet" href="/assets/minimalist-blocks/content-tailwind.min.css" />
    @endpush
</x-guest-layout>
