<x-guest-layout>
    <div id="content" role="main">

        <div class="max-w-7xl mx-auto px-4">


            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="content col-span-12 px-8 py-6">
                        <h2>{!! $subject->name !!}</h2>
                        <p>
                            {!! $subject->bio !!}
                        </p>
                        @if(! empty($subject->subject_id))
                            <ul class="ml-1 flex flex-col gap-y-1">
                                <li>
                                    <a class="text-secondary popup"
                                       href="{{ route('subjects.show', ['subject' => $subject->parent])  }}"
                                    >
                                        {{ str($subject->parent->name)->title() }}
                                    </a>
                                </li>
                            </ul>
                        @endif
                        @if($subject->children->count() > 0)
                            <ul class="ml-1 flex flex-col gap-y-1">
                                @foreach($subject->children->sortBy('name') as $subTopic)
                                    <li>
                                        <a class="text-secondary popup"
                                           href="{{ route('subjects.show', ['subject' => $subTopic])  }}"
                                        >
                                            {{ str($subTopic->name)->title() }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if(! empty($subject->geolocation))
                            <img src="{{ $subject->mapUrl() }}"
                                 alt=""
                                 class="w-full md:w-1/2 h-auto mx-auto"
                            />
                        @endif

                        @if(! empty($subject->footnotes))
                            <h3 class="mt-8 text-2xl border-b border-primary">Footnotes</h3>
                            <p class="mt-4 mb-4">
                                {!! $subject->footnotes !!}
                            </p>
                        @endif

                    </div>
                    <div class="col-span-12 md:col-span-12 px-8">
                        <!--<h3 class="text-primary text-3xl font-serif mt-4 mb-8 pt-7 border-b border-gray-300">Pages</h3>-->
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
