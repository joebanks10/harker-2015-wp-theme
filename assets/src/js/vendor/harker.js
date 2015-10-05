// Set up scope
var hkr = {};

// Google Analytics functions
hkr.ga = {
    init: function() {
        var hkrga = this;

        if (typeof ga === 'undefined') {
            return;
        }

        ga('create', 'UA-2450420-1', 'auto', {
            'name': 'hkr'
        });

        $(document).on('click.hkr.ga', 'a.track-link', function() {
            var $link = $(this),
                url = $link.attr('href'),
                category = $link.data('ga-cat'),
                action = $link.data('ga-action'),
                label = $link.data('ga-label');

            if ($link.hasClass('wistia-link')) {
                category = 'Video CTAs';
            }

            hkrga.trackLink(url, category, action, label);

            return false;
        });

        $(document).on('click.hkr.ga', '.track-click', function() {
            var $el = $(this),
                category = $el.data('ga-cat'),
                action = $el.data('ga-action'),
                label = $el.data('ga-label');

            hkrga.trackEvent(category, action, label);
        });

        $(document).on('click.hkr.ga', '.campus-visits-page .fsNotes a', function() {
            var $link = $(this),
                url = $link.attr('href');

            hkrga.trackLink(url, 'Admission CTAs', 'Visit', 'Event Notes Link');

            return false;
        });
        $(document).on('click.hkr.ga', '.campus-visits-page .fsDescription a:not(.track-link)', function() {
            var $link = $(this),
                url = $link.attr('href');

            hkrga.trackLink(url, 'Admission CTAs', 'Visit', 'Event Description Link');

            return false;
        });

    },
    /**
     * Function that tracks a click on a link in Google Analytics.
     * This function takes a string as an argument, and uses it
     * as the event label. The string can be the anchor text or URL.
     */
    trackLink: function(url, category, action, label) {
        url = typeof url !== 'undefined' ? url : 'href not set';
        category = typeof category !== 'undefined' ? category : 'Tracked Links';
        action = typeof action !== 'undefined' ? action : 'click';
        label = typeof label !== 'undefined' ? label : url;

        ga('hkr.send', 'event', category, action, label, {
            "hitCallback": function() {
                document.location = url;
            }
        });
    },

    trackEvent: function(category, action, label) {
        category = typeof category !== 'undefined' ? category : 'Tracked Events';
        action = typeof action !== 'undefined' ? action : 'undefined';
        label = typeof label !== 'undefined' ? label : window.location.href;

        ga('hkr.send', 'event', category, action, label);
    }
};

hkr.foundation = {
    init: function() {

        // Initialize Foundation
        $(document).foundation({
            "magellan-expedition": {
                destination_threshold: 24 + 96 + 48, // pixels from the top of destination for it to be considered active
                offset_by_height: false
            },
            accordion: {
                multi_expand: true
            }
        });

        // Override Foundation's click callback for direct links.
        $('.accordion').on('click', '.accordion-direct-link', function() {
            var url = $(this).attr('href');
            document.location = url;
        });

    }
};

hkr.accordion = {
    init: function() {
        var $buttons = $('.fsPanel .fsElement .button');

        $buttons.each(function() {
            var $button = $(this),
                $panel = $button.closest('.fsPanel'),
                $header = $panel.children('header'),
                href = $button.attr('href');

            $header.append('<a href="' + href + '" class="accordion-direct-link"></a>');
            $panel.addClass('has-accordion-direct-link');
        });

        $(document).on('click.hkr.accordion', '.accordion-fix .fsPanel > header', function() {
            $(this).siblings('.fsElementContent').toggle();
        });
    }
};

// TODO: Integrate with Media Manager
hkr.slider = {
    init: function() {
        $('.feature-slider').slick({
            autoplay: true 
        });
        this.statsSlider();
    },
    statsSlider: function() {
        var counters = [],
            $countEl = $('.count'),
            $slider = $('.stats-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        if ( $countEl.length === 0 ) {
            return;
        }

        $countEl.each(function() {
            var $el = $(this),
                countTo = parseInt($el.text(), 10),
                counter = new countUp(this, 0, countTo, 0, 3); // count from 0 to number defined in elemnt's text

            // $el.text("0");
            counters.push(counter);
        });

        var inview = new Waypoint.Inview({
                element: $slider[0],
                enter: function(direction) {
                    setTimeout(function() {
                        for(var i = 0, length = counters.length; i < length; i++ ) {
                            counters[i].start();
                        }
                    }, 100);
                }
            });
    }
};

hkr.fade = {
    init: function() {
        this.sequences();
        
        var $faders = $('.fade-in').addClass('fade-in-init'),
            inviews = [];

        $faders.each( function() {
            var $el = $(this);

            inviews.push(
                new Waypoint.Inview({
                    element: this,
                    enter: function(direction) {
                        // setTimeout(function() {
                        $el.addClass('fade-in-start');
                        // }, 100);
                    }
                })
            );
        });
    },
    sequences: function() {
        var $seqChildren = $('.seq-children'),
            $seqSiblings = $('.seq-siblings');

        $seqChildren.each(function() {
            $(this).children().addClass('fade-in').each(function(i){
                $(this).addClass('seq-'+(i+1));
            });
        });

        $seqSiblings.each(function() {
            $(this).siblings().add(this).addClass('fade-in').each(function(i){
                $(this).addClass('seq-'+(i+1));
            });
        });
    }
};

hkr.hero = {
    init: function() {
        if ($('.hero').length !== 0) {
            $('html').addClass('has-hero');
        }

        this.setupBgImage();
        this.setupBgVideo();
        if ($('.fsDraftMode').length === 0) {
            this.setupFeatureVideo();
        }
    },
    setupBgImage: function() {
        var $img = $('.hero-img > img');

        if ($img.length === 0) {
            return;
        }

        if ($('.hero-bg').length) {
            $img.fsBackground({
                cropBottom: 60, // use same crop as bg video (to hide playbar)
                container: '#hero'
            });
        } else {
            $(window).load(function() {
                $img.fsBackground({
                    aspectRatio: $img.width() / $img.height(),
                    container: '#hero'
                });
            });
        }

    },
    setupBgVideo: function() {
        var $videoContainer = $('.hero-bg'),
            vimeoID = $videoContainer.data('vimeo-id');

        if ($videoContainer.length === 0 || vimeoID === undefined) {
            return;
        }

        var vimeoHTML = '<iframe id="vimeoplayer" src="https://player.vimeo.com/video/' + vimeoID + '?autoplay=1&loop=1&title=0&byline=0&portrait=0&api=1&player_id=vimeoplayer" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>',
            $video = $(vimeoHTML),
            vimeoPlayer = $f($video[0]);

        // Add CSS handles to indicate when Vimeo background video is playing
        if (vimeoPlayer) {
            vimeoPlayer.addEvent('ready', function() {
                vimeoPlayer.addEvent('play', function() {
                    $videoContainer.addClass('is-playing');
                });
                vimeoPlayer.addEvent('pause', function() {
                    $videoContainer.removeClass('is-playing');
                });
            });
        }

        // Add element and initiate fullscreen video
        $video.appendTo($videoContainer).fsBackground({
            cropBottom: 60
        });
    },
    setupFeatureVideo: function() {
        var $videoContainer = $('.hero-feature'),
            wistiaID = $videoContainer.data('wistia-id');

        if (wistiaID === undefined || typeof Wistia === 'undefined' || $videoContainer.length === 0) {
            $('#fs-wistia-play').remove();
            return;
        }

        var wistiaHTML = '<div id="wistia_' + wistiaID + '" class="wistia_embed" style="width:100%;height:100%;">&nbsp;</div>',
            exitLinkHTML = '<a href="#" id="fs-wistia-exit" title="Exit Video"><i class="fa fa-2x fa-times"></i></a>';

        // Set up Wistia feature video
        $videoContainer.append(exitLinkHTML + wistiaHTML);
        Wistia.fsembed(wistiaID, {
            container: '.hero-feature',
            playLink: '#fs-wistia-play'
        });

    }
};

hkr.header = {
    init: function() {
        var $header = $('.header');

        this.menu.init();
    },
    menu: {
        init: function() {
            var $menu = $('.header-nav-menu-sections');

            if ($menu.length === 0) {
                this.element = {};
                return this.element;
            }

            this.element = $menu;
            this.mediaQueries = this.getMediaQueries();

            var pathArray = window.location.pathname.split('/'),
                level1 = pathArray[1],
                $activeMenuItem = $menu.find('a[href="/' + level1 + '"]').parent('li');

            $activeMenuItem.addClass('active');

            $menu.truncatedMenu({
                moreItem: '.header-nav-menu-sections > .active, .header-nav-menu-sections .menu-item-more',
                visibleItems: '.header-nav-menu-sections .menu-item-hamburger',
                afterTruncate: function() {
                    $(document).foundation('dropdown', 'reflow');
                }
            });

            // this.mediaQueries();
            // $(window).on('resize.hkr', this.mediaQueries);
        },
        getMediaQueries: function() {
            var $menu = this.element;

            return function() {
                if (Foundation.utils.is_small_only()) {
                    $menu.data('plugin_truncatedMenu').truncateAll();
                    $menu.data('plugin_truncatedMenu').off();
                } else {
                    $menu.data('plugin_truncatedMenu').on();
                }
            };
        }
    }
};

// TODO: Delay reaction of scroll events
hkr.navbar = {
    init: function() {
        var $navBar = $('.nav-bar'),
            $hero = $('.fsElement.hero');

        if ($navBar.length === 0) {
            this.element = {};
            return this.element;
        }

        this.element = $navBar;

        if ($hero.length !== 0 && !$hero.next().is($navBar)) {
            $hero.after($navBar);
        }

        $('html').addClass('has-nav-bar');

        this.sectionMenu.init();
        this.bookmarksMenu.init();

        if ($('body').hasClass('is-404')) {
            return;
        }

        // set up scroll behavior for navbar
        if (!Modernizr.touch) {
            new Waypoint.Sticky({
                element: $navBar[0],
                stuckClass: 'is-stuck',
                wrapper: '<div class="nav-bar-wrapper" />'
            });

            hkr.helpers.scroll(this.getScrollHandle("down"), this.getScrollHandle("up"));
        } else {
            new Waypoint.Sticky({
                element: $('.current-page-bar')[0],
                stuckClass: 'is-stuck',
                wrapper: '<div class="current-page-bar-wrapper" />'
            });
        }

        $(window).load(function() {
            if (location.hash) {
                // scroll up to reveal content behind fixed navbar
                // scrollBy(0, $navBar.height() * -1 - 48);
                var el = $(location.hash),
                    section = el.closest('.fsElement, .section'),
                    sectionTop = (section.offset().top === el.offset().top) ? section.offset().top - 48 : section.offset().top, // subtract padding
                    navBarHeight = $navBar.height(),
                    offset = sectionTop - navBarHeight;

                setTimeout(function() {
                    $(window).scrollTop(offset);
                }, 100);

            }
        });
    },
    getScrollHandle: function(direction) {
        var bookmarksMenu = this.bookmarksMenu,
            $navBar = this.element;

        if (direction === "down") {
            return function() {
                // hide when user scrolls/swipes down
                if (!$navBar.hasClass('is-collapsed') && $navBar.hasClass('is-stuck')) {
                    $navBar.addClass('is-collapsed');
                    if (bookmarksMenu.element.length) {
                        bookmarksMenu.mediaQueries();
                    }
                }
            };
        }

        if (direction === "up") {
            return function() {
                // show when user scrolls/swipes up
                if ($navBar.hasClass('is-collapsed')) {
                    $navBar.removeClass('is-collapsed').addClass('is-social');
                    if (bookmarksMenu.element.length) {
                        bookmarksMenu.mediaQueries();
                    }
                }
            };
        }
    },
    sectionMenu: {
        init: function() {
            var $sectionMenu = $('.primary-nav-menu-sections');

            if ($sectionMenu.length === 0) {
                this.element = {};
                return this.element;
            }

            this.element = $sectionMenu;

            var pathArray = window.location.pathname.split('/'),
                level1 = pathArray[1],
                $activeMenuItem = $sectionMenu.find('a[href="/' + level1 + '"]').parent('li');

            $activeMenuItem.addClass('active');

            $sectionMenu.truncatedMenu({
                visibleItems: '.primary-nav-menu-sections > .active, .primary-nav-menu-sections .menu-item-hamburger',
                moreItem: '.primary-nav-menu-sections .menu-item-more',
                afterTruncate: function() {
                    $(document).foundation('dropdown', 'reflow');
                }
            });
        }
    },
    bookmarksMenu: {
        init: function() {
            var $bookmarksMenu = $('.current-page-menu-bookmarks');

            if ($bookmarksMenu.length === 0) {
                this.element = {};
                return this.element;
            }

            this.element = $bookmarksMenu;
            this.insertBookmarks();
            this.insertPageTitle();
            this.mediaQueries = this.getMediaQueries();

            $bookmarksMenu.truncatedMenu({
                moreItem: '.current-page-menu-bookmarks .menu-item-more, .current-page-menu-bookmarks .menu-item-hamburger',
                afterTruncate: function() {
                    $(document).foundation('dropdown', 'reflow');
                }
            });

            this.mediaQueries();
            $(window).on('resize.hkr', this.mediaQueries);
        },
        getMediaQueries: function() {
            var $bookmarksMenu = this.element;

            return function() {
                if (Foundation.utils.is_small_only()) {
                    $bookmarksMenu.data('plugin_truncatedMenu').truncateAll();
                    $bookmarksMenu.data('plugin_truncatedMenu').off();
                } else {
                    $bookmarksMenu.data('plugin_truncatedMenu').on();
                }
            };
        },
        insertBookmarks: function() {
            var $bookmarks = $('main').find('*[id^="bookmark-"]'),
                $bookmarksMenu = this.element,
                menuHTML = '';

            $bookmarks.each(function(i, el) {
                var $bookmark = $(this),
                    id = $bookmark.attr('id'),
                    text = '',
                    lengthMax = 20;

                if ($bookmark.data('bookmark-label') !== undefined) {
                    text = $bookmark.data('bookmark-label');
                } else {
                    text = $bookmark.text().trim();
                    // if (text.length > lengthMax) {
                    //     text = text.substring(0, lengthMax).trim() + "&hellip;";
                    // }
                }

                $bookmark.attr('data-magellan-destination', id);
                menuHTML += '<li data-magellan-arrival="' + id + '"><a href="#' + id + '">' + text + '</a></li>';
            });

            menuHTML += '<li class="menu-item-more">\n\t<a href="#more-bookmarks" data-dropdown="more-bookmarks" aria-controls="more-bookmarks" aria-expanded="false"><span>More</span></a>\n\t<ul id="more-bookmarks" class="f-dropdown" data-dropdown-content aria-hidden="true"></ul>\n</li>';

            $bookmarksMenu.html(menuHTML);
        },
        insertPageTitle: function() {
            var $pageTitle = $('.title'),
                $pageTopic = $pageTitle.children('.title-topic'),
                $navbarTitle = $('.current-page-title > a'),
                text = '';

            if ($pageTitle.data('nav-bar-title') !== undefined) {
                $pageTitle.data('nav-bar-title');
            } else {
                text = ($pageTopic.length) ? $pageTopic.text().trim() : $pageTitle.text().trim();
            }

            if (text === '') {
                return;
            }

            $navbarTitle.html(text);
        }
    }
};

// mmenu
hkr.globalNav = {
    init: function() {
        var $globalNav = $(".global-nav nav");

        if ($globalNav.length === 0) {
            this.element = {};
            return this.element;
        }

        this.element = $globalNav;
        $globalNav.attr('id', 'global-nav');

        // Set up mmenu
        $globalNav.mmenu({
            offCanvas: {
                position: "left",
                zposition: "front"
            },
            navbars: true,
            extensions: ["pageshadow"]
        }, {
            // configuration
            offCanvas: {
                pageNodetype: 'main',
                pageSelector: '#main'
            },
            classNames: {
                fixedElements: {
                    fixed: "fixed"
                }
            }
        });

        var mmenu = $globalNav.data("mmenu"), // get plugin object
            $currentMenuItem = $globalNav.find('.fsNavCurrentPage'),
            $currentPanel = $currentMenuItem.closest('.mm-panel');

        if ($currentMenuItem.length !== 0) {
            mmenu.setSelected($currentMenuItem);
        }
        if ($currentPanel.length !== 0 && Foundation.utils.is_medium_up()) {
            mmenu.openPanel($currentPanel);
        }

        if ($('#lte-IE9').length > 0) {
            // fix for ie9
            $('.mm-navbar').on('click', function() {
                $('.mm-panel').removeClass('mm-current').removeClass('mm-opened');
            });
        }
    }
};

hkr.photoCover = {
    init: function() {
        var $containers = $('.photo-cover');

        $containers.each(function() {
            var $container = $(this),
                $img = $container.find('img').first(),
                src = $img.attr('src');

            $container.css('backgroundImage', 'url(' + src + ')').addClass('photo-cover-active');
        });
    }
};

hkr.news = {
    init: function() {
        var $feeds = $('.news-feed');

        $feeds.each(function() {
            var $feed = $(this),
                tag = $feed.data('wp-tag'),
                cat = $feed.data('wp-cat'),
                count = $feed.data('wp-count'),
                thumbnail = $feed.data('wp-thumbnail');

            if (tag === undefined) {
                tag = '';
            }
            if (cat === undefined) {
                cat = '';
            }
            if (count === undefined) {
                count = 6;
            }
            if (thumbnail === false) {
                thumbnail = "";
            } else {
                thumbnail = ",thumbnail";
            }

            // Set up WordPress JSON API Feed
            $feed.WPFeed({
                method: 'get_posts',
                args: {
                    tag: tag,
                    category_name: cat,
                    count: count,
                    date_format: 'F j, Y',
                    include: "id,title,title_plain,url" + thumbnail
                }
            });
        });

    }
};

hkr.finalsite = {
    init: function() {
        this.directory();
        this.athleticsEvents();
    },
    directory: function() {
        var regex = /\".*\"\s/,
            $profiles = $('.fsConstituentItem'),
            $names = $('.fsFullName', $profiles);

        $profiles.each(function() {
            var $profile = $(this),
                $photo = $profile.children('.fsPhoto');

            if ($photo.length === 0) {
                $profile.addClass('no-fsPhoto');
            }
        });

        // remove nicknames
        // $names.each(function() {
        //     var $name = $(this),
        //         text = $name.text().trim(),
        //         newName = text.replace(regex, "");

        //     $name.children('a').text(newName);
        // });
    },
    athleticsEvents: function() {
        var regex = /~athletics_team_id/,
            path = window.location.pathname;

        if (regex.test(path)) {
            $('body').addClass('hasTeam');
        }
    }
};

hkr.footer = {
    init: function() {
        var $footer = $('.footer'),
            $lastElement = $('#fsPageContent > .fsLayout > .fsDiv > .fsElement:last-child').first(),
            classes = $lastElement.attr('class'),
            regex = /\w+-bg/;

        if (regex.test(classes)) {
            $footer.addClass('footer-invert');
        }
    }
};

hkr.helpers = {
    scroll: function(handleDown, handleUp) {
        handleDown = typeof handleDown === "function" ? handleDown : function() {};
        handleUp = typeof handleUp === "function" ? handleUp : function() {};

        var lastScrollTop = 0;
        $(window).scroll(function(event) {
            var currentScrollTop = $(this).scrollTop();
            if (currentScrollTop > lastScrollTop) {
                handleDown();
            } else {
                handleUp();
            }
            lastScrollTop = currentScrollTop;
        });
    }
};