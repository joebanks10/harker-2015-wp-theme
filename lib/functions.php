<?php

function hkr_theme_assets() {

    // wp_deregister_script( 'superfish' );
    // wp_deregister_script( 'superfish-args' );

    wp_enqueue_style( 'harker-2015-2', CHILD_THEME_DIR_URL . '/style-2.css', array(), CHILD_THEME_VERSION );
    wp_enqueue_script( 'modernizr', CHILD_THEME_DIR_URL . '/assets/dist/js/scripts.js', array('jquery'), CHILD_THEME_VERSION, true );
    wp_enqueue_script( 'harker-2015-scripts', CHILD_THEME_DIR_URL . '/assets/dist/js/vendor/modernizr.min.js', array('jquery'), CHILD_THEME_VERSION, true );

}