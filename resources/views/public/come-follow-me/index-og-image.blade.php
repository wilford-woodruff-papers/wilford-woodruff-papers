<x-chromeless-layout>
    <div class="w-[1200px] h-[630px]">
        <div class="grid grid-cols-1 h-full md:grid-cols-7">
            <div class="flex flex-col order-2 justify-between p-8 md:order-1 md:col-span-5 bg-secondary">
                <div class="flex flex-col gap-y-4 py-4">
                    <div class="flex flex-col gap-y-2 pb-4">
                        <div class="pb-2 font-serif text-4xl font-extralight text-white">
                            Come, Follow Me Insights:
                        </div>
                        <div class="pb-2 font-serif text-6xl font-semibold text-white drop-shadow-2xl">
                            {{ $bookName }}
                        </div>
                    </div>

                    <div class="flex flex-col pb-4 border-b border-white">
                        <div class="pb-4 text-3xl font-medium leading-10 text-white">
                            Magnify your Come, Follow Me study through<br/>Wilford Woodruff's records
                        </div>
                    </div>

                    <div class="pt-8">
                        <div class="inline py-4 px-4 text-xl font-semibold bg-white shadow-xl text-secondary">
                            STUDY COME, FOLLOW ME WITH WILFORD WOODRUFF
                        </div>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('img/image-logo.png') }}"
                         alt=""
                        class="w-auto h-24"
                    />
                </div>
            </div>
            <div class="order-1 bg-center bg-no-repeat bg-cover md:order-2 md:col-span-2"
                 style="background-image: url('{{ $image }}');">
                <img src="{{ $image }}" alt="" class="w-full md:hidden aspect-[16/8]" />
            </div>
        </div>
    </div>
</x-chromeless-layout>
