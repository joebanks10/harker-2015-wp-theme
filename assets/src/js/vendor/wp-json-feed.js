(function($) {

    // Replaces selected element's content with a WordPress feed.

    $.fn.WPFeed = function(options) {

        var container = this,
            html = '',
            settings = $.extend(true, {
                domain: 'http://news.harker.org',
                method: 'get_recent_posts',
                args: {
                    count: 3,
                    date_format: 'F j, Y',
                    include: "id,title,title_plain,url,content,thumbnail"
                },
                container: 'div',
                errorMsg: 'Read about what\'s happening at Harker in <a href="http://news.harker.org" target="_blank">Harker News</a>.',
                success: function() {}
            }, options),
            inlineOptions = container.data('wpargs') === undefined ? {} : container.data('wpargs');

        settings.args = $.extend(true, settings.args, inlineOptions);

        if (container.length === 0) {
            return;
        }

        $.ajax({
            url: settings.domain + '?json=' + settings.method,
            dataType: 'jsonp',
            data: settings.args,
            cache: true,
            timout: 10000,
            success: function(data) {
                var posts = get_posts(data);
                if (posts) {
                    createHTML(posts); // create HTML for feed
                    container.html(html); // replace container's content with feed
                } else {
                    container.html('<p>' + errorMsg + '</p>');
                }
                settings.success();
            },
            error: function() {
                container.html('<p>' + errorMsg + '</p>');
            }
        });

        function get_posts(data) {

            var posts = {};

            // check if posts exist
            if (data.hasOwnProperty("posts")) {
                posts = data.posts;
            } else if (data.hasOwnProperty('post')) {
                posts = data.post;
            } else {
                console.error("'posts' or 'post' property was not found in JSON response.");
                return false;
            }
            // console.log(posts);

            return posts;

        }

        function createHTML(posts) {

            $.each(posts, function(index, post) {

                html += '<li class="wp-article ' + 'post-' + post.id + '"><div class="wp-body">';

                if (post.thumbnail) {
                    html += '<div class="wp-thumbnail"';
                    if (Modernizr.backgroundsize === true) {
                        html += ' style="background-image: url(' + post.thumbnail + ')"';
                    }
                    html += '><img src="' + post.thumbnail + '" /></div>';
                }

                html += '<div class="wp-text">';
                html += '<div class="wp-title"><a href="' + post.url + '" target="_blank">' + post.title_plain + '</a></div>';

                if (post.date) {
                    html += '<div class="wp-date">Posted ' + post.date + '</div>';
                }

                if (post.excerpt)
                    html += '<p class="wp-excerpt">';
                else if (post.content)
                    html += '<div class="wp-excerpt">';

                if (post.excerpt)
                    html += post.excerpt + '</p>';
                else if (post.content)
                    html += post.content + '</div>';

                html += '</div></div></li>';

            });

        }

    };

})(jQuery);