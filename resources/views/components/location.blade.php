<div>
    <div id="location-info">

        <div class="px-1 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12">
                    <div class="col-span-12 py-2 content">
                        <h2>{!! $subject->name !!}</h2>
                    </div>
                </div>
                <section class="px-2">
                    <ul class="divide-y divide-gray-200">
                        @foreach($pages as $page)
                            <p class="pb-1 text-lg font-medium capitalize text-secondary">
                                <a href="{{ route('pages.show', ['item' => $page->item, 'page' => $page]) }}"
                                   target="location"
                                >{{ str($page->full_name)->stripBracketedID() }}</a>
                            </p>
                        @endforeach
                    </ul>
                    @if($pages->total() > 10)
                        <p class="py-4">
                            <a href="{{ route('subjects.show', ['subject' => $subject->slug]) }}"
                               class="text-lg font-medium text-secondary hover:text-secondary-600"
                            >View All</a>
                        </p>
                    @endif
                </section>
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
</div>
