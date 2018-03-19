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
            @keyframes loading-element {
                0% {
                    width: 0;
                }
                5% {
                    transform: none;
                    width: 20%;
                }
                10% {
                    transform: translateX(20vw);
                    width: 4px;
                }
                35% {
                    transform: translateX(80vw);
                    width: 4px;
                }
                40% {
                    width: 30%;
                    transform: translateX(80vw);
                }
                45% {
                    transform: translateX(110vw);
                }
                46% {
                    visibility: hidden;
                }
                100% {
                    visibility: hidden;
                }
            }

            body.loading #loading-animation div {
                display: block;
            }

            #loading-animation div {
                left: 0;
                top: 4px;
                display: none;
                position: fixed;
                z-index: 1000;
                height: 4px;
                border-radius: 4px;
                background: #1875D1;
                box-shadow: 0 1px 0 #08005c;
                animation: loading-element 5s infinite;
            }

            #loading-animation div:nth-child(2) {
                margin-left: -8px;
                animation-delay: .25s;
            }

            #loading-animation div:nth-child(3) {
                margin-left: -16px;
                animation-delay: .5s;
            }
            #loading-animation div:nth-child(4) {
                margin-left: -24px;
                animation-delay: .75s;
            }
            #loading-animation div:nth-child(5) {
                margin-left: -32px;
                animation-delay: 1s;
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
        <div id="loading-animation">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </body>
</html>
