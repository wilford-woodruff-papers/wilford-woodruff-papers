<x-chromeless-layout>
    <div class="w-[1200px] h-[630px]">
        <div class="grid grid-cols-1 h-full md:grid-cols-7">
            <div class="order-2 p-8 md:order-1 md:col-span-5 bg-secondary">
                <div class="flex flex-col gap-y-4 py-4">
                    <div class="flex flex-col gap-y-2 pb-4 border-b border-white">
                        <div class="text-xl text-white">
                            Week {{ $lesson->week }}: {{ $lesson->reference }}
                        </div>
                        <div class="pb-2 font-serif text-5xl text-white">
                            &ldquo;{{ $lesson->title }}&rdquo;
                        </div>
                    </div>

                    <div class="flex flex-col pt-8">
                        <div class="pb-4 text-3xl font-medium text-white">
                            Come Follow Me Insights with Wilford Woodruff
                        </div>
                        <div class="my-2 font-sans text-2xl font-light text-white line-clamp-6">
                            {!! $lesson->quote !!}
                        </div>
                    </div>

                    <div class="pt-4">
                        <div class="inline py-2 px-4 text-xl font-semibold bg-white shadow-xl text-secondary">
                            READ MORE
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-1 bg-center bg-no-repeat bg-cover md:order-2 md:col-span-2"
                 style="background-image: url('{{ $lesson->getFirstMediaUrl('cover_image') }}');">
                <img src="{{ $lesson->getFirstMediaUrl('cover_image') }}" alt="" class="w-full md:hidden aspect-[16/8]" />
            </div>
        </div>
    </div>
</x-chromeless-layout>
