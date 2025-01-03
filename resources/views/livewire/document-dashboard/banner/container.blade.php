<x-chromeless-layout>
    <div class="overflow-hidden h-[371px] w-[1232px]">
        <div class="flex h-[371px]">
            <div class="absolute top-0 left-0 z-10 h-[371px]">
                <svg width="759" height="371" viewBox="0 0 759 371" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g filter="url(#filter0_d_0_1)">
                        <path d="M-5 -2H747L554.339 372H-5V-2Z" fill="#792310"/>
                    </g>
                    <g opacity="0.25" filter="url(#filter1_f_0_1)">
                        <path d="M476 414C476 354.516 474.8 279.716 447.562 224.759C420.324 169.803 408.673 109.578 358.344 67.5164C308.014 25.4546 294.736 4.76376 228.977 -17.9999C163.219 -40.7636 5.17645 -38.9666 -66 -38.9666L-66 377.03C-60.1907 377.03 -54.4382 377.986 -49.0711 379.844C-43.704 381.702 -38.8274 384.425 -34.7196 387.858C-30.6118 391.291 -27.3533 395.367 -25.1302 399.852C-22.907 404.337 -21.7628 409.145 -21.7628 414H476Z" fill="url(#paint0_linear_0_1)"/>
                    </g>
                    <defs>
                        <filter id="filter0_d_0_1" x="-5" y="-8" width="764" height="386" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                            <feOffset dx="6"/>
                            <feGaussianBlur stdDeviation="3"/>
                            <feComposite in2="hardAlpha" operator="out"/>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_0_1"/>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_0_1" result="shape"/>
                        </filter>
                        <filter id="filter1_f_0_1" x="-266" y="-239" width="942" height="853" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                            <feGaussianBlur stdDeviation="100" result="effect1_foregroundBlur_0_1"/>
                        </filter>
                        <linearGradient id="paint0_linear_0_1" x1="114.667" y1="279.897" x2="669.829" y2="-86.8808" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#769DB0"/>
                            <stop offset="1" stop-color="#769DB0" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                </svg>

            </div>
            <div class="max-w-[680px] flex-0">
                <div class="flex relative z-10 flex-col justify-between pt-8 pb-8 pl-12 h-full pr-18">
                    <div class="flex flex-col gap-y-4 h-full">
                        <h2
                            @php
                                $length = str($item->name)->stripBracketedID()->length()
                            @endphp
                            @class([
                                'pb-2  font-light text-white uppercase leading-[1.2em] line-clamp-3',
                                'text-4xl' => $length <= 45,
                                'text-3xl' => $length > 45 && $length <= 70,
                                'text-2xl' => $length > 70,
                            ])
                        >
                            {!! str($item->name)->stripBracketedID() !!}
                        </h2>
                        <hr class="border-b border-white max-w-[550px]"/>
                        <p class="pt-8 pr-24 text-xl text-white">
                            Explore the document through the featured content below or read the individual pages.
                        </p>
                    </div>
                    <div class="mb-6 text-2xl text-secondary">
                        <div class="inline-block py-2 px-12 uppercase bg-white border border-secondary">
                            Click to Read
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 z-1">
                {!! $section !!}
            </div>
        </div>
    </div>
</x-chromeless-layout>
