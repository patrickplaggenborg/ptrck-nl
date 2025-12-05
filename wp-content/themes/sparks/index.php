<?php get_header(); ?>
	
<div class="default-bg">
	
	<!--BEGIN #content -->
	<div id="content" class="block clearfix">
	<?php zilla_content_start(); ?>
				
	<?php if (have_posts()) : ?>
		
		<!--BEGIN #primary .hfeed-->
		<div id="primary" class="hfeed" role="main">			
		<?php while (have_posts()) : the_post(); ?>
			
			<?php zilla_post_before(); ?>
			<!--BEGIN .hentry -->
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<?php zilla_post_start(); ?>
								
				<?php 
				$format = get_post_format(); 
				get_template_part( 'content', $format ); 

				if( $format != 'quote' && $format != 'link' ) {
					zilla_post_meta();
				}
				?>

				<!--BEGIN .entry-content -->
				<div class="entry-content">
					<?php the_content(__('Continue Reading', 'zilla')); ?>
				<!--END .entry-content -->
				</div>
	        
	        <?php zilla_post_end(); ?>
			<!--END .hentry-->  
			</div>
			<?php zilla_post_after(); ?>

			<?php endwhile; ?>
				
		<!--END #primary .hfeed-->
		</div>
			
	<?php else : ?>

		<!--BEGIN #post-0-->
		<div id="post-0" <?php post_class(); ?>>
		
			<h2 class="entry-title"><?php _e('Error 404 - Not Found', 'zilla') ?></h2>
		
			<!--BEGIN .entry-content-->
			<div class="entry-content">
				<p><?php _e("Sorry, but you are looking for something that isn't here.", "zilla") ?></p>
			<!--END .entry-content-->
			</div>
		
		<!--END #post-0-->
		</div>

	<?php endif; ?>

	<?php get_sidebar(); ?>

	<?php zilla_content_end(); ?>
	<!--END #content .block -->
	</div>
	
<!--END .default-bg -->					
</div>
	
<?php zilla_paging_nav(); ?>

<?php get_footer(); ?>