<div class="bg-white">
    <div class="flex flex-col shadow-lg overflow-hidden">
        <div class="flex-shrink-0">
            @if(! empty($announcement->image))
                <div class="max-w-full md:max-w-7xl h-auto mx-auto">
                    @if(! empty($announcement->link))
                        <a href="{{ $announcement->link }}"
                           target="_blank">
                            @endif
                            <img class="w-full h-auto"
                                 src="{{ \Illuminate\Support\Facades\Storage::disk('announcements')->url($announcement->image) }}"
                                 alt="{{ $announcement->title }}"/>
                            @if(! empty($announcement->link))
                        </a>
                    @endif
                </div>
            @endif
        </div>
        @if(! empty($announcement->description) || (! empty($announcement->button_link) && ! empty($announcement->button_text)))
            <div class="flex-1 bg-white px-6 pb-3 flex flex-col justify-between">
                <div class="flex-1 py-2">
                    @if(! empty($announcement->description))
                        <div class="text-lg font-semibold text-gray-900">
                            {!! $announcement->description !!}
                        </div>
                    @endif
                    @if(! empty($announcement->button_link) && ! empty($announcement->button_text))
                        <div class="w-full text-center mt-6">
                            <x-links.primary href="{{ $announcement->button_link }}" target="_blank">
                                {{ $announcement->button_text }}
                            </x-links.primary>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>
