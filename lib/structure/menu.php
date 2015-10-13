<?php

remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'hkr_current_site_menu_items', 'hkr_do_nav' );

function hkr_do_nav() {

    $classes = 'current-site-menu current-site-menu-items';

    $args = array(
        'theme_location' => 'primary',
        'container'      => '',
        'menu_class'     => $classes,
        'link_before'    => sprintf( '<span %s>', genesis_attr( 'nav-link-wrap' ) ),
        'link_after'     => '</span>',
        'depth'          => 3,
        'echo'           => true
    );

    wp_nav_menu($args);
}