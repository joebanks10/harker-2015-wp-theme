;
(function($, window, undefined) {

    var pluginName = 'truncatedMenu',
        document = window.document,
        defaults = {
            visibleItems: "",
            hiddenItems: "",
            moreItem: "",
            id: 0,
            afterTruncate: function() {}
        };

    function Plugin(element, options) {
        this.element = element;
        this.id = Date.now();

        this.settings = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    $.extend(Plugin.prototype, {
        init: function() {
            this.truncate = this.getTruncate();
            this.on();
        },
        on: function() {
            this.truncate();
            $(window).on('resize.hkr.' + pluginName + '.' + this.id, this.truncate);
        },
        off: function() {
            $(window).off('resize.hkr.' + pluginName + '.' + this.id);
        },
        getTruncate: function() {
            var settings = this.settings,
                $list = $(this.element),
                $moreItem = $(this.settings.moreItem),
                $hiddenList = $moreItem.children('ul'),
                $hiddenItems = $(this.settings.hiddenItems).add($hiddenList.children('li')),
                $visibleItems = $(this.settings.visibleItems).add($moreItem),
                visibleItemsWidth = 0,
                listItems = [];

            this.settings.moreItem = $moreItem;
            this.settings.hiddenItems = $hiddenItems;
            this.settings.visibleItems = $visibleItems;

            if ($list.length === 0) {
                return false;
            }

            if ($moreItem.length === 0) {
                var moreItemHTML = '<li class="menu-item-more"><a href="#more-' + this.id + '" data-dropdown="more-' + this.id + '" aria-controls="more-' + this.id + '" aria-expanded="false"><span>More</span></a><ul id="more-' + this.id + '" class="f-dropdown" data-dropdown-content aria-hidden="true"></ul></li>';

                $moreItem = $(moreItemHTML).appendTo($list);
                $hiddenList = $moreItem.children('ul');
                $visibleItems = ($visibleItems.length === 0) ? $().add($moreItem) : $visibleItems.add($moreItem);

                this.settings.moreItem = $moreItem;
                this.settings.visibleItems = $visibleItems;
            }

            // save initial visible and hidden items
            this.initVisibleItems = $visibleItems;
            this.initHiddenItems = $hiddenItems;

            // get list items and widths
            $list.children('li').not($hiddenItems).each(function() {
                listItems.push({
                    element: this,
                    $element: $(this),
                    width: $(this).outerWidth(true) + 1 // buffer against rounding errors
                });
            });

            // get required visible items width
            $visibleItems.each(function() {
                visibleItemsWidth += $(this).outerWidth(true);
            });

            if ($hiddenList.children().length === 0) {
                $moreItem.addClass('hide');
            }

            return function() {
                var listWidth = $list.width(),
                    visible = [],
                    hidden = [],
                    sum = visibleItemsWidth;

                // console.log("sum = " + sum);

                for (var i = 0; i < listItems.length; i++) {
                    var listItem = listItems[i].element,
                        $listItem = listItems[i].$element,
                        listItemWidth = listItems[i].width;

                    if (!$listItem.is($visibleItems)) {
                        sum += listItemWidth;
                    }

                    if (sum < listWidth || $listItem.is($visibleItems)) {
                        visible.push(listItem);
                        // if (!$listItem.is($visibleItems)) {
                        //     console.log("+ " + listItemWidth + " (" + $listItem.text() + ")" + " = " + sum + " < " + listWidth);
                        // }
                    } else {
                        hidden.push(listItem);
                    }
                }

                $hiddenItems.each(function() {
                    hidden.push(this);
                });

                if (hidden.length > 0) {
                    $moreItem.removeClass('hide');
                } else {
                    $moreItem.addClass('hide');
                }

                $list.empty().append(visible).addClass('is-truncated');
                $hiddenList.empty().append(hidden);

                settings.afterTruncate();
            };
        },
        truncateAll: function() {
            var $list = $(this.element),
                $moreItem = $(this.settings.moreItem).removeClass('hide'),
                $hiddenList = $moreItem.children('ul'),
                $visibleItems = $(this.settings.visibleItems),
                $hiddenItems = $list.find('li').not($visibleItems);

            $list.empty().append($visibleItems).addClass('is-truncated-all');
            $hiddenList.empty().append($hiddenItems);

            this.settings.afterTruncate();
        },
        restore: function() {
            var $list = $(this.element),
                $moreItem = $(this.settings.moreItem).removeClass('hide'),
                $hiddenList = $moreItem.children('ul');

            $list.empty().append(this.initVisibleItems).removeClass('is-truncated');
            $hiddenList.empty().append(this.initHiddenItems);

            if ($hiddenList.children().length === 0) {
                $moreItem.addClass('hide');
            }
        }
    });

    $.fn[pluginName] = function(options) {
        return this.each(function() {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
            }
        });
    };

}(jQuery, window));