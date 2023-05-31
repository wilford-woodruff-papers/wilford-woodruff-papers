<x-guest-layout>
    <div class="py-4 bg-gray-100">
        <div class="flex flex-col items-center pt-6 min-h-screen sm:pt-0">
            <div class="overflow-hidden p-6 mt-6 w-full bg-white shadow-md sm:max-w-2xl prose">
                {!! $terms !!}
            </div>
        </div>
        <div class="flex flex-col items-center pt-6 sm:pt-0">
            <div class="overflow-hidden py-2 mt-2 w-full sm:max-w-2xl prose">
                <form action="{{ route('api.terms.submit') }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit"
                            class="block py-2 w-full font-semibold text-white bg-secondary"
                    >
                        AGREE
                    </button>
                </form>
            </div>
        </div>
    </div>
    @push('styles')
        <style>
            ol {
                list-style-type: none;
                counter-reset: item;
                margin: 0;
                padding: 0;
            }

            ol > li {
                display: table;
                counter-increment: item;
                margin-bottom: 0.6em;
            }

            ol > li:before {
                content: counters(item, ".") ". ";
                display: table-cell;
                padding-right: 0.6em;
            }

            li ol > li {
                margin: 0;
            }

            li ol > li:before {
                content: counters(item, ".") " ";
            }
        </style>
    @endpush
</x-guest-layout>
