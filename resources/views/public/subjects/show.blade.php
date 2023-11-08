<x-guest-layout>
    <x-slot name="title">
        {{ strip_tags($subject->name) }} | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">

        <div class="px-4 mx-auto max-w-7xl">


            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-6 px-8 content">
                        <div>
                            <h2>
                                {!! $subject->name !!}
                            </h2>
                            @auth()
                                @hasanyrole('Editor|Researcher|Admin|Super Admin')
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold">
                                            {{ $subject->category->sortBy('name')->pluck('name')->implode(', ') }}
                                        </div>
                                        <div class="flex text-center divide-x divide-blue-200">
                                            @if(! empty($subject->subject_uri))
                                                <a href="{{ $subject->subject_uri }}"
                                                   class="px-2 text-center text-secondary"
                                                   target="_blank"
                                                >
                                                    FTP
                                                </a>
                                            @endif
                                            <a href="/nova/resources/subjects/{{ $subject->id }}"
                                               class="px-2 text-center text-secondary"
                                               target="_blank"
                                            >
                                                Nova
                                            </a>
                                            @if(in_array('People', $subject->category->pluck('name')->toArray()))
                                                <a href="{{ route('admin.dashboard.people.edit', ['person' => $subject->slug]) }}"
                                                   class="px-2 text-center text-secondary"
                                                   target="_blank"
                                                >
                                                    Content Admin
                                                </a>
                                            @endif
                                            @if(in_array('Places', $subject->category->pluck('name')->toArray()))
                                                <a href="{{ route('admin.dashboard.places.edit', ['place' => $subject->slug]) }}"
                                                   class="px-2 text-center text-secondary"
                                                   target="_blank"
                                                >
                                                    Content Admin
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endhasanyrole
                            @endif
                        </div>
                        @if(! empty($subject->bio_approved_at))
                            <div>
                                {!! $linkify->process($subject->bio) !!}
                            </div>
                        @endif
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
                        @if(! empty($subject->latitude) && ! empty($subject->longitude))
                            <img src="{{ $subject->getFirstMediaUrl('maps') }}"
                                 alt=""
                                 class="mx-auto w-full h-auto md:w-3/5"
                            />
                        @endif

                        @if(! empty($subject->bio_approved_at) && ! empty($subject->footnotes))
                            <h3 class="mt-8 text-2xl border-b border-primary">Footnotes</h3>
                            <p class="mt-4 mb-4">
                                {!! $linkify->process($subject->footnotes) !!}
                            </p>
                        @endif

                    </div>

                    @if($subject->incomplete_identification)
                        <div class="col-span-12 my-8">
                            <x-incomplete-identification :subject="$subject->name"/>
                        </div>
                    @endif

                    <div class="col-span-12 px-8 md:col-span-12">
                        <!--<h3 class="pt-7 mt-4 mb-8 font-serif text-3xl border-b border-gray-300 text-primary">Pages</h3>-->
                        {{--<div class="preview-block">
                            <h3 class="mt-4 text-2xl border-b border-primary">Mentioned in</h3>


                                @foreach($pages as $page)

                                    <x-page-summary :page="$page" />

                                @endforeach

                            </ul>


                        </div>--}}


                        <!-- Tabs -->
                        <div
                            x-data="{
                                selectedId: $persist( '{{ ($quotes->count() > 0 ? 'tab-1-2' : 'tab-1-1') }}').using(sessionStorage).as('subject-tab'),
                                init() {
                                    // Set the first available tab on the page on page load.
                                    this.$nextTick(() => this.determineDefaultTab())
                                },
                                determineDefaultTab() {
                                    if(Array.from(document.getElementById('subject-tablist').children).length == 1){
                                        this.select('tab-1-1');
                                    }
                                },
                                select(id) {
                                    this.selectedId = id
                                },
                                isSelected(id) {
                                    return this.selectedId === id
                                },
                                whichChild(el, parent) {
                                    return Array.from(parent.children).indexOf(el) + 1
                                }
                            }"
                            x-id="['tab']"
                            class="mx-auto max-w-7xl"
                        >
                            <!-- Tab List -->
                            <ul
                                id="subject-tablist"
                                x-ref="tablist"
                                @keydown.right.prevent.stop="$focus.wrap().next()"
                                @keydown.home.prevent.stop="$focus.first()"
                                @keydown.page-up.prevent.stop="$focus.first()"
                                @keydown.left.prevent.stop="$focus.wrap().prev()"
                                @keydown.end.prevent.stop="$focus.last()"
                                @keydown.page-down.prevent.stop="$focus.last()"
                                role="tablist"
                                class="flex items-stretch -mb-px"
                            >
                                <!-- Tab -->
                                @if($quotes->count() > 0)
                                    <li>
                                        <button
                                            :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
                                            @click="select($el.id)"
                                            @mousedown.prevent
                                            @focus="select($el.id)"
                                            type="button"
                                            :tabindex="isSelected($el.id) ? 0 : -1"
                                            :aria-selected="isSelected($el.id)"
                                            :class="isSelected($el.id) ? 'border-gray-200 bg-white' : 'border-transparent'"
                                            class="inline-flex py-2.5 px-5 font-semibold border-t border-r border-l"
                                            role="tab"
                                        >Selected Quotes</button>
                                    </li>
                                @endif

                                <li>
                                    <button
                                        :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
                                        @click="select($el.id)"
                                        @mousedown.prevent
                                        @focus="select($el.id)"
                                        type="button"
                                        :tabindex="isSelected($el.id) ? 0 : -1"
                                        :aria-selected="isSelected($el.id)"
                                        :class="isSelected($el.id) ? 'border-gray-200 bg-white' : 'border-transparent'"
                                        class="inline-flex py-2.5 px-5 font-semibold border-t border-r border-l"
                                        role="tab"
                                    >Mentioned In</button>
                                </li>
                            </ul>

                            <!-- Panels -->
                            <div role="tabpanels" class="bg-white rounded-b-md border border-gray-200">
                                <!-- Panel -->
                                @if($quotes->count() > 0)
                                    <section
                                        x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                                        :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                                        role="tabpanel"
                                        class="p-8"
                                    >
                                        <ul class="divide-y divide-gray-200">
                                            @foreach($quotes as $quote)

                                                <x-quote-summary :quote="$quote" />

                                            @endforeach
                                        </ul>
                                        <div>
                                            {!! $quotes->withQueryString()->links() !!}
                                        </div>
                                    </section>
                                @endif

                                <section
                                    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                                    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                                    role="tabpanel"
                                    class="p-8"
                                >
                                    <ul class="divide-y divide-gray-200">
                                        @foreach($pages as $page)

                                            <x-page-summary :page="$page" />

                                        @endforeach
                                    </ul>
                                    <div>
                                        {!! $pages->withQueryString()->links() !!}
                                    </div>
                                </section>
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
