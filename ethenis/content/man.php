<?php $path = Ethenis::get_path(); ?>
<style>
	.blue-color { color: #3873d7; }
	.green-color { color: #269687; }
	.red-color { color: #9f2b32 }
	.black-color { color: #000 }
	pre, code {
	    font-size: 12px;
	    line-height: 25px;
		text-shadow: 0.5px 0.5px 0, -0.5px -0.5px 0;
	}
	hr { margin: 30px auto; }
	li {
		border-left: 5px solid #EEE;
		padding-left: 5px;
		margin-bottom: 10px;
	}
	@media screen and (max-width: 420px) {
		code, pre {
			word-spacing: -6px;
		}
		ul { padding-left: 10px; }
    }
</style>

<section id="content" class="paper selectable">
<h1>Manual</h1>
<?php if ( $path == 'man/1' ) { ?>
    <h3>Installation</h3>
	<script>document.title = "Installation"</script>
		Download Ethenis Framework, extract the package and copy all the files into the webpage main folder. After that you should have the following folder layout in it.
		<pre>
    --> |
        |--> <span class="blue-color">content</span>
        |--> <span class="blue-color">js</span>
        |     \--> <span class="green-color">ethenis.js</span>
        |--> <span class="green-color">config</span>
        |--> <span class="green-color">index.php</span>
        |--> <span class="green-color">main.php</span>
        \--> <span class="red-color">.htaccess</span>
		</pre>
		<p>Ethenis uses a .htaccess file with rewrite rules, so ensure your apache is configured to read .htaccess files and mod_rewrite is enabled.<p>
	<hr>
<?php } else if ( $path == 'man/2' ) { ?>
    <h3>Configure Web Layout</h3>
	<script>document.title = "Configure Web Layout"</script>
   		The web layout will be set in the <strong>config</strong> file. With it it's possible to modify the animations duration, the paths the website will manage, and the menu elements.
	   	<h6>Example:</h6>
	   		<pre>
    {
        <span class="blue-color">"animationDuration"</span> : 400,
        <span class="blue-color">"scrollAnimationDuration"</span> : 400,
        <span class="blue-color">"content"</span> : {
            <span class="green-color">""</span> : [<span class="green-color">"home.html"</span>, <span class="green-color">"Home"</span>],
            <span class="green-color">"info"</span> : [<span class="green-color">"info.html"</span>, <span class="green-color">"Info"</span>, <span class="red-color">false</span>],
            <span class="green-color">"/^man\/\d*$/"</span> : [<span class="green-color">"man.php"</span>]
          }
    }
 	  		</pre>
		   	<ul>
		   		<li><strong>animationDuration:</strong> the time in milliseconds for the fade animation between page change.</li>
				<li><strong>scrollAnimationDuration:</strong> the time in milliseconds for the "scrollToTop" animation before page change.</li>			
				<li><strong>content:</strong> the content that will be public and its corresponding path.</li>
			</ul>
			<h5>Content entry format:</h5>
				<ul>
					<li>
						<code><span class="green-color">"&lt;path&gt;"</span> : [<span class="green-color">"&lt;file-name&gt;[.html|.php]"</span>, <span class="green-color">"&lt;link-string&gt;"</span>]</code>
					</li>
					<li>
						<code><span class="green-color">"&lt;path&gt;"</span> : [<span class="green-color">"&lt;file-name&gt;[.html|.php]"</span>, <span class="green-color">"&lt;link-string&gt;"</span>, <span class="red-color">false</span>]</code>
						<h6>→ The link won't be added to the navigation menu.</h6>
					</li>
					<li>
						<code><span class="green-color">"&lt;path-pattern&gt;"</span> : [<span class="green-color">"&lt;file-name&gt;[.html|.php]"</span>]</code>
						<h6>→ The link won't be added to the navigation menu.</h6>
					</li>
				</ul>
   	<hr>
<?php } else if ( $path == 'man/3' ) { ?>
    <h3>Set the main content template</h3>
	<script>document.title = "Set the main content templat"</script>
    	All the page design will be supported by an html file template, which will define the content that will remain static in the page. This content will be defined in the <strong>main.php</strong> file.
		<h6>Example</h6>
		<pre class="green-color">
    &lt;html&gt;
        &lt;head&gt;...&lt;/head&gt;
        &lt;body&gt;
            &lt;header class="with-shadow"&gt;&lt;/header&gt;
            &lt;nav&gt;
                <u class="red-color">&lt;{ link-template }&gt;</u>
                    &lt;span style="margin: 5px"&gt;
                        <u class="red-color">&lt;{ link-text }&gt;</u>
                    &lt;/span&gt;
                <u class="red-color">&lt;{ /link-template }&gt;</u>
            &lt;/nav&gt;
            <u class="red-color">&lt;{ content }&gt;</u>
        &lt;/body&gt;
    &lt;/html&gt;
		</pre>
		<ul>
			<li>
				<pre class="red-color">
&lt;{ link-template }&gt;
    <span class="black-color">[html]</span>&lt;{ link-text }&gt;<span class="black-color">[html]</span>
&lt;{ /link-template }&gt;</pre>
				<h6>→ It indicates where to place the link elemeents and the template to follow.</h6>
			</li>
			<li>
				<code class="red-color">&lt;{ content }&gt;</code>
				<h6>→ It indicates where to place the corresponding content.</h6>
			</li>
		</ul>
    <hr>
<?php } else if ( $path == 'man/4' ) { ?>
    <h3>Insert the content Files</h3>
	<script>document.title = "Insert the content Files"</script>
    	The html content to be inserted with each path must be specified inside the <strong>content</strong> directory, inside its corresponding file, as it was previously specified in the <strong>config</strong> file.<br>
    	The PHP and JavaScript code inside those files will also be executed.
		<br><br>
		To change the page title you have to add the  following script to the content file:
		<pre>
    <span class="red-color">&lt;script&gt;</span>
        <span class="blue-color">document.title</span> = <span class="green-color">"&lt;content-title&gt;"</span>;
    <span class="red-color">&lt;/script&gt;</span>
		</pre>
<?php } else if ( $path == 'man/5' ) { ?>
	<h3>Ethenis PHP special functions</h3>
	<script>document.title = "Ethenis PHP special functions"</script>
	<ul>
		<li>
			<code>Ethenis::<span class="blue-color">get_config()</span></code><br>
			→ Returns the configuration values as an array.
		</li>
		<li>
			<code>Ethenis::<span class="blue-color">get_config_json()</span></code><br>
			→ Returns the configuration values as json string.
		</li>
		<li>
			<code>Ethenis::<span class="blue-color">get_path()</span></code><br>
			→ Returns the actual path.
		</li>
	</ul>
<?php } else { ?>
	<h3>This page is empty.</h3>
<?php } ?>
</section>
