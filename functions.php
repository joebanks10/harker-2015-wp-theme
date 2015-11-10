<?php

function hkr_theme_support() {

    // Remove custom background and header support
    remove_theme_support( 'custom-background' );
    remove_theme_support( 'custom-header' );

    // Remove secondary menu
    add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );

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

    // Add Aesop Story Engine component styles
    add_theme_support( "aesop-component-styles", array( "parallax", "image", "quote", "gallery", "content", "video", "audio", "collection", "chapter", "document", "character", "map", "timeline" ) );
}

add_action('genesis_setup', 'hkr_theme_setup');

function hkr_theme_setup() {

    // Child theme variables
    define( 'CHILD_THEME_NAME', 'Harker 2015' );
    define( 'CHILD_THEME_URL', 'http://www.harker.org/' );
    define( 'CHILD_THEME_VERSION', '0.1.0' );
    define( 'CHILD_THEME_DIR', get_stylesheet_directory());
    define( 'CHILD_THEME_DIR_URL', get_stylesheet_directory_uri());

    hkr_theme_support();

    include_once(CHILD_THEME_DIR . '/lib/admin/admin.php');
    include_once(CHILD_THEME_DIR . '/lib/admin/customizer.php');
    include_once(CHILD_THEME_DIR . '/lib/admin/theme-settings.php');
    include_once(CHILD_THEME_DIR . '/lib/admin/post.php');

    include_once(CHILD_THEME_DIR . '/lib/structure/structure.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/header.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/menu.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/post.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/sidebar.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/footer.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/aesop.php');

    include_once(CHILD_THEME_DIR . '/lib/widgets/featured-post-widget.php');
    include_once(CHILD_THEME_DIR . '/lib/widgets/hero-post-widget.php');

} 

add_action( 'init', 'hkr_add_post_type_support' );

function hkr_add_post_type_support() {
    // Add excerpts to pages
    add_post_type_support( 'page', 'excerpt' );
}


