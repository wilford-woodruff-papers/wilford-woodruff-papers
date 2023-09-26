@if(! empty($image))
    <div class="bg-top bg-cover bg-[whitesmoke] bg-blend-multiply" style="background-image: url({{ $image }})">
        <div class="py-4 mx-auto max-w-7xl xl:py-12">
            <h1 class="px-12 text-3xl md:text-4xl xl:text-6xl drop-shadow-m text-secondary">
                {{ $text }}
            </h1>
        </div>
    </div>
@endif
