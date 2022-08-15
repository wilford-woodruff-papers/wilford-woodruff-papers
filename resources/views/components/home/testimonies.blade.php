@if($testimonies->count())
    <div class="my-12">
        <div class="max-w-7xl mx-auto pt-4 md:pt-4 px-4 pb-4 xl:pt-4 md:pb-8 ">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 pb-4">
                <div class="font-extrabold">
                    <h2 class="text-3xl uppercase pb-1 border-b-4 border-highlight">Testimonies</h2>
                </div>
            </div>
        </div>
        <div class="mb-12 mx-auto px-4 grid gap-8 sm:px-6 lg:px-8 lg:max-w-7xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4">
                @foreach($testimonies as $testimony)
                    <a href="{{ route('testimonies.index', ['testimony' => $testimony->slug]) }}">
                        <div {{--onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $testimonial->id]) }})'--}}
                             class="h-48 w-48 md:h-64 md:w-64 overflow-hidden border-4 border-gray-300 mx-auto cursor-pointer">
                            <img src="{{ $testimony->getFirstMediaUrl('images', 'square') }}"
                                 class="h-48 w-48 md:h-64 md:w-64"
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
