<div x-data="{
    show: @entangle('show')
}">

    <div
        id="assigned_item_{{ $item->id }}"
        class="flex items-center border-t border-gray-200 bg-gray-50">
        <div class="flex-0 bg-gray-50 px-2">
            @if($item->pending_page_actions->count() > 0)
                <div class="flex items-center justify-center">
                    <button {{--wire:click="$set('show', true)"--}}
                            @click="show = true"
                            title="Click to expand pages"
                            x-show="! show">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    <button {{--wire:click="$set('show', false)"--}}
                            @click="show = false"
                            title="Click to hide pages"
                            x-show="show" x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
            @else
                <div class="flex items-center justify-center h-6 w-6">&nbsp;</div>
            @endif
        </div>
        <div class="flex-0 bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
            <span href="#" class="inline-flex space-x-2 truncate text-sm leading-5">
                {{ $item->pcf_unique_id_full }}
            </span>
        </div>
        <div class="flex-1 bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
            <a href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
               class="font-medium text-indigo-600 capitalize"
            >
                {{ $item->name }}
            </a>
        </div>
        <div class="flex-1 bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">
            @foreach($item->pending_actions as $action)
                @if($item->pending_page_actions->doesntContain('action_type_id', $action->action_type_id))
                    <button wire:click="markActionComplete({{ $action->id }})"
                            class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap"
                            title="Mark complete"
                    >
                        {{ $action->type->name }}
                    </button>
                @endif
            @endforeach
        </div>
        <div class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6 justify-end">
            {{ $item->pending_actions->first()?->assigned_at?->tz('America/Denver')?->toDayDateTimeString() }}
        </div>
    </div>

    @if($show)

        @forelse($item->page_actions->groupBy('actionable_id') as $pageActions)
            <div x-show="show"
                x-cloak
                class="grid grid-cols-5 items-center border-t border-gray-300">
                <div id="assigned_page_{{ $pageActions->first()->actionable->id }}"
                    class="col-span-1 whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-12">
                    <div class="">
                        <a href="{{ route('admin.dashboard.page', ['item' => $item, 'page' => $pageActions->first()->actionable]) }}"
                           class="font-medium text-indigo-600 capitalize"
                        >
                            Page {{ $pageActions->first()->actionable->order }}
                        </a>
                    </div>
                    <div class="pt-2 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
                        <span class="relative z-0 inline-flex shadow-sm rounded-md">
                          <a href="{{ route('pages.show', ['item' => $item, 'page' => $pageActions->first()->actionable]) }}" class="relative inline-flex items-center px-2 py-1 rounded-l-md border border-gray-300 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" target="_blank">Website</a>
                          <a href="{{ $pageActions->first()->actionable->ftp_link }}" class="-ml-px relative inline-flex items-center px-2 py-1 border border-gray-300 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" target="_blank">FTP</a>
                            @hasanyrole('Admin|Super Admin')
                                <a href="/nova/resources/pages/{{ $pageActions->first()->actionable->id }}" class="-ml-px relative inline-flex items-center px-2 py-1 rounded-r-md border border-gray-300 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" target="_blank">Nova</a>
                            @endhasanyrole
                        </span>
                    </div>

                </div>
                <div class="col-span-2 whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    @foreach($pageActions->whereNull('completed_at') as $action)
                        @if($action->assigned_to == auth()->id())
                            <button wire:click="markActionComplete({{ $action->id }})"
                                    class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap"
                                    title="Mark complete"
                            >
                                {{ $action->type->name }}
                            </button>
                        @endif
                    @endforeach
                </div>
                <div class="col-span-2 whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    {{--{{ $pageActions->first()->assigned_at->tz('America/Denver')->toDayDateTimeString() }}--}}
                    <div>
                        @foreach($pageActions->first()->actionable->completed_actions as $a)
                            <div class="grid grid-cols-9 items-center gap-x-4">
                                <div class="col-span-2 font-semibold">
                                    {{ $a->type->name }}
                                </div>
                                <div class="col-span-3">
                                    {{ $a->completed_at->tz('America/Denver')->toDayDateTimeString() }}
                                </div>
                                <div class="col-span-2">
                                    {{ $a->finisher->name }}
                                </div>
                                <div class="col-span-1">
                                    @if($a->finisher->id == auth()->id() || auth()->user()->hasAnyRole($a->type->roles))
                                        <button wire:click="markActionInComplete({{ $a->id }})"
                                                type="button" class="inline-flex items-center px-2 py-1 my-2 gap-x-2 border border-transparent shadow-sm text-xs leading-4 font-semibold rounded-full text-white bg-red-700 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700">
                                            <!-- Heroicon name: solid/x -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty

        @endforelse

    @endif
</div>
