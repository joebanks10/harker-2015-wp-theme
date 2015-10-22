<?php

remove_action('genesis_header', 'genesis_do_header');
remove_action('genesis_header', 'genesis_header_markup_open', 5);
remove_action('genesis_header', 'genesis_header_markup_close', 15);

add_action( 'template_redirect', 'hkr_add_header' );

function hkr_add_header() {

    if ( has_single_thumbnail('hero') ) {
        add_action('genesis_after_header', 'hkr_do_header', 20);
    } else {
        add_action('genesis_header', 'hkr_do_header');
    }

}

function hkr_do_header() { ?>

    <header class="nav-bar site-header">
        <div class="brand-bar">
            <nav class="primary-nav">
                <ul class="primary-nav-menu primary-nav-menu-home">
                    <li class="harker-logo"><a href="/">The Harker School</a></li>
                </ul>
                <ul class="primary-nav-menu primary-nav-menu-secondary">
                    <li class="menu-item-social menu-item-instagram"><a href="http://instagram.com/harkerschool" title="Instagram"></a></li>
                    <li class="menu-item-social menu-item-youtube"><a href="http://youtube.com/harkerschool" title="Youtube"></a></li>
                    <li class="menu-item-social menu-item-twitter"><a href="http://twitter.com/harkerschool" title="Twitter"></a></li>
                    <li class="menu-item-social menu-item-facebook"><a href="http://facebook.com/harkerschool" title="Facebook"></a></li>
                    <li class="menu-item-search"><a href="http://search.harker.org" title="Search"></a></li>
                    <li class="menu-item-login"><a href="http://www.harker.org/page.cfm?p=196" title="Login"></a></li>
                </ul>
                <ul class="primary-nav-menu primary-nav-menu-sections">
                    <li class="menu-item-hamburger"><a href="#global-nav" title="Menu"><span class="menu-item-text">Menu</span></a></li>
                    <li><a href="/admission">Admission</a></li>
                    <li><a href="/preschool">Preschool</a></li>
                    <li><a href="/lower-school">Lower School</a></li>
                    <li><a href="/middle-school">Middle School</a></li>
                    <li><a href="/upper-school">Upper School</a></li>
                    <li><a href="/summer">Summer</a></li>
                    <li class="menu-item-more">
                        <a href="#more-sections" data-dropdown="more-sections" aria-controls="more-sections" aria-expanded="false"><span>More</span></a>
                        <ul id="more-sections" class="f-dropdown" data-dropdown-content aria-hidden="true">
                            <li class="more-sections-item"><a href="/about">About</a></li>
                            <li class="more-sections-item"><a href="/news">News</a></li>
                            <li class="more-sections-item"><a href="/alumni">Alumni</a></li>
                            <li class="more-sections-item"><a href="/giving">Giving</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="current-site-bar">
            <nav class="current-site-nav">
                <ul class="current-site-menu current-site-menu-meta">
                    <li class="current-site-title"><?php do_action( 'genesis_site_title' ); ?></li>
                    <li class="current-site-tagline"><?php do_action( 'genesis_site_description' ); ?></li>
                </ul>
                <?php do_action( 'hkr_current_site_menu_items' ); ?>
            </nav>
        </div>
    </header>

<?php
}

remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
add_action( 'genesis_site_description', 'hkr_seo_site_description' );

function hkr_seo_site_description() {

    //* Set what goes inside the wrapping tags
    $inside = '<span>' . esc_html( get_bloginfo( 'description' ) ) . '</span>';

    //* Determine which wrapping tags to use
    $wrap = is_home() && 'description' === genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : 'p';

    //* And finally, $wrap in h2 if HTML5 & semantic headings enabled
    $wrap = genesis_html5() && genesis_get_seo_option( 'semantic_headings' ) ? 'h2' : $wrap;

    //* Build the description
    $description  = genesis_html5() ? sprintf( "<{$wrap} %s>", genesis_attr( 'site-description' ) ) : sprintf( '<%s id="description">%s</%s>', $wrap, $inside, $wrap );
    $description .= genesis_html5() ? "{$inside}</{$wrap}>" : '';

    //* Output (filtered)
    $output = $inside ? apply_filters( 'genesis_seo_description', $description, $inside, $wrap ) : '';

    echo $output;

}
