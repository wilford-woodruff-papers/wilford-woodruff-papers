@php
    $subjects = collect([]);
    $item->pages->each(function($page) use (&$subjects){
        $subjects = $subjects->merge($page->subjects->all());
    });
    $subjects = $subjects->unique('id');
@endphp

<x-guest-layout>

    <div id="content" role="main">

        <div class="px-4 my-12 mx-auto max-w-7xl lg:px-0">
            <div class="my-4 text-4xl font-semibold border-b-2 border-gray-300 text-primary">
                <h2>
                    <span class="title">
                        {{ \Illuminate\Support\Str::of($item->name)->replaceMatches('/\[.*?\]/', '')->trim() }}
                    </span>
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-12">
                <div class="col-span-1 md:col-span-4">
                    <div class="property">
                        <h4>
                            Title
                        </h4>
                        <div class="values">
                            <div class="value" lang="">
                                {{ \Illuminate\Support\Str::of($item->name)->replaceMatches('/\[.*?\]/', '')->trim() }}
                            </div>
                        </div>
                    </div>
                    @if($item->type)
                        <div class="property">
                            <h4>Document Type</h4>
                            <div class="value">
                                <a href="{{ route('documents', ['type' => $item->type]) }}">
                                    {{ $item->type->name }}
                                </a>
                            </div>
                            <div class="my-8">
                                <x-links.primary
                                    href="{{ route('documents.show.transcript', ['item' => $item->uuid]) }}"
                                    target="_blank"
                                >
                                    View Full Transcript
                                </x-links.primary>
                            </div>
                        </div>
                    @endif
                    @hasanyrole('Editor|Admin|Super Admin')
                        @if(! empty($item->count() > 0))
                            <div class="property">
                                <h4>Sections ({{ $item->items->count() }})</h4>
                                @foreach($item->items->sortBy('order') as $section)
                                    <div class="value">
                                        {{ $section->name }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endhasanyrole
                    @if($subjects)
                        <div class="property">
                            <h4>
                                People & Places
                            </h4>
                            <div class="values">
                                @foreach($subjects->sortBy('name') as $subject)
                                    <div class="value" lang="">
                                        <a class="text-secondary"
                                           href="{{ route('subjects.show', ['subject' => $subject]) }}">
                                            {{ $subject->name }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
                <div class="col-span-1 md:col-span-8">

                    <ul class="divide-y divide-gray-200">

                        @foreach($pages as $page)

                            <x-page-summary :page="$page" />

                        @endforeach

                    </ul>
                    <div class="px-8 my-4">
                        {!! $pages->withQueryString()->links('vendor.pagination.tailwind') !!}
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-guest-layout>
