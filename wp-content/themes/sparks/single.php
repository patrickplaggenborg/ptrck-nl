<?php get_header(); ?>

<!--BEGIN #content-->
<div id="content" class="clearfix">
<?php zilla_content_start(); ?>

	<!--BEGIN #primary .hfeed-->
	<div id="primary" class="hfeed" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<?php zilla_post_before(); ?>
		<!--BEGIN .hentry -->
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<?php zilla_post_start(); ?>
			
			<?php 
				$format = get_post_format(); 
				get_template_part( 'content', $format ); 
			?>
						
			<div class="block clearfix">
								
				<!--BEGIN .entry-content -->
				<div class="entry-content">
					<?php the_content(__('Continue Reading', 'zilla')); ?>
					<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'zilla').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<!--END .entry-content -->
				</div>

				<?php zilla_post_meta_single(); ?>
			
			</div>

        <?php zilla_post_end(); ?>
        <!--END .hentry-->  
		</div>
		<?php zilla_post_after(); ?>

		<?php 
		    zilla_comments_before();
		    comments_template('', true); 
		    zilla_comments_after();
		?>

		<?php endwhile; else: ?>

		<!--BEGIN #post-0-->
		<div id="post-0" <?php post_class() ?>>
		
			<h1 class="entry-title"><?php _e('Error 404 - Not Found', 'zilla') ?></h1>
		
			<!--BEGIN .entry-content-->
			<div class="entry-content">
				<p><?php _e("Sorry, but you are looking for something that isn't here.", "zilla") ?></p>
			<!--END .entry-content-->
			</div>
		
		<!--END #post-0-->
		</div>

	<?php endif; ?>
	<!--END #primary .hfeed-->
	</div>

<?php zilla_content_end(); ?>	
<!--END #content -->
</div>

<!--BEGIN .navigation .single-page-navigation -->
<div class="navigation single-page-navigation block" role="navigation">
	<div class="nav-previous"><?php previous_post_link('%link') ?></div>
	<div class="nav-next"><?php next_post_link('%link') ?></div>
<!--END .navigation .single-page-navigation -->
</div>

<?php get_footer(); ?>