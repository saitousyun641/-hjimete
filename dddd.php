<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */

if ( ! function_exists( 'twentytwentytwo_support' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * @since Twenty Twenty-Two 1.0
     *
     * @return void
     */
    function twentytwentytwo_support() {
        // Add support for block styles.
        add_theme_support( 'wp-block-styles' );

        // Enqueue editor styles.
        add_editor_style( 'style.css' );
    }
endif;
add_action( 'after_setup_theme', 'twentytwentytwo_support' );

if ( ! function_exists( 'twentytwentytwo_styles' ) ) :
    /**
     * Enqueue styles.
     *
     * @since Twenty Twenty-Two 1.0
     *
     * @return void
     */
    function twentytwentytwo_styles() {
        // Register theme stylesheet.
        $theme_version = wp_get_theme()->get( 'Version' );

        $version_string = is_string( $theme_version ) ? $theme_version : false;
        wp_register_style(
            'twentytwentytwo-style',
            get_template_directory_uri() . '/style.css',
            array(),
            $version_string
        );

        // Enqueue theme stylesheet.
        wp_enqueue_style( 'twentytwentytwo-style' );
    }
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';

// JavaScriptのロード
function enqueue_custom_scripts() {
    wp_enqueue_script( 'random-menu-script', get_template_directory_uri() . '/random-menu.js', array('jquery'), null, true );
    wp_localize_script( 'random-menu-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_scripts' );

// ショートコードを追加
function random_menu_button() {
    ob_start();
    ?>
    <div class="wp-block-button">
        <a class="wp-block-button__link wp-element-button" id="random-menu-button" href="#">ランダムな献立を表示</a>
    </div>
    <div id="random-menu-result"></div>
    <?php
    return ob_get_clean();
}
add_shortcode('random_menu', 'random_menu_button');

// ランダム献立を生成する関数
function get_random_menu() {
    $menus = array(
        "スパゲッティ",
        "カレーライス",
        "ラーメン",
        "寿司",
        "ピザ",
        "天ぷら",
        "焼肉",
        "オムライス",
        "そば",
        "うどん"
    );

    $random_menu = $menus[array_rand($menus)];
    return $random_menu;
}

function random_menu_ajax_handler() {
    $random_menu = get_random_menu();
    wp_send_json_success(array('menu' => $random_menu));
    wp_die();
}

add_action('wp_ajax_random_menu', 'random_menu_ajax_handler');
add_action('wp_ajax_nopriv_random_menu', 'random_menu_ajax_handler');
