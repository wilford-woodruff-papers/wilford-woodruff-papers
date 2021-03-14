@php
    $subjects = collect([]);
    $item->pages->each(function($page) use (&$subjects){
        $subjects = $subjects->merge($page->subjects->all());
    });
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

                        @foreach($item->pages as $page)
                            <li class="py-4 grid grid-cols-7">
                                <div class="col-span-1 px-2">
                                    <a class="col-span-1 h-auto w-20 my-2 mx-auto" href="{{ route('pages.show', ['item' => $item, 'page' => $page]) }}">
                                        <img src="{{ optional($page->getFirstMedia())->getUrl('thumb') }}" alt="">
                                    </a>
                                </div>
                                <div class="col-span-6 py-2">
                                    <p class="text-lg font-medium text-secondary pb-1 capitalize">
                                        <a href="{{ route('pages.show', ['item' => $item, 'page' => $page]) }}">{{ $page->name }}</a>
                                    </p>
                                    <p class="text-sm text-gray-500 ml-2 py-2">
                                        {{--TODO: add snippet of transcript --}}
                                    </p>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>

        </div>
    </div>

</x-guest-layout>
