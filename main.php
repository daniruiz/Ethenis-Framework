<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name=viewport content="width=550, maximum-scale=1">
        <title>Ethenis Framework</title>
        <link rel="icon" href="/img/favicon.png">
        <link rel="stylesheet" type="text/css" href="/css/flat-remix.css">
        <style>
            a.__eth-link:hover { text-decoration: none; } 
            a.__eth-selected-link {
                border-bottom: 4px solid white;
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
                background: linear-gradient(203deg, rgba(124,69,152,1) 0%, rgba(124,69,152,1) 0%, rgba(124,69,152,1) 0%, rgba(124,69,152,1) 0%, rgba(124,69,152,1) 0%, rgba(124,69,152,1) 0%, rgba(124,69,152,1) 17%, rgba(36,93,197,1) 100%);
                top: 0;
                z-index: -1;
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
<script>
    window.addEventListener('scroll', function() {
		scroll = window.scrollY;
		document.getElementsByTagName('header')[0].style.height = 250 - scroll*0.5 + "px";
	});
</script>
