(function($) {
    $(document).ready(function() {
        hkr.hero.init();
        hkr.header.init();
        hkr.navbar.init();
        hkr.foundation.init();
        hkr.globalNav.init();
        hkr.news.init();
        hkr.photoCover.init();
        hkr.accordion.init();
        hkr.slider.init();
        hkr.fade.init();
        hkr.footer.init();
        hkr.finalsite.init();
    });
    $(window).load(function() {
        hkr.ga.init();
    });
})(jQuery);