<?php 

add_action( 'customize_register', 'hkr_customizer_register', 20 );

function hkr_customizer_register( $wp_customize ) {
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('background_image');

    $wp_customize->remove_setting('genesis-settings[blog_title]');
    $wp_customize->remove_control('blog_title');
}
