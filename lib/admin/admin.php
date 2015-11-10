<?php

add_action( 'admin_enqueue_scripts', 'hkr_admin_assets' );

function hkr_admin_assets() {
    wp_enqueue_style( 'hkr_admin_css', CHILD_THEME_DIR_URL . '/assets/admin/style.css');
}
