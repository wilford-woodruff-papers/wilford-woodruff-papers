<div class="bg-white">
    <div class="flex overflow-hidden flex-col shadow-lg">
        <div class="flex-shrink-0">
            @if(! empty($announcement->image))
                <div class="mx-auto max-w-full h-auto md:max-w-7xl min-h-[200px] md:min-h-[371px]">
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
            <div class="flex flex-col flex-1 justify-between px-6 pb-3 bg-white">
                <div class="flex-1 py-2">
                    @if(! empty($announcement->description))
                        <div class="text-lg font-semibold text-gray-900">
                            {!! $announcement->description !!}
                        </div>
                    @endif
                    @if(! empty($announcement->button_link) && ! empty($announcement->button_text))
                        <div class="mt-6 w-full text-center">
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
