<?php if( is_home() || is_archive() || is_search() ) { 
	
	zilla_gallery_js($post->ID);
	zilla_gallery($post->ID, '', 'slider');
?>

	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'zilla' ), the_title_attribute( 'echo=0' ) ) ); ?>"> <?php the_title(); ?></a></h2>
	
<?php } elseif( is_single() ) { ?>

	<?php 
		$post_meta = get_metadata('post', $post->ID);
		$post_display_bg = ( array_key_exists('_zilla_post_display_background', $post_meta) ) ? $post_meta['_zilla_post_display_background'][0] : '';
		$bg_class = '';
		$data_url = '';
		if( $post_display_bg == 'on' ) {
			$bg_class = 'custom-bg ';
			if( $post_meta['_zilla_background_cover'][0] == 'on' ) {
				$bg_url = esc_url($post_meta['_zilla_background_image_url'][0]);
				if( !empty($bg_url) ) {
					$data_url = " data-url='$bg_url'";
				}
			}
		}
	?>
	
	<div class="<?php echo $bg_class; ?>post-media default-bg"<?php echo $data_url; ?>>
		
		<?php 
			zilla_gallery_js($post->ID, true);
			zilla_gallery($post->ID, '', 'slider', true); 
		?>
	
	</div>
	
<?php } ?>