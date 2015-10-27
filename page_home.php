<?php

//* Template Name: Home

// add_action( 'genesis_after_header', 'hkr_do_home_banner', 15 );

function hkr_do_home_banner() {
    genesis_widget_area( 'hkr-home-banner-widgets', array( 
        'before' => '<div class="home-widgets home-widgets-banner widget-area">', 
        'after'  => '</div>'
    ));
}

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'hkr_do_home_content' );

function hkr_do_home_content() {
    genesis_widget_area( 'hkr-home-content-widgets', array( 
        'before' => '<div class="home-widgets home-widgets-content widget-area">', 
        'after'  => '</div>'
    ));
}

genesis();
