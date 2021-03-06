<?php 

if ( feature_first_post() ) {
    add_action( 'template_redirect', 'hkr_setup_featured_post' );

    add_filter( 'genesis_attr_entry', 'hkr_attr_entry_feature' );
    add_filter( 'archive_thumbnail_size', 'hkr_featured_post_image_size' );
}

function hkr_setup_featured_post() {
    $page = (isset($_REQUEST['page'])) ? (int) $_REQUEST['page'] : 0; // for infinite scroll ajax requests
    
    if ( is_home() && ! is_paged() && $page === 0 ) {
        add_action( 'genesis_before_while', 'hkr_do_featured_post_loop' );
        add_action( 'genesis_before_entry', 'hkr_skip_featured_post', 1 );
    }

}

/**
 * Display the first post with a photo in the loop as the first story of the loop.
 */
function hkr_do_featured_post_loop() {

    while ( have_posts() ) : the_post();

        if ( ! has_post_thumbnail() ) {
            continue;
        }

        global $post, $_hkr_displayed_ids;
        $post->is_featured = true;

        do_action( 'genesis_before_entry' );

        printf( '<article %s>', genesis_attr( 'entry' ) );

            do_action( 'genesis_entry_header' );

            do_action( 'genesis_before_entry_content' );

            printf( '<div %s>', genesis_attr( 'entry-content' ) );
            do_action( 'genesis_entry_content' );
            echo '</div>';

            do_action( 'genesis_after_entry_content' );

            do_action( 'genesis_entry_footer' );

        echo '</article>';

        do_action( 'genesis_after_entry' );

        $_hkr_displayed_ids[] = $post->ID;

        break;

    endwhile; //* end of one post

    rewind_posts();

}

/**
 * Skip the story that was displayed first
 */
function hkr_skip_featured_post() {
    global $post, $_hkr_displayed_ids;

    if ( in_array($post->ID, $_hkr_displayed_ids) ) {
        the_post(); // advance to the next post
    }
}

function hkr_attr_entry_feature( $attributes ) { 
    global $post;

    if ( $post->is_featured ) {
        $attributes['class'] .= ' entry-feature';
    } 

    return $attributes; 
}

function hkr_featured_post_image_size($size) {
    global $post;

    if ( $post->is_featured ) {
        return 'archive-post';
        // return 'feature-square';
    } else {
        return $size;
    }
}
