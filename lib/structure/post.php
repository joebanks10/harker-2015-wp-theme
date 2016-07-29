<?php

add_filter( 'genesis_post_info', 'hkr_archive_post_info' );

function hkr_archive_post_info($post_info) {
    if ( ! is_single() ) {
        $option = genesis_get_option('hkr_archive_post_info');
        
        if (!empty($option)) {
            $post_info = $option;
        }
    }

    return $post_info;
}
