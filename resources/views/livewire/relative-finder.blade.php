<div>
    <div class="">
        <div class="py-8 mx-auto max-w-7xl">
            @if(session()->has('status'))
                <div class="py-6 px-8">
                    <div class="relative py-3 px-4 text-green-700 bg-green-100 rounded border border-green-400" role="alert">
                        <span class="">{{ session()->get('status') }}</span>
                    </div>
                </div>

            @endif
        </div>
        <livewire:wilford-woodruff-relationship lazy />
        <div class="py-8 mx-auto max-w-7xl relative-finder">
            {{ $this->table }}
        </div>
    </div>
</div>
