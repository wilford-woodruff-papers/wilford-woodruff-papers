<div>
    <div class="absolute top-2 right-4">
        <button wire:click="$dispatch('closeModal')"
                type="button"
                class="text-2xl font-semibold close"
                aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    {{-- class="max-w-[94%]" --}}
    <iframe src="{{ route('pages.preview', ['item' => $item, 'page' => $page]) }}"
        class="overflow-y-scroll w-full h-screen border-0"
    ></iframe>
</div>
