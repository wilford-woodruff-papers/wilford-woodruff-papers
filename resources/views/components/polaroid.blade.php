<a href="{{ route($route) }}">
    <div class="p-4 bg-polaroid">
        <div class="w-full h-48 md:h-64 md:h-96 bg-cover bg-top" style="background-image: url({{ asset($image) }})">
        </div>
        <div class="text-base md:text-xl font-serif pt-4 text-secondary font-bold italic text-center">
            {{ $name }}
        </div>
    </div>
</a>
