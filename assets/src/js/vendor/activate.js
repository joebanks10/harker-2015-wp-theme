(function($) {

    // Toggles active state on click for selected elements
    Activate = function(selector, options) {
        this.selector = selector;
        this.settings = $.extend(true, {}, Activate.prototype.defaults, options);

        this.init();
    };

    // default options
    Activate.prototype.defaults = {
        activeClassName: 'active',
        beforeActivate: function(){},
        afterActivate: function(){},
        beforeDeactivate: function(){},
        afterDeactivate: function(){}
    };

    Activate.prototype.init = function() {
        var plugin = this;

        $(document).on('click.activate', this.selector, function() {
            var $el = $(this),
                active = plugin.isActive($el);

            if(active) {
                plugin.settings.beforeDeactivate($el, active);
            } else {
                plugin.settings.beforeActivate($el, active);
            }

            $el.toggleClass(plugin.settings.activeClassName);
            
            if(active) {
                plugin.settings.afterActivate($el, active);
            } else {
                plugin.settings.afterDeactivate($el, active);
            }

            return false;
        });
    };

    Activate.prototype.isActive = function(el) {
        if(el.hasClass(this.settings.activeClassName)) {
            return true;
        } else {
            return false;
        }
    };

    Activate.prototype.activateAll = function() {
        $(this.selector).addClass(this.settings.activeClassName);
    };

    Activate.prototype.deactivateAll = function() {
        $(this.selector).removeClass(this.settings.activeClassName);
    };

})(jQuery);
