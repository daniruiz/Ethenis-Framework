<?php
header("Content-Type: text/html;charset=utf-8");
//
ini_set('display_errors', 1);
//


final class Ethenis {
    private static $config;
    
    public static function exec(){
        self::load_config();
        self::load_content();
    }
    
    public static function get_config_json(){
        return json_encode(self::$config);
    }

    private static function load_config() {
        $config_string = file_get_contents("config");
        $config_json = str_replace("\\","\\\\", $config_string);
        self::$config = json_decode($config_json, true);
    }

    private static function load_content() {
        $main_content = file_get_contents("main.php");
        $secondary_content = self::get_secondary_content();
        $final_content = self::replace_special_variables($main_content,
                $secondary_content);
        eval(' ?>'.$final_content.'<?php ');
    }

    private static function get_secondary_content(){
        $uri = substr($_SERVER['REQUEST_URI'], 1);
        $dir = "";
        foreach (self::$config as $pattern => $values){
            if($uri == $pattern ||
                    (self::is_pattern($pattern) &&
                    preg_match($pattern, $uri))) {
                $dir = $values[0];
                break;
            }
        }
        if($dir == "")
            http_response_code(404);
        return file_get_contents("content/".$dir);
    }
    
    private static function replace_special_variables($main_content,
            $secondary_content){                
        preg_match(
                "/(?:<{ link-template }>)".
                    "(.*)(?:<{ dir-name }>)(.*)".
                "(?:<{ \/link-template }>)/",
                $main_content, $matches);

        $nav_html = self::generate_nav($matches[1], $matches[2]);
        $secondary_content =
                '<div id="__eth-content">'.
                     $secondary_content.
                 '</div>';
        
        $final_content = preg_replace(
                "/<{ link-template }>".
                    ".*<{ dir-name }>.*".
                "<{ \/link-template }>/"
                , $nav_html, $main_content);
        $final_content = str_replace("<{ content }>",
                $secondary_content, $final_content);
        return $final_content;
    }
    
    private static function generate_nav($pre_link_html, $post_link_html){
        $nav = "";
        foreach(self::$config as $dir => $values){
            if(end($values) != false &&
                !self::is_pattern($dir) && isset($values[1])){
                $nav .=
                '<a class="__eth-link" href="/'. $dir .'">'.
                    $pre_link_html . $values[1] . $post_link_html.
                '</a>';
            }
        }
        return $nav;
    }
    
    private static function is_pattern($pattern){
        return preg_match("/\/.*\//", $pattern);
    }
}

Ethenis::exec();
?>
<style>
    #__eth-content {
        opacity: 1;
        transition: opacity .3s;
    }
</style>
<script>
    __ETHENIS_CONFIG = <?php echo Ethenis::get_config_json(); ?>
</script>
<script src="/js/index.js"></script>


