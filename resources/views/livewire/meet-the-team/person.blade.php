<div class="pb-4 person-modal" style="height: auto; background-color: {{ $backgroundColor }};">
    <div class="absolute top-2 right-4">
        <button wire:click="$dispatch('closeModal')"
                type="button"
                class="text-2xl font-semibold close"
                aria-label="Close"
                style="color: {{ $textColor }};"
        >
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="grid grid-cols-1 gap-x-8 px-16 pb-4 md:grid-cols-2">
        <div class="pt-8">
            <div class="space-y-4 cursor-pointer">
                <div class="px-7 pt-5">
                    <div class="aspect-w-3 aspect-h-4">
                        <img class="object-cover object-top" src="{{ Storage::disk('board_members')->url($person->image) }}" alt="">
                    </div>
                </div>

                <div class="pb-3 space-y-2"
                     style="color: {{ $textColor }};">
                    <div class="px-1 space-y-1 text-xl leading-6 text-center">
                        <h3 class="font-medium">{{ $person->name }}</h3>
                        @if(! empty($person->title))
                            <p class="px-4 text-base font-normal serif">
                                {{ $person->title }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="relative pt-14">
            <div class="overflow-y-scroll p-4 text-justify text-black bg-white md:absolute md:h-[680px]">
                {!! $person->bio !!}
            </div>
        </div>
    </div>
    <div class="bg-secondary h-[272px]">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="py-4">
                <div class="space-y-4 cursor-pointer">
                    @if(! empty($person->supporting_image))
                        <div class="px-16 md:pr-12 md:pl-24">
                            <div class="aspect-w-3 aspect-h-3">
                                <img class="w-auto h-full md:object-cover md:object-top" src="{{ Storage::disk('board_members')->url($person->supporting_image) }}" alt="">
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
    <div class="grid grid-cols-1 gap-x-12 px-16 mt-4 md:grid-cols-2 md:pr-12 md:pl-24">
        <div class="flex justify-center items-start pt-4 md:pr-12">
            @if(! empty($person->supporting_person_link))
                <a href="{{ $person->supporting_person_link }}"
                   target="_blank"
                   class="text-2xl underline text-secondary"
                >
                    {{ $person->supporting_person_name }}
                </a>
            @endif
        </div>
        <div class="pt-4 md:pr-20 md:pl-4">
            @if(! empty($person->supporting_image_description))
                <p class="text-justify"
                   style="color: {{ $textColor }};">
                    {{ $person->supporting_image_description }}
                </p>
            @endif

        </div>
    </div>
</div>
