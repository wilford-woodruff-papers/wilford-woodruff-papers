<div>
    @if(empty($action))
        <button wire:click="markComplete()"
                type="button"
                class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
            {{ $actionTypeNamePrefix }} {{ $actionTypeName }}
        </button>
    @else
    {{ $actionTypeName }} by {{ $action->finisher?->name }} on {{ $action->completed_at->toFormattedDateString() }}
@endif
</div>
