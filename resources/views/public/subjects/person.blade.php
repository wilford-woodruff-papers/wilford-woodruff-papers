<x-guest-layout>
    <x-slot name="title">
        {{ strip_tags($subject->name) }} | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="bg-gray-100">
            <div class="px-8 mx-auto max-w-7xl">
                <div class="pt-12 pb-4">
                    <div class="">
                        <div class="flex flex-col gap-x-8 md:flex-row">
                            <div class="flex-shrink-0">
                                <div class="flex flex-col gap-y-8">
                                    @if(! empty($subject->portrait))
                                        <img src="{{ $subject->portrait }}"
                                             alt="{{ $subject->name }}"
                                             class="mx-auto w-48 h-auto border-8 border-white shadow-xl" />
                                    @endif
                                    @if(! empty($subject->pid) && $subject->pid !== 'n/a')
                                        <div class="px-1">
                                            <a href="https://www.familysearch.org/tree/person/details/{{ $subject->pid }}"
                                               class="block px-2 pt-1 pb-2 text-sm bg-white border border-gray-200"
                                               target="_blank"
                                            >
                                                <img src="{{ asset('img/familytree-logo.png') }}"
                                                     alt="FamilySearch"
                                                     class="mx-auto w-auto h-6"
                                                />
                                            </a>
                                        </div>
                                    @endif
                                    @hasanyrole('Editor|Researcher|Admin|Super Admin')
                                        <div class="-mt-4 -mb-4 font-semibold border-b border-gray-200">
                                            Admin Links
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
                                                    People Admin
                                                </a>
                                            @endif
                                        </div>
                                    @endhasanyrole
                                </div>
                            </div>
                            <div class="">
                                <div class="flex flex-col gap-y-4 py-4">
                                    <div class="flex flex-col gap-y-2">
                                        <h1 class="font-serif text-2xl md:text-5xl">
                                            {{ $subject->name }}
                                        </h1>
                                        <div class="pl-2 text-xl md:text-2xl">
                                            {{ $subject->display_life_years }}
                                        </div>
                                    </div>
                                    @if($subject->category->count() > 1)
                                        <div class="flex gap-x-2 pl-2">
                                            @foreach($subject->category->filter(fn($item) => $item->name !== 'People' )->sortBy('name') as $category)
                                                <a href="{{ route('people', ['category' => $category->name]) }}" class="py-1 px-2 text-sm text-white bg-secondary">
                                                    {{ $category->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(! empty($subject->bio_approved_at) && ! empty(strip_tags($subject->bio)))
                                        <div class="pl-2 text-xl">
                                            {!! $linkify->process($subject->bio) !!}
                                        </div>
                                        <div>
                                            @if(! empty($subject->footnotes))
                                                <div x-data="{ active: 0 }" class="mx-auto space-y-4 w-full">
                                                    <div x-data="{
                                                            id: 1,
                                                            get expanded() {
                                                                return this.active === this.id
                                                            },
                                                            set expanded(value) {
                                                                this.active = value ? this.id : null
                                                            },
                                                        }" role="region" class="">
                                                        <h2>
                                                            <button
                                                                x-on:click="expanded = !expanded"
                                                                :aria-expanded="expanded"
                                                                class="flex items-center px-2 w-full text-lg text-secondary"
                                                            >
                                                                <span x-show="expanded" aria-hidden="true" class="mr-4">&minus;</span>
                                                                <span x-show="!expanded" aria-hidden="true" class="mr-4">&plus;</span>
                                                                <span>Footnotes</span>
                                                            </button>
                                                        </h2>

                                                        <div x-show="expanded" x-collapse x-cloak>
                                                            <div class="px-6 pt-4 text-lg">
                                                                {!! $linkify->process($subject->footnotes) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @elseif($subject->incomplete_identification)
                                        <div class="col-span-12 my-8">
                                            <x-incomplete-identification :subject="$subject->name"/>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl">
            <div class="my-4">
                <livewire:tagged-person-pages :subject="$subject" />
            </div>
        </div>
    </div>
    @push('styles')
        <style>
            em {
                background-color: #fff59d;
            }
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
