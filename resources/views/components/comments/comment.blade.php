<li class="flex py-4 space-x-3">
    <div class="flex-shrink-0">
        <img class="h-8 w-8 rounded-full"
             src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}">
    </div>
    <div class="min-w-0 flex-1">
        <p class="text-sm text-gray-800">{{ $comment->comment }}</p>
    </div>
</li>
