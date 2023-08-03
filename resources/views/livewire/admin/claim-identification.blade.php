<div>
    @if(! empty($subject->researcher_id))
        {{ $subject->researcher?->name }}
    @elseif(auth()->user()->hasAnyRole(['Bio Editor', 'Bio Admin']))
        <button wire:click="claim"
                type="button"
                class="inline-flex justify-center py-1 px-2 -my-2 w-full text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">
            Claim
        </button>
    @endif
</div>
