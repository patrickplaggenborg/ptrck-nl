<?php 

if( is_active_sidebar( 'home-page-full-column') ) { ?>

	<div class="home-page-full-column block clearfix">
		
		<?php dynamic_sidebar( 'home-page-full-column' ); ?>
		
	</div>

<?php }