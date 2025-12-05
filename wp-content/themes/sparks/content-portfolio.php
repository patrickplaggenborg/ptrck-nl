<?php 
/**
 * Display the portfolio content
 */
 
if( post_password_required() ) {
	echo '<div class="block password-protected">';
		echo get_the_password_form();
	echo '</div>';
} else {
	// Set thumbnail size
	$thumbnail = 'portfolio-3col';
	if( is_page_template('template-portfolio-2col.php') ) {
		$thumbnail = 'portfolio-2col';
	}

	$args = array(
		'post_type' => 'portfolio',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => -1 );

	$query = new WP_Query($args);

	if( $query->have_posts() ) : ?>

		<div class="portfolio-filter block clearfix">
			<?php 
				$portfolio = zilla_get_option('general_portfolio_page');
				$terms = get_terms( 'portfolio-type' );
				if( !empty($terms) ) {
					echo '<h5>' . __( 'Filter:', 'zilla' ) . '</h5>';
					echo '<ul>';
					echo '<li><a href="' . get_permalink($portfolio) . '" class="active" data-filter="*">' . __('All', 'zilla') . '</a></li>';
					foreach( $terms as $term ) {
						echo '<li><a href="' . get_term_link($term) .'" data-filter=".' . $term->slug .'">' . $term->name . '</a></li>';
					}
					echo '</ul>';
				}
			?>
		</div>

		<div class="default-bg">

			<div class="portfolio-block block clearfix">
				<div class="portfolio-container">
				<?php 

				while( $query->have_posts() ) : $query->the_post(); 
					$terms = get_the_terms($post->ID, 'portfolio-type');
					$term_list = '';
					if( !empty($terms) ) {
						foreach( $terms as $term ) {
							$term_list .= "$term->slug" . " ";
						}
						$term_list = trim($term_list);
					}
				?>
					<div id="post-<?php the_ID(); ?>" <?php post_class( $term_list ); ?>>
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf(__('Permanent Link to %s', 'zilla'), the_title_attribute( 'echo=0' ) ) ); ?>" class="portfolio-img-permalink"><?php the_post_thumbnail($thumbnail); ?></a>
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf(__('Permanent Link to %s', 'zilla'), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_title(); ?></a></h2>
						<p class="portfolio-excerpt"><?php echo get_the_excerpt(); ?></p>
						<div class="bbottom"></div>
					</div>
				<?php endwhile; ?>
				<!--END .portfolio-container -->
				</div>
			<!--END .portfolio-block .block .clearfix -->
			</div>
			
		<!--END .default-bg -->
		</div>

<?php 

	endif;
}
?>