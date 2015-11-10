<?php

add_action( 'admin_enqueue_scripts', 'hkr_admin_assets' );

function hkr_admin_assets() {
    wp_enqueue_style( 'hkr_admin_css', CHILD_THEME_DIR_URL . '/assets/admin/style.css');
}

add_filter( 'genesis_theme_settings_menu_ops', 'hkr_menu_ops' );

function hkr_menu_ops( $options ) {
    $options['main_menu']['menu_title'] = 'Harker Theme';
    $options['main_menu']['icon_url'] = CHILD_THEME_DIR_URL . '/lib/admin/images/harker-menu.png';

    return $options;
}