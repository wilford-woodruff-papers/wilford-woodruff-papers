<x-guest-layout>
    <x-slot name="title">
        Wilford Woodruff Papers Foundation Updates
    </x-slot>
    <div class="py-12 px-12 mx-auto max-w-7xl">
        <div class="grid grid-cols-12">
            <div class="col-span-12 py-16 px-2 md:col-span-3">
                <x-submenu area="Media"/>
            </div>
            <div class="col-span-12 md:col-span-9">
                <div class="content">
                    <h2>Updates</h2>
                </div>
                <div>
                    <!-- Begin Constant Contact Inline Form Code -->
                    <div class="ctct-inline-form" data-form-id="043d0ee9-7e01-4dbd-ac81-34f17e56240c"></div>
                    <!-- End Constant Contact Inline Form Code -->
                </div>
                <div class="divide-y sm:mt-4 lg:mt-8 divide-slate-100">
                    @foreach($updates as $update)
                        <article aria-labelledby="episode-5-title" class="py-4 sm:py-6">
                            <div class="grid items-center md:flex">
                                <div class="flex-shrink-0">
                                    <a href="{{ $update->url }}">
                                        <span class="sr-only">{!! $update->subject !!}</span>
                                        <img class="mx-auto w-40 h-auto" src="{{ $update->primary_image_url }}" alt="">
                                    </a>
                                </div>
                                <div class="ml-3">
                                    <div class="lg:px-8">
                                        <div class="lg:max-w-4xl">
                                            <div class="px-4 mx-auto sm:px-6 md:px-4 md:max-w-2xl lg:px-0">
                                                <div class="flex flex-col items-start">
                                                    <h2 id="episode-5-title"
                                                        class="mt-2 text-xl font-bold text-slate-900">
                                                        <a href="{{ $update->url }}"
                                                           @if($update->type == 'Newsletter') target="_newsletter" @endif>
                                                            {!! $update->subject !!}
                                                        </a>
                                                    </h2>
                                                    <time datetime="{{ $update->publish_at->toISOString() }}"
                                                          class="font-mono text-sm leading-7 -order-1 text-slate-500">
                                                        {{ $update->publish_at->format('F j, Y') }}
                                                    </time>
                                                    <p class="mt-1 text-base leading-7 text-slate-700">
                                                        {!! $update->preheader !!}
                                                    </p>
                                                    <div class="flex gap-4 items-center mt-4">
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
                <div class="flex grid flex-wrap grid-cols-1 mt-8 lg:grid-cols-2 browse-controls">
                    <div class="col-span-2 items-center px-8">
                        {!! $updates->withQueryString()->links('vendor.pagination.tailwind') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
