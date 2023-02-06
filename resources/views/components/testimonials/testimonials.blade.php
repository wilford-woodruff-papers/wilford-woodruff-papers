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

                <div class="overflow-hidden relative pt-16 pb-16">
                    @foreach($testimonials as $testimonial)
                        <div @if($testimonial->type != 'Video')
                                 onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $testimonial->id]) }})'
                             @endif
                             class="grid grid-cols-5 gap-x-4 items-center my-24 mx-auto max-w-7xl">
                            <div class="col-span-5 md:col-span-3 @if($loop->odd) order-2 md:order-1 @else order-2 md:order-2 @endif pt-4 md:pt-0 px-4 md:px-12">
                                <h2 class="text-base font-extrabold tracking-tight text-gray-900 lg:text-xl">
                                    {{ $testimonial->title }}
                                </h2>
                                <div class="pt-1 my-4 border-t border-gray-200">
                                    <div class="flex items-center mt-3 space-x-3">
                                        <div class="text-sm font-medium text-gray-900 lg:text-base">
                                            {{ $testimonial->name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-x-4 mt-4 text-base text-gray-800 lg:text-lg">
                                    <div class="flex-initial">
                                        <svg class="w-8 h-8 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                                        </svg>
                                    </div>
                                    <blockquote class="text-justify">
                                        {!! $testimonial->excerpt !!}
                                    </blockquote>
                                    <div class="flex-initial">
                                        <svg class="w-8 h-8 transform rotate-180 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @if($testimonial->type != 'Video')
                                    <div class="mt-6">
                                        <span onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" =>     $testimonial->id]) }})'
                                              class="block py-2 px-4 text-base font-medium text-center text-white uppercase border border-transparent shadow-sm cursor-pointer md:inline-flex bg-secondary">
                                            {{ $testimonial->call_to_action }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-span-5 md:col-span-2 @if($loop->odd) order-1 md:order-2 @else order-1 md:order-1 @endif">
                                @if($testimonial->type == 'Video')
                                    <div class="mx-auto w-[260px] h-[160px] lg:w-[480px] lg:h-[310px]">
                                        <iframe class="w-[260px] h-[160px] lg:w-[480px] lg:h-[310px]" src="{{ $testimonial->embed_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                @else
                                    <div onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $testimonial->id]) }})'
                                         class="px-12 cursor-pointer sm:px-24 md:px-16">
                                        <img class="mx-auto w-full h-auto ring-1 ring-black ring-opacity-5 shadow-xl" src="{{ $testimonial->getFirstMediaUrl('images', 'square') }}" alt="{{ $testimonial->name }}">
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
