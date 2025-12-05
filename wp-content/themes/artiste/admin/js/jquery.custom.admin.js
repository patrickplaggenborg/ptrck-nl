/* ------------------------------------------------------

    Custom JS for the Admin
    
--------------------------------------------------------*/

jQuery(document).ready(function() {
    var portfolioTypeTrigger = jQuery('#tz_portfolio_type'),
        portfolioImage = jQuery('#tz-meta-box-portfolio-image'),
        portfolioVideo = jQuery('#tz-meta-box-portfolio-video'),
        portfolioAudio = jQuery('#tz-meta-box-portfolio-audio');
        currentType = portfolioTypeTrigger.val();
        
    tzSwitch(currentType);

    portfolioTypeTrigger.change( function() {
       currentType = jQuery(this).val();
       
       tzSwitch(currentType);
    });
    
    function tzSwitch(currentType) {
        if( currentType === 'Audio' ) {
            tzHideAll(portfolioAudio);
        } else if( currentType === 'Video' ) {
            tzHideAll(portfolioVideo);
        } else {
            tzHideAll(portfolioImage);
        }
    }
    
    function tzHideAll(notThisOne) {
		portfolioImage.css('display', 'none');
		portfolioVideo.css('display', 'none');
		portfolioAudio.css('display', 'none');
		notThisOne.css('display', 'block');
	}
});