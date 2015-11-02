<?php

add_action( 'init', 'hkr_add_excerpts_to_pages' );

function hkr_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}

add_action('genesis_setup', 'hkr_theme_setup');

function hkr_theme_setup() {

    // Child theme variables
    define( 'CHILD_THEME_NAME', 'Harker 2015' );
    define( 'CHILD_THEME_URL', 'http://www.harker.org/' );
    define( 'CHILD_THEME_VERSION', '0.1.0' );
    define( 'CHILD_THEME_DIR', get_stylesheet_directory());
    define( 'CHILD_THEME_DIR_URL', get_stylesheet_directory_uri());

    include_once(CHILD_THEME_DIR . '/lib/functions.php');
    include_once(CHILD_THEME_DIR . '/lib/admin/theme-settings.php');
    include_once(CHILD_THEME_DIR . '/lib/admin/post.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/post.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/header.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/menu.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/footer.php');
    include_once(CHILD_THEME_DIR . '/lib/aesop.php');

    // Remove secondary menu
    add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );

    // Enqueue child theme assets
    add_action( 'wp_enqueue_scripts', 'hkr_theme_assets' );

    // Add HTML5 markup structure
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

    // Add accessibility support
    add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );

    // Add viewport meta tag for mobile browsers
    add_theme_support( 'genesis-responsive-viewport' );

    // Add inner divs to elements
    add_theme_support( 'genesis-structural-wraps', array(
        'header',
        'nav',
        'subnav',
        'site-inner',
        'footer-widgets',
        'footer'
    ) );

    add_filter( 'genesis_attr_structural-wrap', 'hkr_attributes_structural_wrap' );
    function hkr_attributes_structural_wrap( $attributes ) {

        $site_layout = genesis_site_layout();

        if ( 'full-width-content' === $site_layout ) {
            $attributes['class'] = 'row-full';
        } else {
            $attributes['class'] = 'row';
        }

        return $attributes;

    }

    add_filter( 'genesis_attr_site-inner', 'hkr_attributes_site_inner' );
    function hkr_attributes_site_inner( $attributes ) {

        $attributes['id'] = 'intro';
        $attributes['data-magellan-destination'] = 'intro';

        return $attributes;

    }

    // Add support for custom background
    add_theme_support( 'custom-background' );

    // Add Aesop Story Engine component styles
    add_theme_support( "aesop-component-styles", array( "parallax", "image", "quote", "gallery", "content", "video", "audio", "collection", "chapter", "document", "character", "map", "timeline" ) );

    add_action( 'widgets_init', 'hkr_setup_sidebars' );
    function hkr_setup_sidebars() {
        
        // Remove header right widget area
        unregister_sidebar( 'header-right' );

        // Add header widget area (full screen)
        genesis_register_sidebar( array(
            'id'            => 'hkr-home-banner-widgets',
            'name'          => __( 'Home Page: Banner', 'harker-2015' ),
            'description'   => __( 'This is a widget area above the main content area.', 'harker-2015' ),
        ));

        // Add content widget area
        genesis_register_sidebar( array(
            'id'            => 'hkr-home-content-widgets',
            'name'          => __( 'Home Page: Content', 'harker-2015' ),
            'description'   => __( 'This is a widget area in the main content area.', 'harker-2015' ),
        ));

    }

} 
