<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Harker 2015' );
define( 'CHILD_THEME_URL', 'http://www.harker.org/' );
define( 'CHILD_THEME_VERSION', '0.1.0' );
define( 'CHILD_THEME_DIR', get_stylesheet_directory());
define( 'CHILD_THEME_DIR_URL', get_stylesheet_directory_uri());

include_once(CHILD_THEME_DIR . '/lib/structure/header.php');

unregister_sidebar( 'header-right' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'hkr_theme_assets' );
function hkr_theme_assets() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );
    wp_enqueue_style( 'harker-2015-2', CHILD_THEME_DIR_URL . '/style-2.css', array(), CHILD_THEME_VERSION );
    wp_enqueue_script( 'modernizr', CHILD_THEME_DIR_URL . '/assets/dist/js/scripts.js', array('jquery'), CHILD_THEME_VERSION, true );
    wp_enqueue_script( 'harker-2015-scripts', CHILD_THEME_DIR_URL . '/assets/dist/js/vendor/modernizr.min.js', array('jquery'), CHILD_THEME_VERSION, true );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

// Add Aesop Story Engine component styles
add_theme_support( "aesop-component-styles", array( "parallax", "image", "quote", "gallery", "content", "video", "audio", "collection", "chapter", "document", "character", "map", "timeline" ) );
