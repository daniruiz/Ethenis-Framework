<?php
header('Content-Type: text/html;charset=utf-8');

final class Ethenis
{
    private static $config;
    private static $path;
    private static $generated_code;


    public static function exec() {
        self::$path = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 1);
        self::load_config();
        self::load_content();
        return self::generated_code();
    }

    public static function generated_code() {
        return self::$generated_code;
    }

    public static function get_config() {
        return self::$config;
    }

    public static function get_config_json() {
        return json_encode(self::$config);
    }

    public static function get_path() {
        return self::$path;
    }


    private static function load_config() {
        $config_string = file_get_contents('config');
        $config_json = str_replace('\\', '\\\\', $config_string);
        self::$config = json_decode($config_json, true);
    }

    private static function load_content() {
        $secondary_content_dir = self::get_secondary_content_dir();
        if (isset($_GET['ajax']) && $_GET['ajax']) {
            self::$generated_code = ' ?>' . file_get_contents($secondary_content_dir) . '<?php ';
        } else {
            if ($secondary_content_dir == 'content/404.html')
                http_response_code(404);
            $secondary_content = file_get_contents($secondary_content_dir);
            $main_content = self::get_main_content();
            self::generate_final_content($main_content, $secondary_content);
        }
    }

    private static function get_secondary_content_dir() {
        $dir = '';
        foreach (self::$config['content'] as $pattern => $values) {
            if (self::$path == $pattern || (self::is_pattern($pattern) && preg_match($pattern, self::$path))) {
                $dir = $values[0];
                break;
            }
        }
        if ($dir == '')
            $dir = self::$config['404'];
        return "content/${dir}";
    }

    private static function get_main_content() {
        function is_template($content) {
            return preg_match('/<{\s*\/?content\s*}>/', $content);
        }

        $main = file_get_contents('content/main.php');
        if (!is_template($main)) {
            preg_match_all('/(?:(?:include|require)(?:_once)?\(([\'"]))([^\1\))]*)(\1\))/',
                    $main, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $content = ' ?>' . file_get_contents($match[2]) . '<?php ';
                if (is_template($content)) {
                    $main = str_replace($match[0], $content, $main);
                    break;
                }
            }
        }
        return $main;
    }

    private static function generate_final_content($main_content, $secondary_content) {
        $final_content = self::replace_special_variables($main_content, $secondary_content);
        $fade_animation_duration = self::get_config()['fadeAnimationDuration'];
        $config_json = self::get_config_json();
        $replace = <<< EOF
        <style>
            #__eth-content {
                opacity: 1;
                transition: opacity ${fade_animation_duration}ms;
            }
        </style>
        <script>__ETHENIS.config = ${config_json}</script>
        <script src="/js/ethenis.js"></script>
    </body>
EOF;
        $final_content = preg_replace('/ *<\/body>/', $replace, $final_content);
        self::$generated_code = ' ?>' . $final_content . '<?php ';
    }

    private static function replace_special_variables($main_content, $secondary_content) {
        $final_content = $main_content;

        preg_match(
            '/(?:<{\s*link-template\s*}>)' .
            '(.*)(?:<{\s*link-text\s*}>)(.*)' .
            '(?:<{\s*\/link-template\s*}>)/s',
            $main_content, $matches);


        if (!empty($matches[0])) {
            if (!isset($matches[1])) $matches[1] = '';
            if (!isset($matches[2])) $matches[2] = '';

            $nav_html =
                '<div id="__eth-nav">' .
                self::generate_nav($matches[1], $matches[2]) .
                '</div>';

            $final_content = str_replace($matches[0],
                $nav_html, $final_content);
        }

        $secondary_content =
            '<script>__ETHENIS = {}</script>' .
            '<div id="__eth-content">' .
            $secondary_content .
            '</div>';

        $final_content = preg_replace('/<{\s*\/?content\s*}>/', $secondary_content, $final_content);
        return $final_content;
    }

    private static function generate_nav($pre_link_html, $post_link_html) {
        $nav = '';
        foreach (self::$config['content'] as $dir => $values) {
            if (end($values) != false &&
                !self::is_pattern($dir) && isset($values[1])) {
                $link_class = '__eth-link' . ((self::$path == $dir) ? ' __eth-selected-link' : '');
                $nav .=
                    '<a class="' . $link_class . '" href="/' . $dir . '">' .
                    $pre_link_html . $values[1] . $post_link_html .
                    '</a>';
            }
        }
        return $nav;
    }

    private static function is_pattern($pattern) {
        return preg_match('/\/.*\//', $pattern);
    }
}

eval(Ethenis::exec());

?>
