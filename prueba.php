<pre>
    <?php
        $config_string = file_get_contents("config");
        $config_json = str_replace("\\","\\\\", $config_string);
        $config = json_decode($config_json, true);
        echo print_r($config)
    ?>
</pre>
