<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex,nofollow">
        <style>
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 100;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-ultralight-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 200;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-thin-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 400;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-regular-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 500;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-medium-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 600;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-semibold-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 700;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-bold-webfont.woff");
        }
        </style>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="flex justify-center items-center min-h-screen">
        <div class="bg-[#0B2836] w-[1200px] h-[630px] text-white p-12 border-[#B4A677] border-[16px] bg-cover bg-center"
            style="background-image: url('{{ asset('img/opengraph.png') }}')"
        >
            <div class="grid grid-cols-2 gap-x-8">
                <div>
                    <img src="{{ asset('img/image-logo.png') }}" alt="Wilford Woodruff Papers Foundation" class="w-full h-auto">
                    @if(! empty(str($title)->replace('_', ' ')->trim()))
                        <h1 class="mt-6 font-bold text-white uppercase text-[32px]">{!! html_entity_decode(str($title)->replace('_', ' ')->trim()) !!}</h1>
                    @endif
                    <div class="inline-block px-6 py-3 @if(! empty(str($title)->replace('_', ' ')->trim())) mt-12 @else mt-20 @endif text-[24px] font-semibold text-[#FFFFFF] bg-[#B4A677]">Read More</div>
                </div>
                <div class="pl-32">
                    <img src="{{ asset('img/wilford-woodruff.png') }}" alt="Wilford Woodruff" class="w-full h-auto">
                </div>
            </div>
        </div>
    </body>
</html>
