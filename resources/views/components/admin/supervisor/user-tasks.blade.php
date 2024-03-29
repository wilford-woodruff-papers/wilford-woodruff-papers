@if(true)
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col mt-8">
            <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                <div class="inline-block py-2 min-w-full align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden ring-1 ring-black ring-opacity-5 shadow md:rounded-lg">
                        <table x-data="{
                                    open: null
                                }"
                               class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th></th>
                                <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">{{ $user->name }}'s Tasks</th>
                                <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6"></th>
                                <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">Date Claimed</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($user->pending_actions as $action)
                                <tr
                                    id="assigned_item_{{ $action->actionable->id }}"
                                    class="border-t border-gray-200">
                                    <th>
                                        @if($action->actionable->pending_page_actions_for_user($user->id)->count() > 0)
                                            <div class="flex justify-center items-center">
                                                <button x-on:click="open = {{ $action->actionable->id }}"
                                                        title="Click to expand pages">
                                                    <svg x-show="open != {{ $action->actionable->id }}" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                                <button x-on:click="open = null"
                                                        title="Click to hide pages">
                                                    <svg x-show="open == {{ $action->actionable->id }}" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </th>
                                    <th scope="colgroup" class="py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                        <a href="{{ route('admin.dashboard.document', ['item' => $action->actionable]) }}"
                                           class="font-medium text-indigo-600 capitalize"
                                        >
                                            {{ $action->actionable->name }}
                                        </a>
                                    </th>
                                    <th class="py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                        @foreach($action->actionable->pending_actions_for_user($user->id) as $action)
                                            <button wire:click="markActionComplete({{ $action->id }})"
                                                    class="inline-flex items-center py-1.5 px-2.5 text-xs font-medium text-gray-700 whitespace-nowrap bg-white rounded border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                                                    title="Mark complete"
                                            >
                                                {{ $action->type->name }}
                                            </button>
                                        @endforeach
                                    </th>
                                    <th class="py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                                        {{ $action->actionable->pending_actions_for_user($user->id)->first()->assigned_at?->tz('America/Denver')->toDayDateTimeString() }}
                                    </th>
                                </tr>
                                @forelse($action->actionable->pending_page_actions_for_user($user->id)->groupBy('actionable_id') as $pageActions)
                                    <tr x-show="open == {{ $action->actionable->id }}"
                                        x-cloak
                                        class="border-t border-gray-300">
                                        <td></td>
                                        <td id="assigned_page_{{ $pageActions->first()->actionable->id }}"
                                            class="py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-12">
                                            <a href="{{ route('admin.dashboard.page', ['item' => $action->actionable, 'page' => $pageActions->first()->actionable]) }}"
                                               class="font-medium text-indigo-600 capitalize"
                                            >
                                                Page {{ $pageActions->first()->actionable->order }}
                                            </a>
                                        </td>
                                        <td class="py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            @foreach($pageActions as $a)
                                                <button wire:click="markActionComplete({{ $a->id }})"
                                                        class="inline-flex items-center py-1.5 px-2.5 text-xs font-medium text-gray-700 whitespace-nowrap bg-white rounded border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                                                        title="Mark complete"
                                                >
                                                    {{ $a->type->name }}
                                                </button>
                                            @endforeach
                                        </td>
                                        <td class="py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            {{ $pageActions->first()->assigned_at?->tz('America/Denver')->toDayDateTimeString() }}
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
