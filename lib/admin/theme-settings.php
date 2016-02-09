<?php

add_filter( 'genesis_theme_settings_defaults', 'hkr_theme_ops_defaults' );

function hkr_theme_ops_defaults( $defaults ) {
    $defaults['single_thumbnail'] = 0;
    $defaults['single_thumbnail_format'] = 'genesis_entry_header';
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
}


add_action( 'genesis_theme_settings_metaboxes', 'hkr_settings_boxes' );

function hkr_settings_boxes( $_genesis_theme_settings_pagehook ) {
    remove_meta_box( 'genesis-theme-settings-header', $_genesis_theme_settings_pagehook, 'main' );
    add_meta_box( 'hkr-single-settings', __( 'Featured Image Display Settings for Single Posts/Pages', 'harker-2015' ), 'hkr_single_settings_box_content', $_genesis_theme_settings_pagehook, 'main');
}

function hkr_single_settings_box_content() {
    ?>
    <p>Use these settings to configure how featured images display by default in a single post/page. You'll be able to customize these settings for each post/page.</p>
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
    <?php
}

function hkr_settings_field_name($name) {
    echo GENESIS_SETTINGS_FIELD . '[' . $name . ']';
}
