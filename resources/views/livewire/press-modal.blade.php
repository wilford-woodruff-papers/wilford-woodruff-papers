<div class="press-modal" style="height: calc(100vh - 60px);">
    <div class="absolute right-4 top-2">
        <button wire:click="$emit('closeModal')"
                type="button"
                class="close text-2xl font-semibold"
                aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="h-full grid grid-cols-5">
        <div class="article col-span-5 md:col-span-3 h-full overflow-y-scroll">
            @include('public.landing-areas.media.'.Str::of($press->type)->lower())
        </div>
        <div class="col-span-5 md:col-span-2 h-full overflow-y-scroll">
            <livewire:comments :model="$press">
        </div>
    </div>
</div>
