/*-----------------------------------------------------------------------------------

 	Custom JS - All front-end jQuery
 
-----------------------------------------------------------------------------------*/
 

jQuery(document).ready(function() {

    /* Shortcodes -----------------------------*/
    jQuery("#tabs").tabs();
    jQuery(".tabs").tabs();
    
    
    jQuery(".toggle").each( function () {
        if(jQuery(this).attr('data-id') == 'closed') {
            jQuery(this).accordion({ header: 'h4', collapsible: true, active: false  });
        } else {
            jQuery(this).accordion({ header: 'h4', collapsible: true});
        }
    });

    /* Fix IE quirkiness ----------------------*/
    if( jQuery('body').hasClass('ie') && !jQuery('body').hasClass('single-post') ) {
        var portfolioImages = jQuery('.post-thumb').find('a').find('img');
        
        portfolioImages.hover(
            function() {
                jQuery(this).animate({
                    opacity: .4
                }, 300);
            },
            function() {
                jQuery(this).animate({
                    opacity: 1
                }, 300);
            }
        );
    }
    
});