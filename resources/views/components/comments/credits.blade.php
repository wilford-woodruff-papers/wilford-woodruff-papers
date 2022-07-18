@if(! empty($media->credits))
    <li class="bg-gray-200 px-4 py-4">
        <div class="flex flex-col gap-x-4">
            <div class="text-lg font-medium border-b-2 border-gray-300">
                Video Credits
            </div>
            <div class="pt-4">
                {!! $media->credits !!}
            </div>
        </div>
    </li>
@endif
