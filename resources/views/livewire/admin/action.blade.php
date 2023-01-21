<tr>
    @if($show)
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        {{ $action->type->name }}
    </td>

    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
        @if(! empty($action->assigned_to))
            <div class="flex items-center">
                <div class="h-10 w-10 flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="{{ $action->assignee->profile_photo_url }}" alt="">
                </div>
                <div class="ml-4">
                    <div class="font-medium text-gray-900">{{ $action->assignee->name }}</div>
                    <div class="text-gray-500">{{ str($action->assignee->email)->before('@') }}</div>
                    <div class="text-gray-500">{{ $action->assigned_at?->tz('America/Denver')->toDayDateTimeString() }}</div>
                </div>
            </div>
            @if($action->assigned_to == auth()->id() || auth()->user()->hasAnyRole($action->type->roles))
                <div class="">
                    <button wire:click="unassignAction({{ $action->id }})"
                            class="text-red-700"
                    >
                        Unassign
                    </button>
                </div>
            @endif
        @else
            <select wire:model="assignee">
                <option>-- Choose --</option>
                @foreach($users as $key => $user) <option value="{{ $key }}">{{ $user }}</option> @endforeach
            </select>
        @endif

    </td>

    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
        @if(! empty($action->completed_by))
            <div class="flex items-center">
                <div class="h-10 w-10 flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="{{ $action->finisher->profile_photo_url }}" alt="">
                </div>
                <div class="ml-4">
                    <div class="font-medium text-gray-900">{{ $action->finisher->name }}</div>
                    <div class="text-gray-500">{{ str($action->finisher->email)->before('@') }}</div>
                    <div class="text-gray-500">{{ $action->completed_at?->tz('America/Denver')->toDayDateTimeString() }}</div>
                </div>
            </div>
            @if($action->completed_by == auth()->id() || auth()->user()->hasAnyRole($action->type->roles))
                <div class="">
                    <button wire:click="uncompleteAction({{ $action->id }})"
                            class="text-red-700"
                    >
                        Remove Person
                    </button>
                </div>
            @endif
        @else
            <select wire:model="finisher">
                <option>-- Choose --</option>
                @foreach($users as $key => $user) <option value="{{ $key }}">{{ $user }}</option> @endforeach
            </select>
        @endif
    </td>
    {{--<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Active</span>
    </td>--}}

    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
        @if(auth()->user()->hasAnyRole($action->type->roles))
            <button wire:click="deleteAction()"
                    type="button" class="inline-flex items-center px-2 py-1 my-2 gap-x-2 border border-transparent shadow-sm text-xs leading-4 font-semibold rounded-full text-white bg-red-700 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700">
                <!-- Heroicon name: solid/trash -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        @endif
    </td>
    @endif
</tr>
