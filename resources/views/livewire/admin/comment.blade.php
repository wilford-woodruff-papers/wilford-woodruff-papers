<li>
    <div class="flex space-x-3">
        <div class="flex-shrink-0">
            <img class="w-10 h-10 rounded-full" src="{{ $comment->creator->profile_photo_url }}" alt="">
        </div>
        <div>
            <div class="text-sm">
                <a href="#" class="font-medium text-gray-900"> {{ $comment->creator->name }}</a>
            </div>
            <div class="mt-1 text-sm text-gray-700">
                {{ $comment->text }}
            </div>
            <div class="mt-2 space-x-2 text-sm">
                <span class="font-medium text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                <span class="font-medium text-gray-500">&middot;</span>
                <span class="font-medium text-gray-500">{{ $comment->created_at->toDayDateTimeString() }}</span>
                @if($comment->created_by == auth()->id())
                    <button wire:click.debounce="delete" type="button" class="font-medium text-red-900">Delete</button>
                @endif
            </div>
        </div>
    </div>
</li>
