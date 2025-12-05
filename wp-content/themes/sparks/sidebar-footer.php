<?php if( is_active_sidebar( 'footer-column') || is_active_sidebar( 'footer-column-2' ) || is_active_sidebar( 'footer-column-3' ) ) { ?>

	<div class="footer-upper clearfix">
	<?php 

		if( is_active_sidebar( 'footer-column' ) ) {
			echo '<div class="footer-column-1">';
				dynamic_sidebar( 'footer-column' );
			echo '</div>';
		}

		if( is_active_sidebar( 'footer-column-2' ) )
			echo '<div class="footer-column-2">';
				dynamic_sidebar( 'footer-column-2' );
			echo '</div>';

		if( is_active_sidebar( 'footer-column-3' ) )
			echo '<div class="footer-column-3">';
				dynamic_sidebar( 'footer-column-3' );
			echo '</div>';

	?>
	</div>

<?php } ?>