<?php 

add_action( 'template_redirect', 'hkr_setup_featured_post' );

function hkr_setup_featured_post() {
    
    if ( is_page_template( 'page_blog.php' ) && is_front_page() ) {
        add_action( 'genesis_before_while', 'hkr_do_featured_post_loop' );
        add_action( 'genesis_before_entry', 'hkr_skip_featured_post' );
    }
    
}

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

function hkr_skip_featured_post() {
    global $post, $_hkr_displayed_ids;

    if ( in_array($post->ID, $_hkr_displayed_ids) ) {
        the_post(); // advance to the next post
    }
}