<x-guest-layout>
    <x-slot name="title">
        {{ $opportunity->title }} | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Get Involved"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 article content">
                        <h2 class="text-lg">{{ $opportunity->title }}</h2>

                        <div class="grid gap-16 mt-4 lg:grid-cols-1 lg:gap-y-12">
                            <div>
                                <p class="mt-3 text-base text-gray-500">
                                    {!! $opportunity->description !!}
                                </p>
                            </div>
                        </div>

                        @if(! empty($opportunity->file))
                            <div class="grid gap-16 mt-4 lg:grid-cols-1 lg:gap-y-12">
                                <div>
                                    <p class="mt-3">
                                        <a class="py-2 px-4 text-base border-2 border-secondary bg-secondary"
                                           style="color: white; text-decoration: none;"
                                           href="{{ Storage::disk('job_opportunities')->url($opportunity->file) }}"
                                           target="_opportunity">Full description</a>
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
