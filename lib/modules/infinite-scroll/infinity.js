(function($){

    $(window).load(function(){
        
        if ( 'object' != typeof infiniteScroll.scroller ) {
            return;
        }

        var scroller = infiniteScroll.scroller,
            scrollHandlerExists = false,
            throttle = true,
            $button = $();

        if ( infiniteScroll.settings.type === 'click' ) {
            return; 
        }

        // add event handler to turn off infinite scroll when max pages reached
        // Note: this event fires AFTER html of response is appended
        scroller.body.on( 'post-load', function(event, response) {
            if (typeof response.max_pages === 'undefined') {
                return;
            }

            if (typeof Foundation !== 'undefined' && ! Foundation.utils.is_large_up()) {
                // minimize infinite scroll when columns are stacked on smaller screens
                // Note: first request (page 2) has already been processed by now
                response.max_pages = 1;
            }

            if (scroller.page < response.max_pages) {
                return; 
            }

            // turn off infinite scroll
            scroller.pause();
            scroller.window.unbind( 'scroll.infinity' );
            scroller.throttle = false;

            // add button if not last batch and default button is used
            if (!response.lastbatch && scroller.click_handle) {
                $button = $( '[id=infinite-handle]' ).remove();
                scroller.element.append( scroller.handle );
            }

            // add scroll handler for updating URL
            if (!scrollHandlerExists) {
                scrollHandlerExists = true;

                scroller.window.bind( 'scroll', function() {
                    if ( throttle ) { 
                        scroller.determineURL();
                        throttle = false;

                        setTimeout( function() {
                            throttle = true;
                        } , 250 );
                    }                        
                });
            }
               
        });

        // add event handler for button
        scroller.body.delegate( '#infinite-handle', 'click.infinity', function() {
            // Handle the handle
            if ( scroller.click_handle ) {
                $( '#infinite-handle' ).remove();
            }

            // Fire the refresh
            scroller.resume();
            scroller.refresh();
        });

    });

})(jQuery);