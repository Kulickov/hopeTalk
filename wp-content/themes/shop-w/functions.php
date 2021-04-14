<?php

    ini_set('max_execution_time', 900);

    define('VG_URI', get_template_directory_uri() . '/');
    define('VG_ASSETS_URI', VG_URI . 'assets/');
    define('VG_IMG', VG_ASSETS_URI . 'img/');

    define('VG_PATH', __DIR__ . '/');
    define('VG_COMPONENTS_PATH', VG_PATH . 'inc/');
    define('VG_TEMPLATES_PATH', VG_PATH . 'templates/');
    define('VG_IMG_PATH', VG_PATH . 'assets/img/');

    // подключаем компоненты сайта
    require_once VG_COMPONENTS_PATH . 'woocommerce/wooGeneral.php';
    require_once VG_COMPONENTS_PATH . 'woocommerce/redefinitionHook.php';
    require_once VG_COMPONENTS_PATH . 'woocommerce/product-sort.php';

    //настройки темы
    add_action( 'after_setup_theme', 'vg_setup' );

    if ( ! function_exists( 'vg_setup' ) ) :

    	function vg_setup() {

    		// This theme styles the visual editor with editor-style.css to match the theme style.
    		add_editor_style();

    		// Load regular editor styles into the new block-based editor.
    		add_theme_support( 'editor-styles' );


    		// This theme uses wp_nav_menu() in one location.
    		register_nav_menu( 'primary', 'Top' );

    		register_nav_menu( 'footer', 'Footer' );

    		add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

    		add_theme_support( 'post-thumbnails' );

            add_theme_support( 'title-tag' );
    	}
    endif;


    //подключаем css и js темы
    add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

    function theme_name_scripts() {

        {
            $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
            // if (!is_admin() && !is_user_logged_in()) {
            //     wp_deregister_script('jquery');
            // }
            wp_enqueue_script('mainJs', VG_URI . 'assets/js/main' . $suffix . '.js', [], 1.04, true);
            wp_enqueue_style('mainCss', VG_URI . 'assets/css/main' . $suffix . '.css', [], 1.05);

            wp_localize_script('mainJs', 'vg_ajaxurl',
                [
                    'url' => admin_url('admin-ajax.php')
                ]
            );
        }

    }

    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => __('Настройки сайта'),
            'menu_title' => __('Настройки сайта'),
            'menu_slug' => 'acf-options',
            'capability' => 'edit_posts',
        ]);
    }

    ## Отключает Гутенберг.
    ## ver: 1.2
    if( 'disable_gutenberg' ){
        remove_theme_support( 'core-block-patterns' ); // WP 5.5

        add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );

        // отключим подключение базовых css стилей для блоков
        // ВАЖНО! когда выйдут виджеты на блоках или что-то еще, эту строку нужно будет комментировать
        remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );

        // Move the Privacy Policy help notice back under the title field.
        add_action( 'admin_init', function(){
            remove_action( 'admin_notices', [ 'WP_Privacy_Policy_Content', 'notice' ] );
            add_action( 'edit_form_after_title', [ 'WP_Privacy_Policy_Content', 'notice' ] );
        } );
    }


 ?>
