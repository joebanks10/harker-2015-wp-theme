<?php
/**
 * Featured Post Feed. Modified version of Genesis Featured Post widget class.
 *
 * @since 0.1.8
 *
 * @package Genesis\Widgets
 */
class HKR_Featured_Posts extends WP_Widget {

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
            'classname'   => 'featured-content featured-posts',
            'description' => __( 'Displays posts with thumbnails', 'harker-2015' ),
        );

        $control_ops = array(
            'id_base' => 'featured-post',
            'width'   => 505,
            'height'  => 350,
        );

        // add actions and filters
        add_action( 'hkr_before_featured_post_widget_content', array($this, 'large_featured_image') );
        add_filter( 'genesis_attr_featured-post', array($this, 'post_class') );

        parent::__construct( 'featured-post', __( 'Featured Posts (harker)', 'harker-2015' ), $widget_ops, $control_ops );

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

        if ( ! empty($instance['headlines_num']) && $instance['headlines_num'] + 1 > $wp_query->post_count ) {
            $instance['headlines_num'] = $wp_query->post_count - 1;
        }

        echo $args['before_widget'];
        do_action( 'hkr_before_featured_post_widget_content', $instance );

        // the widget title
        if ( ! empty( $instance['title'] ) )
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];

        // the post loop
        if ( have_posts() ) : while ( have_posts() ) : the_post();
            $_genesis_displayed_ids[] = get_the_ID();

            // open headlines elements
            if ( ! empty($instance['headlines_num']) ) {
                
                if ( $wp_query->current_post == 0 ) {
                    echo '<div class="featured-post-1-headlines-wrap">';
                } 
                else if ( $wp_query->current_post == 1 ) {
                    echo '<div class="featured-headlines">';
                    
                    if ( ! empty($instance['headlines_title']) )
                        echo '<div class="featured-headlines-header">' . esc_html( $instance['headlines_title'] ) . '</div>';
                    
                    echo '<ul class="featured-headlines-list">';
                }

            }

            // the post
            if ( ! empty($instance['headlines_num']) && $wp_query->current_post > 0 && $wp_query->current_post < (1 + $instance['headlines_num']) ) {
                $this->post_list_item( $args, $instance );
            } 
            else {
                $this->post_article( $args, $instance );
            }

            // close headlines elements
            if ( ! empty($instance['headlines_num']) ) {

                if ( $wp_query->current_post == $instance['headlines_num'] ) {
                    echo '</ul></div></div>';
                }

            }

        endwhile; endif; 
        wp_reset_query();

        // the more posts link
        if ( ! empty( $instance['more_from_category'] ) && $url = $this->get_archive_url( $instance ) ) {
            printf(
                '<p class="featured-posts-more"><a href="%1$s">%2$s</a></p>',
                esc_url( $url ),
                esc_html( $instance['more_from_category_text'] )
            );
        }

        do_action( 'hkr_after_featured_post_widget_content', $instance );
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

    function large_featured_image( $instance ) {
        global $wp_query;

        if ( ! $instance['show_large_image'] ) 
            return;

        if ( have_posts() ) : 
            the_post();

            $post_id = get_the_ID();
            $size = 'large';

            $anchor_class = "entry-image-link entry-image-link-$post_id entry-image-$size-link";
            $image = genesis_get_image( array(
                'format'  => 'html',
                'size'    => $size,
                'context' => 'featured-post-widget',
                'attr'    => genesis_parse_attr( 'entry-image-widget', array ( 'alt' => get_the_title() ) ),
            ) );

            if ( $instance['show_large_image'] && $image ) {
                $role = empty( $instance['show_title'] ) ? '' : 'aria-hidden="true"';
                printf( '<a href="%s" class="%s" %s>%s</a>', get_permalink(), esc_attr( $anchor_class ), $role, $image );
            }

        endif;

        rewind_posts();

    }

    function post_article( $args, $instance ) {
        global $wp_query;

        genesis_markup( array(
            'html5'   => '<article %s>',
            'xhtml'   => sprintf( '<div class="%s">', implode( ' ', get_post_class() ) ),
            'context' => 'featured-post',
        ) );

        $image = genesis_get_image( array(
            'format'  => 'html',
            'size'    => $instance['image_size'],
            'context' => 'featured-post-widget',
            'attr'    => genesis_parse_attr( 'entry-image-widget', array ( 'alt' => get_the_title() ) ),
        ) );

        if ( $instance['show_image'] && $image && ! ($instance['show_large_image'] && $wp_query->current_post == 0 ) ) {
            $role = empty( $instance['show_title'] ) ? '' : 'aria-hidden="true"';
            printf( '<a href="%s" class="%s" %s>%s</a>', get_permalink(), esc_attr( $instance['image_alignment'] ), $role, $image );
        }

        if ( ! empty( $instance['show_gravatar'] ) ) {
            echo '<span class="' . esc_attr( $instance['gravatar_alignment'] ) . '">';
            echo get_avatar( get_the_author_meta( 'ID' ), $instance['gravatar_size'] );
            echo '</span>';
        }

        if ( $instance['show_title'] )
            echo genesis_html5() ? '<header class="entry-header">' : '';

        $this->post_title( $args, $instance );

        if ( ! empty( $instance['show_byline'] ) && ! empty( $instance['post_info'] ) )
            printf( genesis_html5() ? '<p class="entry-meta">%s</p>' : '<p class="byline post-info">%s</p>', do_shortcode( $instance['post_info'] ) );

        if ( $instance['show_title'] )
            echo genesis_html5() ? '</header>' : '';

        if ( ! empty( $instance['show_content'] ) ) {

            echo genesis_html5() ? '<div class="entry-content">' : '';

            if ( 'excerpt' == $instance['show_content'] ) {
                the_excerpt();
            }
            elseif ( 'content-limit' == $instance['show_content'] ) {
                the_content_limit( (int) $instance['content_limit'], genesis_a11y_more_link( esc_html( $instance['more_text'] ) ) );
            }
            else {

                global $more;

                $orig_more = $more;
                $more = 0;

                the_content( genesis_a11y_more_link( esc_html( $instance['more_text'] ) ) );

                $more = $orig_more;

            }

            echo genesis_html5() ? '</div>' : '';

        }

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

        if ( empty( $instance['show_title'] ) ) 
            return;

        $title = get_the_title() ? get_the_title() : __( '(no title)', 'harker-2015' );

        $title = apply_filters( 'genesis_featured_post_title', $title, $instance, $args );
        $heading = genesis_a11y( 'headings' ) ? 'h4' : 'h2';

        if ( genesis_html5() )
            printf( '<%s class="entry-title"><a href="%s">%s</a></%s>', $heading, get_permalink(), $title, $heading );
        else
            printf( '<%s><a href="%s">%s</a></%s>', $heading, get_permalink(), $title, $heading );
    }

    function post_class( $attributes ) {
        global $wp_query;

        $classes = get_post_class();
        $classes[] = 'featured-post-' . ($wp_query->current_post + 1);

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
        $new_instance['more_text'] = strip_tags( $new_instance['more_text'] );
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

        <div class="genesis-widget-column">

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
                    <label for="<?php echo $this->get_field_id( 'posts_tag' ); ?>"><?php _e( 'Tag', 'harker-2015' ); ?>:</label><br>
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

            <div class="genesis-widget-column-box">

                <h4>Author Gravatar</h4>
                <p>
                    <input id="<?php echo esc_attr( $this->get_field_id( 'show_gravatar' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_gravatar' ) ); ?>" value="1" <?php checked( $instance['show_gravatar'] ); ?>/>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'show_gravatar' ) ); ?>"><?php _e( 'Show Author Gravatar', 'harker-2015' ); ?></label>
                    <input type="hidden" id="<?php echo esc_attr( $this->get_field_id( 'gravatar_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'gravatar_size' ) ); ?>" value="45" />
                </p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'gravatar_alignment' ) ); ?>"><?php _e( 'Gravatar Alignment', 'genesis' ); ?>:</label>
                    <select id="<?php echo esc_attr( $this->get_field_id( 'gravatar_alignment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'gravatar_alignment' ) ); ?>">
                        <option value="alignnone">- <?php _e( 'None', 'genesis' ); ?> -</option>
                        <option value="alignleft" <?php selected( 'alignleft', $instance['gravatar_alignment'] ); ?>><?php _e( 'Left', 'genesis' ); ?></option>
                        <option value="alignright" <?php selected( 'alignright', $instance['gravatar_alignment'] ); ?>><?php _e( 'Right', 'genesis' ); ?></option>
                    </select>
                </p>

            </div>

            <div class="genesis-widget-column-box">

                <h4>Featured Image</h4>
                <p>
                    <input id="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_image' ) ); ?>" value="1" <?php checked( $instance['show_image'] ); ?>/>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>"><?php _e( 'Show Featured Image', 'harker-2015' ); ?></label>
                </p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>"><?php _e( 'Image Size', 'harker-2015' ); ?>:</label>
                    <select id="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>" class="genesis-image-size-selector" name="<?php echo esc_attr( $this->get_field_name( 'image_size' ) ); ?>">
                        <?php
                        $sizes = genesis_get_image_sizes();
                        foreach( (array) $sizes as $name => $size )
                            #echo '<option value="' . esc_attr( $name ) . '" '. selected( $name, $instance['image_size'], FALSE ) . '>' . esc_html( $name ) . ' ( ' . esc_html( $size['width'] ) . 'x' . esc_html( $size['height'] ) . ' )</option>';
                            printf( '<option value="%s" %s>%s (%sx%s)</option>', esc_attr( $name ), selected( $name, $instance['image_size'], 0 ), esc_html( $name ), esc_html( $size['width'] ), esc_html( $size['height'] ) );
                        ?>
                    </select>
                </p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'image_alignment' ) ) ; ?>"><?php _e( 'Image Alignment', 'harker-2015' ); ?>:</label>
                    <select id="<?php echo esc_attr( $this->get_field_id( 'image_alignment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_alignment' ) ); ?>">
                        <option value="alignnone">- <?php _e( 'None', 'harker-2015' ); ?> -</option>
                        <option value="alignleft" <?php selected( 'alignleft', $instance['image_alignment'] ); ?>><?php _e( 'Left', 'harker-2015' ); ?></option>
                        <option value="alignright" <?php selected( 'alignright', $instance['image_alignment'] ); ?>><?php _e( 'Right', 'harker-2015' ); ?></option>
                        <option value="aligncenter" <?php selected( 'aligncenter', $instance['image_alignment'] ); ?>><?php _e( 'Center', 'harker-2015' ); ?></option>
                    </select>
                </p>

                <p>
                    <input id="<?php echo esc_attr( $this->get_field_id( 'show_large_image' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_large_image' ) ); ?>" value="1" <?php checked( $instance['show_large_image'] ); ?>/>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'show_large_image' ) ); ?>"><?php _e( 'Show a large Featured Image for the first post', 'harker-2015' ); ?></label>
                </p>

            </div>

        </div>

        <div class="genesis-widget-column genesis-widget-column-right">

            <div class="genesis-widget-column-box genesis-widget-column-box-top">

                <h4>Post Content</h4>
                <p>
                    <input id="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_title' ) ); ?>" value="1" <?php checked( $instance['show_title'] ); ?>/>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>"><?php _e( 'Show Post Title', 'harker-2015' ); ?></label>
                </p>

                <p>
                    <input id="<?php echo esc_attr( $this->get_field_id( 'show_byline' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_byline' ) ); ?>" value="1" <?php checked( $instance['show_byline'] ); ?>/>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'show_byline' ) ); ?>"><?php _e( 'Show Post Info', 'harker-2015' ); ?></label>

                    <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'post_info' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_info' ) ); ?>" value="<?php echo esc_attr( $instance['post_info'] ); ?>" class="widefat" />
                    <label for="<?php echo esc_attr( $this->get_field_id( 'post_info' ) ); ?>" class="screen-reader-text"><?php _e( 'Content Post Info', 'harker-2015' ); ?></label>

                </p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>"><?php _e( 'Content Type', 'harker-2015' ); ?>:</label>
                    <select id="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_content' ) ); ?>">
                        <option value="content" <?php selected( 'content', $instance['show_content'] ); ?>><?php _e( 'Show Content', 'harker-2015' ); ?></option>
                        <option value="excerpt" <?php selected( 'excerpt', $instance['show_content'] ); ?>><?php _e( 'Show Excerpt', 'harker-2015' ); ?></option>
                        <option value="content-limit" <?php selected( 'content-limit', $instance['show_content'] ); ?>><?php _e( 'Show Content Limit', 'harker-2015' ); ?></option>
                        <option value="" <?php selected( '', $instance['show_content'] ); ?>><?php _e( 'No Content', 'harker-2015' ); ?></option>
                    </select>
                    <br />
                    <label for="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>"><?php _e( 'Limit content to', 'harker-2015' ); ?>
                        <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_limit' ) ); ?>" value="<?php echo esc_attr( intval( $instance['content_limit'] ) ); ?>" size="3" />
                        <?php _e( 'characters', 'harker-2015' ); ?>
                    </label>
                </p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>"><?php _e( 'More Text (if applicable)', 'harker-2015' ); ?>:</label>
                    <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_text' ) ); ?>" value="<?php echo esc_attr( $instance['more_text'] ); ?>" />
                </p>

            </div>

            <div class="genesis-widget-column-box">

                <h4>Headlines</h4>
                <p id="<?php echo esc_attr( $this->get_field_id( 'headlines_title' ) ); ?>-descr"><?php _e( 'To display a small list of headlines after the first post, please fill out the information below:', 'genesis' ); ?>:</p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'headlines_title' ) ); ?>"><?php _e( 'Title', 'genesis' ); ?>:</label>
                    <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'headlines_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'headlines_title' ) ); ?>" value="<?php echo esc_attr( $instance['headlines_title'] ); ?>" class="widefat" aria-describedby="<?php echo esc_attr( $this->get_field_id( 'headlines_title' ) ); ?>-descr" />
                </p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'headlines_num' ) ); ?>"><?php _e( 'Number of Headlines to Display', 'genesis' ); ?>:</label>
                    <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'headlines_num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'headlines_num' ) ); ?>" value="<?php echo esc_attr( $instance['headlines_num'] ); ?>" size="2" />
                </p>

            </div>

            <div class="genesis-widget-column-box">

                <h4>More Link</h4>
                <p>
                    <input id="<?php echo esc_attr( $this->get_field_id( 'more_from_category' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'more_from_category' ) ); ?>" value="1" <?php checked( $instance['more_from_category'] ); ?>/>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'more_from_category' ) ); ?>"><?php _e( 'Show Category Archive Link', 'harker-2015' ); ?></label>
                </p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'more_from_category_text' ) ); ?>"><?php _e( 'Link Text', 'harker-2015' ); ?>:</label>
                    <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'more_from_category_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_from_category_text' ) ); ?>" value="<?php echo esc_attr( $instance['more_from_category_text'] ); ?>" class="widefat" />
                </p>

            </div>

        </div>
        <?php

    }

}
