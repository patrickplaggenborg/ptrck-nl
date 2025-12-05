<?php
	$related_title = zilla_get_option('portfolio_related_portfolios_title');
	$related_count = zilla_get_option('portfolio_related_portfolios_count');

	$args = array( 'posts_per_page' => $related_count );
	$related = zilla_get_posts_related_by_taxonomy($post->ID, 'portfolio-type', $args); 
	
	if( is_object($related) && $related->have_posts() ) :
?>

		<!--BEGIN .default-bg-->
		<div class="default-bg">

			<!--BEGIN .block .portfolio-block-->
			<div class="block portfolio-block">
				<h3 class="related-title"><?php echo stripslashes( esc_html($related_title) ); ?></h3>
				
				<div class="related-portfolios">
					
					<?php while( $related->have_posts() ) : $related->the_post(); ?>

						<div <?php post_class(); ?>>
							<a href="<?php the_permalink(); ?>" class="portfolio-img-permalink"><?php the_post_thumbnail(); ?></a>
							<h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<p class="portfolio-excerpt"><?php echo get_the_excerpt(); ?></p>
							<div class="bbottom"></div>
						</div>
						
					<?php endwhile; ?>
				</div>
			
			<!--END .block .portfolio-block-->
			</div>

		<!--END .default-bg-->
		</div>
		
	<?php endif; wp_reset_postdata();