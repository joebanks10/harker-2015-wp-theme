<?php

add_filter( 'genesis_theme_settings_defaults', 'hkr_theme_ops_defaults' );

function hkr_theme_ops_defaults( $defaults ) {
    $defaults['single_thumbnail'] = 0;
    $defaults['single_thumbnail_format'] = 'genesis_entry_header';
    $defaults['condensed_theme'] = 0;
    $defaults['featured_first_post'] = 0;
    $defaults['hkr_archive_post_info'] = '';
    return $defaults;
}


add_action( 'genesis_settings_sanitizer_init', 'hkr_theme_ops_sanitization_filters' );

function hkr_theme_ops_sanitization_filters() {
    genesis_add_option_filter( 
        'one_zero', 
        GENESIS_SETTINGS_FIELD,
        array(
            'single_thumbnail'
        ) 
    );
    genesis_add_option_filter( 
        'no_html', 
        GENESIS_SETTINGS_FIELD,
        array(
            'single_thumbnail_format'
        ) 
    );
    genesis_add_option_filter( 
        'one_zero', 
        GENESIS_SETTINGS_FIELD,
        array(
            'condensed_theme'
        ) 
    );
    genesis_add_option_filter( 
        'one_zero', 
        GENESIS_SETTINGS_FIELD,
        array(
            'featured_first_post'
        ) 
    );
    genesis_add_option_filter( 
        'safe_html', 
        GENESIS_SETTINGS_FIELD,
        array(
            'hkr_archive_post_info'
        ) 
    );
}


add_action( 'genesis_theme_settings_metaboxes', 'hkr_settings_boxes' );

function hkr_settings_boxes( $_genesis_theme_settings_pagehook ) {
    remove_meta_box( 'genesis-theme-settings-header', $_genesis_theme_settings_pagehook, 'main' );
    add_meta_box( 'hkr-single-settings', __( 'Single View', 'harker-2015' ), 'hkr_single_settings_box_content', $_genesis_theme_settings_pagehook, 'main');
    add_meta_box( 'hkr-extra-settings', __( 'Theme Extras', 'harker-2015' ), 'hkr_extras_box_content', $_genesis_theme_settings_pagehook, 'main');
}

function hkr_single_settings_box_content() {
    ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row">
                    Featured Image
                </th>
                <td>
                    <p><span class="description">Configure how featured images display by default in a single post/page. You'll be able to customize these settings for each post/page.</span></p>
                    <p>
                        <label for="<?php hkr_settings_field_name('single_thumbnail'); ?>"><input type="checkbox" name="<?php hkr_settings_field_name('single_thumbnail'); ?>" id="<?php hkr_settings_field_name('single_thumbnail'); ?>" value="1"<?php checked( genesis_get_option('single_thumbnail') ); ?> />
                        <?php _e( 'Display the Featured Image?', 'harker-2015' ); ?></label>
                    </p>
                    <div id="genesis_post_image_extras">
                        <p>
                            <label for="<?php hkr_settings_field_name('single_thumbnail_format'); ?>"><?php _e( 'Display Featured Image as:', 'harker-2015' ); ?></label>
                            <select name="<?php hkr_settings_field_name('single_thumbnail_format'); ?>" id="<?php hkr_settings_field_name('single_thumbnail_format'); ?>">
                                <?php
                                $formats = array( 
                                    'square' => 'Square',
                                    'content' => 'Content', 
                                    'banner' => 'Banner',
                                    'hero' => 'Hero'
                                );
                                foreach ( $formats as $format => $description )
                                    echo '<option value="' . $format . '"' . selected( genesis_get_option('single_thumbnail_format'), $format, FALSE ) . '>' . $description . '</option>' . "\n";
                                ?>
                            </select>
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

function hkr_extras_box_content() {
    ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row">
                    Condensed Theme
                </th>
                <td>
                    <p><span class="description">The condensed theme reduces the size of content and white space in order to list more stories "above the fold". This theme is used for Harker News.</span></p>
                    <p>
                        <label for="<?php hkr_settings_field_name('condensed_theme'); ?>"><input type="checkbox" name="<?php hkr_settings_field_name('condensed_theme'); ?>" id="<?php hkr_settings_field_name('condensed_theme'); ?>" value="1"<?php checked( genesis_get_option('condensed_theme') ); ?> />
                        <?php _e( 'Use condensed theme?', 'harker-2015' ); ?></label>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" colspan="2" style="padding: 0;">
                    <h3>Content Archive</h3>
                </th>
            </tr>
            <tr valign="top">
                <th scope="row">
                    Featured First Post
                </th>
                <td>
                    <p><span class="description">Feature the first post with a photo on the home page.</span></p>
                    <p>
                        <label for="<?php hkr_settings_field_name('featured_first_post'); ?>"><input type="checkbox" name="<?php hkr_settings_field_name('featured_first_post'); ?>" id="<?php hkr_settings_field_name('featured_first_post'); ?>" value="1"<?php checked( genesis_get_option('featured_first_post') ); ?> />
                        <?php _e( 'Feature first post?', 'harker-2015' ); ?></label>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="<?php hkr_settings_field_name('hkr_archive_post_info'); ?>"><?php _e( 'Post Info', 'harker-2015' ); ?></label>
                </th>
                <td>
                    <p><span class="description">Use shortcodes to print post meta info. <a href="http://my.studiopress.com/docs/shortcode-reference/" target="_blank">See shortcode reference</a></span></p>
                    <p>
                        <input type="text" class="regular-text" name="<?php hkr_settings_field_name('hkr_archive_post_info'); ?>" id="<?php hkr_settings_field_name('hkr_archive_post_info'); ?>" value="<?php echo esc_html(genesis_get_option('hkr_archive_post_info')); ?>" />
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

function hkr_settings_field_name($name) {
    echo GENESIS_SETTINGS_FIELD . '[' . $name . ']';
}

// Template Helpers

function is_condensed_theme() {
    return (bool) genesis_get_option('condensed_theme');
}

function feature_first_post() {
    return (bool) genesis_get_option('featured_first_post');
}
