<div class="w-full h-full bg-center bg-cover scale-150 min-h-[630]"
    style="background-image: url('{{ app()->environment('production') ? $item->firstPageWithText?->getfirstMediaUrl() : 'https://wilford-woodruff-papers.nyc3.digitaloceanspaces.com/media-library/445909/default.jpg' }}');"
>
    <div class="absolute inset-0 bg-[#F2F2F2] opacity-20 mix-blend-screen"></div>
</div>
