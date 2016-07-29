<?php

// Enable shortcodes in widget text
add_filter('widget_text', 'do_shortcode');

add_action( 'widgets_init', 'hkr_setup_sidebars' );

function hkr_setup_sidebars() {
    
    // Remove header right widget area
    unregister_sidebar( 'header-right' );

    genesis_register_sidebar( array(
        'id'            => 'hkr-top-banner-widgets',
        'name'          => __( 'Top Banner', 'harker-2015' ),
        'description'   => __( 'This is a widget area above the main content area.', 'harker-2015' ),
    ));

    // Add header widget area (full screen)
    genesis_register_sidebar( array(
        'id'            => 'hkr-home-banner-widgets',
        'name'          => __( 'Home Page: Banner', 'harker-2015' ),
        'description'   => __( 'This is a widget area above the main content area of the Home page template.', 'harker-2015' ),
    ));

    // Add content widget area
    genesis_register_sidebar( array(
        'id'            => 'hkr-home-content-widgets',
        'name'          => __( 'Home Page: Content', 'harker-2015' ),
        'description'   => __( 'This is a widget area in the main content area of the Home page template.', 'harker-2015' ),
    ));

}

add_action( 'widgets_init', 'hkr_setup_widgets' );

function hkr_setup_widgets() {

    // Remove Genesis Featured Post Widget
    unregister_widget( 'Genesis_Featured_Post' );

    // Add modified version of Genesis Featured Post Widget
    register_widget( 'HKR_Featured_Posts_Content' );
    register_widget( 'HKR_Featured_Posts_Banner' );

}
