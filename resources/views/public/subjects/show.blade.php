<x-guest-layout>
    <x-slot name="title">
        {{ strip_tags($subject->name) }} | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">

        <div class="px-4 mx-auto max-w-7xl">


            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-6 px-8 content">
                        <h2>{!! $subject->name !!}</h2>
                        <p>
                            {!! $subject->bio !!}
                        </p>
                        @if(! empty($subject->subject_id))
                            <ul class="flex flex-col gap-y-1 ml-1">
                                <li>
                                    <a class="text-secondary popup"
                                       href="{{ route('subjects.show', ['subject' => $subject->parent])  }}"
                                    >
                                        {{ $subject->parent->name }}
                                    </a>
                                </li>
                            </ul>
                        @endif
                        @if($subject->children->count() > 0)
                            <ul class="flex flex-col gap-y-1 ml-1">
                                @foreach($subject->children->sortBy('name') as $subTopic)
                                    <li>
                                        <a class="text-secondary popup"
                                           href="{{ route('subjects.show', ['subject' => $subTopic])  }}"
                                        >
                                            {{ $subTopic->name }} ({{ $subTopic->pages_count }})
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if(! empty($subject->geolocation))
                            <img src="{{ $subject->mapUrl() }}"
                                 alt=""
                                 class="mx-auto w-full h-auto md:w-1/2"
                            />
                        @endif

                        @if(! empty($subject->footnotes))
                            <h3 class="mt-8 text-2xl border-b border-primary">Footnotes</h3>
                            <p class="mt-4 mb-4">
                                {!! $subject->footnotes !!}
                            </p>
                        @endif

                    </div>
                    <div class="col-span-12 px-8 md:col-span-12">
                        <!--<h3 class="pt-7 mt-4 mb-8 font-serif text-3xl border-b border-gray-300 text-primary">Pages</h3>-->
                        <div class="preview-block">
                            <h3 class="mt-4 text-2xl border-b border-primary">Mentioned in</h3>
                            <ul class="divide-y divide-gray-200">

                                @foreach($pages as $page)

                                    <x-page-summary :page="$page" />

                                @endforeach

                            </ul>

                            <div>
                                {!! $pages->withQueryString()->links() !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('styles')
        <style>
            .content ul {
                list-style-type: none;
            }
            .content ul li:before {
                content: '\2014';
                position: absolute;
                margin-left: -20px;
            }
        </style>
    @endpush
</x-guest-layout>
