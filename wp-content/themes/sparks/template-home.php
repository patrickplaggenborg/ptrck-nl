<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>

		<!--BEGIN #content .clearfix-->
		<div id="content" class="block clearfix">
		<?php zilla_content_start(); ?>

			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed" role="main">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <?php zilla_page_before(); ?>
				<!--BEGIN .hentry-->
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<?php zilla_page_start(); ?>

					<!--BEGIN .entry-content -->
					<div class="entry-content">
						<?php the_content(); ?>
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

			<?php get_sidebar('home-columns'); ?>
		
		<?php zilla_content_end(); ?>	
		<!--END #content .block .clearfix -->
		</div>
		
		<?php
			get_template_part('content', 'home-featured-portfolios');
			get_sidebar('home-full-column');
		?>

<?php get_footer(); ?>