<div>
    <div class="px-2 pb-1 mx-8 text-lg border-b border-gray-200">
        {{ $subject->tagged_count }} {{ str('page')->plural($subject->tagged_count) }} tagged with {{ $subject->name }}
    </div>
    <section class="px-12">
        <ul  wire:loading.remove
             class="divide-y divide-gray-200"
             id="pages">
            @foreach($pages as $page)
                <x-page-summary :page="$page" :subject="$subject" />
            @endforeach
        </ul>
        <div id="page-pagination">
            {!! $pages->withQueryString()->links() !!}
        </div>
    </section>
</div>
