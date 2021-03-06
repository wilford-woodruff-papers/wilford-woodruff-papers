@if($images->count())
    <div class="mt-8">
        <div id="image-testimonials">

            <div class="relative pt-16 pb-16 overflow-hidden">
                @foreach($images as $image)
                    @if($loop->odd)
                        <div class="relative">
                            <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                                <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-16 lg:max-w-none lg:mx-0 lg:px-0">
                                    <div>
                                        <div class="mt-6">
                                            <h2 class="text-lg font-extrabold tracking-tight text-gray-900">
                                                {{ $image->title }}
                                            </h2>
                                            <div class="mt-4 text-3xl text-gray-500">
                                                {!! $image->excerpt !!}
                                            </div>
                                            <div class="mt-6">
                                                <span onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $image->id]) }})'
                                                      class="inline-flex bg-secondary text-white px-4 py-2 border border-transparent text-base font-medium shadow-sm cursor-pointer">
                                                    Read more
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-8 border-t border-gray-200 pt-1">
                                        <blockquote>
                                            <footer class="mt-3">
                                                <div class="flex items-center space-x-3">
                                                    <div class="text-base font-medium text-gray-700">
                                                        {{ $image->name }}
                                                    </div>
                                                </div>
                                            </footer>
                                        </blockquote>
                                    </div>
                                </div>
                                <div class="mt-12 sm:mt-16 lg:mt-0">
                                    <div onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $image->id]) }})'
                                         class="pl-4 -mr-48 sm:pl-6 md:-mr-16 lg:px-0 lg:m-0 lg:relative lg:h-full cursor-pointer">
                                        <img class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none" src="{{ $image->getFirstMediaUrl('images', 'square') }}" alt="{{ $image->name }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="my-24">
                            <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                                <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-32 lg:max-w-none lg:mx-0 lg:px-0 lg:col-start-2">
                                    <div>
                                        <div class="mt-6">
                                            <h2 class="text-lg font-extrabold tracking-tight text-gray-900">
                                                {{ $image->title }}
                                            </h2>
                                            <div class="mt-4 text-3xl text-gray-500">
                                                {!! $image->excerpt !!}
                                            </div>
                                            <div class="mt-6">
                                                <span onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $image->id]) }})'
                                                   class="inline-flex bg-secondary text-white px-4 py-2 border border-transparent text-base font-medium shadow-sm cursor-pointer">
                                                    Read more
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-8 border-t border-gray-200 pt-1">
                                        <blockquote>
                                            <footer class="mt-3">
                                                <div class="flex items-center space-x-3">
                                                    <div class="text-base font-medium text-gray-700">
                                                        {{ $image->name }}
                                                    </div>
                                                </div>
                                            </footer>
                                        </blockquote>
                                    </div>
                                </div>
                                <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-start-1">
                                    <div onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $image->id]) }})'
                                         class="pr-4 -ml-48 sm:pr-6 md:-ml-16 lg:px-0 lg:m-0 lg:relative lg:h-full cursor-pointer">
                                        <img class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:right-0 lg:h-full lg:w-auto lg:max-w-none" src="{{ $image->getFirstMediaUrl('images', 'square') }}" alt="{{ $image->name }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
