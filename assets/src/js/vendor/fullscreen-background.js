;
(function($, window, document, undefined) {

    "use strict";

    var pluginName = "fsBackground",
        defaults = {
            aspectRatio: 16 / 9,
            cropBottom: 0,
            container: '',
            ready: function() {}
        };

    // The actual plugin constructor
    function Plugin(element, options) {
        this.element = element;

        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;

        this._name = pluginName;
        this.init();
    }

    // Avoid Plugin.prototype conflicts
    $.extend(Plugin.prototype, {
        init: function() {
            var theWindow = $(window),
                $element = $(this.element),
                $container = $(this.settings.container);

            // bind resize event handler                                              
            theWindow.resize({
                theWindow: theWindow,
                element: $element,
                container: $container,
                settings: this.settings
            }, this.resizeContent).trigger("resize");

            this.settings.ready();
        },
        // resize element to fill the screen
        resizeContent: function(event) {
            var windowWidth = event.data.theWindow.width(),
                windowHeight = event.data.theWindow.height(),
                $element = event.data.element,
                $container = event.data.container,
                $img = event.data.img,
                aspectRatio = event.data.settings.aspectRatio,
                crop = event.data.settings.cropBottom,
                newWidth = '',
                newHeight = '',
                topOffset = '',
                leftOffset = '',
                styles = {};

            if ((windowWidth / windowHeight) < aspectRatio) {
                // element doesn't fill vertical space
                // increase element width and crop left/right
                // newWidth / windowHeight = 16/9
                newWidth = windowHeight * aspectRatio;
                leftOffset = -((newWidth - windowWidth) / 2); // center align

                if (crop) {
                    // increase element height to crop bottom of element and hide controls
                    newHeight = windowHeight + crop;
                    newWidth = newHeight * aspectRatio;
                    topOffset = 0;
                }

            } else {
                // element doesn't fill horizontal space
                // increase element height and crop top/bottom
                // windowWidth / newHeight = 16/9
                newHeight = windowWidth / aspectRatio;
                topOffset = -((newHeight - windowHeight) / 2); // center align

                if (crop) {
                    if ((newHeight - windowHeight) < crop) {
                        // element is not tall enough to crop
                        // increase element height to crop bottom of element and hide controls
                        newHeight = windowHeight + crop;
                        newWidth = newHeight * aspectRatio;
                        topOffset = 0;
                        leftOffset = -((newWidth - windowWidth) / 2); // center align
                    } else if (Math.abs(topOffset) < crop) {
                        // element is not tall enough to vertically center
                        topOffset = 0;
                    }
                }

            }

            // update elements
            $container.css({
                'width': windowWidth,
                'height': windowHeight
            }).addClass('is-resized');

            $element.css({
                'display': 'block',
                'width': newWidth,
                'height': newHeight,
                'top': topOffset,
                'left': leftOffset
            }).addClass('is-resized');
        }
    });

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function(options) {
        return this.each(function() {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });
    };

})(jQuery, window, document);