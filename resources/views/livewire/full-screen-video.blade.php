<div>
    <div class="absolute top-2 right-4">
        <button wire:click="$dispatch('closeModal')"
                type="button"
                class="text-2xl font-semibold close"
                aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <iframe class="w-full aspect-[16/9]" src="{{ $url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
</div>
