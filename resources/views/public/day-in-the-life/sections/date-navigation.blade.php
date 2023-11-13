<div class="flex gap-x-12 justify-center items-center">
    <div>
        @if(! empty($previousDay))
            <a href="{{ route('day-in-the-life', ['date' => $previousDay]) }}"
               title="{{ $previousDay }}"
               class="p-2 text-white rounded-full shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 font-semibold text-secondary">
                    <path fill-rule="evenodd" d="M7.72 12.53a.75.75 0 010-1.06l7.5-7.5a.75.75 0 111.06 1.06L9.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5z" clip-rule="evenodd" />
                </svg>
            </a>
        @endif
    </div>
    <div class="flex gap-x-4 justify-center items-center">
        <h1 class="text-2xl font-semibold text-center text-gray-900 md:text-4xl">
            {{ $date->toFormattedDateString() }}
        </h1>
        <div class="">
            <div class="h-0">
                <input class="w-0 h-0 border-0" x-ref="{{ $location }}_picker" type="text"/>
            </div>
            <button class="mx-auto text-gray-900" x-on:click="pickers['{{ $location }}'].toggle()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                </svg>
            </button>
        </div>
    </div>

    <div>
        @if(! empty($nextDay))
            <a href="{{ route('day-in-the-life', ['date' => $nextDay]) }}"
               title="{{ $nextDay }}"
               class="p-2 text-white rounded-full shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 font-semibold text-secondary">
                    <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z" clip-rule="evenodd" />
                </svg>
            </a>
        @endif
    </div>
</div>
