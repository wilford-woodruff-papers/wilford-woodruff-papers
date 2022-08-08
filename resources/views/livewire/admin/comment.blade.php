<li>
    <div class="flex space-x-3">
        <div class="flex-shrink-0">
            <img class="h-10 w-10 rounded-full" src="{{ $comment->creator->profile_photo_url }}" alt="">
        </div>
        <div>
            <div class="text-sm">
                <a href="#" class="font-medium text-gray-900"> {{ $comment->creator->name }}</a>
            </div>
            <div class="mt-1 text-sm text-gray-700">
                {{ $comment->text }}
            </div>
            <div class="mt-2 text-sm space-x-2">
                <span class="text-gray-500 font-medium">{{ $comment->created_at->diffForHumans() }}</span>
                <span class="text-gray-500 font-medium">&middot;</span>
                <span class="text-gray-500 font-medium">{{ $comment->created_at->toDayDateTimeString() }}</span>
                @if($comment->created_by == auth()->id())
                    <button wire:click.debounce="delete" type="button" class="text-red-900 font-medium">Delete</button>
                @endif
            </div>
        </div>
    </div>
</li>
