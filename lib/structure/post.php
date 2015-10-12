<?php

remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'hkr_do_post_image', 4 );

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
