<!DOCTYPE html>

<html>
    <head>
           
        <!-- Meta -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
        <meta name="description" content="Ethenis is a PHP and JavaScript framework developed with the aim of speeding up the creation of web applications with dynamically loaded content.">
        
        <!-- Title -->
        <title>Ethenis Framework</title>		
        <meta name="apple-mobile-web-app-title" content="Ethenis">
        
        <!-- Theme Colors -->
        <meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="theme-color" content="#5f4da7">
		<meta name="msapplication-navbutton-color" content="#5f4da7">
		<meta name="apple-mobile-web-app-status-bar-style" content="#5f4da7">
        
        <!-- Icons -->
        <link rel="shortcut icon" href="/img/favicon.png">
        <link rel="icon" type="image/png" href="/img/favicon.png">
        <link rel="apple-touch-icon-precomposed" href="/img/favicon.png">
        
        <!-- Flat-Remix.css -->
        <link rel="stylesheet" type="text/css" href="/css/flat-remix.css">

		
		<script>
			function headerAnimation() {
				scroll = window.scrollY;
				document.getElementsByTagName('header')[0].style.height = 250 - scroll*0.5 + "px";
			}
			window.onload = function() {
				headerAnimation();
				window.addEventListener( 'scroll', headerAnimation );
			}
		</script>
        <style>
            nav a.__eth-link:hover { text-decoration: none; } 
            nav a.__eth-selected-link {
                border-bottom: 4px solid white;
            }
            a.blue-button-link {
				color: white;
				line-height: 50px;
				border-radius: 2px;
				background: blue;
				width: 236px;
				text-align: center;
				margin: 30px auto;
				text-shadow: 0 0 1px white;
				color: white;
				display: block;
			}
            body { padding-bottom: 100px; }
            section, .paper {
		        max-width: 500px;
                width: 95%;
		        margin: 40px auto;
	        }
            header {
                position: absolute;
                height: 250px;
                width: 100%;
                background: linear-gradient(203deg, rgba(124,69,152,1) 17%, rgb(34, 0, 221) 100%);
                top: 0;
                z-index: -1;
                will-change: height;
            }
            nav {
                position: relative;
                left: 50%;
                display: inline-block;
                transform: translate(-50%, 0);
                margin-top: 50px;
            }
            nav a { color: white!important}
            .nav-link-content {
                font-size: 20px;
                margin: 0 20px;
            }
            #loading {
                display: none;
                height: 50px;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            body.loading #loading {
                display: block;
            }
            @-webkit-keyframes cargando {
                0%, 40%, 100% {
                    -webkit-transform: scaleY(0.05);
                }
                20% {
                    -webkit-transform: scaleY(1);
                }
            }
            @keyframes cargando {
                0%, 40%, 100% {
                    transform: scaleY(0.05);
                    -webkit-transform: scaleY(0.05);
                }
                20% {
                    transform: scaleY(1);
                    -webkit-transform: scaleY(1);
                }
            }
            #loading div {
                box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);
                height: 100%;
                width: 8px;
                display: inline-block;
                margin-left: 2px;
                -webkit-animation: cargando .8s infinite ease-in-out;
                animation: cargando .8s infinite ease-in-out;
            }
            #loading div:nth-child(1) {
                background: #0000ff;
                -webkit-animation-delay: -.5s;
                animation-delay: -.5s;
            }
            #loading div:nth-child(2) {
                background: #3873d7;
                -webkit-animation-delay: -.4s;
                animation-delay: -.4s;
            }
            #loading div:nth-child(3) {
                background: #269687;
                -webkit-animation-delay: -.3s;
                animation-delay: -.3s;
            }
            #loading div:nth-child(4) {
                background: #ba174e;
                -webkit-animation-delay: -.2s;
                animation-delay: -.2s;
            }
            #loading div:nth-child(5) {
                background: #9f2b32;
                -webkit-animation-delay: -.1s;
                animation-delay: -.1s;
            }
            #loading div:nth-child(6) {
                background: #7c4598;
            }
            @media screen and (max-width: 450px) {
                .nav-link-content {
					font-size: 18px;
    				margin: 0 5px;
                }
            }
        </style>
    </head>
    <body>
        <header class="with-shadow"></header>
        <nav>
            <{ link-template }><span class="nav-link-content"><{ link-text }></span><{ /link-template }>
        </nav>
        <{ content }>
        <div id="loading"><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </body>
</html>
