<div class="press-modal" style="height: calc(100vh - 60px);">
    <div class="absolute top-2 right-4">
        <button wire:click="$emit('closeModal')"
                type="button"
                class="text-2xl font-semibold close"
                aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="grid grid-cols-5 h-full">
        <div class="overflow-y-scroll col-span-5 h-full md:col-span-3 article">
            @include('public.landing-areas.media.'.Str::of($press->type)->lower())
        </div>
        <div class="overflow-y-scroll col-span-5 h-full md:col-span-2">
            <livewire:comments :model="$press">
        </div>
    </div>
</div>
