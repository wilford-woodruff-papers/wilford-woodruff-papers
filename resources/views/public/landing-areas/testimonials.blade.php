<div>
    <x-slot name="title">
        Testimonies | {{ config('app.name') }}
    </x-slot>
    <div class="max-w-7xl mx-auto">
        <x-testimonials.featured-testimonials :featured="$featured"/>
    </div>
    <div>
        <div class="max-w-7xl mx-auto pt-16 pb-4">
            <div onclick="Livewire.emit('openModal', 'forms.testify')"
                 class="max-w-xl mx-auto px-4 py-2 bg-secondary text-white text-center uppercase"
                 role="button">
                Share your testimony
            </div>
        </div>
        <div class="max-w-7xl mx-auto">
            <x-testimonials.testimonials :testimonials="$testimonials"/>
        </div>
        <div class="max-w-7xl mx-auto">
            <div class="text-center">
                @if($testimonials->hasMorePages())
                    <div x-intersect:enter="@this.call('loadMore')">
                        <div class="text-2xl py-6" wire:loading>...</div>
                    </div>
                @endif
            </div>
        </div>
        <div class="max-w-7xl mx-auto mb-12 text-center">
            <a href="{{ route('landing-areas.ponder') }}"
               class="inline-block mx-auto bg-secondary text-white px-4 py-2 border border-transparent text-base font-medium shadow-sm cursor-pointer">
                    Explore more on our Ponder page
            </a>
        </div>
    </div>
</div>
