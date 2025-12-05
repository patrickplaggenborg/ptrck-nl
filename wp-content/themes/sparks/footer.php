	<?php zilla_footer_before(); ?>
	<!-- BEGIN #footer -->
	<div id="footer">
		
		<!-- BEGIN .block -->
		<div class="block clearfix">
	    
	    <?php zilla_footer_start(); ?>
	    
	    	<?php get_sidebar( 'footer' ); ?>
	    	
			<!-- BEGIN .footer-lower -->	    
		    <div class="footer-lower">
		    
				<p class="copyright">&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>. <?php _e('Powered by', 'zilla') ?> <a href="http://wordpress.org/">WordPress</a>.</p>
			
				<p class="credit"><a href="http://www.themezilla.com/themes/sparks">Sparks Theme</a> by <a href="http://www.themezilla.com/">ThemeZilla</a></p>
 
			<!-- END .footer-lower -->
			</div>
		
	    <?php zilla_footer_end(); ?>
	    <!--END .block -->
	    </div>
	    
	<!-- END #footer -->
	</div>
	<?php zilla_footer_after(); ?>
			
	<!-- Theme Hook -->
	<?php wp_footer(); ?>
	<?php zilla_body_end(); ?>
			
	<!-- <?php echo 'Ran '. $wpdb->num_queries .' queries '. timer_stop(0, 2) .' seconds'; ?> -->
<!--END body-->
</body>
<!--END html-->
</html>