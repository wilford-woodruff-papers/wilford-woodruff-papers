@if(! empty($section['items']) && $section['items']->count() > 0)
<div>
    <div class="relative">
        <div id="{{ str($section['name'])->slug() }}" class="absolute -top-32"></div>
        <h2 class="my-8 text-4xl font-thin uppercase border-b-4 border-highlight">
            {{ $section['name'] }}
        </h2>
        <p class="mt-4 mb-8 text-xl">
            Browse other documents with this same date. These could include pages from Wilford Woodruff's autobiography, daybooks, letters, or other documents.
        </p>
    </div>
    @if($section['items']->count() > 3)
        <div class="grid grid-cols-1 gap-y-12 mx-auto mt-16 max-w-2xl lg:grid-cols-3 lg:mx-2 lg:max-w-none">
            @foreach ($section['items'] as $page)
                <article class="flex flex-col justify-between items-start p-4 cursor-pointer hover:bg-gray-100"
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
                                    {!!
                                        str($page->parent?->name)
                                            ->stripBracketedID()
                                            ->remove('[[')
                                            ->remove(']]')
                                    !!}
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
                                                    ->replace('<u>', '')
                                                    ->replace('</u>', '')
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
        <div class="grid grid-cols-1 gap-8">
            @foreach($section['items'] as $page)
                <article x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $page->id }}})"
                    class="py-4 pr-4 cursor-pointer hover:bg-gray-100"
                >
                    <div class="grid grid-cols-2 gap-x-4">
                        <div class="col-span-1 bg-cover bg-center bg-clip-content px-8 @if($loop->odd) order-0 @else order-1 @endif"
                             style="background-image: url('{{ $page->getfirstMediaUrl(conversionName: 'web') }}')"
                        >
                            <div class="overflow-hidden h-full shadow-2xl backdrop-blur-sm">
                                <div class="overflow-hidden mx-auto w-1/2 h-full shadow-2xl">
                                    <img src="{{ $page->getfirstMediaUrl(conversionName: 'web') }}"
                                         alt=""
                                         class="mx-auto w-full h-auto scale-125" />
                                </div>
                            </div>
                        </div>
                        <div class="col-span-1 @if($loop->odd) order-1 text-right @else order-0 text-left @endif">
                            <div class="flex flex-col gap-y-4 justify-between py-12 h-full">
                                <div>
                                    <div class="text-xl cursor-pointer text-secondary"
                                         x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $page->id }}})">
                                        {!!
                                            str($page->parent?->name)
                                                ->stripBracketedID()
                                                ->remove('[[')
                                                ->remove(']]')
                                        !!}
                                    </div>
                                </div>
                                <div class="">
                                    <div class="text-lg text-gray-900 line-clamp-6">
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
                                                    ->replace('<u>', '')
                                                    ->replace('</u>', '')
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
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endif
