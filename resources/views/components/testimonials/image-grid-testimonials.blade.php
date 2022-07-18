@if($testimonials->count())
    <div class="my-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
            @foreach($testimonials as $testimonial)
                <div onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $testimonial->id]) }})'
                     class="h-48 w-48 md:h-32 md:w-32 rounded-full overflow-hidden border-4 border-gray-300 mx-auto cursor-pointer">
                <img src="{{ $testimonial->getFirstMediaUrl('images', 'square-thumb') }}"
                         class="h-48 w-48 md:h-32 md:w-32"
                         alt="{{ $testimonial->name }}"
                         alt="{{ $testimonial->name }}"
                    />
                </div>
            @endforeach
        </div>
    </div>
@endif
