@php
    $subjects = collect([]);
    $item->pages->each(function($page) use (&$subjects){
        $subjects = $subjects->merge($page->subjects->all());
    });
    $subjects = $subjects->unique('id');
@endphp

<x-guest-layout>

    <div id="content" role="main">

        <div class="max-w-7xl mx-auto my-12 px-4 lg:px-0">
            <div class="text-4xl text-primary font-semibold my-4 border-b-2 border-gray-300">
                <h2>
                    <span class="title">
                        {{ $item->name }}
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
                                {{ $item->name }}
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
                        </div>
                    @endif
                    @if(auth()->check() && auth()->user()->hasRole('Super Admin'))
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
                    @endif
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
                    <div class="my-4 px-8">
                        {!! $pages->withQueryString()->links('vendor.pagination.tailwind') !!}
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-guest-layout>
