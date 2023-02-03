<tr>
    @if($show)
    <td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap">
        {{ $action->type->name }}
    </td>

    <td class="py-4 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-6">
        @if(! empty($action->assigned_to))
            <div class="flex items-center">
                <div class="flex-shrink-0 w-10 h-10">
                    <img class="w-10 h-10 rounded-full" src="{{ $action->assignee->profile_photo_url }}" alt="">
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
                @foreach($users as $key => $user) <option value="{{ $user->id }}">{{ $user->name }}</option> @endforeach
            </select>
        @endif

    </td>

    <td class="py-4 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-6">
        @if(! empty($action->completed_by))
            <div class="flex items-center">
                <div class="flex-shrink-0 w-10 h-10">
                    <img class="w-10 h-10 rounded-full" src="{{ $action->finisher->profile_photo_url }}" alt="">
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
                @foreach($users as $key => $user) <option value="{{ $user->id }}">{{ $user->name }}</option> @endforeach
            </select>
        @endif
    </td>
    {{--<td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap">
        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Active</span>
    </td>--}}

    <td class="relative py-4 pr-4 pl-3 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
        @if(auth()->user()->hasAnyRole($action->type->roles))
            <button wire:click="deleteAction()"
                    type="button" class="inline-flex gap-x-2 items-center py-1 px-2 my-2 text-xs font-semibold leading-4 text-white bg-red-700 rounded-full border border-transparent shadow-sm hover:bg-red-700 focus:ring-2 focus:ring-red-700 focus:ring-offset-2 focus:outline-none">
                <!-- Heroicon name: solid/trash -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        @endif
    </td>
    @endif
</tr>
