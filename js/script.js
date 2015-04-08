jQuery(document).ready(function($) {

    //any time a 'more info' button is clicked, expand the additional info panel
    $('.toplevel_page_wp-basix .wpb-module-more-info').on('click', function(event) {
        event.preventDefault();
        $(this).parent().children('.toplevel_page_wp-basix .wpb-module-more-info-details').slideToggle();
    });

    //when a new 'message' is rendered, wait a while and then fade it out
    //purely for aesthetics.
    $('.toplevel_page_wp-basix').bind('DOMSubtreeModified', function() {
        if ($('.wpb-settings-updated').length) {
            $('.toplevel_page_wp-basix').unbind('DOMSubtreeModified');
            $('.wpb-settings-updated').delay(3000).slideUp();
        }
    });
});