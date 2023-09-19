<div>
    {{-- class="max-w-[94%]" --}}
    <iframe src="{{ route('pages.preview', ['item' => $item, 'page' => $page]) }}"
        class="overflow-y-scroll w-full h-screen border-0"
    ></iframe>
</div>
