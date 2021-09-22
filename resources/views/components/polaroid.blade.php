<a href="{{ route($route) }}">
    <div class="p-4 bg-polaroid">
        <div class="w-full h-48 bg-top bg-cover xl:h-96" style="background-image: url({{ asset($image) }})">
        </div>
        <div class="pt-4 font-serif text-base italic font-bold text-center md:text-xl text-secondary">
            {{ $name }}
        </div>
    </div>
</a>
