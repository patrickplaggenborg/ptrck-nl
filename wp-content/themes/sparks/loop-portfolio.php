<?php if( have_posts() ) : ?>

	<div class="portfolio-filter block clearfix">
			<?php 
				$portfolio = zilla_get_option('general_portfolio_page');
				$terms = get_terms( 'portfolio-type' );
				$my_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				$termID = $my_term->term_id;
				if( !empty($terms) ) {
					echo '<h5>' . __( 'Filter:', 'zilla' ) . '</h5>';
					echo '<ul>';
					echo '<li><a href="' . get_permalink($portfolio) . '">' . __('All', 'zilla') . '</a></li>';
					foreach( $terms as $term ) {
						$class = ($termID == $term->term_id) ? 'class="active"' : '';
						echo '<li><a href="' . get_term_link($term) .'"' . $class . '>' . $term->name . '</a></li>';
					}
					echo '</ul>';
				}
			?>
		</div>

		<div class="default-bg">

			<div class="portfolio-block block clearfix">
			<?php zilla_content_start(); ?>
			
				<div class="portfolio-container">
				<?php 
				$thumbnail = 'portfolio-3col';

				while( have_posts() ) : the_post(); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php the_post_thumbnail($thumbnail); ?>
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf(__('Permanent Link to %s', 'zilla'), the_title_attribute('echo=0') ) ); ?>"><?php the_title(); ?></a></h2>
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