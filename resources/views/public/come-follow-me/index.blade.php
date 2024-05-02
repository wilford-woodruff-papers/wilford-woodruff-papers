<x-guest-layout>
    <div>
        <div class="mx-auto max-w-7xl">
            <div class="flex flex-col gap-y-1 mt-8 mb-4">
                <h1 class="text-6xl text-center">
                    Come Follow Me with Wilford Woodruff
                </h1>
                <h2 class="text-2xl text-center">
                    Magnify your Come Follow Me study through Wilford Woodruff’s records
                </h2>
            </div>
            @if($cfm)
                <div class="grid grid-cols-5">
                    <div class="col-span-4 p-4 bg-secondary">
                        <div class="flex flex-col">
                            <div class="text-4xl text-white border-b border-white">
                                "{{ $cfm->title }}"
                            </div>
                            <div class="text-2xl text-white">
                                Week {{ $cfm->week }}
                            </div>
                            <div class="text-2xl font-semibold text-white">
                                {{ $cfm->reference }}
                            </div>
                            <div class="text-lg text-white line-clamp-4">
                                {!! $cfm->quote !!}
                            </div>
                            <div>
                                <a href="{{ route('come-follow-me.show', $cfm) }}"
                                   class="py-3 px-8 font-semibold bg-white text-secondary">
                                    READ MORE >>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 bg-center bg-no-repeat bg-cover"
                         style="background-image: url('{{ $cfm->getFirstMediaUrl() }}');">
                    </div>
                </div>
            @endif
            <a class="grid grid-cols-4 gap-4 my-8">
                @foreach($lessons as $lesson)
                    <a href="{{ route('come-follow-me.show', ['book' => $bookSlug, 'week' => $lesson->week]) }}">
                        <div class="flex flex-col gap-y-4">
                            <div class="overflow-hidden">
                                <img src="{{ $lesson->getFirstMediaUrl() }}"
                                     alt="{{ $lesson->title }}"
                                     class="w-full h-auto shadow-xl" />
                            </div>
                            <div class="flex flex-col px-2">
                                <div class="flex justify-center items-center">
                                    Week {{ $lesson->week }}
                                </div>
                                <div class="flex justify-center items-center">
                                    {{ $lesson->reference }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>
