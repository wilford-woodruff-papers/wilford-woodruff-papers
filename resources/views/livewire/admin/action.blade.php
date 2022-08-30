<tr>
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
        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, {{ $action->description }}</span></a>
    </td>
</tr>
