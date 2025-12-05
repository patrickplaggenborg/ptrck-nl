<?php if( is_home() || is_archive() || is_search() ) { 
	
	/* if the post has a WP 2.9+ Thumbnail */
	if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
		<div class="post-thumb">
			<a title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'zilla' ), the_title_attribute( 'echo=0' ) ) ); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); /* post thumbnail settings configured in functions.php */ ?></a>
		</div>
	<?php } ?>

	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'zilla' ), the_title_attribute( 'echo=0' ) ) ); ?>"> <?php the_title(); ?></a></h2>
<?php } elseif( is_single() && function_exists('has_post_thumbnail') && has_post_thumbnail() ) { ?>

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
		<div class="post-thumb block">
		<?php 
			the_post_thumbnail(); /* post thumbnail settings configured in functions.php */ 
			$thumb_id = get_post_thumbnail_id(); 
			$thumb = get_posts( array( 'post_type' => 'attachment', 'p' => $thumb_id)); 
			$caption = $thumb[0]->post_excerpt; 
			if( !empty($caption) ) { echo '<p class="image-caption">' . $caption . '</p>'; }
		?>
		</div>
	</div>
<?php } ?>