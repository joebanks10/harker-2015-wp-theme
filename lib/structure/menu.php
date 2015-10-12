<?php

remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'hkr_current_site_menu_items', 'hkr_do_nav' );

function hkr_do_nav() {

    $classes = 'current-site-menu current-site-menu-items';
    if ( genesis_superfish_enabled() ) {
        $classes .= ' js-superfish';
    }

    $args = array(
        'theme_location' => '',
        'container'      => '',
        'menu_class'     => $classes,
        'link_before'    => sprintf( '<span %s>', genesis_attr( 'nav-link-wrap' ) ),
        'link_after'     => '</span>',
        'echo'           => true,
    );

    wp_nav_menu($args);
}