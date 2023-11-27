<div wire:init="loadComments">
    <section aria-labelledby="notes-title">
        <div class="bg-white shadow sm:overflow-hidden sm:rounded-lg">
            <div class="divide-y divide-gray-200">
                <div class="py-5 px-4 sm:px-6">
                    <h2 id="notes-title" class="text-lg font-medium text-gray-900">Notes</h2>
                </div>
                <div>
                    @if($comments->count() > 0)
                        <div class="py-6 px-4 sm:px-6">
                            <ul role="list" class="overflow-y-scroll space-y-8 max-h-96">
                                @foreach($comments as $comment)
                                    <livewire:admin.comment :comment="$comment" :wire:key="'comment-'.$comment->id"/>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="py-6 px-4 bg-gray-50 sm:px-6">
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <img class="w-10 h-10 rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="">
                    </div>
                    <div class="flex-1 min-w-0">
                        <form wire:submit="save">
                            <div>
                                <label for="comment" class="sr-only">About</label>
                                <textarea wire:model="comment.text"
                                          id="comment" name="comment" rows="3"
                                          class="block w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:border-blue-500 focus:ring-blue-500"
                                          placeholder="Add a note"></textarea>
                            </div>
                            <div class="flex justify-between items-center mt-3">
                                {{--<a href="#" class="inline-flex items-start space-x-2 text-sm text-gray-500 hover:text-gray-900 group">
                                    <!-- Heroicon name: solid/question-mark-circle -->
                                    <svg class="flex-shrink-0 w-5 h-5 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                    <span> Some HTML is okay. </span>
                                </a>--}}
                                <button type="submit"
                                        class="inline-flex justify-center items-center py-2 px-4 text-sm font-medium text-white bg-blue-600 rounded-md border border-transparent shadow-sm hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none">Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
