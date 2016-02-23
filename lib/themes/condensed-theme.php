<?php

/* Structure - Post
-------------------------------------------------- */

if ( is_condensed_theme() ) {
    add_action( 'template_redirect', 'hkr_remove_post_info' );
    add_action( 'template_redirect', 'hkr_remove_entry_footer' );

    remove_filter( 'archive_thumbnail_size', 'featured_post_image_size' );
    add_filter( 'archive_thumbnail_size', 'hkr_cond_featured_post_image_size' );
}

function hkr_remove_post_info() {
    if ( ! is_single() && is_condensed_theme() ) {
        add_filter( 'genesis_post_info', '__return_false' );
    }
}

function hkr_remove_entry_footer() {
    if ( ! is_single() && is_condensed_theme() ) {
        remove_post_type_support( 'post', 'genesis-entry-meta-after-content' );
    }
}

function hkr_cond_featured_post_image_size($size) {
    global $post;

    if ( $post->is_featured ) {
        return 'large-square';
    } else {
        return $size;
    }
}