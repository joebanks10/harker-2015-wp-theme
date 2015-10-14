<?php

add_filter( 'genesis_theme_settings_defaults', 'hkr_theme_ops_defaults' );

function hkr_theme_ops_defaults( $defaults ) {
    $defaults['single_thumbnail'] = 0;
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
}


add_action( 'genesis_theme_settings_metaboxes', 'hkr_single_settings_box' );

function hkr_single_settings_box( $_genesis_theme_settings_pagehook ) {
    add_meta_box( 'hkr-single-settings', __( 'Single Posts', 'genesis' ), 'hkr_single_settings_box_content', $_genesis_theme_settings_pagehook, 'main');
}

function hkr_single_settings_box_content() {
    ?>
    <p>
        <label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[single_thumbnail]"><input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[single_thumbnail]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[single_thumbnail]" value="1"<?php checked( genesis_get_option('single_thumbnail') ); ?> />
        <?php _e( 'Include the Featured Image?', 'genesis' ); ?></label>
    </p>
    <?php
}
