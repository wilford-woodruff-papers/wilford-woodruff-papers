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
                        <div @if($testimonial->type != 'Video')
                                 onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $testimonial->id]) }})'
                             @endif
                             class="max-w-7xl mx-auto grid grid-cols-5 items-center gap-x-4 my-24">
                            <div class="col-span-5 md:col-span-3 @if($loop->odd) order-2 md:order-1 @else order-2 md:order-2 @endif pt-4 md:pt-0 px-4 md:px-12">
                                <h2 class="text-base lg:text-xl font-extrabold tracking-tight text-gray-900">
                                    {{ $testimonial->title }}
                                </h2>
                                <div class="my-4 border-t border-gray-200 pt-1">
                                    <div class="flex items-center space-x-3 mt-3">
                                        <div class="text-sm lg:text-base font-medium text-gray-900">
                                            {{ $testimonial->name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-x-4 mt-4 text-base lg:text-lg text-gray-800">
                                    <div class="flex-initial">
                                        <svg class="h-8 w-8 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                                        </svg>
                                    </div>
                                    <blockquote class="text-justify">
                                        {!! $testimonial->excerpt !!}
                                    </blockquote>
                                    <div class="flex-initial">
                                        <svg class="h-8 w-8 text-primary-80 transform rotate-180" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @if($testimonial->type != 'Video')
                                    <div class="mt-6">
                                        <span onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" =>     $testimonial->id]) }})'
                                              class="block text-center uppercase md:inline-flex bg-secondary text-white px-4 py-2 border border-transparent text-base font-medium shadow-sm cursor-pointer">
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
