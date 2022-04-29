<div class="p-4">
    <h2 class="text-xl font-medium py-2 mb-2 border-b border-gray-200">
        {!! $press->title !!}
    </h2>
    <div class="">
        @if(! empty($press->link))
            <p class="text-center mb-2">
                <a href="{{ $press->link }}"
                   target="_blank"
                   class="text-secondary px-12 flex justify-center items-center gap-x-2"
                >
                    Open in new window
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </p>
            <iframe class=""
                    style="width: 100%; height: calc(100vh - 200px)"
                    src="{{ $press->link }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
        @else
            {!! $press->description !!}
        @endif
    </div>
</div>
