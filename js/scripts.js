(function( $ ) {

    $( document ).on( 'click', '.author-rss-feed .help', function() {
        $(this).parents('p:first').next('.help-content').toggle();
        return false;
    })


})( jQuery );
