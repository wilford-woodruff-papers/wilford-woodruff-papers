<div>
    <div class="relative">
        <div id="{{ str('Topics')->slug() }}" class="absolute -top-32"></div>
        <h2 class="text-2xl font-thin uppercase border-b-4 md:text-3xl lg:text-4xl border-highlight">
            Topics
        </h2>
        <p class="mt-4 mb-8 text-xl">
            Browse topics Wilford Woodruff mentioned in this document.
        </p>
    </div>
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-4">
        @php
            $oldLetter = null;
            $letter = null;
        @endphp
        @foreach($item->topics->split(4) as $group)
            <div>
                @foreach($group as $topic)
                    @php
                        $letter = str($topic->name)->upper()->split(1)->first();
                    @endphp
                    @if(! empty($letter) && $letter !== $oldLetter)
                        <div class="pt-3 pb-1 text-2xl font-semibold text-black">
                            {{ $letter }}
                        </div>
                    @endif
                    <div class="flex gap-x-2">
                        <a href="{{ route('subjects.show', ['subject' => $topic->slug]) }}"
                           class="text-xl"
                           target="_blank"
                        >
                            <span class="text-secondary">
                                {{ $topic->name }}
                            </span>
                                    <span class="text-base text-black">
                                ({{ \Illuminate\Support\Number::format($topic->tagged_count)}})
                            </span>
                        </a>
                    </div>
                        @php
                            $oldLetter = $letter;
                        @endphp
                @endforeach
            </div>
        @endforeach
    </div>
</div>
