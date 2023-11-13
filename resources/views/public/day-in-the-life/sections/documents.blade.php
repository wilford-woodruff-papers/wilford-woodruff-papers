@if(! empty($section['items']) && $section['items']->count() > 0)
<div>
    <div class="relative">
        <div id="{{ str($section['name'])->slug() }}" class="absolute -top-32"></div>
        <h2 class="my-8 text-2xl font-semibold uppercase">
            {{ $section['name'] }}
        </h2>
    </div>
    @if($section['items']->count() > 3)
        <div class="grid grid-cols-1 gap-x-8 gap-y-20 mx-auto mt-16 max-w-2xl lg:grid-cols-3 lg:mx-2 lg:max-w-none">
            @foreach ($section['items'] as $page)
                <article class="flex flex-col justify-between items-start cursor-pointer"
                         x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $page->id }}})">
                    <div
                        class="w-full"
                    >

                        <div class="overflow-hidden relative w-full">
                            <img src="{{ $page->getfirstMediaUrl(conversionName: 'thumb') }}"
                                 alt=""
                                 class="object-cover w-full bg-gray-100 scale-150 aspect-[16/9] sm:aspect-[2/1] lg:aspect-[3/2]">
                            <div class="absolute inset-0 ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="max-w-xl">
                            <div class="relative group">
                                <h3 class="mt-3 text-lg font-semibold leading-6 group-hover:text-gray-600 text-secondary">
                                    <span class="absolute inset-0"></span>
                                    {!! str($page->parent?->name)->remove('[[')->remove(']]') !!}
                                </h3>
                                <div class="mt-5 text-sm leading-6 text-gray-900 line-clamp-3">
                                    {!!
                                        str(
                                            strip_tags(
                                                str($page->transcript)
                                                    ->extractContentOnDate($date)
                                                    ->addSubjectLinks()
                                                    ->addScriptureLinks()
                                                    ->removeQZCodes(false)
                                                    ->replace('&amp;', '&')
                                                    ->replace('<s>', '')
                                                    ->replace('</s>', '')
                                                )
                                        )
                                        ->trim(' ')
                                        ->ltrim('.')
                                        ->ltrim(',')
                                        ->trim(' ')
                                    !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="grid grid-cols-1 gap-16">
            @foreach($section['items'] as $page)
                <article x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $page->id }}})">
                    <div class="grid grid-cols-2 gap-x-4">
                        <div class="col-span-1 px-8 @if($loop->odd) order-0 @else order-1 @endif">
                            <div class="overflow-hidden">
                                <img src="{{ $page->getfirstMediaUrl(conversionName: 'web') }}"
                                     alt=""
                                     class="w-full h-auto scale-125" />
                            </div>
                        </div>
                        <div class="col-span-1 @if($loop->odd) order-1 text-right @else order-0 text-left @endif">
                            <div class="flex flex-col gap-y-4 justify-between py-12 h-full">
                                <div>
                                    <div class="text-xl cursor-pointer text-secondary"
                                         x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $page->id }}})">
                                        {{ $page->parent?->name }}
                                    </div>
                                </div>
                                <div class="">
                                    <div class="text-lg text-gray-900 line-clamp-6">
                                        {!!
                                            str($page->transcript)
                                                ->extractContentOnDate($date)
                                                ->addSubjectLinks()
                                                ->addScriptureLinks()
                                                ->removeQZCodes(false)
                                                ->replace('&amp;', '&')->replace('<s>', '')
                                                ->replace('</s>', '')
                                                ->trim(' ')
                                                ->ltrim('.')
                                                ->ltrim(',')
                                                ->trim(' ')
                                        !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endif
