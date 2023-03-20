<div>
    <section class="galeria">
        <div class="container">
            <h1 class="tit">Conference Art</h1>
            <div class="contenedorImgs"></div>
        </div>
    </section>

    @push('scripts')
        <script>
            $(function(){
                const strL = 'https://images.unsplash.com/photo-';
                const strR = '?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ';
                const imgs = [
                    {
                        descripcion: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                        titulo: 'Happy',
                        url: strL+'1544568100-847a948585b9'+strR,
                    },
                    {
                        descripcion: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                        titulo: 'Pug Life',
                        url: strL+'1517423440428-a5a00ad493e8'+strR,
                    },
                    {
                        descripcion: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                        titulo: 'I Love Flowers',
                        url: strL+'1510771463146-e89e6e86560e'+strR,
                    },
                    {
                        descripcion: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                        titulo: 'Cute Puppy',
                        url: strL+'1507146426996-ef05306b995a'+strR,
                    },
                    {
                        descripcion: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                        titulo: 'In the beach',
                        url: strL+'1530281700549-e82e7bf110d6'+strR,
                    },
                    {
                        descripcion: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                        titulo: 'Happy Friends',
                        url: strL+'1548199973-03cce0bbc87b'+strR,
                    },
                    {
                        descripcion: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                        titulo: 'A Great Dog',
                        url: strL+'1552053831-71594a27632d'+strR,
                    },
                    {
                        descripcion: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                        titulo: 'Universitary Dog',
                        url: strL+'1535930891776-0c2dfb7fda1a'+strR,
                    },
                    {
                        descripcion: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                        titulo: 'I Love Brother',
                        url: strL+'1504595403659-9088ce801e29'+strR,
                    },
                    {
                        descripcion: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                        titulo: 'I Want a Bone',
                        url: strL+'1518717758536-85ae29035b6d'+strR,
                    },
                ]

                $.each(imgs, function(i, img){
                    $('.galeria .contenedorImgs').append(`
      <div class="imagen" style="background-image:url('${img.url}')">
        <p class="nombre">${img.titulo}</p>
      </div>`
                    );
                })
                setTimeout(() => {
                    $('.galeria').addClass('vis');
                }, 1000)
                $('.galeria').on('click', '.contenedorImgs .imagen', function(){
                    var imagen = imgs[$(this).index()].url;
                    var titulo = imgs[$(this).index()].titulo;
                    var descripcion = imgs[$(this).index()].descripcion;
                    $('.galeria').addClass('scale');
                    $(this).addClass('activa');
                    if(!$('.fullPreview').length){
                        $('body').append(`
        <div class="fullPreview">
          <div class="cerrarModal"></div>
          <div class="wrapper">
            <div class="blur" style="background-image:url(${imagen})"></div>
            <p class="titulo">${titulo}</p>
            <img src="${imagen}">
            <p class="desc">${descripcion}</p>
          </div>
          <div class="controles">
            <div class="control av"></div>
            <div class="control ret"></div>
          </div>
        </div>`
                        )
                        $('.fullPreview').fadeIn().css('display','flex');
                    }
                })
                $('body').on('click', '.fullPreview .cerrarModal', function(){
                    $('.contenedorImgs .imagen.activa').removeClass('activa');
                    $('.galeria').removeClass('scale');
                    $(this).parent().fadeOut(function(){
                        $(this).remove();
                    })
                })
                $('body').on('click', '.fullPreview .control', function(){
                    var activa = $('.contenedorImgs .imagen.activa');
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
                        $('.contenedorImgs .imagen.activa').removeClass('activa');
                        $('.contenedorImgs .imagen').eq(index).addClass('activa');
                        $('.fullPreview').find('.blur').css('background-image', 'url('+imgs[index].url+')');
                        $('.fullPreview').find('img').attr('src', imgs[index].url);
                        $('.fullPreview').find('.titulo').text(imgs[index].titulo);
                        $('.fullPreview').find('.desc').text(imgs[index].descripcion);
                        $('.fullPreview').removeClass('anim');
                    }, 500)
                })
            })
        </script>
    @endpush

    @push('styles')
        <style>
            @import url("https://fonts.googleapis.com/css?family=Rajdhani&display=swap");
            body .galeria{
                margin: 0;
                padding: 0;
            }
            body .galeria * {
                margin: 0;
                padding: 0;
                color: #1c1c1c;
                box-sizing: border-box;
                font-family: "Rajdhani", sans-serif;
            }
            body .galeria * li, body .galeria * ul {
                list-style-type: none;
            }
            body .galeria * a {
                text-decoration: none;
            }

            .galeria {
                width: 100%;
                margin: 0 auto;
                background-color: #1c1c1c;
                overflow: hidden;
            }
            .galeria.vis .container h1, .galeria.vis .container h2 {
                opacity: 1;
                transform: none;
            }
            .galeria.vis .container .h2 {
                transition-delay: 0.2s;
            }
            .galeria.vis .container .contenedorImgs .imagen {
                opacity: 1;
                transform: none;
            }
            .galeria.vis .container .contenedorImgs .imagen:nth-child(1) {
                transition-delay: 0.1s;
            }
            .galeria.vis .container .contenedorImgs .imagen:nth-child(2) {
                transition-delay: 0.2s;
            }
            .galeria.vis .container .contenedorImgs .imagen:nth-child(3) {
                transition-delay: 0.3s;
            }
            .galeria.vis .container .contenedorImgs .imagen:nth-child(4) {
                transition-delay: 0.4s;
            }
            .galeria.vis .container .contenedorImgs .imagen:nth-child(5) {
                transition-delay: 0.5s;
            }
            .galeria.vis .container .contenedorImgs .imagen:nth-child(6) {
                transition-delay: 0.6s;
            }
            .galeria.vis .container .contenedorImgs .imagen:nth-child(7) {
                transition-delay: 0.7s;
            }
            .galeria.vis .container .contenedorImgs .imagen:nth-child(8) {
                transition-delay: 0.8s;
            }
            .galeria.vis .container .contenedorImgs .imagen:nth-child(9) {
                transition-delay: 0.9s;
            }
            .galeria.vis .container .contenedorImgs .imagen:nth-child(10) {
                transition-delay: 1s;
            }
            .galeria.scale .container {
                opacity: 0;
                transform: scale(1.2);
            }
            .galeria .container {
                width: 90%;
                min-height: 100vh;
                margin: 0 auto;
                padding: 50px 0;
                transition: ease all 0.5s;
            }
            .galeria .container h1, .galeria .container h2 {
                opacity: 0;
                color: #fff;
                font-weight: 500;
                text-align: center;
                letter-spacing: 1px;
                text-transform: uppercase;
                transform: translateY(-30px);
                transition: ease all 0.5s;
            }
            .galeria .container h1 {
                font-size: 60px;
            }
            .galeria .container .contenedorImgs {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                align-items: center;
                justify-content: flex-start;
                align-content: center;
                width: 100%;
                margin-top: 30px;
            }
            .galeria .container .contenedorImgs .imagen {
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
            .galeria .container .contenedorImgs .imagen:hover:before {
                opacity: 1;
            }
            .galeria .container .contenedorImgs .imagen:hover .nombre {
                transform: none;
            }
            .galeria .container .contenedorImgs .imagen:before {
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
            .galeria .container .contenedorImgs .imagen .nombre {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                margin: 0 auto;
                width: 90%;
                color: #fff;
                font-size: 30px;
                text-align: center;
                transform: translateY(100%);
                text-shadow: -2px -2px 5px #1c1c1c;
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
            .fullPreview.anim .wrapper .titulo {
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
            .fullPreview .wrapper .titulo {
                position: absolute;
                top: 0;
                left: 0;
                color: transparent;
                font-size: 100px;
                -webkit-text-stroke: 1px #fff;
                z-index: 1;
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



