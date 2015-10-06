<?php

remove_action('genesis_header', 'genesis_do_header');
remove_action('genesis_header', 'genesis_header_markup_open', 5);
remove_action('genesis_header', 'genesis_header_markup_close', 15);

add_action('genesis_header', 'hkr_do_header');

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
    <div class="current-page-bar">
        <nav class="current-page-nav" data-magellan-expedition="current-page-nav">
            <ul class="current-page-menu current-page-menu-meta">
                <li class="current-page-title"><a href="#top">Sections</a></li>
            </ul>
            <ul class="current-page-menu current-page-menu-bookmarks">
            </ul>
        </nav>
    </div>
</header>

<?php
}
