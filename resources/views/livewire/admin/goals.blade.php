<div>
    <div class="mx-auto mt-4 max-w-7xl">

        <div x-data="{
                saved: @entangle('saved').live
            }"
             x-init="
                    $wire.on('notify-saved', () => {
                        setTimeout(() => { saved = false }, 2000)
                    });
              "
             class=""
        >
            <form wire:submit="saveGoal">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col mt-8 bg-white">
                        <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                            <div class="inline-block py-2 min-w-full align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden px-4 ring-1 ring-black ring-opacity-5 shadow md:rounded-lg">
                                    <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start sm:py-5 sm:border-t sm:border-gray-200">
                                        <label for="finish_at"
                                               class="block text-sm font-medium text-gray-700 sm:col-span-1 sm:pt-2 sm:mt-px">
                                            Goal End Date
                                        </label>
                                        <div class="mt-1 sm:col-span-3 sm:mt-0">
                                            <input wire:model.live="goal.finish_at"
                                                type="date"
                                                name="finish_at"
                                                id="finish_at"
                                                class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                    <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start sm:py-5 sm:border-t sm:border-gray-200">
                                        <label for="type"
                                               class="block text-sm font-medium text-gray-700 sm:col-span-1 sm:pt-2 sm:mt-px">
                                            Document Type
                                        </label>
                                        <div class="mt-1 sm:col-span-3 sm:mt-0">
                                            <select wire:model.live="goal.type_id"
                                                    name="type"
                                                    id="type"
                                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option> -- Select -- </option>
                                                @foreach($types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                                <option value="999">People & Places</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start sm:py-5 sm:border-t sm:border-gray-200">
                                        <label for="action_type_id"
                                               class="block text-sm font-medium text-gray-700 sm:col-span-1 sm:pt-2 sm:mt-px">
                                            Step
                                        </label>
                                        <div class="mt-1 sm:col-span-3 sm:mt-0">
                                            <select wire:model.live="goal.action_type_id"
                                                    name="action_type"
                                                    id="action_type"
                                                    class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option> -- Select -- </option>
                                                @foreach($actionTypes as $actionType)
                                                    <option value="{{ $actionType->id }}">{{ $actionType->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start sm:py-5 sm:border-t sm:border-gray-200">
                                        <label for="target"
                                               class="block text-sm font-medium text-gray-700 sm:col-span-1 sm:pt-2 sm:mt-px">
                                            Goal Target
                                        </label>
                                        <div class="mt-1 sm:col-span-3 sm:mt-0">
                                            <input wire:model.live="goal.target"
                                                   type="number"
                                                   name="target"
                                                   id="target"
                                                   class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                    <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start sm:py-5 sm:border-t sm:border-gray-200">
                                        <div class="flex relative items-start">
                                            <div class="flex items-center h-5">
                                                <input wire:model.live="clear"
                                                       id="clear"
                                                       aria-describedby="clear-description"
                                                       name="clear"
                                                       type="checkbox"
                                                       class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="clear" class="font-medium text-gray-700">Clear values</label>
                                            </div>
                                        </div>
                                        <button wire:loading.attr="disabled"
                                                type="submit"
                                                class="inline-flex justify-center py-2 px-4 text-sm font-medium text-white bg-indigo-600 rounded-md border border-transparent shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
                                            Save
                                        </button>
                                        <button  wire:loading.attr="disabled"
                                                 wire:click="editGoal(-1)"
                                                 class="inline-flex justify-center py-2 px-4 text-sm font-medium text-white bg-gray-400 rounded-md border border-transparent shadow-sm hover:bg-gray-300 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none">
                                            Clear
                                        </button>
                                    </div>
                                    <div class="mb-4">
                                        <div>
                                            @if ($saved)
                                                <div class="mb-6 w-full bg-white rounded-lg pointer-events-auto">
                                                    <div class="overflow-hidden rounded-lg shadow-xs">
                                                        <div class="p-4">
                                                            <div class="flex justify-start">
                                                                <div class="flex-shrink-0">
                                                                    <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </div>
                                                                <div class="flex-initial pt-0.5 ml-3">
                                                                    <p class="text-sm font-medium leading-5 text-gray-900">
                                                                        Successfully saved!
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div id="errors-bottom">
                                            @if ($errors->any())
                                                <div class="p-4 bg-red-50 rounded-md">
                                                    <div class="flex">
                                                        <div class="flex-shrink-0">
                                                            <!-- Heroicon name: solid/x-circle -->
                                                            <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                        <div class="ml-3">
                                                            <h2 class="text-sm font-medium text-red-800">
                                                                There were {{ $errors->count() }} error(s) saving this goal
                                                            </h2>
                                                            <div class="mt-2 text-sm text-red-700">
                                                                <ul class="pl-5 space-y-1 list-disc">
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if(! empty($doc_type))
            <div class="">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col mt-8">
                        <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                            <div class="inline-block py-2 min-w-full align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden ring-1 ring-black ring-opacity-5 shadow md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">
                                                <select wire:model.live="doc_type" class="text-sm">
                                                    @foreach(\App\Models\Type::query()->orderBy('name')->get() as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </th>
                                            @foreach($doc_action_types as $action)
                                                <th scope="col"
                                                    @class([
                                                         'py-3.5 pr-3 pl-3 text-base font-semibold text-center text-gray-900',
                                                         'bg-[#b6d7a8]' =>  ($action == 'Transcription'),
                                                         'bg-[#f9cb9c]' =>  ($action == 'Verification'),
                                                         'bg-[#a4c2f4]' =>  ($action == 'Subject Tagging'),
                                                         'bg-[#b4a7d6]' =>  ($action == 'Topic Tagging'),
                                                         'bg-[#d5a6bd]' =>  ($action == 'Stylization'),
                                                         'bg-[#ea9999]' =>  ($action == 'Publish'),
                                                   ])>
                                                    {{ $action }}
                                                </th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($goals->groupBy('finish_at') as $key => $date)
                                            <tr class="border-t border-gray-200">
                                                <th class="py-2 px-4 text-base font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                                    <span class="font-bold text-gray-700 capitalize cursor-pointer">
                                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $key)->toFormattedDateString() }}
                                                    </span>
                                                </th>
                                                @foreach($doc_action_types as $action)
                                                    <td @class([
                                                             'py-2 px-4 text-base font-semibold text-left text-gray-900 bg-gray-50 sm:px-6',
                                                             'bg-[#b6d7a8]' =>  ($action == 'Transcription'),
                                                             'bg-[#f9cb9c]' =>  ($action == 'Verification'),
                                                             'bg-[#a4c2f4]' =>  ($action == 'Subject Tagging'),
                                                             'bg-[#b4a7d6]' =>  ($action == 'Topic Tagging'),
                                                             'bg-[#d5a6bd]' =>  ($action == 'Stylization'),
                                                             'bg-[#ea9999]' =>  ($action == 'Publish'),
                                                       ])>
                                                        <div
                                                           class="font-semibold text-center text-gray-700"
                                                        >
                                                            {{ $date->firstWhere('action_type_id', $actionTypes->firstWhere('name', $action)->id)?->target }}
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col mt-8">
                    <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                        <div class="inline-block py-2 min-w-full align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden ring-1 ring-black ring-opacity-5 shadow md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">
                                            <select wire:model.live="doc_type" class="text-sm">
                                                <option value="">-- Select Document Type --</option>
                                                @foreach(\App\Models\Type::query()->orderBy('name')->get() as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </th>
                                        <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">
                                            <select wire:model.live="action_type" class="text-sm">
                                                <option value="">-- Select Task Type --</option>
                                                @foreach($actionTypes as $actionType)
                                                    <option value="{{ $actionType->id }}">{{ $actionType->name }}</option>
                                                @endforeach
                                            </select>
                                        </th>
                                        <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6"></th>
                                        <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6"></th>
                                        <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($goals as $goal)
                                        <tr id="date_{{ $goal->id }}"
                                            class="border-t border-gray-200">
                                            <th class="py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                                <span wire:click="editGoal({{ $goal->id }})"
                                                   class="font-medium text-indigo-600 capitalize cursor-pointer"
                                                >
                                                    @if($goal->type_id == 999)
                                                        People & Places
                                                    @else
                                                        {{ $goal->type->name }}
                                                    @endif
                                                </span>
                                            </th>
                                            <th class="py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                                <span wire:click="editGoal({{ $goal->id }})"
                                                   class="font-medium text-indigo-600 capitalize cursor-pointer"
                                                >
                                                    {{ $goal->action_type->name }}
                                                </span>
                                            </th>
                                            <th class="py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                                <span wire:click="editGoal({{ $goal->id }})"
                                                   class="font-medium text-indigo-600 capitalize cursor-pointer"
                                                >
                                                    {{ $goal->finish_at->toFormattedDateString() }}
                                                </span>
                                            </th>
                                            <th class="py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                                <span wire:click="editGoal({{ $goal->id }})"
                                                   class="font-medium text-indigo-600 capitalize cursor-pointer"
                                                >
                                                    {{ $goal->target }}
                                                </span>
                                            </th>
                                            <th class="py-2 px-4 w-20 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                                <button wire:click="deleteGoal({{ $goal->id }})"
                                                        class="flex"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-800 hover:text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="px-4 pt-3 pb-2">
                                    {{--{!! $goals->links() !!}--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
