<?php
$portfolio_count = zilla_get_option('home_featured_portfolio_count');
if( !empty($portfolio_count) && $portfolio_count != 0 ) {
	// Grab our vars
	$orderby = zilla_get_option('home_featured_portfolio_order');
	$orderby = ( !empty($orderby) ) ? $orderby : 'rand';
	$order = ( $orderby == 'post_date' ) ? 'DESC' : 'ASC';

	// Set our $args
	$args = array(
		'numberposts' => $portfolio_count,
		'orderby' => $orderby,
		'order' => $order,
		'meta_key' => '_zilla_portfolio_featured',
		'meta_value' => 'on',
		'post_type' => 'portfolio',
		'post_status' => 'publish'
	);

	$portfolios = get_posts( $args );
	if( !empty($portfolios) ) {
		zilla_gallery_js('featured-portfolios', true);
		echo '<div id="zilla-gallery-featured-portfolios" class="featured-portfolios default-bg">';

			echo '<ul class="media-gallery">';
				foreach( $portfolios as $portfolio ) {
					echo '<li><div>';
						echo '<a href="' . get_permalink($portfolio->ID) . '" class="portfolio-img-permalink">' . get_the_post_thumbnail($portfolio->ID) . '</a>';
						echo '<h3><a href="' . get_permalink($portfolio->ID) . '">' . $portfolio->post_title . '</a></h3>';
						if( !empty($portfolio->post_excerpt) ) {
							echo '<p>' . $portfolio->post_excerpt . '</p>';
						}
					echo '</div></li>';
				}
			echo '</ul>';

			if( $portfolio_count > 1 ) {
				printf( '<a href="#" id="zilla-slide-prev-featured-portfolios" class="zilla-slide-prev">%s</a>', __('Previous', 'zilla') );
				printf( '<a href="#" id="zilla-slide-next-featured-portfolios" class="zilla-slide-next">%s</a>', __('Next', 'zilla') );
			}
		echo '</div>';
	}
}
