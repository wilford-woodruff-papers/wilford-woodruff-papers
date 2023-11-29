@if($testimonials->count())
    <div class="my-12">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8">
            @foreach($testimonials as $testimonial)
                <div onclick="Livewire.dispatch('openModal', { component: 'testimonial', arguments: { testimonial: {{ $testimonial->id }} }})"
                     class="overflow-hidden mx-auto w-48 h-48 rounded-full border-4 border-gray-300 cursor-pointer md:w-32 md:h-32">
                <img src="{{ $testimonial->getFirstMediaUrl('images', 'square-thumb') }}"
                         class="w-48 h-48 md:w-32 md:h-32"
                         alt="{{ $testimonial->name }}"
                         alt="{{ $testimonial->name }}"
                    />
                </div>
            @endforeach
        </div>
    </div>
@endif
