<?php get_header(); ?>

<div class="default-bg">
	
	<div id="content" class="block clearfix">
	
		<!--BEGIN #primary .hfeed-->
		<div id="primary" class="hfeed" role="main">
		
			<!--BEGIN #post-0-->
			<div id="post-0" <?php post_class() ?>>
				
				<h1 class="entry-title"><?php _e('Error 404 - Not Found', 'zilla') ?></h1>
				
				<!--BEGIN .entry-content-->
				<div class="entry-content">
					<p><?php _e('Sorry, but you are looking for something that is not here.', 'zilla') ?></p>
				<!--END .entry-content-->
				</div>
				
			<!--END #post-0-->
			</div>
			
		<!--END #primary .hfeed-->
		</div>

		<?php get_sidebar(); ?>

	<!--END #content -->
	</div>

<!--END .default-bg-->	
</div>

<?php get_footer(); ?>