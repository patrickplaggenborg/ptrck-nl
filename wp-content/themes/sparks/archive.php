<?php get_header(); ?>

	<div class="default-bg">

		<!--BEGIN #content .block clearfix -->
		<div id="content" class="block clearfix">
		<?php zilla_content_start(); ?>
			
			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed" role="main">
			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			    
			    <?php zilla_post_before(); ?>
				<!--BEGIN .hentry -->
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php zilla_post_start(); ?>
				    
					<?php 
					$format = get_post_format(); 
					get_template_part( 'content', $format ); 

					if( $format != 'quote' && $format != 'link' ) {
						zilla_post_meta();
					}
					?>
	
					<!--BEGIN .entry-summary -->
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					<!--END .entry-summary -->
					</div>
                    
                <?php zilla_post_end(); ?>
            	<!--END .hentry -->
				</div>
				<?php zilla_post_after(); ?>
	
			<?php endwhile; ?>
			
			<?php else : 
	
    			if ( is_category() ) { // If this is a category archive
    				printf( '<p>%s</p>', sprintf( __('Sorry, but there are not any posts in the %s category yet.', 'zilla'), single_cat_title('',false) ) );
    			} else if ( is_date() ) { // If this is a date archive
    				_e('<p>Sorry, but there aren not any posts with this date.</p>', 'zilla');
    			} else if ( is_author() ) { // If this is a category archive
    				$userdata = get_userdatabylogin(get_query_var('author_name'));
    				printf( '<p>%s</p>', sprintf( __('Sorry, but there are not any posts by %s yet.', 'zilla'), $userdata->display_name ) );
    			} else {
    				_e('<p>No posts found.</p>', 'zilla');
    			}
	
			 endif; ?>
			
			<!--END #primary .hfeed-->
			</div>	
	
			<?php get_sidebar(); ?>
			
		<?php zilla_content_end(); ?>
		<!--END #content .block .clearfix -->
		</div>
	
	<!--END .default-bg -->
	</div>
	
	<?php zilla_paging_nav(); ?>

<?php get_footer(); ?>