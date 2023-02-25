<x-admin-layout>
    <div class="py-8 px-2 mx-auto max-w-7xl">
        <table class="w-full">
            <thead>
                <tr class="text-left">
                    <th class="px-2">Item</th>
                    <th class="px-2">Page</th>
                    <th class="px-4">Action</th>
                    <th class="px-4">Completed At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                    <tr>
                        <td class="px-2">
                            <a href="{{ route('admin.dashboard.document', ['item' => $page->item]) }}"
                               class="text-secondary"
                               target="_document"
                            >
                                {{ $page->item?->name }}
                            </a>
                        </td>
                        <td class="px-2">
                            <a href="{{ route('admin.dashboard.page', ['item' => $page->item, 'page' => $page]) }}"
                               class="text-secondary"
                               target="_document"
                            >
                                {{ str($page->name)->replace('_', ' ')->title()->limit(10) }}
                            </a>
                        </td>
                        <td class="px-4">
                            {{ $page->actions->first()?->type->name }}
                        </td>
                        <td class="px-4">
                            <div class="whitespace-nowrap">
                                {{ $page->actions->first()?->completed_at->toFormattedDateString() }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="py-8 px-8">
                <tr>
                    <td colspan="4">
                        {!! $pages->appends(request()->query())->links() !!}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</x-admin-layout>
