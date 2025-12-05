<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>

		<!--BEGIN #content .block-->
		<div id="content" class="block clearfix">
		<?php zilla_content_start(); ?>

			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed full-width" role="main">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <?php zilla_page_before(); ?>
				<!--BEGIN .hentry-->
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<?php zilla_page_start(); ?>
                    
					<!--BEGIN .entry-content -->
					<div class="entry-content">
						<?php the_content(__('Continue Reading', 'zilla')); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'zilla').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<!--END .entry-content -->
					</div>

                <?php zilla_page_end(); ?>
				<!--END .hentry-->
				</div>
				<?php zilla_page_after(); ?>

				<?php endwhile; endif; ?>
			
			<!--END #primary .hfeed-->
			</div>
		
		<?php zilla_content_end(); ?>	
		<!--END #content .block-->
		</div>

		<?php 
		    zilla_comments_before();
		    comments_template('', true); 
		    zilla_comments_after();
		?>

<?php get_footer(); ?>