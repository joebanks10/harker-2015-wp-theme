<?php

remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

add_action( 'genesis_footer', 'hkr_do_footer' );

function hkr_do_footer() { ?>

<footer class="section footer">
    <div class="row">
        <div class="column">
            <nav class="footer-nav">
                <ul class="footer-nav-menu row">
                    <li class="column large-5 medium-8">
                        <a href="#">Preschool</a>
                        <ul>
                            <li><a href="#">Academics</a></li>
                            <li><a href="#">Specialty Classes</a></li>
                            <li><a href="#">Teachers</a></li>
                            <li><a href="#">Support &amp; Services</a></li>
                            <li><a href="#">Campus &amp; Facilities</a></li>
                            <li><a href="#">School Community</a></li>
                        </ul>
                    </li>
                    <li class="column large-5 medium-8">
                        <a href="#">Lower School</a>
                        <ul>
                            <li><a href="#">Academics</a></li>
                            <li><a href="#">Programs &amp; Extracurriculars</a></li>
                            <li><a href="#">Teachers</a></li>
                            <li><a href="#">Students</a></li>
                            <li><a href="#">Support &amp; Services</a></li>
                            <li><a href="#">Campus &amp; Facilities</a></li>
                            <li><a href="#">School Community</a></li>
                        </ul>
                    </li>
                    <li class="column large-5 medium-8">
                        <a href="#">Middle School</a>
                        <ul>
                            <li><a href="#">Academics</a></li>
                            <li><a href="#">Programs &amp; Extracurriculars</a></li>
                            <li><a href="#">Teachers</a></li>
                            <li><a href="#">Students</a></li>
                            <li><a href="#">Support &amp; Services</a></li>
                            <li><a href="#">Campus &amp; Facilities</a></li>
                            <li><a href="#">School Community</a></li>
                        </ul>
                    </li>
                    <li class="column large-5 medium-8">
                        <a href="#">Upper School</a>
                        <ul>
                            <li><a href="#">Academics</a></li>
                            <li><a href="#">Programs &amp; Extracurriculars</a></li>
                            <li><a href="#">Teachers</a></li>
                            <li><a href="#">Students</a></li>
                            <li><a href="#">Support &amp; Services</a></li>
                            <li><a href="#">Campus &amp; Facilities</a></li>
                            <li><a href="#">School Community</a></li>
                        </ul>
                    </li>
                    <li class="column large-4 medium-8 end">
                        <ul>
                            <li><a href="#">Admission</a></li>
                            <li><a href="#">Summer</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">News</a></li>
                            <li><a href="#">Alumni</a></li>
                            <li><a href="#">Giving</a></li>
                            <li><a href="#">Portal</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div class="text-center"><div class="harker-logo harker-logo-horiz"><a href="http://www.harker.org">The Harker School</a></div></div>
            <p class="footer-legal">Copyright &copy; 1893-2015 &bull; The Harker School &bull; San Jose, CA 95129 <span class="footer-contact-link">| <a href="page.cfm?p=93" target="_self">Contact Us</a> | <a href="/page.cfm?p=3686" data-page-name="Privacy Policy">Privacy Policy</a></span></p>
            <div class="text-center">
                <ul class="footer-nav-menu-social">
                    <li class="menu-item-followtext">Follow Us!</li>
                    <li class="menu-item-social menu-item-instagram"><a href="http://instagram.com/harkerschool" title="Instagram"></a></li>
                    <li class="menu-item-social menu-item-youtube"><a href="http://youtube.com/harkerschool" title="Youtube"></a></li>
                    <li class="menu-item-social menu-item-twitter"><a href="http://twitter.com/harkerschool" title="Twitter"></a></li>
                    <li class="menu-item-social menu-item-facebook"><a href="http://facebook.com/harkerschool" title="Facebook"></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<?php
}
