<?php

/*-----------------------------------------------------------------------------------

	Here we have all the custom functions for the theme
	Please be extremely cautious editing this file,
	When things go wrong, they tend to go wrong in a big way.
	You have been warned!

-------------------------------------------------------------------------------------*/


/**
 * Set Max Content Width
 *
 * @since Sparks 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 750;


if( !function_exists( 'zilla_content_width' ) ) :
/**
 * Adjust the content_width for the full width page and single image
 * attachment templates.
 *
 * @since Sparks 1.0
 *
 * @return void
 */
function zilla_content_width() {
    if ( is_page_template( 'template-full-width.php' ) || is_attachment() ) {
        global $content_width;
        $content_width = 980;
    }
}
endif; 
add_action( 'template_redirect', 'zilla_content_width' );


if ( !function_exists( 'zilla_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers various features supported
 * by Sparks
 * 
 * @uses load_theme_textdoman() For translation support
 * @uses register_nav_menu() To add support for navigation menu
 * @uses add_theme_support() To add support for post-thumbnails and post-formats
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size
 * @uses add_image_size() To add additional image sizes
 *
 * @since Sparks 1.0
 *
 * @return void
 */
function zilla_theme_setup() {
    
    /* Load translation domain --------------------------------------------------*/
	load_theme_textdomain( 'zilla', get_template_directory() . '/languages' );
    
	/* Register WP 3.0+ Menus ---------------------------------------------------*/
	register_nav_menu( 'primary-menu', __('Primary Menu', 'zilla') );
	
	/* Configure WP 2.9+ Thumbnails ---------------------------------------------*/
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 750, 9999 ); // Normal post thumbnails
    add_image_size( 'portfolio-2col', 450, 321 ); // 2 col portfolio pages
    add_image_size( 'portfolio-3col', 280, 200 ); // 3 col portfolio pages
	
	/* Add support for post formats ---------------------------------------------*/
	add_theme_support( 'post-formats', array( 'audio', 'gallery', 'image', 'link', 'quote', 'video' ) );

    /* Theme uses own gallery styles --------------------------------------------*/
    add_filter( 'use_default_gallery_style', '__return_false' );
}
endif;
add_action( 'after_setup_theme', 'zilla_theme_setup' );


if ( !function_exists( 'zilla_sidebars_init' ) ) :
/**
 * Register the sidebars for the theme
 *
 * @since Sparks 1.0
 *
 * @uses register_sidebar() To add sidebar areas
 * @return void
 */
function zilla_sidebars_init() {
	register_sidebar(array(
		'name' => __('Main Sidebar', 'zilla'),
		'description' => __('Widget area for blog pages.', 'zilla'),
		'id' => 'sidebar-main',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
    register_sidebars(3, array(
        'name' => __('Footer Column %d', 'zilla'),
        'id' => 'footer-column',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
    register_sidebars(3, array(
        'name' => __('Home Page Column %d', 'zilla'),
        'id' => 'home-page-column',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'name' => __('Portfolio Pages Full Width Column', 'zilla'),
        'description' => __('Widget area for a full width column widget area in the home page template and portfolio pages.', 'zilla'),
        'id' => 'home-page-full-column',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
endif;
add_action( 'widgets_init', 'zilla_sidebars_init' );


if ( !function_exists( 'zilla_excerpt_length' ) ) :
/**
 * Sets a custom excerpt length for portfolios
 *
 * @since Sparks 1.0
 *
 * @param int $length Excerpt length
 * @return int New excerpt length
 */
function zilla_excerpt_length($length) {
    if( get_post_type() == 'portfolio' )
        return 15;
    else
    	return 55; 
}
endif;
add_filter('excerpt_length', 'zilla_excerpt_length');


if ( !function_exists( 'zilla_excerpt_more' ) ) :
/**
 * Replaces [...] in excerpt string
 *
 * @since Sparks 1.0
 *
 * @param string $excerpt Existing excerpt
 * @return string
 */
function zilla_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt); 
}
endif;
add_filter('wp_trim_excerpt', 'zilla_excerpt_more');


if ( !function_exists( 'zilla_wp_title' ) ) :
/**
 * Creates formatted and more specific title element for output based
 * on current view
 *
 * @since Sparks 1.0
 *
 * @param string $title Default title text
 * @param string $sep Optional separator
 * @return string Formatted title
 */
function zilla_wp_title( $title, $sep ) {
	if( !zilla_is_third_party_seo() ){
        global $paged, $page;

        if( is_feed() )
            return $title;

        $title .= get_bloginfo( 'name' );

        $site_description = get_bloginfo( 'description', 'display' );
        if( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

		if( $paged >= 2 || $page >= 2 )
            $title = "$title $sep " . sprintf( __('Page %s', 'zilla'), max( $paged, $page ) );
	}
	return $title;
}
endif;
add_filter('wp_title', 'zilla_wp_title', 10, 2);


if ( !function_exists( 'zilla_enqueue_scripts' ) ) :
/**
 * Enqueues scripts and styles for front end
 *
 * @since Sparks 1.0
 *
 * @return void
 */
function zilla_enqueue_scripts() {
    /* Register our scripts -----------------------------------------------------*/
    wp_register_script('validation', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js', 'jquery', '1.9', TRUE);
	wp_register_script('superfish', get_template_directory_uri() . '/js/superfish.js', 'jquery', '1.7.4', TRUE);
    wp_register_script('zillaMobileMenu', get_template_directory_uri() . '/js/jquery.zillamobilemenu.min.js', 'jquery', '0.1', TRUE);
    wp_register_script('fitVids', get_template_directory_uri() . '/js/jquery.fitvids.min.js', 'jquery', '1.0', TRUE);
    wp_register_script('isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', 'jquery', '1.5.25', TRUE);
    wp_register_script('jPlayer', get_template_directory_uri() . '/js/jquery.jplayer.min.js', 'jquery', '2.3', TRUE);
    wp_register_script('backstretch', get_template_directory_uri() . '/js/jquery.backstretch.min.js', 'jquery', '2.0.3', TRUE);
    wp_register_script('cycle2', get_template_directory_uri() . '/js/jquery.cycle2.min.js', array('jquery'), '20121219', TRUE);
    wp_register_script('cycle2-center', get_template_directory_uri() . '/js/jquery.cycle2.center.min.js', 'cycle2', '20121121', TRUE);
    wp_register_script('cycle2-sparksHorz', get_template_directory_uri() . '/js/jquery.cycle2.sparksHorz.min.js', 'cycle2', '', TRUE);
	wp_register_script('zilla-custom', get_template_directory_uri() . '/js/jquery.custom.js', array('jquery', 'superfish', 'zillaMobileMenu', 'isotope', 'fitVids', 'cycle2', 'cycle2-sparksHorz'), '1.0', TRUE);
	
	/* Enqueue our scripts ------------------------------------------------------*/
	wp_enqueue_script('jquery');
    wp_enqueue_script('zillaMobileMenu');
	wp_enqueue_script('superfish');
    wp_enqueue_script('fitVids');
    wp_enqueue_script('isotope');
    wp_enqueue_script('jPlayer');
    wp_enqueue_script('cycle2');
    wp_enqueue_script('cycle2-sparksHorz');
    wp_enqueue_script('cycle2-center');
	wp_enqueue_script('zilla-custom');
	
    /* loads the javascript required for threaded comments ----------------------*/
	if( is_singular() && comments_open() && get_option( 'thread_comments') ) 
        wp_enqueue_script( 'comment-reply' ); 

	if( is_page_template('template-contact.php') ) 
        wp_enqueue_script('validation');

    if( is_singular('portfolio') || is_singular('post') )
        wp_enqueue_script('backstretch');

    /* Load our stylesheets -----------------------------------------------------*/
    $zilla_options = get_option('zilla_framework_options');
    wp_enqueue_style( $zilla_options['theme_name'], get_stylesheet_uri() );
    wp_enqueue_style( 'PTSerifFont', 'http://fonts.googleapis.com/css?family=PT+Serif:400,400italic' );
}
endif;
add_action('wp_enqueue_scripts', 'zilla_enqueue_scripts');


if ( !function_exists( 'zilla_enqueue_admin_scripts' ) ) :
/**
 * Enqueues scripts for back end
 *
 * @since Sparks 1.0
 *
 * @return void
 */
function zilla_enqueue_admin_scripts() {
    wp_register_script( 'zilla-admin', get_template_directory_uri() . '/includes/js/jquery.custom.admin.js', 'jquery' );
    wp_enqueue_script( 'zilla-admin' );
}
endif;
add_action( 'admin_enqueue_scripts', 'zilla_enqueue_admin_scripts' );


if ( !function_exists( 'zilla_add_portfolio_to_rss' ) ) :
/**
 * Adds portfolios to RSS feed
 *
 * @since Sparks 1.0
 *
 * @param obj $request
 * @return obj Updated request
 */
function zilla_add_portfolio_to_rss( $request ) {
    if (isset($request['feed']) && !isset($request['post_type']))
        $request['post_type'] = array('post', 'portfolio');

    return $request;
}
endif;
add_filter('request', 'zilla_add_portfolio_to_rss');


if( !function_exists('zilla_post_meta') ) :
/**
 * Print HTML meta information for current post
 *
 * @since Sparks 1.0
 *
 * @return void
 */
function zilla_post_meta() { ?>
    <!--BEGIN .entry-meta .entry-header-->
    <div class="entry-meta entry-header">
    <?php 
        printf( '<span class="published"><a href="%1$s" title="%2$s" rel="bookmark">%3$s</a></span>',
            esc_url( get_permalink() ),
            esc_attr( get_the_time() ),
            esc_html( get_the_time( get_option('date_format') ) ) 
        );
    ?>
        
        <span class="middot">&middot;</span>

        <span class="comment-count"><?php comments_popup_link(__('No Comments', 'zilla'), __('1 Comment', 'zilla'), __('% Comments', 'zilla')); ?></span>

        <?php edit_post_link( __('Edit', 'zilla'), '<span class="edit-post">', '</span>' ); ?>
        
    <!--END .entry-meta entry-header -->
    </div>
    <?php        
}
endif;


if( !function_exists('zilla_post_meta_single') ) :
/**
 * Print HTML meta information for current post single view
 *
 * @since Sparks 1.0
 *
 * @return void
 */
function zilla_post_meta_single() { ?>
    <!--BEGIN .entry-meta .entry-header-->
    <div class="entry-meta entry-header">
    <?php 
        printf( '<span class="author">%1$s <a href="%2$s" title="%3$s" rel="author">%4$s</a></span>',
            __('Posted by:', 'zilla'),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __('View all posts by %s', 'zilla' ), get_the_author() ) ),
            get_the_author()
        );

        printf( '<span class="published">%1$s <a href="%2$s" title="%3$s" rel="bookmark">%4$s</a></span>',
            __('Date:', 'zilla'),
            esc_url( get_permalink() ),
            esc_attr( get_the_time() ),
            esc_html( get_the_time( get_option('date_format') ) ) 
        );
    ?>
        
        <span class="entry-categories"><?php _e('Categories:', 'zilla') ?> <?php the_category(' '); ?></span>
    
        <span class="entry-tags"><?php the_tags(__('Tagged:', 'zilla'), '', ''); ?></span>
            
        <?php edit_post_link( __('Edit', 'zilla'), '<span class="edit-post">', '</span>' ); ?>
        
    <!--END .entry-meta entry-header -->
    </div>
    <?php        
}
endif;


if( ! function_exists( 'zilla_paging_nav' ) ) :
/**
 * Display navigation to next/prev if needed
 *
 * @since Sparks 1.0
 *
 * @return void
 */
function zilla_paging_nav() {
    global $wp_query;

    if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
        return;
    ?>
    
    <!--BEGIN .navigation .page-navigation -->
    <div class="navigation page-navigation block" role="navigation">
        <?php if( get_next_posts_link() ) { ?>
        <div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'zilla')) ?></div>
        <?php } ?>

        <?php if( get_previous_posts_link() ) { ?>
        <div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'zilla')) ?></div>
        <?php } ?>
    <!--END .navigation .page-navigation -->
    </div>
    
    <?php
}
endif;


if ( !function_exists( 'zilla_comment' ) ) :
/**
 * Custom comment HTML output
 *
 * @since Sparks 1.0
 *
 * @param $comment
 * @param $args
 * @param $depth
 * @return void
 */
function zilla_comment($comment, $args, $depth) {

    $isByAuthor = false;

    if($comment->comment_author_email == get_the_author_meta('email')) {
        $isByAuthor = true;
    }

    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

        <div id="comment-<?php comment_ID(); ?>">
            
            <div class="comment-body">
                <?php comment_text() ?>
            </div>
            
            <div class="comment-author vcard">
                <?php printf(__('<cite class="fn">%s</cite> ', 'zilla'), get_comment_author_link()) ?> <?php if($isByAuthor) { ?><span class="author-tag"><?php _e('(Author)', 'zilla') ?></span><?php } ?>
            </div>

            <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s', 'zilla'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'zilla'),'  ','') ?> &middot; <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>

            <?php if ($comment->comment_approved == '0') : ?>
                <em class="moderation"><?php _e('Your comment is awaiting moderation.', 'zilla') ?></em><br />
            <?php endif; ?>

        </div>
<?php
}
endif;


if ( !function_exists( 'zilla_list_pings' ) ) :
/**
 * Separate pings from comments 
 *
 * @since Sparks 1.0
 *
 * @param $comment
 * @param $args 
 * @param $depth
 * @return void
 */
function zilla_list_pings($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
	<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
	<?php 
}
endif;


if( !function_exists( 'zilla_commentform_before' ) ) :
/**
 * Insert HTML before comment form
 *
 * @since Sparks 1.0
 *
 * @return void
 */
function zilla_commentform_before() {
    echo '<div class="block">';
}
endif;
add_action( 'comment_form_before', 'zilla_commentform_before' );


if( !function_exists( 'zilla_commentform_after' ) ) :
/**
 * Insert HTML after comment form
 *
 * @since Sparks 1.0
 *
 * @return void
 */
function zilla_commentform_after() {
    echo '</div><!--END .block-->';
}
endif;
add_action( 'comment_form_after', 'zilla_commentform_after' );


if ( !function_exists( 'zilla_gallery_js' ) ) :
/**
 * Print the JS code for galleries
 *
 * @since Sparks 1.0
 *
 * @param int $id ID of the post
 * @param boolean $single Optional flag to set view for single post view
 * @return void
 */
function zilla_gallery_js( $postid, $single = false ) { 
?>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            var $zillaSlider = $('#zilla-gallery-<?php echo $postid; ?>').find('.media-gallery');

            $zillaSlider.cycle({
                autoHeight: 0,
                <?php if( $single ) { ?>
                    fx: 'sparksHorz',
                <?php } else { ?>
                    fx: 'scrollHorz',
                <?php } ?>
                slides: '> li',
                speed: 500,
                timeout: 0,
                <?php if( $single ) { ?>
                    centerHorz: true,
                <?php } ?>
                updateView: 1, // fire update view one time
                next: '#zilla-slide-next-<?php echo esc_js($postid); ?>',
                prev: '#zilla-slide-prev-<?php echo esc_js($postid); ?>'
            });

            $zillaSlider.on('cycle-update-view', function(e,o,sh,cs) {
                var $this = $(this),
                    $currentSlide = $(cs);

                    $this.animate({
                        height: $currentSlide.height()
                    }, 300); // adjust height on slide transition

                $(window).resize(function() {
                    $this.stop().animate({
                        height: $currentSlide.height()
                    }, 500);
                }); // adjust height of slide on screen resize
            });
        });
    </script>
<?php
} 
endif;


if ( !function_exists( 'zilla_gallery' ) ) :
/**
 * Print the HTML for galleries
 *
 * @since Sparks 1.0
 *
 * @param int $id ID of the post
 * @param string $imagesize Optional size of image
 * @param string $layout Optional layout format 
 * @param boolean $single Optional flag to set view for single post view
 * @return void
 */
function zilla_gallery($postid, $imagesize = '', $layout = 'stacked', $single = false) { 

    $image_ids_raw = get_post_meta($postid, '_zilla_image_ids', true);
    if( $image_ids_raw != '' ) {
        // custom gallery created
        $image_ids = explode(',', $image_ids_raw);
        $orderby = 'post__in';
        $post_parent = null;
    } else {
        // pull all images attached to post
        $image_ids = '';
        $orderby = 'menu_order';
        $post_parent = $postid;
    }

    // get all image attachments
    $args = array(
        'include' => $image_ids,
        'numberposts' => -1,
        'orderby' => $orderby,
        'order' => 'ASC',
        'post_type' => 'attachment',
        'post_parent' => $post_parent,
        'post_mime_type' => 'image',
        'post_status' => null
    );
    $attachments = get_posts($args);
    if( !empty($attachments) ) {
        echo "<!-- BEGIN #slider-$postid -->\n<div id='zilla-gallery-$postid' class='$layout'>";
        echo '<ul class="media-gallery">';

        foreach( $attachments as $attachment ) {
            $src = wp_get_attachment_image_src( $attachment->ID, $imagesize );
            $caption = $attachment->post_excerpt;
            $caption = ($caption) ? "<div class='slide-caption'>$caption</div>" : '';
            $alt = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
            echo "<li><div>$caption<img height='$src[2]' width='$src[1]' src='$src[0]' alt='$alt' /></div></li>";
        }

        echo '</ul>';

        if( $layout !== 'stacked' ) {
            if( $single ) {
                echo '<a href="#" id="zilla-slide-prev-'. $postid .'" class="zilla-slide-prev-full">' . __('Previous', 'zilla') . '</a>';
                echo '<a href="#" id="zilla-slide-next-'. $postid .'" class="zilla-slide-next-full">' . __('Next', 'zilla') . '</a>';
            } else {
                echo '<a href="#" id="zilla-slide-prev-'. $postid .'" class="zilla-slide-prev">' . __('Previous', 'zilla') . '</a>';
                echo '<a href="#" id="zilla-slide-next-'. $postid .'" class="zilla-slide-next">' . __('Next', 'zilla') . '</a>';
            }
        }
        echo "<!-- END #slider-$postid -->\n</div>";
    }
}
endif;


if ( !function_exists( 'zilla_audio' ) ) :
/**
 * Print HTML for audio post format media
 *
 * @since Sparks 1.0
 *
 * @param int $postid Post ID
 * @param int $width Width of the media area
 * @param int $height Height of the media area
 * @return void
 */
function zilla_audio($postid, $width = 560, $height = 300) {

    $mp3 = get_post_meta($postid, '_zilla_audio_mp3', TRUE);
    $ogg = get_post_meta($postid, '_zilla_audio_ogg', TRUE);
    $poster = get_post_meta($postid, '_zilla_audio_poster_url', TRUE);
    $height = get_post_meta($postid, '_zilla_audio_height', TRUE);  
?>
        <script type="text/javascript">
    
            jQuery(document).ready(function($){

                if( $().jPlayer ) {
                    $("#jquery-jplayer-audio-<?php echo $postid; ?>").jPlayer({
                        ready: function () {
                            $(this).jPlayer("setMedia", {
                                <?php if($poster != '') : ?>
                                poster: "<?php echo esc_js($poster); ?>",
                                <?php endif; ?>
                                <?php if($mp3 != '') : ?>
                                mp3: "<?php echo esc_js($mp3); ?>",
                                <?php endif; ?>
                                <?php if($ogg != '') : ?>
                                oga: "<?php echo esc_js($ogg); ?>",
                                <?php endif; ?>
                                end: ""
                            });
                        },
                        <?php if( !empty($poster) ) { ?>
                        size: {
                            width: "100%",
                            height: "<?php echo esc_js($height); ?>px"
                        },
                        <?php } ?>
                        preload: 'auto',
                        swfPath: "<?php echo get_template_directory_uri(); ?>/js",
                        cssSelectorAncestor: "#jp-audio-interface-<?php echo esc_js($postid); ?>",
                        supplied: "<?php if($ogg != '') : ?>oga,<?php endif; ?><?php if($mp3 != '') : ?>mp3<?php endif; ?>"
                    });
                
                }
            });
        </script>
    
        <div id="jp-container-<?php echo $postid; ?>" class="jp-audio">
            <div class="jp-type-single">
                <div id="jquery-jplayer-audio-<?php echo $postid; ?>" class="jp-jplayer" data-orig-width="<?php echo $width; ?>" data-orig-height="<?php echo $height; ?>"></div>
                <div id="jp-audio-interface-<?php echo $postid; ?>" class="jp-interface">
                    <ul class="jp-controls">
                        <li><a href="#" class="jp-play" tabindex="1" title="play">play</a></li>
                        <li><a href="#" class="jp-pause" tabindex="1" title="pause">pause</a></li>
                        <li><a href="#" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                        <li><a href="#" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                    </ul>
                    <div class="jp-progress">
                        <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                        </div>
                    </div>
                    <div class="jp-volume-bar">
                        <div class="jp-volume-bar-value"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php 
}
endif;


if ( !function_exists( 'zilla_video' ) ) :
/**
 * Print HTML for video post format media
 *
 * @since Sparks 1.0
 *
 * @param int $postid Post ID
 * @param int $width Width of the media area
 * @param int $height Height of the media area
 * @return void
 */
function zilla_video($postid, $width = 560, $height = 300) {

    $height = get_post_meta($postid, '_zilla_video_height', true);
    $m4v = get_post_meta($postid, '_zilla_video_m4v', true);
    $ogv = get_post_meta($postid, '_zilla_video_ogv', true);
    $poster = get_post_meta($postid, '_zilla_video_poster_url', true);

?>
<script type="text/javascript">
    jQuery(document).ready(function($){
    
        if( $().jPlayer ) {
            $("#jquery-jplayer-video-<?php echo $postid; ?>").jPlayer({
                ready: function () {
                    $(this).jPlayer("setMedia", {
                        <?php if($m4v != '') : ?>
                        m4v: "<?php echo esc_js($m4v); ?>",
                        <?php endif; ?>
                        <?php if($ogv != '') : ?>
                        ogv: "<?php echo esc_js($ogv); ?>",
                        <?php endif; ?>
                        <?php if ($poster != '') : ?>
                        poster: "<?php echo esc_js($poster); ?>"
                        <?php endif; ?>
                    });
                },
                size: {
                    width: "100%",
                    height: "<?php echo esc_js($height); ?>px"
                },
                preload: 'auto',
                swfPath: "<?php echo get_template_directory_uri(); ?>/js",
                cssSelectorAncestor: "#jp-video-container-<?php echo esc_js($postid); ?>",
                supplied: "<?php if($m4v != '') : ?>m4v, <?php endif; ?><?php if($ogv != '') : ?>ogv<?php endif; ?>"
            });

            $('#jquery-jplayer-video-<?php echo esc_js($postid); ?>').bind($.jPlayer.event.playing, function(event) {
                $(this).add('#jp-video-interface-<?php echo esc_js($postid); ?>').hover( function() {
                    $('#jp-video-interface-<?php echo esc_js($postid); ?>').stop().animate({ opacity: 1 }, 400);
                }, function() {
                    $('#jp-video-interface-<?php echo esc_js($postid); ?>').stop().animate({ opacity: 0 }, 400);
                });
            });
            
            $('#jquery-jplayer-video-<?php echo esc_js($postid); ?>').bind($.jPlayer.event.pause, function(event) {
                $('#jquery-jplayer-video-<?php echo esc_js($postid); ?>').add('#jp-video-interface-<?php echo esc_js($postid); ?>').unbind('hover');
                $('#jp-video-interface-<?php echo esc_js($postid); ?>').stop().animate({ opacity: 1 }, 400);
            });
        }
    });
</script>

<div id="jp-video-container-<?php echo $postid; ?>" class="jp-video jp-video-normal">
    <div class="jp-type-single">
        <div id="jquery-jplayer-video-<?php echo $postid; ?>" class="jp-jplayer" data-orig-width="<?php echo $width; ?>" data-orig-height="<?php echo $height; ?>"></div>
        <div class="jp-gui">
        <div id="jp-video-interface-<?php echo $postid; ?>" class="jp-interface">
            <ul class="jp-controls">
                <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
            </ul>
            <div class="jp-progress">
                <div class="jp-seek-bar">
                    <div class="jp-play-bar"></div>
                </div>
            </div>
            <div class="jp-volume-bar">
                <div class="jp-volume-bar-value"></div>
            </div>
        </div>
    </div>
    </div>
</div>

<?php }
endif;


if( !function_exists( 'zilla_get_page_title' ) ) :
/**
 * Return formatted title for the current view page
 *
 * @since Sparks 1.0
 *
 * @return string Formatted title
 */
function zilla_get_page_title() {
    $page_title = '';

    if( is_singular() ) {
        if( is_page() ) {
            $page_title = get_the_title();
        } elseif( is_single() ) {
            $page_title = get_the_title();
        }
    } else {
        if( is_home() ) {
            $page_title = zilla_get_option('general_default_page_title');
        } elseif( is_archive() ) {
            if( is_category() ) {
                $page_title = sprintf( __( 'All posts in: %s', 'zilla' ), single_cat_title('', false) );
            } elseif( is_tag() ) {
                $page_title = sprintf( __( 'All posts in: %s', 'zilla' ), single_tag_title('', false) );
            } elseif( is_date() ) {
                if( is_month() ) {
                    $page_title = sprintf( __( 'Archive for: %s', 'zilla' ), get_the_time( 'F, Y' ) );
                } elseif( is_year() ) {
                    $page_title = sprintf( __( 'Archive for: %s', 'zilla' ), get_the_time( 'Y' ) );
                } elseif( is_day() ) {
                    $page_title = sprintf( __('Archive for: %s', 'zilla' ), get_the_time( get_option('date_format') ) );
                } else {
                    $page_title = __('Blog Archives', 'zilla');
                }
            } elseif( is_author() ) {
                if(get_query_var('author_name')) {
                    $curauth = get_user_by( 'login', get_query_var('author_name') );
                } else {
                    $curauth = get_userdata(get_query_var('author'));
                }
                $page_title = $curauth->display_name;
            } else {
                $page_title = single_term_title('', false);
            }
        } elseif( is_search() ) {
            $page_title = sprintf( __( 'Search Results for &#8220;%s&#8221;', 'zilla' ), get_search_query() );
        }
    }

    return $page_title;
}
endif;


if( !function_exists( 'zilla_get_page_caption' ) ) :
/**
 * Returns formatted page caption for current view
 *
 * @since Sparks 1.0
 *
 * @return string Formatted page caption
 */
function zilla_get_page_caption() {
    $page_caption = '';

    if( is_singular() ) {
        $id = get_the_ID();
        if( is_page() ) {
            $page_caption = get_post_meta($id, '_zilla_page_caption', true);
        } elseif( is_singular('portfolio') ) {
            $page_caption = get_post_meta($id, '_zilla_portfolio_caption', true);
        } else {
            $page_caption = false;
        }
    } else {
        if( is_home() ) {
            $page_caption = zilla_get_option('general_default_page_caption');
        } elseif( is_archive() ) {
            if( is_category() ) {
                $page_caption = strip_tags(category_description(), '<a><b><em><br>');
            } elseif( is_tag() ) {
                $page_caption = strip_tags(tag_description(), '<a><b><em><br>');
            } else {
                $page_caption = term_description();
            }
        }
    }

    return $page_caption;
}
endif;


if( !function_exists( 'zilla_get_posts_related_by_taxonomy' ) ) :
/**
 * Get the posts related by taxonomy
 * 
 * @since Sparks 1.0
 *
 * @param int $post_id post ID
 * @param string $taxonomy the taxonomy to search by
 * @param array $args optional additional arguments
 * @return obj $query the resulting query
 */
function zilla_get_posts_related_by_taxonomy($post_id, $taxonomy, $args = array() ) {
    $terms = wp_get_object_terms($post_id, $taxonomy);

    if( count($terms) ) {
        $post = get_post($post_id);
        $our_terms = array();
        foreach ($terms as $term) {
            $our_terms[] = $term->slug;
        }
        $args = wp_parse_args($args, array(
            'post_type' => $post->post_type,
            'post__not_in' => array($post_id),
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'terms' => $our_terms,
                    'field' => 'slug',
                    'operator' => 'IN'
                )
            ),
            'orderby' => 'rand'
            )
        );
        $query = new WP_Query($args);
        return $query;
    } else {
        return false;
    }
}
endif;


if( !function_exists( 'zilla_set_portfolio_args' ) ) :
/**
 * Set up the query args for the portfolio type taxonomy
 * 
 * @since Sparks 1.0
 *
 * @param obj $query
 * @return void
 */
function zilla_set_portfolio_args( $query ) {
    if( is_admin() || !$query->is_main_query() )
        return;

    if( is_tax( 'portfolio-type' ) ) {
        $query->set( 'posts_per_page', -1 );
        $query->set( 'orderby', 'menu_order' );
        $query->set( 'order', 'ASC' );
        return;
    }
}
endif;
add_action( 'pre_get_posts', 'zilla_set_portfolio_args' );


if( !function_exists( 'zilla_portfolio_type_template_selector' ) ) :
/**
 * Override the default portfolio type archive to use the portfolio archive
 * http://billerickson.net/reusing-wordpress-theme-files/
 *
 * @since Sparks 1.0
 *
 * @param $template
 * @return $template
 */
function zilla_portfolio_type_template_selector( $template ) {
    if( is_tax( 'portfolio-type' ) ) {
        $template = get_query_template( 'archive-portfolio' );
    }

    if( is_post_type_archive( 'portfolio' ) ) {
        $template = get_query_template( 'template-portfolio-3col' );
    }

    return $template;
}
endif;
add_filter( 'template_include', 'zilla_portfolio_type_template_selector' );


if( !function_exists('zilla_set_custom_background') ) :
/**
 * Returns the CSS for custom backgrounds
 *
 * @since Sparks 1.0
 *
 * @param string $content existing CSS content
 * @return string $content of CSS
 */
function zilla_set_custom_background($content) {
    $posts = get_posts( 
        array(
            'numberposts' => -1,
            'post_status' => array('publish', 'private'),
            'post_type' => array('post', 'portfolio'),
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => '_zilla_portfolio_display_background',
                    'value' => 'on'
                ),
                array(
                    'key' => '_zilla_post_display_background',
                    'value' => 'on'
                )
            )
        )
    );

    if( empty($posts) ) return $content;

    $i = 0;
    
    foreach( $posts as $post ) {
        if( $i == 0 ) $output = '/* Custom Portfolios */';
        $i++;

        $id = $post->ID;
        if( $post->post_type == 'portfolio' ) {
            $custom_bg = get_post_meta($id, '_zilla_portfolio_display_background', true);
        } else {
            $custom_bg = get_post_meta($id, '_zilla_post_display_background', true);
        }

        if( $custom_bg == 'on' ) {
            // we need custom code
            $bg_cover = get_post_meta($id, '_zilla_background_cover', true);
            if( $bg_cover == 'on' ) {
                // custom will be handled with JS
                continue;
            }

            $output .= "\n.postid-$id .post-media {\n";

            $bg_url = get_post_meta($id, '_zilla_background_image_url', true);

            if( !empty($bg_url) ) {
                $bg_repeat = get_post_meta($id, '_zilla_background_repeat', true);
                $bg_position = get_post_meta($id, '_zilla_background_position', true);

                $output .= "\tbackground-image: url($bg_url);\n";
                $output .= "\tbackground-repeat: $bg_repeat;\n";
                $output .= "\tbackground-position: top $bg_position;\n";
            }

            $bg_color = get_post_meta($id, '_zilla_background_color', true);
            $bg_color = ( !empty($bg_color) && $bg_color != '#' ) ? $bg_color : 'transparent';
            $output .= "\tbackground-color: $bg_color;\n";
            
            $output .= "}\n";
        }

    }

    $content .= $output . "\n";

    return $content;
}
endif;
add_filter( 'zilla_custom_styles', 'zilla_set_custom_background' );

/*-----------------------------------------------------------------------------------*/
/*	Include the framework
/*-----------------------------------------------------------------------------------*/

$tempdir = get_template_directory();
require_once($tempdir .'/framework/init.php');
require_once($tempdir .'/includes/init.php');

?>