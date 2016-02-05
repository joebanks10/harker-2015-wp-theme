(function($){
    
    $(window).load(function(){
        
        if ( 'object' != typeof infiniteScroll.scroller ) {
            return;
        }

        var scroller = infiniteScroll.scroller,
            timer = null,
            $button = $();

        if ( infiniteScroll.settings.type === 'click' ) {
            return;
        }

        scroller.body.on( 'post-load', function(event, response) {
            if ( response.stop_infinite_scroll ) {
                scroller.window.unbind( 'scroll.infinity' );
                
                $button = $( '[id=infinite-handle]' );
                if ( scroller.click_handle && $button.length > 1) {
                    $button.not(':last').remove();
                }
            }
        });

        scroller.body.delegate( '#infinite-handle', 'click.infinity', function() {
            // Handle the handle
            if ( scroller.click_handle ) {
                $( '#infinite-handle' ).remove();
            }

            // Fire the refresh
            scroller.refresh();
        });

        scroller.window.bind( 'scroll', function() {
            // run the real scroll handler once every 250 ms.
            if ( timer ) { 
                return; 
            }
            
            timer = setTimeout( function() {
                scroller.determineURL();
                timer = null;
            } , 250 );
        });

    });

})(jQuery);