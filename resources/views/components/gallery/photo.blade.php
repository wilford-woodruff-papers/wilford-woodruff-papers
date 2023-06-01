<div>
    <section class="gallery">
        <div class="container">
            {{--<h2 class="py-8 mb-12 text-4xl font-black text-center text-white md:text-5xl">Conference Art</h2>--}}
            <div class="!px-3 pt-6">
                <a href="https://airauctioneer.com/wilford-woodruff-project-art-auction"
                   target="_blank"
                >
                    <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/conference-artwork-banner.png"
                         class="w-full h-auto"
                         alt="">
                </a>
            </div>
            <div class="contenedorImgs"></div>
        </div>
    </section>

    @push('scripts')
        <script>
            $(function(){
                const imgs = [
                    {
                        type: 'image',
                        description: '',
                        title: 'I did not feel the cold - Wilford Woodruff\'s Baptism',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art/wilford-woodruffs-baptism.jpg',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art/wilford-woodruffs-baptism-thumb.jpg',
                    },
                    {
                        type: 'image',
                        description: '',
                        title: 'Language of Inspiration',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art/language-of-inspiration.jpg',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art/language-of-inspiration-thumb.jpg',
                    },
                    {
                        type: 'image',
                        description: '',
                        title: 'The Dawning of a Brighter Day',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art/the-dawning-of-a-brighter-day.png',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art/the-dawning-of-a-brighter-day-thumb.jpg',
                    },
                    {
                        type: 'image',
                        description: '',
                        title: 'Into',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Finto.jpg',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Finto-thumb.jpg',
                    },
                    {
                        type: 'image',
                        description: '',
                        title: 'I Went Forward in Baptism',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2FI-went-forward-in-baptism.jpg',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2FI-went-forward-in-baptism-thumb.jpg',
                    },
                    {
                        type: 'image',
                        description: '',
                        title: 'Nauvoo Painting',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fnauvoo-painting.jpg',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fnauvoo-painting-thumb.jpg',
                    },
                    {
                        type: 'image',
                        description: '',
                        title: 'Ledbury Baptist Church',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fledbury-baptist-church.jpg',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fledbury-baptist-church-thumb.jpg',
                    },
                    {
                        type: 'image',
                        description: '',
                        title: 'Walking In Faith',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fwalking-in-faith.jpg',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fwalking-in-faith-thumb.jpg',
                    },
                    {
                        type: 'image',
                        description: '',
                        title: 'Wilford Picture of Faith',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fwilford-picture-of-faith.jpg',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fwilford-picture-of-faith-thumb.jpg',
                    },
                    {
                        type: 'image',
                        description: '',
                        title: 'Seek Ye This Jesus',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fseek-ye-this-jesus.jpg',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fseek-ye-this-jesus-thumb.jpg',
                    },
                    {
                        type: 'video',
                        description: '',
                        title: 'God Moves in a Mysterious Way',
                        url: 'k0wmUOntCqM',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art/god-moves-in-mysterious-ways.jpg',
                    },
                    {
                        type: 'video',
                        description: '',
                        title: 'Sur Ma Croix',
                        url: 'SUoubv_nRn8',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art/sur-ma-croix.jpg',
                    },
                    {
                        type: 'pdf',
                        description: '',
                        title: 'The Ballad of 1841',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2FThe-Ballad-of-1841.pdf',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fthe-ballad-of-1841-thumb.jpg',
                    },
                    {
                        type: 'pdf',
                        description: '',
                        title: 'The Pile of Mysterious Shoes',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2FThe-Pile-of-Mysterious-Shoes.pdf',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fthe-pile-of-mysterious-shoes-thumb.jpg',
                    },
                    {
                        type: 'pdf',
                        description: '',
                        title: 'The Book of Wilford in Verse',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2FErin-Hills_The-Book-of-Wilford-in-Verse.pdf',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fthe-book-of-wilford-in-verse-thmb.jpg',
                    },
                    {
                        type: 'pdf',
                        description: '',
                        title: 'His Healing Touch',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2FHis-Healing-Touch.pdf',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fhis-healing-touch-thumb.jpg',
                    },
                    {
                        type: 'pdf',
                        description: '',
                        title: 'Prayer After Study',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2FPrayer-After-Study.pdf',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Fprayer-after-study-thumb.jpg',
                    },
                    {
                        type: 'pdf',
                        description: '',
                        title: 'Eternity',
                        url: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2FEternity.pdf',
                        thumburl: 'https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/2023-conference-art%2Feternity-thumb.jpg',
                    },
                ]

                $.each(imgs, function(i, img){
                    $('.gallery .contenedorImgs').append(`
      <div class="image" style="background-image:url('${img.thumburl}')">
        <p class="name">${img.title}</p>
      </div>`
                    );
                })
                setTimeout(() => {
                    $('.gallery').addClass('vis');
                }, 1000)
                $('.gallery').on('click', '.contenedorImgs .image', function(){
                    var type = imgs[$(this).index()].type;
                    var url = imgs[$(this).index()].url;
                    var thumbnail = imgs[$(this).index()].thumburl;
                    var title = imgs[$(this).index()].title;
                    var description = imgs[$(this).index()].description;
                    $('.gallery').addClass('scale');
                    $(this).addClass('activa');
                    if(!$('.fullPreview').length){
                                $('body').append(`
                                    <div class="fullPreview">
                                      <div class="cerrarModal"></div>
                                      <div class="wrapper">
                                        <div class="blur" style="background-image:url(${thumbnail})"></div>
                                        <p class="title">${title}</p>
                                        <div class="viewer">
                                            <img src="${url}"
                                                 class="full-image"/>
                                            <iframe
                                                src="${url}"
                                                class="hidden z-50 w-full border-0 iframe h-[900px]"
                                            ></iframe>
                                            <iframe
                                                src="https://www.youtube.com/embed/${url}?rel=0"
                                                class="hidden z-50 w-full border-0 video h-[900px] aspect-[16/9]"
                                            ></iframe>
                                        </div>
                                        <p class="desc">${description}</p>
                                      </div>
                                      <div class="controles">
                                        <div class="control av"></div>
                                        <div class="control ret"></div>
                                      </div>
                                    </div>`
                                )

                        $('.fullPreview').fadeIn().css('display','flex');
                        switch(type){
                            case 'image':
                                $('.full-image').fadeIn().css('display','block');
                                $('.iframe').fadeOut().css('display','none');
                                $('.video').fadeIn().css('display','none');
                                break;
                            case 'pdf':
                                $('.full-image').fadeOut().css('display','none');
                                $('.iframe').fadeIn().css('display','block');
                                $('.video').fadeIn().css('display','none');
                                break;
                            case 'video':
                                $('.full-image').fadeOut().css('display','none');
                                $('.iframe').fadeIn().css('display','none');
                                $('.video').fadeIn().css('display','block');
                                break;
                        }
                    }
                })
                $('body').on('click', '.fullPreview .cerrarModal', function(){
                    $('.contenedorImgs .image.activa').removeClass('activa');
                    $('.gallery').removeClass('scale');
                    $(this).parent().fadeOut(function(){
                        $(this).remove();
                    })
                })
                $('body').on('click', '.fullPreview .control', function(){
                    var activa = $('.contenedorImgs .image.activa');
                    var index;
                    if($(this).hasClass('av')){
                        index = activa.next().index();
                        if(index < 0) index = 0;
                    }else{
                        index = activa.prev().index();
                        if(index < 0) index = imgs.length - 1;
                    }
                    $('.fullPreview').addClass('anim');
                    setTimeout(()=>{
                        $('.contenedorImgs .image.activa').removeClass('activa');
                        $('.contenedorImgs .image').eq(index).addClass('activa');
                        $('.fullPreview').find('.blur').css('background-image', 'url('+imgs[index].thumburl+')');
                        $('.fullPreview').find('.title').text(imgs[index].title);
                        $('.fullPreview').find('.desc').text(imgs[index].description);
                        $('.fullPreview').removeClass('anim');
                        var type = imgs[index].type;
                        switch(type){
                            case 'image':
                                $('.fullPreview').find('img').attr('src', imgs[index].url);
                                $('.full-image').fadeIn().css('display','block');
                                $('.iframe').fadeOut().css('display','none');
                                $('.video').fadeIn().css('display','none');
                                break;
                            case 'pdf':
                                $('.fullPreview').find('.iframe').attr('src', imgs[index].url);
                                $('.full-image').fadeOut().css('display','none');
                                $('.iframe').fadeIn().css('display','block');
                                $('.video').fadeIn().css('display','none');
                                break;
                            case 'video':
                                $('.fullPreview').find('.video').attr('src', 'https://www.youtube.com/embed/'+imgs[index].url+'?rel=0');
                                $('.full-image').fadeOut().css('display','none');
                                $('.iframe').fadeIn().css('display','none');
                                $('.video').fadeIn().css('display','block');
                                break;
                        }
                    }, 500)
                })
            })
        </script>
    @endpush

    @push('styles')
        <style>
            {{--@import url("https://fonts.googleapis.com/css?family=Rajdhani&display=swap");--}}
            body .gallery{
                margin: 0;
                padding: 0;
            }
            body .gallery * {
                margin: 0;
                padding: 0;
                color: #1c1c1c;
                box-sizing: border-box;
                font-family: 'Source Sans Pro', 'sans-serif';
            }
            body .gallery * li, body .gallery * ul {
                list-style-type: none;
            }
            body .gallery * a {
                text-decoration: none;
            }

            .gallery {
                width: 100%;
                margin: 0 auto;
                background-color: #792310;
                overflow: hidden;
            }
            .gallery.vis .container h1, .gallery.vis .container h2 {
                opacity: 1;
                transform: none;
            }
            .gallery.vis .container .h2 {
                transition-delay: 0.2s;
            }
            .gallery.vis .container .contenedorImgs .image {
                opacity: 1;
                transform: none;
            }
            .gallery.vis .container .contenedorImgs .image:nth-child(1) {
                transition-delay: 0.1s;
            }
            .gallery.vis .container .contenedorImgs .image:nth-child(2) {
                transition-delay: 0.2s;
            }
            .gallery.vis .container .contenedorImgs .image:nth-child(3) {
                transition-delay: 0.3s;
            }
            .gallery.vis .container .contenedorImgs .image:nth-child(4) {
                transition-delay: 0.4s;
            }
            .gallery.vis .container .contenedorImgs .image:nth-child(5) {
                transition-delay: 0.5s;
            }
            .gallery.vis .container .contenedorImgs .image:nth-child(6) {
                transition-delay: 0.6s;
            }
            .gallery.vis .container .contenedorImgs .image:nth-child(7) {
                transition-delay: 0.7s;
            }
            .gallery.vis .container .contenedorImgs .image:nth-child(8) {
                transition-delay: 0.8s;
            }
            .gallery.vis .container .contenedorImgs .image:nth-child(9) {
                transition-delay: 0.9s;
            }
            .gallery.vis .container .contenedorImgs .image:nth-child(10) {
                transition-delay: 1s;
            }
            .gallery.scale .container {
                opacity: 0;
                transform: scale(1.2);
            }
            .gallery .container {
                width: 90%;
                /*min-height: 100vh;*/
                margin: 0 auto;
                padding: 50px 0;
                transition: ease all 0.5s;
            }
            .gallery .container h1, .gallery .container h2 {
                opacity: 0;
                color: #fff;
                /*font-weight: 500;*/
                text-align: center;
                letter-spacing: 1px;
                /*text-transform: uppercase;*/
                transform: translateY(-30px);
                transition: ease all 0.5s;
            }
            .gallery .container h1 {
                font-size: 60px;
            }
            .gallery .container .contenedorImgs {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                align-items: center;
                justify-content: flex-start;
                align-content: center;
                width: 100%;
                margin-top: 30px;
            }
            .gallery .container .contenedorImgs .image {
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                width: calc((100% / 3) - 20px);
                height: 250px;
                margin: 10px;
                opacity: 0;
                transform: translateX(-50px);
                position: relative;
                overflow: hidden;
                cursor: pointer;
                transition: ease all 0.5s;
            }
            .gallery .container .contenedorImgs .image:hover:before {
                opacity: 1;
            }
            .gallery .container .contenedorImgs .image:hover .name {
                transform: none;
            }
            .gallery .container .contenedorImgs .image:before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
                background: linear-gradient(transparent, #fff);
                transition: ease all 0.5s;
            }
            .gallery .container .contenedorImgs .image .name {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                margin: 0 auto;
                width: 90%;
                color: #000;
                font-size: 30px;
                text-align: center;
                transform: translateY(100%);
                /*text-shadow: -2px -2px 5px #1c1c1c;*/
                transition: cubic-bezier(0.68, -0.55, 0.27, 1.55) all 0.5s;
            }

            .fullPreview {
                display: flex;
                flex-direction: column;
                flex-wrap: nowrap;
                align-items: center;
                justify-content: center;
                align-content: center;
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(28, 28, 28, 0.9);
                z-index: 100;
            }
            .fullPreview.anim .wrapper .title {
                opacity: 0;
                transform: translateX(-100px);
                transition-delay: 0s;
            }
            .fullPreview.anim .wrapper img {
                opacity: 0;
                transform: translateX(100px);
            }
            .fullPreview.anim .wrapper .desc {
                opacity: 0;
                transform: translateY(100px);
                transition-delay: 0s;
            }
            .fullPreview .cerrarModal {
                display: flex;
                flex-direction: column;
                flex-wrap: nowrap;
                align-items: center;
                justify-content: center;
                align-content: center;
                position: absolute;
                top: 30px;
                right: 30px;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background-color: #fff;
                cursor: pointer;
                z-index: 10;
                transition: ease all 0.3s;
            }
            .fullPreview .cerrarModal:hover {
                transform: rotate(90deg);
            }
            .fullPreview .cerrarModal:before, .fullPreview .cerrarModal:after {
                content: "";
                position: absolute;
                width: 50%;
                height: 2px;
                background-color: #1c1c1c;
            }
            .fullPreview .cerrarModal:before {
                transform: rotate(45deg);
            }
            .fullPreview .cerrarModal:after {
                transform: rotate(-45deg);
            }
            .fullPreview .wrapper .viewer {
                padding-top: 50px;
                display: flex;
                flex-direction: column;
                flex-wrap: nowrap;
                align-items: center;
                justify-content: center;
                align-content: center;
                width: 90%;
                height: 90%;
                position: relative;
            }
            .fullPreview .wrapper {
                display: flex;
                flex-direction: column;
                flex-wrap: nowrap;
                align-items: center;
                justify-content: center;
                align-content: center;
                width: 90%;
                height: 90%;
                position: relative;
            }
            .fullPreview .wrapper .blur {
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                filter: blur(40px);
                transition: ease all 0.5s;
            }
            .fullPreview .wrapper .title {
                position: absolute;
                top: 0;
                left: 0;
                color: black;
                font-size: 60px;
                /*-webkit-text-stroke: 1px #fff;*/
                z-index: 60;
                transition: cubic-bezier(0.68, -0.55, 0.27, 1.55) all 0.5s 0.3s;
            }
            .fullPreview .wrapper img {
                max-width: 90%;
                max-height: 80%;
                position: relative;
                transition: cubic-bezier(0.68, -0.55, 0.27, 1.55) all 0.5s;
            }
            .fullPreview .wrapper .desc {
                width: 100%;
                max-width: 600px;
                padding: 10px 0;
                color: #fff;
                text-align: center;
                position: relative;
                transition: cubic-bezier(0.68, -0.55, 0.27, 1.55) all 0.5s 0.5s;
            }
            .fullPreview .controles {
                position: absolute;
                bottom: 30px;
                right: 30px;
            }
            .fullPreview .controles .control {
                display: flex;
                flex-direction: column;
                flex-wrap: nowrap;
                align-items: center;
                justify-content: center;
                align-content: center;
                width: 50px;
                height: 30px;
                position: relative;
                cursor: pointer;
                transition: cubic-bezier(0.68, -0.55, 0.27, 1.55) all 0.5s;
            }
            .fullPreview .controles .control:hover {
                width: 70px;
            }
            .fullPreview .controles .control.av {
                margin-left: auto;
            }
            .fullPreview .controles .control.ret {
                margin: 10px 30px 0 0;
                transform: rotate(180deg);
            }
            .fullPreview .controles .control:before, .fullPreview .controles .control:after {
                content: "";
                position: absolute;
            }
            .fullPreview .controles .control:before {
                left: 0;
                width: 80%;
                height: 2px;
                background-color: #fff;
            }
            .fullPreview .controles .control:after {
                right: 0;
                width: 10px;
                height: 10px;
                border: 2px solid #fff;
                border-bottom: 0;
                border-left: 0;
                transform: rotate(45deg);
            }
        </style>
    @endpush
</div>



