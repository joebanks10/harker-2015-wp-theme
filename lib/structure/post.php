<?php

add_filter( 'genesis_post_info', 'hkr_archive_post_info' );

function hkr_archive_post_info($post_info) {
    if ( ! is_single() ) {
        $post_info = genesis_get_option('hkr_archive_post_info');
    }

    return $post_info;
}
