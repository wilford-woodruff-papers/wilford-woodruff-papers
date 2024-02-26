<div class="">
    <div x-data="{
        scrolledFromTop: false,
    }"
         @scroll.window="$refs.nav.getBoundingClientRect().top <= 10 ? scrolledFromTop = true : scrolledFromTop = false"
        class="grid gap-y-8 py-12 px-12 mx-auto max-w-7xl">

        @include('livewire.document-dashboard.sections.banner')

        @include('livewire.document-dashboard.sections.nav')

        @include('livewire.document-dashboard.sections.metadata')

        @include('livewire.document-dashboard.sections.people')

        @include('livewire.document-dashboard.sections.places')

        @include('livewire.document-dashboard.sections.topics')

        @include('livewire.document-dashboard.sections.quotes')

        @include('livewire.document-dashboard.sections.events')

    </div>
</div>
