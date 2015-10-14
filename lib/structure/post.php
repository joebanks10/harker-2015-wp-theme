<?php

remove_filter( 'post_class', 'genesis_featured_image_post_class' );
add_filter( 'post_class', 'hkr_featured_image_post_class' );

// Check if post has a thumbnail; exludes attachments in post content (use Genesis function to include attachments)
function hkr_featured_image_post_class( $classes ) {

    if ( has_post_thumbnail() && ! in_array( 'has-post-thumbnail', $classes ) ) {
        $classes[] = 'has-post-thumbnail';
    }

    if ( ! genesis_get_option( 'single_thumbnail' ) && ($i = array_search( 'has-post-thumbnail', $classes )) !== false ) {
        unset($classes[$i]);
    }

    return $classes;

}

remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'hkr_do_post_image', 4 );

// Print post thumbnail in archives/blogs
function hkr_do_post_image() {

    if ( ! is_singular() && genesis_get_option( 'content_archive_thumbnail' ) ) {
        $img = genesis_get_image( array(
            'format'  => 'html',
            'size'    => genesis_get_option( 'image_size' ),
            'context' => 'archive',
            'attr'    => genesis_parse_attr( 'entry-image', array ( 'alt' => get_the_title() ) ),
        ) );

        $size = genesis_get_option( 'image_size' );
        $anchor_classes = "entry-image-link entry-image-$size-link";

        if ( ! empty( $img ) )
            printf( '<a href="%s" class="%s" aria-hidden="true">%s</a>', get_permalink(), $anchor_classes, $img );
    }

}

add_action( 'genesis_entry_header', 'hkr_do_single_post_thumbnail', 3 );

function hkr_do_single_post_thumbnail() {
    if ( is_single() && has_post_thumbnail() && genesis_get_option( 'single_thumbnail' ) ) {
        echo '<div class="entry-image-container">';
        the_post_thumbnail('large', array('class' => 'attachment-large entry-image'));
        echo '</div>';
    }
}
