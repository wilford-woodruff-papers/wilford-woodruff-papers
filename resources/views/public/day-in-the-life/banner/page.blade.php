<div class="w-full h-full bg-center bg-cover scale-150"
    style="background-image: url('{{ app()->environment('production') ? $day->first()->getfirstMediaUrl(conversionName: 'web') : 'https://wilford-woodruff-papers.nyc3.digitaloceanspaces.com/media-library/233014/conversions/default-web.jpg' }}');"
>
    <div class="absolute inset-0 bg-[#F2F2F2] opacity-20 mix-blend-screen"></div>
</div>
