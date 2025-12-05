<?php

/* These are functions specific to the included option settings and this theme */


/*-----------------------------------------------------------------------------------*/
/* Output Custom CSS from theme options
/*-----------------------------------------------------------------------------------*/

function tz_head_css() {

		$shortname =  get_option('tz_shortname'); 
		$output = '';
		
		$custom_css = get_option('tz_custom_css');
		
		if ($custom_css <> '') {
			$output .= $custom_css . "\n";
		}
		
		// Output styles
		if ($output <> '') {
			$output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo stripslashes($output);
		}
	
}

add_action('wp_head', 'tz_head_css');


/*-----------------------------------------------------------------------------------*/
/* Add Body Classes for Layout
/*-----------------------------------------------------------------------------------*/

add_filter('body_class','tz_body_class');
 
function tz_body_class($classes) {
	$shortname = get_option('tz_shortname');
	$layout = get_option($shortname .'_layout');
	if ($layout == '') {
		$layout = 'layout-2cr';
	}
	$classes[] = $layout;
	return $classes;
}


/*-----------------------------------------------------------------------------------*/
/* Add Favicon
/*-----------------------------------------------------------------------------------*/

function tz_favicon() {
	$shortname = get_option('tz_shortname');
	if (get_option($shortname . '_custom_favicon') != '') {
	echo '<link rel="shortcut icon" href="'. get_option('tz_custom_favicon') .'"/>'."\n";
	}
}

add_action('wp_head', 'tz_favicon');


/*-----------------------------------------------------------------------------------*/
/* Show analytics code in footer */
/*-----------------------------------------------------------------------------------*/

function tz_analytics(){
	$shortname =  get_option('tz_shortname');
	$output = get_option($shortname . '_google_analytics');
	if ( $output <> "" ) 
		echo stripslashes($output) . "\n";
}
add_action('wp_footer','tz_analytics');

/*-----------------------------------------------------------------------------------*/
/*	Get related posts by taxonomy
/*-----------------------------------------------------------------------------------*/

function get_posts_related_by_taxonomy($post_id, $taxonomy, $args=array()) {
  $query = new WP_Query();
  $terms = wp_get_object_terms($post_id, $taxonomy);
  if (count($terms)) {
    // Assumes only one term for per post in this taxonomy
    $post_ids = get_objects_in_term($terms[0]->term_id,$taxonomy);
    $post = get_post($post_id);
    $our_terms = array();
    foreach($terms as $term) {
        $our_terms[] = $term->slug;
    }
    $args = wp_parse_args($args,array(
        'post_type' => $post->post_type, // The assumes the post types match
        //'post__in' => $post_ids,
        'post__not_in' => array($post_id),
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'terms' => $our_terms,
                'field' => 'slug',
                'operator' => 'IN'
            )
        ),
        'orderby' => 'rand',
        'posts_per_page' => get_option('tz_portfolio_related_number')
    ));
    $query = new WP_Query($args);
  }
  return $query;
}


/*-----------------------------------------------------------------------------------*/
/* Output image */
/*-----------------------------------------------------------------------------------*/

function tz_image($postid, $imagesize) {
    $thumbid = 0;
    
    // get the featured image for the post
    if( has_post_thumbnail($postid) ) {
        $thumbid = get_post_thumbnail_id($postid);
    }

    $image_ids_raw = get_post_meta($postid, 'tz_image_ids', true);

    if( $image_ids_raw ) {
        // Using WP3.5; use post__in orderby option
        $image_ids = explode(',', $image_ids_raw);
        $temp_id = $postid;
        $postid = null;
        $orderby = 'post__in';
        $include = $image_ids;
    } else {
        $orderby = 'menu_order';
        $include = '';
    }

    // get first 2 attachments for the post
    $args = array(
        'include' => $include,
        'orderby' => $orderby,
        'post_type' => 'attachment',
        'post_parent' => $postid,
        'post_mime_type' => 'image',
        'post_status' => null,
        'numberposts' => 2
    );
    $attachments = get_posts($args);

    $postid = ( isset($temp_id) ) ? $temp_id : $postid;

    if( !empty($attachments) ) {
        foreach( $attachments as $attachment ) {
            // if current image is featured image reloop
            if( $attachment->ID == $thumbid ) continue;
            $src = wp_get_attachment_image_src( $attachment->ID, $imagesize );
            $alt = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
            echo "<div class='image-frame'>";
            echo "<img height='$src[2]' width='$src[1]' src='$src[0]' alt='$alt' />";
            echo "</div>";
            // got image, time to exit foreach
            break;
        }
    }   
    
}

/*-----------------------------------------------------------------------------------*/
/* Output gallery slideshow */
/*-----------------------------------------------------------------------------------*/
function tz_gallery($postid, $imagesize) { ?>
    <script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#slider-<?php echo $postid; ?>").slides({
				preload: true,
				preloadImage: jQuery("#slider-<?php echo $postid; ?>").attr('data-loader'), 
				generatePagination: false,
				generateNextPrev: true,
				next: 'slides_next',
				prev: 'slides_prev',
				effect: 'fade',
				crossfade: true,
				autoHeight: true,
				bigTarget: true,
				animationComplete: function(current) {
				    jQuery('#slide_current').text(current);
				}
			});
		});
	</script>
<?php 
    // get stylesheet to load proper ajax-loader image
    $style = get_option('tz_alt_stylesheet');
    $loader = ($style == 'dark.css') ? 'ajax-loader-dark.gif' : 'ajax-loader.gif';
    
    $thumbid = 0;

    // get the featured image for the post
    if( has_post_thumbnail($postid) ) {
        $thumbid = get_post_thumbnail_id($postid);
    }

    echo "<!-- BEGIN #slider-## -->\n<div id='slider-$postid' class='slider' data-loader='" . get_template_directory_uri() . "/images/$loader'>";
    
    $image_ids_raw = get_post_meta($postid, 'tz_image_ids', true);

    if( $image_ids_raw ) {
        // Using WP3.5; use post__in orderby option
        $image_ids = explode(',', $image_ids_raw);
        $temp_id = $postid;
        $postid = null;
        $orderby = 'post__in';
        $include = $image_ids;
    } else {
        $orderby = 'menu_order';
        $include = '';
    }

    // get all of the attachments for the post
    $args = array(
        'include' => $include,
        'orderby' => $orderby,
        'post_type' => 'attachment',
        'post_parent' => $postid,
        'post_mime_type' => 'image',
        'post_status' => null,
        'numberposts' => -1
    );
    $attachments = get_posts($args);

    $postid = ( isset($temp_id) ) ? $temp_id : $postid;
    
    if( !empty($attachments) ) {
        echo '<div class="slides_container">';
        $i = 0;
        foreach( $attachments as $attachment ) {
            if( $attachment->ID == $thumbid ) continue;
            $src = wp_get_attachment_image_src( $attachment->ID, $imagesize );
            $alt = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
            echo "<div><img height='$src[2]' width='$src[1]' src='$src[0]' alt='$alt' /></div>";
            $i++;
        }
        echo '</div>';
        echo "<span class='slide_count'>" . __('Image <span id="slide_current">1</span> of', 'framework') . " $i</span>";
    }

    echo "<!-- END #slider-## -->\n</div>";
}

/*-----------------------------------------------------------------------------------*/
/* Output video */
/*-----------------------------------------------------------------------------------*/
function tz_video($postid) {
	
	$height = get_post_meta($postid, 'tz_video_height', true);
	$m4v = get_post_meta($postid, 'tz_video_m4v', true);
	$ogv = get_post_meta($postid, 'tz_video_ogv', true);
	$poster = get_post_meta($postid, 'tz_video_poster', true);
	
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		
		if(jQuery().jPlayer) {
			jQuery("#jquery_jplayer_<?php echo $postid; ?>").jPlayer({
				ready: function () {
					jQuery(this).jPlayer("setMedia", {
						<?php if($m4v != '') : ?>
						m4v: "<?php echo $m4v; ?>",
						<?php endif; ?>
						<?php if($ogv != '') : ?>
						ogv: "<?php echo $ogv; ?>",
						<?php endif; ?>
						<?php if ($poster != '') : ?>
						poster: "<?php echo $poster; ?>"
						<?php endif; ?>
					});
				},
				size: {
				    width: "700px",
				    height: "<?php echo $height . 'px'; ?>"
				},
				swfPath: "<?php echo get_template_directory_uri(); ?>/js",
				cssSelectorAncestor: "#jp_interface_<?php echo $postid; ?>",
				supplied: "<?php if($m4v != '') : ?>m4v, <?php endif; ?><?php if($ogv != '') : ?>ogv, <?php endif; ?> all"
			});
		}
	});
</script>

<div id="jquery_jplayer_<?php echo $postid; ?>" class="jp-jplayer jp-jplayer-video"></div>

<div class="jp-video-container">
    <div class="jp-video">
        <div class="jp-type-single">
            <div id="jp_interface_<?php echo $postid; ?>" class="jp-interface">
                <ul class="jp-controls">
                	<li><div class="seperator-first"></div></li>
                    <li><div class="seperator-second"></div></li>
                    <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                    <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                    <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                    <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                </ul>
                <div class="jp-progress-container">
                    <div class="jp-progress">
                        <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                        </div>
                    </div>
                </div>
                <div class="jp-volume-bar-container">
                    <div class="jp-volume-bar">
                        <div class="jp-volume-bar-value"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php }

/*-----------------------------------------------------------------------------------*/
/*	Output Audio
/*-----------------------------------------------------------------------------------*/

function tz_audio($postid) {
	
	$mp3 = get_post_meta($postid, 'tz_audio_mp3', TRUE);
	$ogg = get_post_meta($postid, 'tz_audio_ogg', TRUE);
	
?>

		<script type="text/javascript">
		
			jQuery(document).ready(function(){
	
				if(jQuery().jPlayer) {
					jQuery("#jquery_jplayer_<?php echo $postid; ?>").jPlayer({
						ready: function () {
							jQuery(this).jPlayer("setMedia", {
							    <?php if($mp3 != '') : ?>
								mp3: "<?php echo $mp3; ?>",
								<?php endif; ?>
								<?php if($ogg != '') : ?>
								oga: "<?php echo $ogg; ?>",
								<?php endif; ?>
								end: ""
							});
						},
						swfPath: "<?php echo get_template_directory_uri(); ?>/js",
						cssSelectorAncestor: "#jp_interface_<?php echo $postid; ?>",
						supplied: "<?php if($ogg != '') : ?>oga,<?php endif; ?><?php if($mp3 != '') : ?>mp3, <?php endif; ?> all"
					});
					
				}
			});
		</script>
		
	    <div id="jquery_jplayer_<?php echo $postid; ?>" class="jp-jplayer jp-jplayer-audio"></div>

        <div class="jp-audio-container">
            <div class="jp-audio">
                <div class="jp-type-single">
                    <div id="jp_interface_<?php echo $postid; ?>" class="jp-interface">
                        <ul class="jp-controls">
                        	<li><div class="seperator-first"></div></li>
                            <li><div class="seperator-second"></div></li>
                            <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                            <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                            <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                            <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                        </ul>
                        <div class="jp-progress-container">
                            <div class="jp-progress">
                                <div class="jp-seek-bar">
                                    <div class="jp-play-bar"></div>
                                </div>
                            </div>
                        </div>
                        <div class="jp-volume-bar-container">
                            <div class="jp-volume-bar">
                                <div class="jp-volume-bar-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php 
}