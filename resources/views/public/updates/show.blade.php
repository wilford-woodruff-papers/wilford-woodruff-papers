<x-guest-layout>
    <div class="max-w-7xl mx-auto px-12 py-12">
        <div class="content">
            <h2>
                {{ $update->subject }}
            </h2>
            <div class="bg-white">
                <div class="flex flex-col shadow-lg overflow-hidden">
                    <div class="flex-1 bg-white px-6 pb-3 flex flex-col justify-between">
                        <div class="flex-1">
                            <div class="text-lg font-semibold text-gray-900">
                                {!! $update->content !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
