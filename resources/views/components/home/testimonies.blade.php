@if($testimonies->count())
    <div class="my-12">
        <div class="px-4 pt-4 pb-4 mx-auto max-w-7xl md:pt-4 md:pb-8 xl:pt-4">
            <div class="grid grid-cols-1 pb-4 sm:grid-cols-2 md:grid-cols-3">
                <div class="font-extrabold">
                    <h2 class="pb-1 text-3xl uppercase border-b-4 border-highlight">Testimonies</h2>
                </div>
            </div>
        </div>
        <div class="grid gap-8 px-4 mx-auto mb-12 sm:px-6 lg:px-8 lg:max-w-7xl">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4">
                @foreach($testimonies as $testimony)
                    <a href="{{ route('testimonies.index', ['testimony' => $testimony->slug]) }}">
                        <div {{--onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $testimonial->id]) }})'--}}
                             class="overflow-hidden mx-auto w-48 h-48 border-4 border-gray-300 cursor-pointer md:w-64 md:h-64">
                            <img src="{{ $testimony->getFirstMediaUrl('images', 'square') }}"
                                 class="w-48 h-48 md:w-64 md:h-64"
                                 alt="{{ $testimony->name }}"
                                 title="{{ $testimony->name }}"
                            />
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif
