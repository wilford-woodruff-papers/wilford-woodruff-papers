
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url("https://use.typekit.net/gey1gtp.css");
        * {
            margin: 0;
            padding: 0;
        }
        html {
            overflow: hidden !important;
        }
        body {
            background-color: #1C1C1C;
            overflow-x: hidden !important;
            height: 100vh;
        }
        .page-cover {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #1C1C1C;
            color: #fff;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
            z-index: 100;
        }
        .page-cover.mobile {
            display: none;
        }
        @media only screen and (max-width: 700px) {
            .page-cover.mobile {
                display: flex !important;
            }
        }.page-cover .cover-title {
             font-family: "Proxima-nova", sans-serif;
             text-transform: uppercase;
             font-size: 2em;
         }
        .nav-container {
            display: flex;
            justify-content: stretch;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 0 4vw;
            margin-top: 6vh;
            box-sizing: border-box;
            background-color: transparent;
            z-index: 20;
        }
        .nav-container .align {
            flex-grow: 1;
        }
        .nav-container .align.left .logo {
            height: 3em;
        }
        .nav-container .align.right {
            text-align: right;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .nav-container .align.right ul {
            list-style-type: none;
        }
        .nav-container .align.right ul li {
            display: inline-block;
            margin-left: 2em;
        }
        #landing.section {
            width: 100vw;
            height: 100vh;
            position: relative;
        }
        #landing.section .back-image {
            position: absolute;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            z-index: -1;
        }
        #landing.section .back-image img {

        }
        #landing.section .align-wrapper {
            width: 100%;
            text-align: center;
        }
        #landing.section .align-wrapper .content {
            width: 60%;
            margin: 0 auto;
            text-align: center;
        }
        #landing.section .align-wrapper .content * {
            margin-bottom: 5vh;
        }
        #content.section {
            position: relative;
            width: 100vw;
            padding: 0 10vw;
            margin-top: 15vh;
            box-sizing: border-box;
        }
        #content.section .back-image-slide {
            position: absolute;
            text-align: center;
            left: -20vw;
            right: -20vw;
            top: -10vh;
            z-index: -1;
        }
        #content.section .back-image-slide .stack {
            display: inline-block;
        }
        #content.section .back-image-slide .stack.offset {
            position: relative;
            top: 10vh;
            opacity: 0.4;
        }
        #content.section .back-image-slide .stack:not(:last-child) {
            margin-right: 5vh;
        }
        #content.section .back-image-slide img {
            display: block;
            height: 40vh;
            width: 35vw;
            object-fit: cover;
            opacity: 0.3;
            border-radius: 30px;
            margin-bottom: 8vh;
        }
        #content.section .aligner {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        #content.section .aligner .right, #content.section .aligner .left {
            display: block;
            margin-bottom: 15vh;
        }
        #content.section .aligner .right .button, #content.section .aligner .left .button {
            margin-top: 5vh;
        }
        #content.section .aligner .right .heart, #content.section .aligner .left .heart {
            position: relative;
            top: 50%;
            left: 0.2em;
            fill: #FF5722;
            transform: translateY(30%);
            width: 1.7em;
        }
        #content.section .aligner .right {
            align-self: flex-end;
            text-align: right;
        }
        .button {
            display: inline-block;
            font-size: 1em;
            letter-spacing: 0.07em;
            font-family: "Proxima-nova", sans-serif;
            text-transform: uppercase;
            font-weight: 800;
            padding: 0.8em 2em;
            box-sizing: border-box;
            text-decoration: none;
            color: #1C1C1C;
            cursor: pointer;
            border-radius: 60px;
            background-color: #77FF65;
            transition: transform 0.3s cubic-bezier(0.68,  -0.6,  0.32,  1.6);
        }
        .button:hover {
            transform: scale(1.08);
        }
        .sublink, .subtext {
            position: relative;
            font-size: 1em;
            letter-spacing: 0.07em;
            font-family: "Proxima-nova", sans-serif;
            text-transform: uppercase;
            text-decoration: none;
            font-weight: 800;
            color: #fff;
        }
        .sublink {
            cursor: pointer;
        }
        .sublink::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #fff;
            transform: scaleX(0);
            transition: all 0.4s cubic-bezier(0.68,  -0.6,  0.32,  1.6);
            -webkit-transform: scaleX(0);
            -webkit-transition: all 0.4s cubic-bezier(0.68,  -0.6,  0.32,  1.6);
        }
        .sublink:hover::before {
            transform: scaleX(1);
        }
        .sublink span {
            color: #84f397;
        }
        .title {
            font-size: 4em;
            letter-spacing: 0.03em;
            color: #fff;
            font-family: "Proxima-nova", sans-serif;
            text-transform: uppercase;
            font-weight: 800;
        }
        .title span {
            color: #84f397;
        }
        h2, h3 {
            font-size: 3.8em;
            letter-spacing: 0.03em;
            color: #fff;
            font-family: "Proxima-nova", sans-serif;
            text-transform: uppercase;
            font-weight: 800;
        }
        h2 span, h3 span {
            color: #77FF65;
        }
        h3 {
            font-weight: 200;
            font-size: 3.5em;
        }
        h3 span {
            font-weight: 800;
        }
    </style>
    <title>SlickScroll - Momentum Scrolling JS library</title>

    <link rel="canonical" href="https://slickscroll.musabhassan.com" />
    <meta name="description" content="SlickScroll is a JavaScript library that makes momentum scrolling quick and painless.">

    <script src="https://slickscroll.musabhassan.com/slickscroll.min.js" type="text/javascript"></script>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <!-- Slickscroll -->
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', () => {
            new slickScroll.default({
                root: document.body,
                duration: 400,
                easing: "easeOutQuart",
                offsets: [
                    {element: ".slow-parallax", speedY: 0.8},
                    {element: ".faster-parallax", speedY: 0.7},
                    {element: ".nav", speedY: 1}
                ]
            });
        }, false);
    </script>
</head>
<body>

    <x-header />

    {{ $slot }}

    <x-footer />

</body>
</html>
