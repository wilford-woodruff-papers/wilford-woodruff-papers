<x-guest-layout>

    <x-slot name="openGraph">
        <meta property="og:title" content="Come, Follow Me Insights: {{ $book }}">
        <meta property="og:description" content="Magnify your Come, Follow Me study through Wilford Woodruff's records">
        <meta property="og:type" content="website">
        <meta property="og:image" content="{{ route('come-follow-me.index.ogimage', ['book' => $bookSlug]) }}">
        <meta property="og:url" content="{{ route('come-follow-me.index', ['book' => $bookSlug]) }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Come, Follow Me Insights: {{ $book }}">
    </x-slot>

    <div>
        <div class="mx-auto max-w-7xl">
            <div class="flex flex-col gap-y-1 mt-8 mb-2">
                <h1 class="text-4xl text-center md:text-6xl">
                    <span class="italic">Come, Follow Me</span> with Wilford Woodruff
                </h1>
                <h2 class="text-xl text-center md:text-2xl">
                    Magnify your <span class="italic">Come, Follow Me</span> study through Wilford Woodruff’s records
                </h2>
            </div>
            <div class="my-8 mx-8">
                <div>
                    <div class="flex justify-center sm:hidden">
                        <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                        <select aria-label="Select a tab" class="col-start-1 row-start-1 py-2 pr-8 pl-3 w-full text-base text-gray-900 bg-white rounded-md appearance-none outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-secondary-600"
                                onChange="window.location.href = this.value">
                        >
                            <option @selected($bookSlug === 'doctrine-and-covenants')
                                value="{{ route('come-follow-me.index', ['book' => 'doctrine-and-covenants']) }}">
                                Doctrine & Covenants
                            </option>
                            <option @selected($bookSlug === 'book-of-mormon')
                                value="{{ route('come-follow-me.index', ['book' => 'book-of-mormon']) }}">
                                Book of Mormon
                            </option>
                        </select>
                    </div>
                    <div class="hidden justify-center sm:flex">
                        <nav class="flex space-x-4" aria-label="Tabs">
                            <!-- Current: "bg-indigo-100 text-indigo-700", Default: "text-gray-500 hover:text-gray-700" -->
                            <a href="{{ route('come-follow-me.index', ['book' => 'doctrine-and-covenants']) }}"
                                @class([
                                   'py-2 px-3 text-sm font-medium',
                                   'bg-secondary text-white' => $bookSlug === 'doctrine-and-covenants',
                                   'bg-white text-secondary hover:bg-secondary-500 hover:text-white' => $bookSlug !== 'doctrine-and-covenants',
                                ])>
                                Doctrine & Covenants
                            </a>
                            <a href="{{ route('come-follow-me.index', ['book' => 'book-of-mormon']) }}"
                               @class([
                                  'py-2 px-3 text-sm font-medium',
                                  'bg-secondary text-white' => $bookSlug === 'book-of-mormon',
                                  'bg-white text-secondary hover:bg-secondary-500 hover:text-white' => $bookSlug !== 'book-of-mormon',
                               ])>
                                Book of Mormon
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            @if($cfm)
                <div class="grid grid-cols-1 pb-4 md:order-1 md:grid-cols-7">
                    <div class="order-2 p-8 md:col-span-5 bg-secondary">
                        <div class="flex flex-col gap-y-4">
                            <div class="pb-2 font-serif text-4xl text-white border-b border-white">
                                &ldquo;{{ $cfm->title }}&rdquo;
                            </div>
                            <div class="flex flex-col">
                                <div class="text-xl text-white">
                                    Week {{ $cfm->week }}
                                </div>
                                <div class="text-2xl font-semibold text-white">
                                    {{ $cfm->reference }}
                                </div>
                                <div class="py-2 text-xl text-white line-clamp-4">
                                    {!! $cfm->quote !!}
                                </div>
                            </div>
                            <div class="mb-3">
                                <a href="{{ route('come-follow-me.show', ['book' => $bookSlug, 'week' => $cfm->week]) }}"
                                   class="py-3 px-8 font-semibold bg-white text-secondary">
                                    READ MORE >>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 bg-center bg-no-repeat bg-cover md:order-2 md:col-span-2"
                         style="background-image: url('{{ $cfm->getFirstMediaUrl('cover_image') }}');">
                        <img src="{{ $cfm->getFirstMediaUrl('cover_image') }}" alt="" class="w-full md:hidden aspect-[16/8]" />
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-2 gap-x-6 gap-y-8 my-8 md:grid-cols-4">
                @foreach($lessons as $lesson)
                    @include('public.come-follow-me.card')
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>
