<div x-data="{
            observe () {
                let observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            @this.call('loadMore')
                        }
                    })
                }, {
                    root: null
                })

                observer.observe(this.$el)
            }
        }"
     x-init="observe">
    @if($testimonials->count())
        <div class="mt-8">
            <div id="image-testimonials">

                <div class="relative pt-16 pb-16 overflow-hidden">
                    @foreach($testimonials as $testimonial)
                        <div class="max-w-7xl mx-auto grid grid-cols-5 items-center gap-x-4 my-24">
                            <div class="col-span-5 md:col-span-3 @if($loop->odd) order-2 md:order-1 @else order-2 md:order-2 @endif pt-4 md:pt-0 px-4 md:px-12">
                                <h2 class="text-base lg:text-xl font-extrabold tracking-tight text-gray-900">
                                    {{ $testimonial->title }}
                                </h2>
                                <div class="my-4 border-t border-gray-200 pt-1">
                                    <blockquote>
                                        <footer class="mt-3">
                                            <div class="flex items-center space-x-3">
                                                <div class="text-sm lg:text-base font-medium text-gray-900">
                                                    {{ $testimonial->name }}
                                                </div>
                                            </div>
                                        </footer>
                                    </blockquote>
                                </div>
                                <div class="mt-4 text-base lg:text-lg text-gray-800">
                                    {!! $testimonial->excerpt !!}
                                </div>
                                @if($testimonial->type != 'Video')
                                    <div class="mt-6">
                                        <span onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" =>     $testimonial->id]) }})'
                                              class="block text-center md:inline-flex bg-secondary text-white px-4 py-2 border border-transparent text-base font-medium shadow-sm cursor-pointer">
                                            {{ $testimonial->call_to_action }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-span-5 md:col-span-2 @if($loop->odd) order-1 md:order-2 @else order-1 md:order-1 @endif">
                                @if($testimonial->type == 'Video')
                                    <div class="w-[260px] h-[160px] lg:w-[480px] lg:h-[310px] mx-auto">
                                        <iframe class="w-[260px] h-[160px] lg:w-[480px] lg:h-[310px]" src="{{ $testimonial->embed_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                @else
                                    <div onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $testimonial->id]) }})'
                                         class="px-12 sm:px-24 md:px-16 cursor-pointer">
                                        <img class="w-full h-auto mx-auto shadow-xl ring-1 ring-black ring-opacity-5" src="{{ $testimonial->getFirstMediaUrl('images', 'square') }}" alt="{{ $testimonial->name }}">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
