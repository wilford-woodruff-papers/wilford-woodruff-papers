<x-guest-layout>
    <div class="py-4 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden prose">
                {!! $terms !!}
            </div>
        </div>
        <div class="flex flex-col items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-2xl mt-2 py-2 overflow-hidden prose">
                <form action="{{ route('terms.submit') }}" method="POST">
                    <button type="submit"
                            class="bg-secondary text-white font-semibold py-2 block w-full"
                    >
                        AGREE
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
