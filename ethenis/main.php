<!DOCTYPE html>

<html>
    <head>
           
        <!-- Meta -->
		<meta charset="UTF-8">
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
            body {
                padding-bottom: 100px;
                min-width: 550px;
            }
            section, .paper {
		        width: 500px;
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
            pre {
                font-size: 16px;
            }
        </style>
    </head>
    <body>
        <header class="with-shadow"></header>
        <nav>
            <{ link-template }><span class="nav-link-content"><{ dir-name }></span><{ /link-template }>
        </nav>
        <{ content }>
        <hr>
        <section class="selectable">
            <h1>PHP Test</h1>
            <pre>PHP Version: <?php echo phpversion() ?></pre>
            <h5>Ethenis config</h5>
            <pre><?php print_r(Ethenis::get_config()) ?></pre>
        </section>
    </body>
</html>
