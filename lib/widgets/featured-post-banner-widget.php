<?php
/**
 * Hero Banner Feed. Modified version of Genesis Featured Post widget class.
 *
 * @since 0.1.8
 *
 * @package Genesis\Widgets
 */
class HKR_Featured_Posts_Banner extends WP_Widget {

    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor. Set the default widget options and create widget.
     *
     * @since 0.1.8
     */
    function __construct() {

        $this->defaults = array(
            'title'                   => '',
            'posts_cat'               => '',
            'posts_tag'               => '',
            'posts_num'               => 1,
            'posts_offset'            => 0,
            'orderby'                 => '',
            'order'                   => '',
            'exclude_displayed'       => 0,
            'exclude_sticky'          => 0,
            'show_image'              => 0,
            'image_alignment'         => '',
            'image_size'              => 'thumbnail',
            'show_large_image'        => 0,
            'show_gravatar'           => 0,
            'gravatar_alignment'      => '',
            'gravatar_size'           => '',
            'show_title'              => 0,
            'show_byline'             => 0,
            'post_info'               => '[post_date] ' . __( 'by', 'harker-2015' ) . ' [post_author_posts_link] [post_comments]',
            'show_content'            => 'excerpt',
            'content_limit'           => '',
            'more_text'               => __( 'Read More...', 'harker-2015' ),
            'extra_num'               => '',
            'extra_title'             => '',
            'headlines_num'           => '',
            'headlines_title'         => '',
            'more_from_category'      => '',
            'more_from_category_text' => __( 'Read More Posts', 'harker-2015' ),
        );

        $widget_ops = array(
            'classname'   => 'featured-posts-banner',
            'description' => __( 'Displays posts with thumbnails. Optimized for the Home Page: Banner area.', 'harker-2015' ),
        );

        $control_ops = array(
            'id_base' => 'featured-post-banner'
        );

        // add actions and filters
        add_action( 'hkr_before_banner_post_widget_content', array($this, 'large_featured_image_open') );
        add_action( 'hkr_after_banner_post_widget_content', array($this, 'large_featured_image_close') );
        add_filter( 'genesis_attr_banner-post', array($this, 'post_class') );

        parent::__construct( 'featured-post-banner', __( 'Featured Posts Banner', 'harker-2015' ), $widget_ops, $control_ops );

    }

    /**
     * Echo the widget content.
     *
     * @since 0.1.8
     *
     * @global WP_Query $wp_query               Query object.
     * @global array    $_genesis_displayed_ids Array of displayed post IDs.
     * @global $integer $more
     *
     * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
     * @param array $instance The settings for the particular instance of the widget
     */
    function widget( $args, $instance ) {
        global $wp_query, $_genesis_displayed_ids;

        // get widget args
        $instance = wp_parse_args( (array) $instance, $this->defaults );

        // get posts
        $wp_query = $this->get_query( $instance );

        echo $args['before_widget'];
        do_action( 'hkr_before_banner_post_widget_content', $instance );

        // the widget title
        if ( ! empty( $instance['title'] ) )
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];

        // the post loop
        if ( have_posts() ) : while ( have_posts() ) : the_post();
            
            $_genesis_displayed_ids[] = get_the_ID();

            if ( $wp_query->current_post == 0 ) {
                $this->post_article( $args, $instance );
            }
            else {
                
                if ( $wp_query->current_post == 1 ) {
                    echo '<ul class="banner-posts-list">';
                }
                
                $this->post_list_item( $args, $instance );

                if ( $wp_query->current_post == ($wp_query->post_count-1) ) {
                    echo '</ul>';
                }

            }

        endwhile; endif; 
        wp_reset_query();

        do_action( 'hkr_after_banner_post_widget_content', $instance );
        echo $args['after_widget'];

    }

    function get_query( $instance ) {
        global $_genesis_displayed_ids;

        $query_args = array(
            'post_type'           => 'post',
            'cat'                 => $instance['posts_cat'],
            'tag_id'              => $instance['posts_tag'],
            'showposts'           => $instance['posts_num'],
            'offset'              => $instance['posts_offset'],
            'orderby'             => $instance['orderby'],
            'order'               => $instance['order'],
            'ignore_sticky_posts' => $instance['exclude_sticky'],
        );

        //* Exclude displayed IDs from this loop?
        if ( $instance['exclude_displayed'] )
            $query_args['post__not_in'] = (array) $_genesis_displayed_ids;

        return new WP_Query( $query_args );
    }

    function large_featured_image_open( $instance ) {
        global $wp_query;

        if ( have_posts() ) : 
            the_post();

            $image_url = genesis_get_image( array(
                'format'  => 'url'
            ) );

            if ( $image_url ) {
                printf( '<div class="banner-background has-background-image" style="background-image:url(%s);">', $image_url );
            } else {
                echo '<div class="banner-background">';
            }

            echo '<div class="banner-overlay">';
            echo '<div class="row">';

        endif;

        rewind_posts();

    }

    function large_featured_image_close() {
        echo '</div></div></div>';
    }

    function post_article( $args, $instance ) {
        global $wp_query;

        genesis_markup( array(
            'html5'   => '<article %s>',
            'xhtml'   => sprintf( '<div class="%s">', implode( ' ', get_post_class() ) ),
            'context' => 'banner-post',
        ) );

        echo genesis_html5() ? '<header class="entry-header">' : '';

        $this->post_title( $args, $instance );

        if ( ! empty( $instance['show_byline'] ) && ! empty( $instance['post_info'] ) )
            printf( genesis_html5() ? '<p class="entry-meta">%s</p>' : '<p class="byline post-info">%s</p>', do_shortcode( $instance['post_info'] ) );

        echo genesis_html5() ? '</header>' : '';

        genesis_markup( array(
            'html5' => '</article>',
            'xhtml' => '</div>',
        ) );
    }

    function post_list_item( $args, $instance ) {
        global $wp_query;

        genesis_markup( array(
            'html5'   => '<li %s>',
            'xhtml'   => sprintf( '<li class="%s">', implode( ' ', get_post_class() ) ),
            'context' => 'featured-post',
        ) );

        $this->post_title( $args, $instance );

        echo '</li>';
        
    }

    function post_title( $args, $instance ) {

        $title = get_the_title() ? get_the_title() : __( '(no title)', 'harker-2015' );

        $title = apply_filters( 'hkr_banner_post_title', $title, $instance, $args );
        $heading = genesis_a11y( 'headings' ) ? 'h4' : 'h2';

        if ( genesis_html5() )
            printf( '<%s class="entry-title"><a href="%s">%s</a></%s>', $heading, get_permalink(), $title, $heading );
        else
            printf( '<%s><a href="%s">%s</a></%s>', $heading, get_permalink(), $title, $heading );

    }

    function post_class( $attributes ) {
        global $wp_query;

        $classes = get_post_class();
        $classes[] = 'banner-post-' . ($wp_query->current_post + 1);

        $attributes['class'] = join( ' ', $classes );

        return $attributes;

    }

    function get_archive_url( $instance ) {
        
        if ( empty( $instance['posts_cat'] ) && empty( $instance['posts_tag'] ) )
            return false;

        if ( ! empty( $instance['posts_cat'] ) && empty( $instance['posts_tag'] ) ) {
            $url = get_category_link( $instance['posts_cat'] );
        } 
        else if ( empty( $instance['posts_cat'] ) && ! empty( $instance['posts_tag'] ) ) {
            $url = get_tag_link( $instance['posts_tag'] );
        } 
        else {
            $url = get_category_link( $instance['posts_cat'] );
            $url .= ( preg_match('/\?/', $url) ) ? '&' : '?';
            $url .= 'tag_id=' . $instance['posts_tag'];
        }

        return $url;

    }

    /**
     * Update a particular instance.
     *
     * This function should check that $new_instance is set correctly.
     * The newly calculated value of $instance should be returned.
     * If "false" is returned, the instance won't be saved/updated.
     *
     * @since 0.1.8
     *
     * @param array $new_instance New settings for this instance as input by the user via form()
     * @param array $old_instance Old settings for this instance
     * @return array Settings to save or bool false to cancel saving
     */
    function update( $new_instance, $old_instance ) {

        $new_instance['title']     = strip_tags( $new_instance['title'] );
        // $new_instance['more_text'] = strip_tags( $new_instance['more_text'] );
        $new_instance['post_info'] = wp_kses_post( $new_instance['post_info'] );

        return $new_instance;

    }

    /**
     * Echo the settings update form.
     *
     * @since 0.1.8
     *
     * @param array $instance Current settings
     */
    function form( $instance ) {

        //* Merge with defaults
        $instance = wp_parse_args( (array) $instance, $this->defaults );

        ?>
        <style>
            .genesis-widget-column-box {
                padding-top: 0;
                margin-bottom: 10px;
            }
        </style>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'harker-2015' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
        </p>

        <div class="genesis-widget-column-box genesis-widget-column-box-top">

            <h4>Post Selection</h4>
            <p>
                <label for="<?php echo $this->get_field_id( 'posts_cat' ); ?>"><?php _e( 'Category', 'harker-2015' ); ?>:</label>
                <?php
                $categories_args = array(
                    'name'            => $this->get_field_name( 'posts_cat' ),
                    'id'              => $this->get_field_id( 'posts_cat' ),
                    'selected'        => $instance['posts_cat'],
                    'orderby'         => 'Name',
                    'hierarchical'    => 1,
                    'show_option_all' => __( 'All Categories', 'harker-2015' ),
                    'hide_empty'      => '0',
                );
                wp_dropdown_categories( $categories_args ); ?>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'posts_tag' ); ?>"><?php _e( 'Tag', 'harker-2015' ); ?>:</label>
                <?php
                $tag_args = array(
                    'name'            => $this->get_field_name( 'posts_tag' ),
                    'id'              => $this->get_field_id( 'posts_tag' ),
                    'selected'        => $instance['posts_tag'],
                    'orderby'         => 'Name',
                    'hierarchical'    => 1,
                    'show_option_all' => __( 'All Tags', 'harker-2015' ),
                    'hide_empty'      => '0',
                    'taxonomy' => 'post_tag'
                );
                wp_dropdown_categories( $tag_args ); ?>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'posts_num' ) ); ?>"><?php _e( 'Number of Posts to Show', 'harker-2015' ); ?>:</label>
                <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'posts_num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_num' ) ); ?>" value="<?php echo esc_attr( $instance['posts_num'] ); ?>" size="2" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'posts_offset' ) ); ?>"><?php _e( 'Number of Posts to Offset', 'harker-2015' ); ?>:</label>
                <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'posts_offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_offset' ) ); ?>" value="<?php echo esc_attr( $instance['posts_offset'] ); ?>" size="2" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( 'Order By', 'harker-2015' ); ?>:</label>
                <select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
                    <option value="date" <?php selected( 'date', $instance['orderby'] ); ?>><?php _e( 'Date', 'harker-2015' ); ?></option>
                    <option value="title" <?php selected( 'title', $instance['orderby'] ); ?>><?php _e( 'Title', 'harker-2015' ); ?></option>
                    <option value="parent" <?php selected( 'parent', $instance['orderby'] ); ?>><?php _e( 'Parent', 'harker-2015' ); ?></option>
                    <option value="ID" <?php selected( 'ID', $instance['orderby'] ); ?>><?php _e( 'ID', 'harker-2015' ); ?></option>
                    <option value="comment_count" <?php selected( 'comment_count', $instance['orderby'] ); ?>><?php _e( 'Comment Count', 'harker-2015' ); ?></option>
                    <option value="rand" <?php selected( 'rand', $instance['orderby'] ); ?>><?php _e( 'Random', 'harker-2015' ); ?></option>
                </select>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Sort Order', 'harker-2015' ); ?>:</label>
                <select id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
                    <option value="DESC" <?php selected( 'DESC', $instance['order'] ); ?>><?php _e( 'Descending (3, 2, 1)', 'harker-2015' ); ?></option>
                    <option value="ASC" <?php selected( 'ASC', $instance['order'] ); ?>><?php _e( 'Ascending (1, 2, 3)', 'harker-2015' ); ?></option>
                </select>
            </p>

            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'exclude_displayed' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'exclude_displayed' ) ); ?>" value="1" <?php checked( $instance['exclude_displayed'] ); ?>/>
                <label for="<?php echo esc_attr( $this->get_field_id( 'exclude_displayed' ) ); ?>"><?php _e( 'Exclude Previously Displayed Posts?', 'harker-2015' ); ?></label>
            </p>

            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'exclude_sticky' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'exclude_sticky' ) ); ?>" value="1" <?php checked( $instance['exclude_sticky'] ); ?>/>
                <label for="<?php echo esc_attr( $this->get_field_id( 'exclude_sticky' ) ); ?>"><?php _e( 'Exclude Sticky Posts?', 'harker-2015' ); ?></label>
            </p>

        </div>

        <div class="genesis-widget-column-box genesis-widget-column-box-top">

            <h4>Post Content</h4>

            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'show_byline' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_byline' ) ); ?>" value="1" <?php checked( $instance['show_byline'] ); ?>/>
                <label for="<?php echo esc_attr( $this->get_field_id( 'show_byline' ) ); ?>"><?php _e( 'Show Post Info', 'harker-2015' ); ?></label>

                <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'post_info' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_info' ) ); ?>" value="<?php echo esc_attr( $instance['post_info'] ); ?>" class="widefat" />
                <label for="<?php echo esc_attr( $this->get_field_id( 'post_info' ) ); ?>" class="screen-reader-text"><?php _e( 'Content Post Info', 'harker-2015' ); ?></label>

            </p>

        </div>
        <?php

    }

}
