<?php 
/**
 * Create Home Options section
 */

add_action('admin_init', 'zilla_home_options');

function zilla_home_options(){
	$home_options['description'] = __('The home page is controlled via a number of areas within the admin. You can add content via the edit page view. Additionally, you can add widgets to the 3 home page columns and the full width column. Configure your featured portfolios carousel with the following options. Each portfolio to be featured must be selected as a featured portfolio in the edit portfolio view.', 'zilla');

    $options = array();
    for( $i = 0 ; $i <= 10 ; $i++ ) {
        $options[$i] = $i;
    }
    $home_options[] = array(
        'title' => __('Number of Featured Portfolios', 'zilla'),
        'desc' => __('How many featured portfolios should be in the carousel. Select 0 if you do not want the carousel to show.', 'zilla'),
        'type' => 'select',
        'id' => 'home_featured_portfolio_count',
        'options' => $options,
        'std' => 0
    );
    
    $options = array( 
        'rand' => __('Random', 'zilla'), 
        'post_date' => __('Date', 'zilla'), 
        'menu_order' => __('Menu Order', 'zilla') 
    );                        
    $home_options[] = array(
        'title' => __('Order of Portfolios', 'zilla'),
        'desc' => __('How should the featured portfolios be ordered?', 'zilla'),
        'type' => 'select',
        'id' => 'home_featured_portfolio_order',
        'options' => $options,
        'std' => 'rand'
    );
                        
    zilla_add_framework_page( 'Home Options', $home_options, 12 );
}