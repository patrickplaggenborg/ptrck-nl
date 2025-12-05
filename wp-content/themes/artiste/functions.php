<?php

/*-----------------------------------------------------------------------------------

	Here we have all the custom functions for the theme
	Please be extremely cautious editing this file,
	When things go wrong, they tend to go wrong in a big way.
	You have been warned!

-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Load Translation Text Domain
/*-----------------------------------------------------------------------------------*/

load_theme_textdomain ('framework');


/*-----------------------------------------------------------------------------------*/
/*	Set Max Content Width (use in conjuction with ".entry-content img" css)
/*-----------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) ) $content_width = 670;


/*-----------------------------------------------------------------------------------*/
/*	Register Sidebars
/*-----------------------------------------------------------------------------------*/

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Main Sidebar',
		'id' => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Portfolio Sidebar',
		'id' => 'sidebar-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}


/*-----------------------------------------------------------------------------------*/
/*	Configure WP2.9+ Thumbnails
/*-----------------------------------------------------------------------------------*/

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 50, 50, true ); // Normal post thumbnails
	add_image_size( 'thumbnail-large', 530, '', false ); // for blog pages
	add_image_size( 'portfolio-thumb', 210, 140, true ); // for the portfolio home page thumbs
	add_image_size( 'portfolio-main', 700, '', false ); // for the individual portfolio page
}


/*-----------------------------------------------------------------------------------*/
/*	Custom Gravatar Support
/*-----------------------------------------------------------------------------------*/

function tz_custom_gravatar( $avatar_defaults ) {
    $tz_avatar = get_template_directory_uri() . '/images/gravatar.png';
    $avatar_defaults[$tz_avatar] = 'Custom Gravatar (/images/gravatar.png)';
    return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'tz_custom_gravatar' );


/*-----------------------------------------------------------------------------------*/
/*	Change Default Excerpt Length
/*-----------------------------------------------------------------------------------*/

function tz_excerpt_length($length) { return 55; }
add_filter('excerpt_length', 'tz_excerpt_length');


/*-----------------------------------------------------------------------------------*/
/*	Configure Excerpt String
/*-----------------------------------------------------------------------------------*/

function tz_excerpt_more($excerpt) { return str_replace('[...]', '...', $excerpt); }
add_filter('wp_trim_excerpt', 'tz_excerpt_more');


/*-----------------------------------------------------------------------------------*/
/*	Register and load common JS
/*-----------------------------------------------------------------------------------*/

/* load front end scripts -----------------------------------------*/
function tz_enqueue_scripts() {
	// comment out the next two lines to load the local copy of jQuery
	wp_register_script('slides', get_template_directory_uri() . '/js/slides.min.jquery.js', 'jquery', '1.1.9', true);
	wp_register_script('validation', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js', 'jquery');
	wp_register_script('jplayer', get_template_directory_uri() . '/js/jquery.jplayer.min.js', 'jquery', '2.1', true);
	wp_register_script('tz_custom', get_template_directory_uri() . '/js/jquery.custom.js', array('jquery', 'slides', 'jplayer', 'jquery-ui-tabs', 'jquery-ui-accordion'), '1.0', true);

    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('slides');
	wp_enqueue_script('tz_custom');
	
	// load jPlayer on appropriate pages
	if( is_page_template('template-home.php') || ('portfolio' == get_post_type()) ) wp_enqueue_script('jplayer');
	
    // load custom script which shows on the contact page.
    if( is_page_template('template-contact.php') ) wp_enqueue_script('validation');
    
    // load single scripts only on single pages
    if( is_singular() ) wp_enqueue_script( 'comment-reply' ); // loads the javascript required for threaded comments     
}

add_action('wp_enqueue_scripts', 'tz_enqueue_scripts');

/* load validation js for contact form template -----------------*/
function tz_contact_validate() {
	if( is_page_template('template-contact.php') ) { ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#contactForm").validate();
			});
		</script>
	<?php }
}
add_action('wp_head', 'tz_contact_validate');

/* load admin custom script ------------------------------------*/
function tz_admin_enqueue_scripts() {
    wp_register_script('tz_admin_custom', get_template_directory_uri() . '/admin/js/jquery.custom.admin.js', array('jquery'), '1.0');
    wp_enqueue_script('tz_admin_custom');

    wp_enqueue_style('zilla-meta', get_template_directory_uri() . '/admin/css/zilla-meta.css');
}

add_action('admin_enqueue_scripts', 'tz_admin_enqueue_scripts');


/*-----------------------------------------------------------------------------------*/
/*	Add Browser Detection Body Class
/*-----------------------------------------------------------------------------------*/

add_filter('body_class','tz_browser_body_class');
function tz_browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) {
	    $classes[] = 'ie';
	    $browser = $_SERVER[ 'HTTP_USER_AGENT' ];
	    if( preg_match( "/MSIE 7.0/", $browser ) ) {
	        $classes[] = 'ie7';
	    }
    }
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}


/*-----------------------------------------------------------------------------------*/
/*	Comment Styling
/*-----------------------------------------------------------------------------------*/

function tz_comment($comment, $args, $depth) {

    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     
        <div id="comment-<?php comment_ID(); ?>">
            <?php echo get_avatar($comment,$size='40'); ?>
            <div class="comment-author vcard">
                <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
            </div>

            <div class="comment-meta commentmetadata">
                <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s', 'framework'), get_comment_date(),  get_comment_time()) ?></a>
                <?php edit_comment_link(__('(Edit)', 'framework'),'  ','') ?> &middot; <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            </div>
      
            <?php if ($comment->comment_approved == '0') : ?>
                <em class="moderation"><?php _e('Your comment is awaiting moderation.', 'framework') ?></em>
                <br />
            <?php endif; ?>
	  
            <div class="comment-body">
                <?php comment_text() ?>
            </div>

        </div>

<?php
}


/*-----------------------------------------------------------------------------------*/
/*	Seperated Pings Styling
/*-----------------------------------------------------------------------------------*/

function tz_list_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment; ?>
<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }


/*-----------------------------------------------------------------------------------*/
/*	Custom Login Logo Support
/*-----------------------------------------------------------------------------------*/

function tz_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_template_directory_uri().'/images/custom-login-logo.png) !important; background-size: auto auto !important; }
    </style>';
}
function tz_wp_login_url() {
    return home_url();
}
function tz_wp_login_title() {
    return get_option('blogname');
}

add_action('login_head', 'tz_custom_login_logo');
add_filter('login_headerurl', 'tz_wp_login_url');
add_filter('login_headertitle', 'tz_wp_login_title');


/*-----------------------------------------------------------------------------------*/
/*	Load Widgets & Shortcodes
/*-----------------------------------------------------------------------------------*/

// Add the Latest Tweets Custom Widget
include("functions/widget-tweets.php");

// Add the Flickr Photos Custom Widget
include("functions/widget-flickr.php");

// Add the Custom Video Widget
include("functions/widget-video.php");

// Add the Theme Shortcodes
include("functions/theme-shortcodes.php");

// Add the post types and custom metaboxes
include("functions/theme-posttypes.php");
include("functions/theme-portfoliometa.php");

/*-----------------------------------------------------------------------------------*/
/*	Filters that allow shortcodes in Text Widgets
/*-----------------------------------------------------------------------------------*/

add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');

/*-----------------------------------------------------------------------------------*/
/*	Load Theme Options
/*-----------------------------------------------------------------------------------*/

define('TZ_FILEPATH', TEMPLATEPATH);
define('TZ_DIRECTORY', get_template_directory_uri());

require_once (TZ_FILEPATH . '/admin/admin-functions.php');
require_once (TZ_FILEPATH . '/admin/admin-interface.php');
require_once (TZ_FILEPATH . '/functions/theme-options.php');
require_once (TZ_FILEPATH . '/functions/theme-functions.php');
require_once (TZ_FILEPATH . '/tinymce/tinymce.loader.php');

?>