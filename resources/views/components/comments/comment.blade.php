<li class="">
    <div class="flex pt-4 pb-2 space-x-3">
        <div class="flex-shrink-0">
            <img class="w-8 h-8 rounded-full"
                 src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}">
        </div>
        <div class="flex-1 min-w-0">
            <div class="text-base text-gray-800">{{ $comment->comment }}</div>
        </div>
        <div>
            @guest()
                <button wire:click="login()">
                    <span class="sr-only">Login to like comment</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 cursor-pointer hover:text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
            @else
                <button wire:click="toggleCommentLike({{ $comment->id }})">
                    <span class="sr-only">Like comment</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 cursor-pointer hover:text-red-700 @if(\Maize\Markable\Models\Like::has($comment, \Illuminate\Support\Facades\Auth::user())) text-red-700 @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
            @endguest
        </div>
    </div>

    <div class="flex px-6 pb-4 mt-2">
        <span class="inline-flex gap-x-4 items-center text-sm">
            <span class="text-xs font-medium text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
            @if(($count = \Maize\Markable\Models\Like::count($comment)) > 0)
                <span class="text-xs font-medium text-gray-400">{{ $count }} {{ str('Like')->plural($count) }}</span>
            @endif
            @if($comment->user_id == Auth::id())
                <span wire:click="deleteComment({{ $comment->id }})"
                      class="text-xs font-medium text-red-700 cursor-pointer">Delete</span>
            @endif
        </span>
    </div>
</li>
