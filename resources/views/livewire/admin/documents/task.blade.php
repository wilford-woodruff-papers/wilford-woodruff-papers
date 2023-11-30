<div x-data="{
    show: @entangle('show').live
}">

    <div
        id="assigned_item_{{ $item->id }}"
        class="flex items-center bg-gray-50 border-t border-gray-200">
        <div class="px-2 bg-gray-50 flex-0">
            @if($item->pending_page_actions->count() > 0)
                <div class="flex justify-center items-center">
                    <button {{--wire:click="$set('show', true)"--}}
                            @click="show = true"
                            title="Click to expand pages"
                            x-show="! show">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    <button {{--wire:click="$set('show', false)"--}}
                            @click="show = false"
                            title="Click to hide pages"
                            x-show="show" x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
            @else
                <div class="flex justify-center items-center w-6 h-6">&nbsp;</div>
            @endif
        </div>
        <div class="py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6 flex-0">
            <span href="#" class="inline-flex space-x-2 text-sm leading-5 truncate">
                {{ $item->pcf_unique_id_full }}
            </span>
        </div>
        <div class="flex-1 py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
            <a href="{{ route('admin.dashboard.document', ['item' => $item]) }}"
               class="font-medium text-indigo-600 capitalize"
            >
                {{ $item->name }}
            </a>
        </div>
        <div class="flex-1 py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
            @foreach($item->pending_actions as $action)
                @if($item->pending_page_actions->doesntContain('action_type_id', $action->action_type_id))
                    <button wire:click="markActionComplete({{ $action->id }})"
                            class="inline-flex items-center py-1.5 px-2.5 text-xs font-medium text-gray-700 whitespace-nowrap bg-white rounded border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                            title="Mark complete"
                    >
                        {{ $action->type->name }}
                    </button>
                @endif
            @endforeach
        </div>
        <div class="justify-end py-2 px-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
            {{ $item->pending_actions->first()?->assigned_at?->tz('America/Denver')?->toDayDateTimeString() }}
        </div>
    </div>

    @if($show)

        @forelse($item->page_actions->groupBy('actionable_id') as $pageActions)
            <div x-show="show"
                x-cloak
                class="grid grid-cols-5 items-center border-t border-gray-300">
                <div id="assigned_page_{{ $pageActions->first()->actionable->id }}"
                    class="col-span-1 py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-12">
                    <div class="">
                        <a href="{{ route('admin.dashboard.page', ['item' => $item, 'page' => $pageActions->first()->actionable]) }}"
                           class="font-medium text-indigo-600 capitalize"
                        >
                            Page {{ $pageActions->first()->actionable->order }}
                        </a>
                    </div>
                    <div class="flex flex-col-reverse pt-2 space-y-4 space-y-reverse sm:flex-row-reverse sm:space-y-0 sm:space-x-3 sm:space-x-reverse md:flex-row md:mt-0 md:space-x-3 justify-stretch">
                        <span class="inline-flex relative z-0 rounded-md shadow-sm">
                          <a href="{{ route('pages.show', ['item' => $item, 'page' => $pageActions->first()->actionable]) }}" class="inline-flex relative items-center py-1 px-2 text-xs font-medium text-gray-700 bg-white rounded-l-md border border-gray-300 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none" target="_blank">Website</a>
                          <a href="{{ $pageActions->first()->actionable->ftp_link }}" class="inline-flex relative items-center py-1 px-2 -ml-px text-xs font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none" target="_blank">FTP</a>
                            @hasanyrole('Admin|Super Admin')
                                <a href="/nova/resources/pages/{{ $pageActions->first()->actionable->id }}" class="inline-flex relative items-center py-1 px-2 -ml-px text-xs font-medium text-gray-700 bg-white rounded-r-md border border-gray-300 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none" target="_blank">Nova</a>
                            @endhasanyrole
                        </span>
                    </div>

                </div>
                <div class="col-span-2 py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                    @foreach($pageActions->whereNull('completed_at') as $action)
                        @if($action->assigned_to == auth()->id())
                            <button wire:click="markActionComplete({{ $action->id }})"
                                    class="inline-flex items-center py-1.5 px-2.5 text-xs font-medium text-gray-700 whitespace-nowrap bg-white rounded border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                                    title="Mark complete"
                            >
                                {{ $action->type->name }}
                            </button>
                        @endif
                    @endforeach
                </div>
                <div class="col-span-2 py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                    {{--{{ $pageActions->first()->assigned_at->tz('America/Denver')->toDayDateTimeString() }}--}}
                    <div class="divide-y">
                        @foreach($pageActions->first()->actionable->completed_actions as $a)
                            <div class="grid grid-cols-9 gap-y-2 gap-x-4 items-center">
                                <div class="col-span-2 font-semibold">
                                    {{ $a->type->name }}
                                </div>
                                <div class="col-span-4">
                                    <div>
                                        {{ $a->finisher->name }}
                                    </div>
                                    <div>
                                        {{ $a->completed_at->tz('America/Denver')->toDayDateTimeString() }}
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    @if($a->finisher->id == auth()->id() || auth()->user()->hasAnyRole(['Admin', 'Super Admin']))
                                        <button wire:click="markActionInComplete({{ $a->id }})"
                                                type="button" class="inline-flex items-center py-0.5 px-2 text-xs font-medium text-gray-700 text-red-700 bg-white rounded border border-red-700 border-dotted shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-red-700 focus:ring-offset-2 focus:outline-none">
                                            Mark Incomplete
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
