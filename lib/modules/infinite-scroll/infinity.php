<?php

if ( hkr_jetpack_module_is_active('infinite-scroll') ) {
    remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
}

add_action( 'wp_enqueue_scripts', 'hkr_infinite_scroll_script' );

function hkr_infinite_scroll_script() {
    if ( hkr_jetpack_module_is_active('infinite-scroll') ) {
        wp_enqueue_script( 'harker-infinite-scroll', CHILD_THEME_DIR_URL . '/lib/modules/infinite-scroll/infinity.js', array('the-neverending-homepage'), CHILD_THEME_VERSION, true );
    }
}

add_filter( 'infinite_scroll_results', 'hkr_infinite_scroll_results' );

/**
 * Add max pages to AJAX response
 * @param  array $results Results of AJAX request
 * @return array          Filtered results
 */
function hkr_infinite_scroll_results($results) {
    if ( '' === get_option( The_Neverending_Home_Page::$option_name_enabled ) ) {
        return $results;
    }

    $max_pages = get_option( 'hkr_infinite_scroll_pages' );
    if ( ! $max_pages ) {
        return $results;
    }

    $results['max_pages'] = (int) $max_pages;

    return $results;
}

// admin
add_action( 'admin_init', 'hkr_infinite_scroll_settings', 15 );

/**
 * Add admin meta boxes for options
 */
function hkr_infinite_scroll_settings() {
    // Add the setting field and place it in Settings > Reading
    add_settings_field( 'hkr_infinite_scroll_pages', '<span id="hkr-infinite-scroll-options">' . __( 'Infinite scroll options', 'harker-2015' ) . '</span>', 'hkr_infinite_setting_html', 'reading' );
    register_setting( 'reading', 'hkr_infinite_scroll_pages', 'hkr_infinite_scroll_pages_validate' );
}

function hkr_infinite_setting_html() {
    $current = get_option( 'hkr_infinite_scroll_pages' );

    echo '<label>Stop infinite scroll on page:</label> <input name="hkr_infinite_scroll_pages" type="number" min="2" max="99" value="' . $current . '" />';
}

function hkr_infinite_scroll_pages_validate($input) {
    $input = (int) $input;

    if ( $input < 2 || $input > 99 ) {
        return '';
    } else {
        return $input;
    }
}

// helpers
function hkr_jetpack_module_is_active($module) {
    return (class_exists( 'Jetpack' ) && Jetpack::is_module_active( $module ));
}
