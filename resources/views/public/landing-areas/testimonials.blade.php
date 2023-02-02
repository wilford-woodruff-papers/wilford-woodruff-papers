<div>
    <x-slot name="title">
        Testimonies | {{ config('app.name') }}
    </x-slot>
    <div class="mx-auto max-w-7xl">
        <x-testimonials.featured-testimonials :featured="$featured"/>
    </div>
    <div>
        <div class="pt-16 pb-4 mx-auto max-w-7xl">
            <div onclick="Livewire.emit('openModal', 'forms.testify')"
                 class="py-2 px-4 mx-auto max-w-xl text-center text-white uppercase bg-secondary"
                 role="button">
                Share your testimony
            </div>
        </div>
        <div class="mx-auto max-w-7xl">
            <x-testimonials.testimonials :testimonials="$testimonials"/>
        </div>
        <div class="mx-auto max-w-7xl">
            <div class="text-center">
                @if($testimonials->hasMorePages())
                    <div x-intersect:enter="@this.call('loadMore')">
                        <div class="py-6 text-2xl" wire:loading>...</div>
                    </div>
                @endif
            </div>
        </div>
        <div class="mx-auto mb-12 max-w-7xl text-center">
            <a href="{{ route('landing-areas.ponder') }}"
               class="inline-block py-2 px-4 mx-auto text-base font-medium text-white border border-transparent shadow-sm cursor-pointer bg-secondary">
                    Explore more on our Ponder page
            </a>
        </div>
    </div>
    @push('scripts')
        @if($showTestimony)
            <script>
                Livewire.emit("openModal", "testimonial", @json(["testimonial" => $showTestimony->id]) );
            </script>
        @endif
    @endpush
</div>
