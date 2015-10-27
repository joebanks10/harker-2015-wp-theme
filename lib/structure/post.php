<?php

/* Featured Image
-------------------------------------------------- */

remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'hkr_do_archive_thumbnail', 4 );

// Print post thumbnail in archives/blogs
function hkr_do_archive_thumbnail() {

    if ( ! is_singular() && genesis_get_option( 'content_archive_thumbnail' ) ) {
        $img = genesis_get_image( array(
            'format'  => 'html',
            'size'    => genesis_get_option( 'image_size' ),
            'context' => 'archive',
            'attr'    => genesis_parse_attr( 'entry-image', array ( 'alt' => get_the_title() ) ),
        ) );

        $size = genesis_get_option( 'image_size' );

        // add custom anchor classes
        $anchor_classes = "entry-image-link entry-image-$size-link";

        if ( ! empty( $img ) )
            printf( '<a href="%s" class="%s" aria-hidden="true">%s</a>', get_permalink(), $anchor_classes, $img );
    }

}

add_action( 'template_redirect', 'hkr_do_single_thumbnail' );

function hkr_do_single_thumbnail() {

    if ( has_single_thumbnail() ) {
        add_filter( 'body_class', 'hkr_single_thumbnail_class' );

        if ( has_single_thumbnail('content') ) {
            
            if ( is_page_template( 'page_blog.php' ) ) {
                add_action( 'genesis_before_loop', 'hkr_do_single_post_content_image', 5 );
            } else {
                add_action( 'genesis_entry_header', 'hkr_do_single_post_content_image', 3 );
            }

        } else if ( has_single_thumbnail('banner') ) {

            if ( is_page_template( 'page_home.php' ) && is_active_sidebar( 'hkr-home-banner-widgets') ) 
                return;
            
            add_action( 'genesis_after_header', 'hkr_do_single_post_banner_image', 15 );
            
            if ( is_page_template( 'page_blog.php' ) ) {
                remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
            } else {
                remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
                remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
            }

        } else if ( has_single_thumbnail('hero') ) {
            if ( is_page_template( 'page_home.php' ) && is_active_sidebar( 'hkr-home-banner-widgets') ) 
                return;

            add_action( 'genesis_after_header', 'hkr_do_single_post_hero_image', 15 );
        } 

    }

}


/* Feature Image Templates
-------------------------------------------------- */

function hkr_do_single_post_content_image() {
    ?>
    <div class="entry-image-content">
        <?php the_post_thumbnail('large', array('class' => 'attachment-large entry-image')); ?>
    </div>
    <?php
}

function hkr_do_single_post_banner_image() {
    global $post;

    $thumb_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

    ?>
    <div class="entry-image-banner">
        <div class="banner-text">
            <div class="row">
                <div class="columns medium-22 large-24 medium-centered">
                    <div class="hero-title"><?php echo $post->post_title; ?></div>
                    <?php if ( is_single() ) : ?>
                    <div class="hero-meta">
                        <?php echo hkr_get_post_time($post->ID)  . __( ' by ', 'genesis' ) . hkr_get_post_author_posts_link($post->post_author)  ?>
                    </div>
                    <?php endif; ?>
                    <?php if ( !empty( $post->post_excerpt ) ) : ?>
                    <div class="hero-subtitle">
                        <?php echo $post->post_excerpt; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="banner-image" style="background-image: url(<?php echo $thumb_url; ?>)">
            <?php the_post_thumbnail('full', array( 'class' => 'attachment-large entry-image' )); ?>
        </div>
    </div>
    <?php
}

function hkr_do_single_post_hero_image() {
    hkr_do_hero_header();
    hkr_do_hero();
}

function hkr_do_hero_header() {
    ?>
    <header class="header hero-header">
        <div class="row">
            <div class="column">
                <nav class="header-nav">
                    <div class="harker-logo"><a href="http://www.harker.org">The Harker School</a></div>
                    <ul class="header-nav-menu header-nav-menu-secondary">
                        <li class="menu-item-search"><a href="#" title="Search"></a></li>
                        <li class="menu-item-login"><a href="#" title="Login"></a></li>
                    </ul>
                    <ul class="header-nav-menu header-nav-menu-sections">
                        <li class="menu-item-hamburger"><a href="#global-nav" title="Menu"><span class="menu-item-text">Menu</span></a></li>
                        <li><a href="#">Admission</a></li>
                        <li><a href="#">Preschool</a></li>
                        <li><a href="#">Lower School</a></li>
                        <li><a href="#">Middle School</a></li>
                        <li><a href="#">Upper School</a></li>
                        <li><a href="#">Summer</a></li>
                        <li class="menu-item-more">
                            <a href="#h-more-sections" data-dropdown="h-more-sections" aria-controls="h-more-sections" aria-expanded="false"><span>More</span></a>
                            <ul id="h-more-sections" class="f-dropdown" data-dropdown-content aria-hidden="true">
                                <li class="more-sections-item"><a href="/about">About</a></li>
                                <li class="more-sections-item"><a href="/news">News</a></li>
                                <li class="more-sections-item"><a href="/alumni">Alumni</a></li>
                                <li class="more-sections-item"><a href="/giving">Giving</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <?php
}

function hkr_do_hero() {
    global $post;
    
    ?>
    <div id="hero" class="hero hero-overlay entry-image-hero">
        <div class="hero-text">
            <div class="row">
                <div class="columns medium-16 medium-centered">
                    <div class="hero-title"><?php echo $post->post_title; ?></div>
                    <?php if ( is_single() ) : ?>
                    <div class="hero-meta">
                        <?php echo hkr_get_post_time($post->ID)  . __( ' by ', 'genesis' ) . hkr_get_post_author_posts_link($post->post_author)  ?>
                    </div>
                    <?php endif; ?>
                    <?php if ( !empty( $post->post_excerpt ) ) : ?>
                    <div class="hero-subtitle">
                        <?php echo $post->post_excerpt; ?>
                    </div>
                    <?php endif; ?>
                    <div id="actions" data-magellan-expedition="actions">
                        <ul class="button-group">
                            <li data-magellan-arrival="intro">
                                <a class="button secondary" href="#intro">Learn More</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-img hero-fixed">
            <?php the_post_thumbnail('full', array('class' => 'attachment-large entry-image')); ?>
        </div>
    </div>
    <?php
}


/* Class Hooks
-------------------------------------------------- */

remove_filter( 'post_class', 'genesis_featured_image_post_class' );
add_filter( 'post_class', 'hkr_featured_image_post_class' );

// Check if post has a thumbnail; exludes attachments in post content (use Genesis function to include attachments)
function hkr_featured_image_post_class( $classes ) {

    if ( has_post_thumbnail() && ! in_array( 'has-post-thumbnail', $classes ) ) {
        $classes[] = 'has-post-thumbnail';
    }

    if ( $i = array_search( 'has-post-thumbnail', $classes ) !== false ) {
        
        if ( ! genesis_get_option( 'single_thumbnail' ) ) {
            unset($classes[$i]);
        }
        if ( 'genesis_after_header' === genesis_get_option('single_thumbnail_format') ) {
            unset($classes[$i]);
        }

    }

    return $classes;

}
    
function hkr_single_thumbnail_class( $classes ) {
    $classes[] = 'has-single-thumbnail';

    if ( 'content' === genesis_get_option('single_thumbnail_format') ) {
        $classes[] = 'has-single-thumbnail-content';
    } else if ( 'banner' === genesis_get_option('single_thumbnail_format') ) {
        $classes[] = 'has-single-thumbnail-banner';
    } else if ( 'hero' === genesis_get_option('single_thumbnail_format') ) {
        $classes[] = 'has-single-thumbnail-hero';
    } 

    return $classes;
}


/* Helper Functions 
-------------------------------------------------- */

function has_single_thumbnail( $format = false ) {

    if ( genesis_get_custom_field('_hkr_custom_single_thumbnail') ) {

        $has_format = ($format) ? ($format == genesis_get_custom_field( '_hkr_single_thumbnail_format' )) : true;

        return (is_singular() && has_post_thumbnail() && genesis_get_custom_field( '_hkr_single_thumbnail' ) && $has_format);

    } else {

        $has_format = ($format) ? ($format == genesis_get_option( 'single_thumbnail_format' )) : true;

        return (is_singular() && has_post_thumbnail() && genesis_get_option( 'single_thumbnail' ) && $has_format);

    }

}

function hkr_get_post_time( $post_id ) {
    $output = sprintf( '<time %s>', genesis_attr( 'entry-time' ) ) . get_the_time( get_option( 'date_format' ), $post_id ) . '</time>';

    return $output;
}

function hkr_get_post_author_posts_link( $user_id ) {
    
    $author = get_the_author_meta( 'display_name', $user_id );
    $url    = get_author_posts_url( $user_id );

    $output  = sprintf( '<span %s>', genesis_attr( 'entry-author' ) );
    $output .= sprintf( '<a href="%s" %s>', $url, genesis_attr( 'entry-author-link' ) );
    $output .= sprintf( '<span %s>', genesis_attr( 'entry-author-name' ) );
    $output .= esc_html( $author );
    $output .= '</span></a></span>';

    return $output;
}
