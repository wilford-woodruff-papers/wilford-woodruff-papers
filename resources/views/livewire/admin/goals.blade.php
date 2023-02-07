<div>
    <div class="mx-auto mt-4 max-w-7xl">

        <div class="">
            <form wire:submit.prevent="saveGoal">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col mt-8 bg-white">
                        <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                            <div class="inline-block py-2 min-w-full align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden px-4 ring-1 ring-black ring-opacity-5 shadow md:rounded-lg">
                                    <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start sm:py-5 sm:border-t sm:border-gray-200">
                                        <label for="finish_at"
                                               class="block text-sm font-medium text-gray-700 sm:col-span-1 sm:pt-2 sm:mt-px">
                                            Goal
                                        </label>
                                        <div class="mt-1 sm:col-span-3 sm:mt-0">
                                            <input wire:model="goal.finish_at"
                                                type="date"
                                                name="finish_at"
                                                id="finish_at"
                                                class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 text-sm font-medium text-white bg-indigo-600 rounded-md border border-transparent shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
                                            Save
                                        </button>
                                        <button wire:click="editGoal(-1)" type="submit" class="inline-flex justify-center py-2 px-4 text-sm font-medium text-white bg-gray-400 rounded-md border border-transparent shadow-sm hover:bg-gray-300 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none">
                                            Clear
                                        </button>
                                    </div>
                                    <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start sm:py-5 sm:border-t sm:border-gray-200">
                                        <label for="type"
                                               class="block text-sm font-medium text-gray-700 sm:col-span-1 sm:pt-2 sm:mt-px">
                                            Document Type
                                        </label>
                                        <div class="mt-1 sm:col-span-3 sm:mt-0">
                                            <select wire:model="goal.type_id"
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
                                            <select wire:model="goal.action_type_id"
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
                                            Target
                                        </label>
                                        <div class="mt-1 sm:col-span-3 sm:mt-0">
                                            <input wire:model="goal.target"
                                                   type="number"
                                                   name="target"
                                                   id="target"
                                                   class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col mt-8">
                    <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                        <div class="inline-block py-2 min-w-full align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden ring-1 ring-black ring-opacity-5 shadow md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">Goals</th>
                                        <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6"></th>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
