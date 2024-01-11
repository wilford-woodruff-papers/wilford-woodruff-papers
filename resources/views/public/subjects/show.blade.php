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
                        @if(! empty($subject->pid) && $subject->pid !== 'n/a')
                            <a href="https://www.familysearch.org/tree/person/details/{{ $subject->pid }}"
                               class="inline-block px-2 pt-1 pb-2 text-sm bg-white rounded-md border border-gray-200"
                               target="_blank"
                            >
                                <img src="{{ asset('img/familytree-logo.png') }}"
                                     alt="FamilySearch"
                                     class="w-auto h-6"
                                />
                            </a>
                        @endif

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
                                            {{ $subTopic->name }} ({{ $subTopic->tagged_count }})
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

                        <livewire:tagged-pages :subject="$subject"/>

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
