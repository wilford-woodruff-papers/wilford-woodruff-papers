<div>
    <div class="px-4 pt-4 pb-4 mx-auto max-w-7xl md:pt-4 md:pb-4 xl:pt-4">
        <div class="grid grid-cols-1 pb-4 sm:grid-cols-2 md:grid-cols-3">
            <div class="font-extrabold">
                <h2 class="pb-1 text-3xl uppercase border-b-4 border-highlight">Progress</h2>
            </div>
        </div>
    </div>
    <div class="mb-8">
        <div class="py-4 px-4 mx-auto max-w-7xl md:py-4 md:px-4">
            @if($quarterlyUpdate)
                <div class="mb-2">
                    <div class="px-2 pb-4 mx-auto max-w-7xl md:pb-8">
                        <div class="flex overflow-hidden flex-col shadow-lg">
                            <div class="flex-shrink-0">
                                <div class="mx-auto max-w-full h-auto md:max-w-7xl">
                                    <a href="{{ $quarterlyUpdate->url }}">
                                        <img src="https://nyc3.digitaloceanspaces.com/wilford-woodruff-papers/img/quarterly-progress-report.png" alt="Quarterly Progress Report"/>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="grid gap-5 md:grid-cols-2">
                <div class="px-2 mx-auto">
                    <img class="object-cover object-center shadow-2xl" src="https://nyc3.digitaloceanspaces.com/wilford-woodruff-papers/img/progress-1.png" alt="">
                </div>
                <div class="px-2 mx-auto">
                    <img class="object-cover object-center shadow-2xl" src="https://nyc3.digitaloceanspaces.com/wilford-woodruff-papers/img/progress-2.png" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
