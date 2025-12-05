<?php 
/**
 * Create Portfolio Options section
 */

add_action('admin_init', 'zilla_portfolio_options');

function zilla_portfolio_options(){
	$portfolio_options['description'] = __('The single portfolio page view is controlled via this options page.', 'zilla');

	$options = array( 
		'true' => __('Yes', 'zilla'),
		'false' => __('No', 'zilla')
	);

    $portfolio_options[] = array( 
        'title' => __('Display Related Portfolios', 'zilla'),
		'desc' => __('Would you like to display related portfolios on the single portfolio view?', 'zilla'),
		'type' => 'select',
		'id' => 'portfolio_display_related_portfolios',
		'options' => $options,
		'std' => 'true'
    );

    $portfolio_options[] = array(
        'title' => __('Related Portfolios Title', 'zilla'),
		'desc' => __('What should the title of the related portfolios be?', 'zilla'),
		'type' => 'text',
		'id' => 'portfolio_related_portfolios_title',
		'std' => __('Similar Projects', 'zilla')
    );

    $options = array();
    for( $i = 3 ; $i <= 12 ; $i+=3 ) {
        $options[$i] = $i;
    }

    $portfolio_options[] = array(
        'title' => __('Number of Related Portfolios', 'zilla'),
        'desc' => __('How many related portfolios should be displayed.', 'zilla'),
        'type' => 'select',
        'id' => 'portfolio_related_portfolios_count',
        'options' => $options,
        'std' => 3
    );
                        
    zilla_add_framework_page( 'Portfolio Options', $portfolio_options, 13 );
}