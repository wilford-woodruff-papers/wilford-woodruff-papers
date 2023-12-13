<div wire:init="load">
    @if(count($duplicatePeople) > 0)
        <div class="p-4 bg-red-50 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">There {{ str('is')->plural($duplicatePeople->count()) }} {{ $duplicatePeople->count() }} possible {{ str('duplicate')->plural($duplicatePeople->count()) }} of this person</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul role="list" class="pl-5 space-y-1 list-disc">
                            @foreach($duplicatePeople as $duplicatePerson)
                                <li>
                                    <a href="{{ route('admin.dashboard.people.edit', ['person' => $duplicatePerson->slug]) }}"
                                       target="_blank"
                                    >
                                        {{ $duplicatePerson->display_name }} ({{ $duplicatePerson->slug }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @elseif(str($person?->slug)?->endsWith('-1'))
        <div class="p-4 bg-red-50 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        It doesn't look like this person has a duplicate, but the URL ends with 1 and needs to be addressed.
                    </h3>
                </div>
            </div>
        </div>
    @endif
</div>
