<x-guest-layout>
    <div class="max-w-7xl mx-auto">
        <x-testimonials.video-testimonials :videos="$videos"/>
    </div>
    <div class="max-w-7xl mx-auto pt-16 pb-4">
        <div onclick="Livewire.emit('openModal', 'forms.testify')"
             class="max-w-xl mx-auto px-4 py-2 bg-secondary text-white text-center"
             role="button">
            Share your testimony
        </div>
    </div>
    <div class="max-w-7xl mx-auto">
        <x-testimonials.image-testimonials :images="$images"/>
    </div>
    <div class="max-w-7xl mx-auto">
        <x-testimonials.image-grid-testimonials :testimonials="$testimonials"/>
    </div>
</x-guest-layout>
