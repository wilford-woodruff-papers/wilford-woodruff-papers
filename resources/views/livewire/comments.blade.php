<div x-data="{
    'comment': @entangle('comment')
}"
     class="flex flex-col h-full">
    <div class="flex-none fixed-top p-4 border-b border-gray-200">
        Comments
    </div>
    <div class="grow px-4 pb-4">
        <div class="mt-6 flow-root">
            <ul role="list" class="-my-4 divide-y divide-gray-200 px-2">
                @foreach($model->comments as $comment)
                    <x-comments.comment :comment="$comment"/>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="flex-none fixed-bottom p-4 border-t border-gray-200">
        <div class="flex justify-between mb-4">
            <div>
                <span class="text-xs font-medium text-gray-500">{{ $model->created_at->diffForHumans() }}</span>
            </div>
            <x-press.share :media="$model" :showCommentIcon="false"/>
        </div>
        <div>
            <form wire:submit.prevent="save()">
                <div class="flex mt-1 gap-x-2">
                    <div class="flex-1">
                        <textarea wire:model.debounce.300ms="comment"
                                  rows="4"
                                  name="comment"
                                  id="comment"
                                  class="block w-full sm:text-sm border border-gray-200 h-16 resize-none focus:ring-white"
                                  placeholder="Add a comment..."
                        ></textarea>
                    </div>
                    <div class="flex-shrink-0">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium shadow-sm text-white bg-secondary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary disabled:opacity-75"
                                x-bind:disabled="!comment"
                        >
                            Post
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

