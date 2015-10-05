;
(function($, window, document, undefined) {

    var defaults = {
        cover: false,
        container: '#fs-wistia-container',
        playLink: '#fs-wistia-play',
        exitLink: '#fs-wistia-exit'
    };

    if (typeof Wistia === 'undefined') {
        return;
    }

    Wistia.fsembed = function(id, options) {
        var settings = $.extend({}, defaults, options),
            videoOptions = {},
            wistiaEmbed = {},
            $container = $(settings.container),
            $html = $('html'),
            $playLink = $(settings.playLink),
            $exitLink = $(settings.exitLink);

        // add the crop fill plugin to the videoOptions
        if (settings.cover) {
            Wistia.obj.merge(videoOptions, {
                plugin: {
                    cropFill: {
                        src: "//fast.wistia.com/labs/crop-fill/plugin.js"
                    }
                }
            });
        }

        wistiaEmbed = Wistia.embed(id, videoOptions);

        $playLink.click(function() {
            if (settings.cover) {
                wistiaEmbed.plugin.cropFill.resize();
            }
            wistiaEmbed.play();
            $container.addClass('is-playing');
            $html.addClass('feature-is-playing');
        });
        $exitLink.click(function() {
            wistiaEmbed._keyBindingsActive = false;
            wistiaEmbed.pause();
            $container.removeClass('is-playing');
            $html.removeClass('feature-is-playing');
        });

        return wistiaEmbed;
    };

})(jQuery, window, document);