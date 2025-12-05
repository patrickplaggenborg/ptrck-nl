<?php
/*
Plugin Name: Zilla Custom Testimonials
Plugin URI: http://themezilla.com
Description: A widget that displays some testimonials
Version: 1.0
Author: Mark Southard
Text Domain: zilla-testimonial-widget
Domain Path: /lang/
*/

class Zilla_Testimonial_Widget extends WP_Widget {

	/*------------------------------------------------------------------------*/
	/* Constructor
	/*------------------------------------------------------------------------*/
	
	public function __construct() {
	
		parent::__construct(
			'zilla-testimonial-widget',
			__( 'Custom Testimonials', 'zilla-testimonial-widget' ),
			array(
				'classname' => 'zilla-testimonial',
				'description' => __( 'Display testimonials in your site.', 'zilla-testimonial-widget' )
			)
		);
		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'zilla_register_widget_scripts' ) );
		
	} // end constructor

	/*-----------------------------------------------------------------------*/
	/* Display Widget 
	/*-----------------------------------------------------------------------*/
	
	public function widget( $args, $instance ) {
	
		extract( $args, EXTR_SKIP );
		
		$title = apply_filters('widget_title', $instance['title']);
		// Build our testimonial array
		for( $i = 1; $i <= 5; $i++ ) {
			$quotes[$i]['quote'] = $instance["quote$i"];
			$quotes[$i]['source'] = $instance["source$i"];
		}
	
		echo $before_widget;
    		
		if( $title ) { echo $before_title . $title . $after_title; }

		?>
		
		<ul class="zilla-testimonial-list">
			<?php 
			foreach( $quotes as $quote ) {
				if( !empty( $quote['quote'] ) ) {
					echo '<li><div>';
					echo '<p class="zilla-testimonial-quote">' . $quote['quote'] . '</p>';
					echo '<p class="zilla-testimonial-source">' . $quote['source'] . '</p>';
					echo '</div></li>';
				}
			}
			?>
		</ul>
		<div id="<?php echo $args['widget_id']; ?>-pager" class="zilla-testimonial-pager"></div>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				if( $().cycle ) {
					$testimonials = $( "#<?php echo $args['widget_id']; ?>" ).find('.zilla-testimonial-list');
					
					$testimonials.cycle({
						slides: '> li',
						pager: "#<?php echo $args['widget_id']; ?>-pager",
						timeout: 0,
						autoHeight: 0,
						centerHorz: true
					});
					// Adjust height of slide on view update
					$testimonials.on( 'cycle-update-view', function(e,o,sh,cs) {
						var $this = $(this);

						$this.animate({
							height: $(cs).height()
						}, 500);

						$(window).resize(function() {
							$this.stop().animate({
								height: $(cs).height()
							}, 500);
						});
					});
					// Adjust height of slide on screen resize
					
				}
			});
		</script>

		<?php 
		
		echo $after_widget;
		
	} // end widget
	
	/*-----------------------------------------------------------------------*/
	/* Update Widget 
	/*-----------------------------------------------------------------------*/

	public function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
	    $instance['quote1'] = strip_tags( $new_instance['quote1'], '<a><br><p><strong><em>' );
	    $instance['source1'] = strip_tags( $new_instance['source1'], '<a><br><p><strong><em>' );
	    $instance['quote2'] = strip_tags( $new_instance['quote2'], '<a><br><p><strong><em>' );
	    $instance['source2'] = strip_tags( $new_instance['source2'], '<a><br><p><strong><em>' );
		$instance['quote3'] = strip_tags( $new_instance['quote3'], '<a><br><p><strong><em>' );
		$instance['source3'] = strip_tags( $new_instance['source3'], '<a><br><p><strong><em>' );
		$instance['quote4'] = strip_tags( $new_instance['quote4'], '<a><br><p><strong><em>' );
		$instance['source4'] = strip_tags( $new_instance['source4'], '<a><br><p><strong><em>' );
		$instance['quote5'] = strip_tags( $new_instance['quote5'], '<a><br><p><strong><em>' );
		$instance['source5'] = strip_tags( $new_instance['source5'], '<a><br><p><strong><em>' );

		return $instance;
		
	} // end widget
	
	/*-----------------------------------------------------------------------*/
	/* Widget Settings
	/*-----------------------------------------------------------------------*/

	public function form( $instance ) {
	
		$defaults = array(
			'title' 	=> '',
			'quote1' 	=> '',
			'source1' 	=> '',
			'quote2' 	=> '',
			'source2'	=> '',
			'quote3' 	=> '',
			'source3'	=> '',
			'quote4' 	=> '',
			'source4'	=> '',
			'quote5'	=> '',
			'source5'	=> ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'zilla') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'quote1' ); ?>"><?php _e('Quote 1', 'zilla') ?></label>
			<textarea style="height:100px;" class="widefat" id="<?php echo $this->get_field_id( 'quote1' ); ?>" name="<?php echo $this->get_field_name( 'quote1' ); ?>"><?php echo stripslashes(htmlspecialchars(( $instance['quote1'] ), ENT_QUOTES)); ?></textarea>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'source1' ); ?>"><?php _e('Source 1:', 'zilla') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('source1'); ?>" name="<?php echo $this->get_field_name('source1'); ?>" value="<?php echo $instance['source1']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'quote2' ); ?>"><?php _e('Quote 2', 'zilla') ?></label>
			<textarea style="height:100px;" class="widefat" id="<?php echo $this->get_field_id( 'quote2' ); ?>" name="<?php echo $this->get_field_name( 'quote2' ); ?>"><?php echo stripslashes(htmlspecialchars(( $instance['quote2'] ), ENT_QUOTES)); ?></textarea>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'source2' ); ?>"><?php _e('Source 2:', 'zilla') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('source2'); ?>" name="<?php echo $this->get_field_name('source2'); ?>" value="<?php echo $instance['source2']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'quote3' ); ?>"><?php _e('Quote 3', 'zilla') ?></label>
			<textarea style="height:100px;" class="widefat" id="<?php echo $this->get_field_id( 'quote3' ); ?>" name="<?php echo $this->get_field_name( 'quote3' ); ?>"><?php echo stripslashes(htmlspecialchars(( $instance['quote3'] ), ENT_QUOTES)); ?></textarea>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'source3' ); ?>"><?php _e('Source 3:', 'zilla') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('source3'); ?>" name="<?php echo $this->get_field_name('source3'); ?>" value="<?php echo $instance['source3']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'quote4' ); ?>"><?php _e('Quote 4', 'zilla') ?></label>
			<textarea style="height:100px;" class="widefat" id="<?php echo $this->get_field_id( 'quote4' ); ?>" name="<?php echo $this->get_field_name( 'quote4' ); ?>"><?php echo stripslashes(htmlspecialchars(( $instance['quote4'] ), ENT_QUOTES)); ?></textarea>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'source4' ); ?>"><?php _e('Source 4:', 'zilla') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('source4'); ?>" name="<?php echo $this->get_field_name('source4'); ?>" value="<?php echo $instance['source4']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'quote5' ); ?>"><?php _e('Quote 5', 'zilla') ?></label>
			<textarea style="height:100px;" class="widefat" id="<?php echo $this->get_field_id( 'quote5' ); ?>" name="<?php echo $this->get_field_name( 'quote5' ); ?>"><?php echo stripslashes(htmlspecialchars(( $instance['quote5'] ), ENT_QUOTES)); ?></textarea>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'source5' ); ?>"><?php _e('Source 5:', 'zilla') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('source5'); ?>" name="<?php echo $this->get_field_name('source5'); ?>" value="<?php echo $instance['source5']; ?>" />
		</p>
		
		<?php
		
	} // end form

		
	// enqueue cycle which is registered in functions.php of theme.
	public function zilla_register_widget_scripts() {
		wp_enqueue_script('cycle2');
        wp_enqueue_script('cycle2-carousel');
        wp_enqueue_script('cycle2-center');
	} // end register_widget_scripts
	
} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("Zilla_Testimonial_Widget");' ) ); 