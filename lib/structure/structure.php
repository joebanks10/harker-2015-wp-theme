<?php

add_filter( 'genesis_attr_structural-wrap', 'hkr_attributes_structural_wrap' );
    
function hkr_attributes_structural_wrap( $attributes ) {

    $site_layout = genesis_site_layout();

    $attributes['class'] = 'row';

    return $attributes;

}

add_filter( 'genesis_attr_site-inner', 'hkr_attributes_site_inner' );

function hkr_attributes_site_inner( $attributes ) {

    $attributes['id'] = 'intro';
    $attributes['data-magellan-destination'] = 'intro';

    return $attributes;

}