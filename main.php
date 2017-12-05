<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui" name="viewport">
        <title>Ethenis Framework</title>
        <link rel="stylesheet" type="text/css" href="/css/flat-remix.css">
        <style>
            body {
                padding-bottom: 100px;
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
            <pre><?php echo "Today is " . date("Y/m/d") . "<br>"; ?></pre>
            <pre>PHP Version: <?php echo phpversion() ?></pre>
            <h5>Ethenis config</h5>
            <pre><?php print_r(Ethenis::$config) ?></pre>
        </section>
    </body>
</html>
<script>
    window.addEventListener('scroll', function() {
		scroll = window.scrollY;
		document.getElementsByTagName('header')[0].style.height = 250 - scroll*0.5 + "px";
	});
</script>
