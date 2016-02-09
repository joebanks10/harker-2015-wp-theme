<?php

add_filter( 'admin_post_thumbnail_html', 'hkr_post_single_thumbnail_fields' );

function hkr_post_single_thumbnail_fields( $content ) {
    ob_start();

    wp_nonce_field( 'hkr_post_single_thumbnail_save', 'hkr_post_single_thumbnail_nonce' );

    ?>
    <hr />
    <p>
        <label for="home-banner-image">
            <input type="checkbox" name="<?php hkr_post_field_name('_hkr_hide_home_banner_image'); ?>" id="home-banner-image" value="1"<?php checked( genesis_get_custom_field('_hkr_hide_home_banner_image') ); ?> />
            <?php _e( 'Do not display in home page banner.' ); ?>
        </label>
    </p>
    <hr />
    <p>
        <label for="custom-single-thumbnail">
            <input type="checkbox" name="<?php hkr_post_field_name('_hkr_custom_single_thumbnail'); ?>" id="custom-single-thumbnail" value="1"<?php checked( genesis_get_custom_field('_hkr_custom_single_thumbnail') ); ?> />
            <?php printf( __( 'Customize the <a href="%s" target="_blank" title="See default settings">Featured Image display settings</a> for this post.', 'harker-2015' ), menu_page_url( 'genesis', 0 ) . '#hkr-single-settings' ); ?>
        </label>
    </p>
    <div id="hkr_single_thumbnail_settings">
        <p>
            <label for="<?php hkr_post_field_name('_hkr_single_thumbnail'); ?>"><input type="checkbox" name="<?php hkr_post_field_name('_hkr_single_thumbnail'); ?>" id="<?php hkr_post_field_name('_hkr_single_thumbnail'); ?>" value="1"<?php checked( genesis_get_custom_field('_hkr_single_thumbnail') ); ?> />
            <?php _e( 'Display the Featured Image?', 'harker-2015' ); ?></label>
        </p>
        <p>
            <label for="<?php hkr_post_field_name('_hkr_single_thumbnail_format'); ?>"><?php _e( 'Display Featured Image as:', 'harker-2015' ); ?></label>
            <select name="<?php hkr_post_field_name('_hkr_single_thumbnail_format'); ?>" id="<?php hkr_post_field_name('_hkr_single_thumbnail_format'); ?>">
                <?php
                $formats = array( 
                    'square' => 'Square',
                    'content' => 'Content', 
                    'banner' => 'Banner',
                    'hero' => 'Hero'
                );
                foreach ( $formats as $format => $description )
                    echo '<option value="' . $format . '"' . selected( genesis_get_custom_field('_hkr_single_thumbnail_format'), $format, FALSE ) . '>' . $description . '</option>' . "\n";
                ?>
            </select>
        </p>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var $form = $('#hkr_single_thumbnail_settings');
                $checkbox = $('#custom-single-thumbnail');

            if ( ! $checkbox[0].checked ) {
                $form.hide();
            }
            
            $('#custom-single-thumbnail').change(function(){
                if ( this.checked ) {
                    $form.show();
                } else {
                    $form.hide();
                }
            });
        });
    </script>
    <?php

    $output = ob_get_contents();
    ob_end_clean();

    return $content . $output;

}

function hkr_post_field_name($name) {
    echo 'hkr_feature_image[' . $name . ']';
}

add_action( 'save_post', 'hkr_post_single_thumbnail_save', 1, 2 );

function hkr_post_single_thumbnail_save( $post_id, $post ) {

    if ( ! isset( $_POST['hkr_feature_image'] ) )
        return;

    $data = wp_parse_args( $_POST['hkr_feature_image'], array(
        '_hkr_hide_home_banner_image' => '',
        '_hkr_custom_single_thumbnail' => '',
        '_hkr_single_thumbnail' => '',
        '_hkr_single_thumbnail_format' => '',
    ) );

    $data = array_map( 'genesis_sanitize_html_classes', $data );

    genesis_save_custom_fields( $data, 'hkr_post_single_thumbnail_save', 'hkr_post_single_thumbnail_nonce', $post );

}
