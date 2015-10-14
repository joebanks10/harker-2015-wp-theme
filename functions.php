<?php

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
    include_once(CHILD_THEME_DIR . '/lib/structure/header.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/menu.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/post.php');
    include_once(CHILD_THEME_DIR . '/lib/structure/footer.php');

    // Remove header widget area
    unregister_sidebar( 'header-right' );

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

    // Add support for custom background
    add_theme_support( 'custom-background' );

    // Add Aesop Story Engine component styles
    add_theme_support( "aesop-component-styles", array( "parallax", "image", "quote", "gallery", "content", "video", "audio", "collection", "chapter", "document", "character", "map", "timeline" ) );

} 
