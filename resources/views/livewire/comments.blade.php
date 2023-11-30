<div x-data="{
    'comment': @entangle('comment').live
}"
     class="flex flex-col h-full">
    <div class="flex-none p-4 border-b border-gray-200 fixed-top">
        Comments
    </div>
    <div class="px-4 pb-4 grow">
        <div class="flow-root mt-6">
            <ul role="list" class="px-2 -my-4 divide-y divide-gray-200">
                @if($model->type == 'Instagram')
                    <x-comments.caption :media="$model"/>
                @endif
                @if($model->type == 'Video')
                    <x-comments.credits :media="$model"/>
                @endif
                @foreach($model->comments as $comment)
                    <x-comments.comment :comment="$comment"/>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="flex-none p-4 border-t border-gray-200 fixed-bottom">
        <div class="flex justify-between mb-4">
            <div>
                <span class="text-xs font-medium text-gray-500">{{ $model->date?->toFormattedDateString() }}</span>
            </div>
            <x-press.share :media="$model" :showCommentIcon="false"/>
        </div>
        <div>
            @if(\Illuminate\Support\Facades\Auth::check())
                <form wire:submit="save()">
                    <div class="flex gap-x-2 mt-1">
                        <div class="flex-1">
                            <textarea wire:model.live.debounce.300ms="comment"
                                      rows="4"
                                      name="comment"
                                      id="comment"
                                      class="block w-full h-16 border border-gray-200 resize-none sm:text-sm focus:ring-white"
                                      placeholder="Add a comment..."
                            ></textarea>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="submit"
                                    class="inline-flex items-center py-2 px-4 text-sm font-medium text-white border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none disabled:opacity-75 bg-secondary hover:bg-secondary focus:ring-secondary"
                                    x-bind:disabled="!comment"
                            >
                                Post
                            </button>
                        </div>
                    </div>
                </form>
                <div>
                    <a target="_blank" href="{{ route('terms.show') }}" class="p-1 text-sm underline text-secondary hover:text-secondary">Commenting Guidelines</a>
                </div>
            @else
                <button wire:click="login()"
                        class="py-1 px-3 text-center text-white bg-secondary"
                >
                    Login to comment
                </button>
            @endif
        </div>
    </div>
</div>

