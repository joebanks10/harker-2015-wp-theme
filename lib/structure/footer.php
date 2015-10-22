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

add_action( 'genesis_after_footer', 'hkr_do_global_nav' );

function hkr_do_global_nav() {
?>

<div id="global-nav" class="global-nav">
    <nav>
        <ul class="fsNavLevel1">
            <li class="fsNavParentPage">
                <a data-pageid="17" href="http://www.harker.org/admission">Admission</a>
                <div class="fsNavPageInfo">
                    <ul class="fsNavLevel2">
                        <li>
                            <a data-pageid="23" href="http://www.harker.org/admission/request-information">Request Information</a>
                        </li>
                        <li>
                            <a data-pageid="25" href="http://www.harker.org/admission/campus-visits">Campus Visits</a>
                        </li>
                        <li>
                            <a data-pageid="29" href="http://www.harker.org/admission/applying-to-harker">Applying to Harker</a>
                        </li>
                        <li>
                            <a data-pageid="18" href="http://www.harker.org/admission/tuition-financial-aid">Tuition &amp; Financial Aid</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="fsNavParentPage">
                <a data-pageid="8" href="http://www.harker.org/preschool">Preschool</a>
                <div class="fsNavPageInfo">
                    <ul class="fsNavLevel2">
                        <li>
                            <a data-pageid="119" href="http://www.harker.org/preschool/threes-and-fours-academics">3s &amp; 4s Academics</a>
                        </li>
                        <li>
                            <a data-pageid="248" href="http://www.harker.org/preschool/transitional-kindergarten-academics">Transitional Kindergarten Academics</a>
                        </li>
                        <li>
                            <a data-pageid="99" href="http://www.harker.org/preschool/specialty-classes">Specialty Classes</a>
                        </li>
                        <li>
                            <a data-pageid="120" href="http://www.harker.org/preschool/teachers">Teachers</a>
                        </li>
                        <li>
                            <a data-pageid="171" href="http://www.harker.org/preschool/support-services">Support &amp; Services</a>
                        </li>
                        <li>
                            <a data-pageid="108" href="http://www.harker.org/preschool/campus-facilities">Campus &amp; Facilities</a>
                        </li>
                        <li>
                            <a data-pageid="43" href="http://www.harker.org/school-community">School Community</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="fsNavParentPage">
                <a data-pageid="6" href="http://www.harker.org/lower-school">Lower School</a>
                <div class="fsNavPageInfo">
                    <ul class="fsNavLevel2">
                        <li>
                            <a data-pageid="30" href="http://www.harker.org/lower-school/academics">Academics</a>
                        </li>
                        <li>
                            <a data-pageid="31" href="http://www.harker.org/lower-school/programs-extracurriculars">Programs &amp; Extracurriculars</a>
                        </li>
                        <li>
                            <a data-pageid="34" href="http://www.harker.org/lower-school/teachers">Teachers</a>
                        </li>
                        <li>
                            <a data-pageid="36" href="http://www.harker.org/lower-school/students">Students</a>
                        </li>
                        <li>
                            <a data-pageid="154" href="http://www.harker.org/lower-school/support-services">Support &amp; Services</a>
                        </li>
                        <li>
                            <a data-pageid="150" href="http://www.harker.org/lower-school/campus-facilities">Campus &amp; Facilities</a>
                        </li>
                        <li>
                            <a data-pageid="40" href="http://www.harker.org/school-community">School Community</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="fsNavParentPage">
                <a data-pageid="7" href="http://www.harker.org/middle-school">Middle School</a>
                <div class="fsNavPageInfo">
                    <ul class="fsNavLevel2">
                        <li>
                            <a data-pageid="50" href="http://www.harker.org/middle-school/academics">Academics</a>
                        </li>
                        <li>
                            <a data-pageid="51" href="http://www.harker.org/middle-school/programs-extracurriculars">Programs &amp; Extracurriculars</a>
                        </li>
                        <li>
                            <a data-pageid="52" href="http://www.harker.org/middle-school/teachers">Teachers</a>
                        </li>
                        <li>
                            <a data-pageid="53" href="http://www.harker.org/middle-school/students">Students</a>
                        </li>
                        <li>
                            <a data-pageid="155" href="http://www.harker.org/middle-school/support-services">Support &amp; Services</a>
                        </li>
                        <li>
                            <a data-pageid="142" href="http://www.harker.org/middle-school/campus-facilities">Campus &amp; Facilities</a>
                        </li>
                        <li>
                            <a data-pageid="41" href="http://www.harker.org/school-community">School Community</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="fsNavParentPage">
                <a data-pageid="9" href="http://www.harker.org/upper-school">Upper School</a>
                <div class="fsNavPageInfo">
                    <ul class="fsNavLevel2">
                        <li>
                            <a data-pageid="60" href="http://www.harker.org/upper-school/academics">Academics</a>
                        </li>
                        <li>
                            <a data-pageid="63" href="http://www.harker.org/upper-school/programs-extracurriculars">Programs &amp; Extracurriculars</a>
                        </li>
                        <li>
                            <a data-pageid="65" href="http://www.harker.org/upper-school/teachers">Teachers</a>
                        </li>
                        <li>
                            <a data-pageid="66" href="http://www.harker.org/upper-school/students">Students</a>
                        </li>
                        <li>
                            <a data-pageid="67" href="http://www.harker.org/upper-school/support-services">Support &amp; Services</a>
                        </li>
                        <li>
                            <a data-pageid="177" href="http://www.harker.org/upper-school/campus-facilities">Campus &amp; Facilities</a>
                        </li>
                        <li>
                            <a data-pageid="42" href="http://www.harker.org/school-community">School Community</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-pageid="207" href="http://www.harker.orghttp://www.harker.org/page.cfm?p=167">Summer</a>
            </li>
            <li class="fsNavParentPage">
                <a data-pageid="101" href="http://www.harker.org/about">About</a>
                <div class="fsNavPageInfo">
                    <ul class="fsNavLevel2">
                        <li>
                            <a data-pageid="143" href="http://www.harker.org/about/contact-us">Contact Us</a>
                        </li>
                        <li>
                            <a data-pageid="157" href="http://www.harker.org/about/philosophy-mission">Philosophy &amp; Mission</a>
                        </li>
                        <li>
                            <a data-pageid="124" href="http://www.harker.org/about/history">History</a>
                        </li>
                        <li>
                            <a data-pageid="118" href="http://www.harker.org/about/events">Events</a>
                        </li>
                        <li>
                            <a data-pageid="159" href="http://www.harker.org/about/message-from-the-head-of-school">Message from the Head of School</a>
                        </li>
                        <li>
                            <a data-pageid="160" href="http://www.harker.org/about/board-of-trustees">Board of Trustees</a>
                        </li>
                        <li>
                            <a data-pageid="102" href="http://www.harker.org/about/facts-stats">Facts &amp; Stats</a>
                        </li>
                        <li>
                            <a data-pageid="117" href="http://www.harker.org/about/eagle-store">Eagle Store</a>
                        </li>
                        <li>
                            <a data-pageid="133" href="http://www.harker.org/about/directory">Staff Directory</a>
                        </li>
                        <li>
                            <a data-pageid="175" href="http://www.harker.org/about/careers">Careers</a>
                        </li>
                        <li>
                            <a data-pageid="122" href="http://www.harker.org/about/nichols-hall-leed-certified">Nichols Hall: LEED Certified</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-pageid="208" href="http://www.harker.orghttp://news.harker.org/">News</a>
            </li>
            <li class="fsNavParentPage">
                <a data-pageid="148" href="http://www.harker.org/alumni">Alumni</a>
                <div class="fsNavPageInfo">
                    <ul class="fsNavLevel2">
                        <li>
                            <a data-pageid="218" href="http://www.harker.org/alumni/transcript-requests">Transcript Requests</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="fsNavParentPage">
                <a data-pageid="79" href="http://www.harker.org/giving">Giving</a>
                <div class="fsNavPageInfo">
                    <ul class="fsNavLevel2">
                        <li>
                            <a data-pageid="104" href="http://www.harker.org/giving/how-to-plan-your-giving">How to Plan Your Giving</a>
                        </li>
                        <li>
                            <a data-pageid="145" href="http://www.harker.org/giving/annual-giving">Annual Giving</a>
                        </li>
                        <li>
                            <a data-pageid="146" href="http://www.harker.org/giving/capital-giving">Capital Giving</a>
                        </li>
                        <li>
                            <a data-pageid="103" href="http://www.harker.org/giving/endowment-planned-giving">Endowment &amp; Planned Giving</a>
                        </li>
                        <li>
                            <a data-pageid="147" href="http://www.harker.org/giving/volunteering">Volunteering</a>
                        </li>
                        <li>
                            <a data-pageid="169" href="http://www.harker.org/giving/donate">Donate</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</div>

<?php
}
