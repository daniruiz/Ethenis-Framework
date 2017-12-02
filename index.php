<?php
header("Content-Type: text/html;charset=utf-8");

function get_content_dir(){
    $uri = $_SERVER['REQUEST_URI'];
    $dir = "";
    $config = file_get_contents("config");
    $config = str_replace("\\","\\\\",$config);
    $config_json = json_decode($config, true);
    foreach ($config_json as $pattern => $value){   
        if(preg_match($pattern, $uri)) {
            $dir = $value;
            break;
        }
    }
    return "content/".$dir;
}

function create_html($content_dir){
    $index_html = file_get_contents("index.html");
    $content_html = file_get_contents($content_dir);
    echo str_replace("<{ content }>", $content_html, $index_html);
}

$content_dir = get_content_dir();
create_html($content_dir);
?>
