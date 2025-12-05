<?php

/**
 * Create the Portfolio meta boxes
 */
 
add_action('add_meta_boxes', 'zilla_metabox_portfolio');
function zilla_metabox_portfolio(){
    
    /* Create a settings metabox -----------------------------------------------------*/
    $meta_box = array(
		'id' => 'zilla-metabox-portfolio-settings',
		'title' =>  __('Portfolio Settings', 'zilla'),
		'description' => __('Input basic settings for this portfolio. For any item that you wish not be displayed, please leave blank. Additional metaboxes will display based on these options.', 'zilla'),
		'page' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' =>  __('Portfolio Caption', 'zilla'),
				'desc' => __('Enter a custom caption for this portfolio.', 'zilla'),
				'id' => '_zilla_portfolio_caption',
				'type' => 'text',
				'std' => '',
			),
			array(
				'name' =>  __('Portfolio Date', 'zilla'),
				'desc' => __('What was the date of the completed portfolio?', 'zilla'),
				'id' => '_zilla_portfolio_date',
				'type' => 'text',
				'std' => '',
			),
			array(
				'name' =>  __('Portfolio Client', 'zilla'),
				'desc' => __('For whom was this portfolio completed?', 'zilla'),
				'id' => '_zilla_portfolio_client',
				'type' => 'text',
				'std' => '',
			),
			array(
				'name' =>  __('Portfolio URL', 'zilla'),
				'desc' => __('What is the URL to the project?', 'zilla'),
				'id' => '_zilla_portfolio_url',
				'type' => 'text',
				'std' => '',
			),
			array(
				'name' =>  __('Featured Portfolio', 'zilla'),
				'desc' => __('Shall this portfolio be a featured portfolio that will display within the home page template?', 'zilla'),
				'id' => '_zilla_portfolio_featured',
				'type' => 'checkbox',
				'std' => 'off'
			),
			array(
				'name' =>  __('Display Gallery', 'zilla'),
				'desc' => __('Please check to display a gallery.', 'zilla'),
				'id' => '_zilla_portfolio_display_gallery',
				'type' => 'checkbox',
				'std' => 'on'
			),
			array(
				'name' =>  __('Display Audio', 'zilla'),
				'desc' => __('Please check to display audio content?', 'zilla'),
				'id' => '_zilla_portfolio_display_audio',
				'type' => 'checkbox',
				'std' => 'off'
			),
			array(
				'name' =>  __('Display Video', 'zilla'),
				'desc' => __('Please check to display video content?', 'zilla'),
				'id' => '_zilla_portfolio_display_video',
				'type' => 'checkbox',
				'std' => 'off'
			),
			array(
				'name' => __('Custom Background', 'zilla'),
				'desc' => __('Please check to include a custom background', 'zilla'),
				'id' => '_zilla_portfolio_display_background',
				'type' => 'checkbox',
				'std' => 'off'
			)
		)
	);
    zilla_add_meta_box( $meta_box );
	
	/* Create an image metabox -------------------------------------------------------*/
	$meta_box = array(
		'id' => 'zilla-metabox-portfolio-gallery',
		'title' =>  __('Gallery Settings', 'zilla'),
		'description' => __('Set up your gallery. All images attached to this portfolio will be included in the gallery.', 'zilla'),
		'page' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' =>  __('Upload Images', 'zilla'),
				'desc' => __('Click to upload images.', 'zilla'),
				'id' => '_zilla_gallery_upload',
				'type' => 'images',
				'std' => __('Upload Images', 'zilla')
			),
			array(
				'name' =>  __('Gallery Type', 'zilla'),
				'desc' => __('Shall the gallery images be displayed in a slideshow or as stacked images.', 'zilla'),
				'id' => '_zilla_portfolio_gallery_layout',
				'type' => 'select',
				'std' => __('Stacked', 'zilla'),
				'options' => array( 
					'stacked' => __('Stacked', 'zilla'), 
					'slider' => __('Slideshow', 'zilla')
				)
			)
		)
	);
    zilla_add_meta_box( $meta_box );
    
    /* Create a video metabox -------------------------------------------------------*/
    $meta_box = array(
		'id' => 'zilla-metabox-portfolio-video',
		'title' => __('Video Settings', 'zilla'),
		'description' => __('These settings enable you to embed videos into your portfolio pages. This theme expects videos to be 750px wide.', 'zilla'),
		'page' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
				'name' => __('Video Height', 'zilla'),
				'desc' => __('The video height (e.g. 500).', 'zilla'),
				'id' => '_zilla_video_height',
				'type' => 'text',
				'std' => ''
			),
			array( 
				'name' => __('M4V File URL', 'zilla'),
				'desc' => __('The URL to the .m4v video file', 'zilla'),
				'id' => '_zilla_video_m4v',
				'type' => 'text',
				'std' => ''
			),
			array( 
				'name' => __('OGV File URL', 'zilla'),
				'desc' => __('The URL to the .ogv video file', 'zilla'),
				'id' => '_zilla_video_ogv',
				'type' => 'text',
				'std' => ''
			),
			array( 
				'name' => __('Poster Image', 'zilla'),
				'desc' => __('The preview image. Height should be based on an image that is 750px wide.', 'zilla'),
				'id' => '_zilla_video_poster_url',
				'type' => 'file',
				'std' => ''
			),
			array(
				'name' => __('Embedded Code', 'zilla'),
				'desc' => __('If you are using something other than self hosted video such as Youtube or Vimeo, paste the embed code here. Width is best at 750px with any height.<br><br> This field will override the above.', 'zilla'),
				'id' => '_zilla_video_embed_code',
				'type' => 'textarea',
				'std' => ''
			)
		)
	);
	zilla_add_meta_box( $meta_box );
	
	/* Create an audio metabox ------------------------------------------------------*/
	$meta_box = array(
		'id' => 'zilla-metabox-portfolio-audio',
		'title' =>  __('Audio Settings', 'zilla'),
		'description' => __('These settings enable you to embed audio into your portfolio pages.', 'zilla'),
		'page' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
				'name' => __('MP3 File URL', 'zilla'),
				'desc' => __('The URL to the .mp3 audio file', 'zilla'),
				'id' => '_zilla_audio_mp3',
				'type' => 'text',
				'std' => ''
			),
			array( 
				'name' => __('OGA File URL', 'zilla'),
				'desc' => __('The URL to the .oga, .ogg audio file', 'zilla'),
				'id' => '_zilla_audio_ogg',
				'type' => 'text',
				'std' => ''
			),
			array( 
				'name' => __('Poster Image', 'zilla'),
				'desc' => __('The preview image for this audio track', 'zilla'),
				'id' => '_zilla_audio_poster_url',
				'type' => 'file',
				'std' => ''
			),
			array( 
				'name' => __('Poster Image Height', 'zilla'),
				'desc' => __('The height of the poster image. Height should be based on an image that is 750px wide.', 'zilla'),
				'id' => '_zilla_audio_height',
				'type' => 'text',
				'std' => ''
			)
		)
	);
	zilla_add_meta_box( $meta_box );

	/* Add custom backgrounds metabox -----------------------------------------*/
    $meta_box = array(
		'id' => 'zilla-metabox-portfolio-background',
		'title' => __('Custom Background Settings', 'zilla'),
		'description' => __('These settings enable you to set a custom background for this portfolio. You can set to have a single large image, a repeated pattern, or a custom color.', 'zilla'),
		'page' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
				'name' => __('Custom Background Image', 'zilla'),
				'desc' => __('Upload a custom background image for this post. Once image has been uploaded, click Insert into Post.', 'zilla'),
				'id' => '_zilla_background_image_url',
				'type' => 'file',
				'std' => ''
			),
			array(
				'name' => __('Cover Background', 'zilla'),
				'desc' => __('Shall the image be stretched to cover the background portion of the media section? Leave this off if you want to use repeat.', 'zilla'),
				'id' => '_zilla_background_cover',
				'type' => 'checkbox',
				'std' => 'on'
			),
			array( 
				'name' => __('Custom Background Position', 'zilla'),
				'desc' => __('Select the background position for the uploaded image.', 'zilla'),
				'id' => '_zilla_background_position',
				'type' => 'radio',
				'std' => 'left',
				'options' => array(
                	'left' => __('Left', 'zilla'),
                	'right' => __('Right', 'zilla'),
                	'center' => __('Center', 'zilla')
                )
			),
			array( 
				'name' => __('Custom Background Repeat', 'zilla'),
				'desc' => __('Select the preferred repeat for the uploaded image.', 'zilla'),
				'id' => '_zilla_background_repeat',
				'type' => 'radio',
				'std' => 'no-repeat',
				'options' => array(
                	'no-repeat' => __('No repeat', 'zilla'),
                	'repeat-x' => __('Repeat Horizontally', 'zilla'),
                	'repeat-y' => __('Repeat Vertically', 'zilla'),
                	'repeat' => __('Repeat', 'zilla')
                )                
			), 
            array( 
				'name' => __('Custom Background Color', 'zilla'),
				'desc' => __('Choose a custom background color for this post.', 'zilla'),
				'id' => '_zilla_background_color',
				'type' => 'color',
				'std' => '',
				'val' => '#f0eee8'
			)
        )
    );
    zilla_add_meta_box( $meta_box );
}