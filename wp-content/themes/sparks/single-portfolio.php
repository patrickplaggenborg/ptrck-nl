<?php get_header(); ?>

<!--BEGIN #content-->
<div id="content" class="clearfix">
<?php zilla_content_start(); ?>

	<!--BEGIN #primary -->
	<div id="primary" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); 
		$port_meta = get_metadata('post', $post->ID);

		// portfolio metadata
		$date = ( array_key_exists('_zilla_portfolio_date', $port_meta) ) ? $port_meta['_zilla_portfolio_date'][0] : '';
		$client = ( array_key_exists('_zilla_portfolio_client', $port_meta) ) ? $port_meta['_zilla_portfolio_client'][0] : '';
		$url = ( array_key_exists('_zilla_portfolio_url', $port_meta) ) ? $port_meta['_zilla_portfolio_url'][0] : '';

		// detemine which media to display
		$portfolio_display_gallery = $port_meta['_zilla_portfolio_display_gallery'][0];
		$portfolio_display_video = $port_meta['_zilla_portfolio_display_video'][0];
		$portfolio_display_audio = $port_meta['_zilla_portfolio_display_audio'][0];
		$portfolio_display_bg = ( array_key_exists('_zilla_portfolio_display_background', $port_meta) ) ? $port_meta['_zilla_portfolio_display_background'][0] : '';
	?>
	
		<?php zilla_post_before(); ?>
		<!--BEGIN .hentry -->
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<?php zilla_post_start(); ?>

			<?php if( $portfolio_display_gallery == 'on' || $portfolio_display_video == 'on' || $portfolio_display_audio == 'on' ) { 

				$bg_class = '';
				$data_url = '';
				if( $portfolio_display_bg == 'on' ) {
					$bg_class = 'custom-bg ';
					if( $port_meta['_zilla_background_cover'][0] == 'on' ) {
						$bg_url = esc_url($port_meta['_zilla_background_image_url'][0]);
						if( !empty($bg_url) ) {
							$data_url = " data-url='$bg_url'";
						}
					}
				}
				?>
					
				<div class="<?php echo $bg_class; ?>post-media default-bg"<?php echo $data_url; ?>>
					
					<?php 
					if( $portfolio_display_gallery == 'on' ) {
						$gallery_type = ( array_key_exists('_zilla_portfolio_gallery_layout', $port_meta) ) ? $port_meta['_zilla_portfolio_gallery_layout'][0] : '';
						if( $gallery_type == 'slider' )
							zilla_gallery_js($post->ID, true);
						zilla_gallery($post->ID, '', $gallery_type, true);
					}

					if( $portfolio_display_video == 'on' ) {
						$embed = $port_meta['_zilla_video_embed_code'][0];
						echo '<div class="media-element media-video">';
						if( !empty($embed) ) {
							echo do_shortcode(stripslashes(htmlspecialchars_decode(esc_html($embed))));
						} else {
							zilla_video($post->ID, 750);
						}
						echo '</div>';
					}

					if( $portfolio_display_audio == 'on' ) {
						echo '<div class="media-element media-audio">';
							zilla_audio($post->ID, 750);
						echo '</div>';
					}
					?>
					
				</div>
			<?php } ?>
						
			<div class="block clearfix">
								
				<!--BEGIN .entry-content -->
				<div class="entry-content">
					<?php the_content(__('Continue Reading', 'zilla')); ?>
					<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'zilla').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<!--END .entry-content -->
				</div>

				<div class="entry-meta entry-header">
		        <?php 
		        	if( $date ) {
		            	printf( '<span class="published">%1$s <span class="portfolio-meta">%2$s</span></span>', __('Date:', 'zilla'), esc_html($date) );
		            }

		            if( $client ) {
		            	printf( '<span class="client">%1$s <span class="portfolio-meta">%2$s</span></span>', __('Client:', 'zilla'), esc_html($client) );
		            }

		            $terms = get_the_terms( $post->ID, 'portfolio-type' );
		            if( !empty( $terms ) ) {
		            	$term_list = '';
		            	foreach( $terms as $term ) {
		            		$term_list .= '<span class="portfolio-meta">' . $term->name . '</span>';
		            	}
		            	printf( '<span class="skills">%1$s %2$s</span>', __('Skills:', 'zilla'), $term_list );
		            }

		            if( $url ) {
		            	printf( '<a href="%1$s" class="portfolio-url">%2$s</a>',
		            		esc_url($url),
		            		__('Launch Project', 'zilla') );
		            }	        
		      
		      		edit_post_link( __('Edit', 'zilla'), '<span class="edit-post">', '</span>' ); 
		      	?>
		            
		        <!--END .entry-meta entry-header -->
		        </div>
						
			</div>

        <?php zilla_post_end(); ?>
        <!--END .hentry-->  
		</div>
		<?php zilla_post_after(); ?>
		
		<?php 
			$display_related = zilla_get_option('portfolio_display_related_portfolios');
			if( $display_related == 'true' ) {
				get_template_part('content', 'related-portfolios');
			}
			get_sidebar('home-full-column');
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

<?php get_footer();