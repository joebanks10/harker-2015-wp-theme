<?php

add_action( 'genesis_before', 'hkr_aesop_body_markup' );

function hkr_aesop_body_markup() {
    do_action( 'ase_theme_body_inside_top' );
}

add_filter( 'genesis_attr_entry-content', 'hkr_aesop_entry_content_class' );

function hkr_aesop_entry_content_class( $attr ) {
    $attr['class'] .= ' aesop-entry-content';

    return $attr;
}

add_filter( 'genesis_attr_entry-header', 'hkr_aesop_entry_header_class' );

function hkr_aesop_entry_header_class( $attr ) {
    $attr['class'] .= ' aesop-entry-header';

    return $attr;
}
