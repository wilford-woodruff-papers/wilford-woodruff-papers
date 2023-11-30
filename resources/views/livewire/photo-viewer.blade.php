<div>
    <div class="">
        <div class="absolute top-2 right-2 px-2.5 bg-white rounded-full">
            <button wire:click="$dispatch('closeModal')"
                    type="button"
                    class="text-2xl font-semibold leading-8 close mt-[0.07rem]"
                    aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <img src="{{ $photo }}"
             alt=""
             class="w-full h-auto"
        />
    </div>
</div>
