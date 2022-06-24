<x-guest-layout>
    <div class="max-w-7xl mx-auto px-12 py-12">
        <div class="grid grid-cols-12">
            <div class="col-span-12 md:col-span-3 px-2 py-16">
                <x-submenu area="Media"/>
            </div>
            <div class="col-span-12 md:col-span-9">
                <div class="content">
                    <h2>Updates</h2>
                </div>
                <div class="divide-y divide-slate-100 sm:mt-4 lg:mt-8">
                    @foreach($updates as $update)
                        <article aria-labelledby="episode-5-title" class="py-4 sm:py-6">
                            <div class="grid md:flex items-center">
                                <div class="flex-shrink-0">
                                    <a href="{{ $update->url }}">
                                        <span class="sr-only">{!! $update->subject !!}</span>
                                        <img class="h-auto w-40 mx-auto" src="{{ $update->primary_image_url }}" alt="">
                                    </a>
                                </div>
                                <div class="ml-3">
                                    <div class="lg:px-8">
                                        <div class="lg:max-w-4xl">
                                            <div class="mx-auto px-4 sm:px-6 md:max-w-2xl md:px-4 lg:px-0">
                                                <div class="flex flex-col items-start">
                                                    <h2 id="episode-5-title"
                                                        class="mt-2 text-xl font-bold text-slate-900">
                                                        <a href="{{ $update->url }}"
                                                           @if($update->type == 'Newsletter') target="_newsletter" @endif>
                                                            {!! $update->subject !!}
                                                        </a>
                                                    </h2>
                                                    <time datetime="{{ $update->publish_at->toISOString() }}"
                                                          class="-order-1 font-mono text-sm leading-7 text-slate-500">
                                                        {{ $update->publish_at->format('l j, Y') }}
                                                    </time>
                                                    <p class="mt-1 text-base leading-7 text-slate-700">
                                                        {!! $update->preheader !!}
                                                    </p>
                                                    <div class="mt-4 flex items-center gap-4">
                                                        <a href="{{ $update->url }}"
                                                           @if($update->type == 'Newsletter') target="_newsletter" @endif
                                                           class="text-base font-semibold text-secondary hover:text-highlight">
                                                            Read more &gt;
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="browse-controls flex flex-wrap grid grid-cols-1 lg:grid-cols-2 mt-8">
                    <div class="items-center col-span-2 px-8">
                        {!! $updates->withQueryString()->links('vendor.pagination.tailwind') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
