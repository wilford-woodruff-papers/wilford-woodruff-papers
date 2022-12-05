<div class="person-modal pb-4" style="height: auto; background-color: {{ $backgroundColor }};">
    <div class="absolute right-4 top-2">
        <button wire:click="$emit('closeModal')"
                type="button"
                class="close text-2xl font-semibold"
                aria-label="Close"
                style="color: {{ $textColor }};"
        >
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 px-16 gap-x-8 pb-4">
        <div class="pt-8">
            <div class="space-y-4 cursor-pointer">
                <div class="pt-5 px-7">
                    <div class="aspect-w-3 aspect-h-3">
                        <img class="object-cover object-top" src="{{ Storage::disk('board_members')->url($person->image) }}" alt="">
                    </div>
                </div>

                <div class="space-y-2 pb-3"
                     style="color: {{ $textColor }};">
                    <div class="space-y-1 text-xl leading-6 text-center px-1">
                        <h3 class="font-medium">{{ $person->name }}</h3>
                        @if(! empty($person->title))
                            <p class="serif px-4 text-base font-normal">
                                {{ $person->title }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="relative pt-12">
            <div class="md:absolute bg-white text-black p-4 md:h-[580px] overflow-y-scroll text-justify">
                {!! $person->bio !!}
            </div>
        </div>
    </div>
    <div class="bg-secondary">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="py-4">
                <div class="space-y-4 cursor-pointer">
                    @if(! empty($person->supporting_image))
                        <div class="px-16 md:pl-24 md:pr-12">
                            <div class="aspect-w-3 aspect-h-3">
                                <img class="object-cover object-top" src="{{ Storage::disk('board_members')->url($person->supporting_image) }}" alt="">
                            </div>
                        </div>
                    @else
                        <div class="h-56">

                        </div>
                    @endif
                </div>
            </div>
            <div class="">

            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="pt-4">
            <p class="px-12 md:pl-24 md:pr-12 text-justify"
               style="color: {{ $textColor }};">
                {{ $person->supporting_image_description }}
            </p>
        </div>
        <div class="">

        </div>
    </div>
</div>
