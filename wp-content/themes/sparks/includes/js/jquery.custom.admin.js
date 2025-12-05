// All custom JS not relating to theme options goes here

jQuery(document).ready(function($) {
    
/*----------------------------------------------------------------------------------*/
/*	Display post format meta boxes as needed
/*----------------------------------------------------------------------------------*/

	// Set up our array of post format objects and group trigger
	var postFormats = [
		{ 	'id' : 'audio',
			'option' : $('#zilla-metabox-post-audio'),
			'trigger' : $('#post-format-audio')
		},
		{
			'id' : 'video',
			'option' : $('#zilla-metabox-post-video'),
			'trigger' : $('#post-format-video')
		},
		{
			'id' : 'gallery',
			'option' : $('#zilla-metabox-post-gallery'),
			'trigger' : $('#post-format-gallery')
		},
		{
			'id' : 'link',
			'option' : $('#zilla-metabox-post-link'),
			'trigger' : $('#post-format-link')
		},
		{
			'id' : 'quote',
			'option' : $('#zilla-metabox-post-quote'),
			'trigger' : $('#post-format-quote')
		}	
		],
		group = $('#post-formats-select input');

	// If format is check, show metabox
	for( var format in postFormats ) {
		if( postFormats[format]['trigger'].is(':checked') ) {
			postFormats[format]['option'].css('display', 'block');
		} else {
			postFormats[format]['option'].css('display', 'none');
		}
	}

	// New format selected, hide and show metaboxes
	group.change( function() {
	    $that = $(this);

	    for( var format in postFormats ) {
	    	if( $that.val() === postFormats[format]['id']) {
	    		postFormats[format]['option'].css('display', 'block');
	    	} else {
	    		postFormats[format]['option'].css('display', 'none');
	    	}
	    }
	});

/*----------------------------------------------------------------------------------*/
/*	Display portfolio meta boxes as needed
/*----------------------------------------------------------------------------------*/

    /* Grab our vars ---------------------------------------------------------------*/
    var displayGallery = $('#_zilla_portfolio_display_gallery'),
	    displayVideo = $('#_zilla_portfolio_display_video'),
	    displayAudio = $('#_zilla_portfolio_display_audio'),
        displayBackground = $('#_zilla_portfolio_display_background');
        portfolioGallery = $('#zilla-metabox-portfolio-gallery'),
        portfolioVideo = $('#zilla-metabox-portfolio-video'),
        portfolioAudio = $('#zilla-metabox-portfolio-audio');
        portfolioBackground = $('#zilla-metabox-portfolio-background');

    portfolioGallery.css('display', 'none');
	portfolioVideo.css('display', 'none');
	portfolioAudio.css('display', 'none');
    portfolioBackground.css('display', 'none');

    /* Hide and show sections as needed --------------------------------------------*/    
    if( displayGallery.is(':checked') ) portfolioGallery.css('display', 'block');
    if( displayVideo.is(':checked') ) portfolioVideo.css('display', 'block');
    if( displayAudio.is(':checked') ) portfolioAudio.css('display', 'block');
    if( displayBackground.is(':checked') ) portfolioBackground.css('display', 'block');

    displayGallery.click(function(e) {
    	if( $(this).is(':checked') ) portfolioGallery.css('display', 'block');
    	else portfolioGallery.css('display', 'none');
    });
    
	displayVideo.click(function(e) {
    	if( $(this).is(':checked') ) portfolioVideo.css('display', 'block');
    	else portfolioVideo.css('display', 'none');
    });

    displayAudio.click(function(e) {
    	if( $(this).is(':checked') ) portfolioAudio.css('display', 'block');
    	else portfolioAudio.css('display', 'none');
    });

    displayBackground.click(function(e) {
        if( $(this).is(':checked') ) portfolioBackground.css('display', 'block');
        else portfolioBackground.css('display', 'none');
    });

/*---------------------------------------------------------------------------------*/
/* Display Theme Options as needed
/*---------------------------------------------------------------------------------*/

	if( $('#zilla-framework').length ) {
		(function() {
			var displayRelatedPortfolios = $('#portfolio_display_related_portfolios'),
				relatedPortfolioFields = [$('#portfolio_related_portfolios_title'), $('#portfolio_related_portfolios_count')],
				homeDisplayFields = $('#home_featured_portfolio_count'),
				homeRelatedFields = [$('#home_featured_portfolio_order')];

			if( displayRelatedPortfolios.val() === 'false' ) {
				disableFields( relatedPortfolioFields );
			}

			displayRelatedPortfolios.change(function() {
				if( $(this).val() === 'true' ) {
					enableFields( relatedPortfolioFields );
				} else {
					disableFields( relatedPortfolioFields );
				}
			});

			if( homeDisplayFields.val() === 0 ) {
				disableFields( homeRelatedFields );
			}

			homeDisplayFields.change(function() {
				if( $(this).val() != 0 ) {
					enableFields( homeRelatedFields );
				} else {
					disableFields( homeRelatedFields );
				}
			});

			function disableFields( arr ) {
				$.each(arr, function(index, value) {
					$(this).val('false').closest('.section').addClass('disabled');
				});
			}

			function enableFields( arr ) {
				$.each(arr, function(index, value) {
					$(this).val('true').closest('.section').removeClass('disabled');
				});
			}
		})();
	}

});