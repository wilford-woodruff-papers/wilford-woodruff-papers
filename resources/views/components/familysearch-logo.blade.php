<div class="flex gap-2 items-center py-2 pr-3 pl-2 text-sm rounded-md border border-gray-200">
    <div>
        <img src="{{ asset('img/familysearch/fs-tree-logo.png') }}"
             alt=""
             class="w-6 h-6"
        >
    </div>
    <div>
        <a href="https://www.familysearch.org/tree/person/details/{{ $getState() }}"
           class="underline text-secondary"
           target="_familysearch"
           rel="noopener noreferrer"
        >
            View in FamilySearch
        </a>
    </div>
</div>
