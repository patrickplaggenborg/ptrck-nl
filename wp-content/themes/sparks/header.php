<!DOCTYPE html>

<!-- BEGIN html -->
<html <?php language_attributes(); ?>>
<!-- A ThemeZilla design (http://www.themezilla.com) - Proudly powered by WordPress (http://wordpress.org) -->

<!-- BEGIN head -->
<head>

	<!-- Meta Tags -->
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width" />
	<?php
		if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
    	header('X-UA-Compatible: IE=edge,chrome=1');
    ?>
	<?php zilla_meta_head(); ?>
	
	<!-- Title -->
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<!-- RSS & Pingbacks -->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php if(zilla_get_option('general_feedburner_url')){ echo zilla_get_option('general_feedburner_url'); } else { bloginfo( 'rss2_url' ); } ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	<?php wp_head(); ?>
    <?php zilla_head(); ?>
    
<!-- END head -->
</head>

<!-- BEGIN body -->
<body <?php body_class('no-js'); ?>>
    <?php zilla_body_start(); ?>
    
    <?php zilla_header_before(); ?>
	<!-- BEGIN #header -->
	<div id="header" class="block clearfix">
	<?php zilla_header_start(); ?>
		
		<!-- BEGIN #logo -->
		<div id="logo">
			<?php /*
			If "plain text logo" is set in theme options then use text
			if a logo url has been set in theme options then use that
			if none of the above then use the default logo.png */
			if (zilla_get_option('general_text_logo') == 'on') { ?>
			<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
			<p id="tagline"><?php bloginfo( 'description' ); ?></p>
			<?php } elseif (zilla_get_option('general_custom_logo')) { ?>
			<a href="<?php echo home_url(); ?>"><img src="<?php echo zilla_get_option('general_custom_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
			<?php } else { ?>
			<a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" width="114" height="23" /></a>
			<?php } ?>
		<!-- END #logo -->
		</div>
		
		<?php zilla_nav_before(); ?>
		<!-- BEGIN #primary-nav -->
		<div id="primary-nav" class="primary-nav-container" role="navigation">
		    <?php if( has_nav_menu( 'primary-menu' ) ) {
		        wp_nav_menu( array( 
		        	'theme_location' => 'primary-menu', 
		        	'container' => '', 
		        	'menu_id' => 'primary-menu',
		        	'menu_class' => 'sf-menu primary-menu' ) ); 
		    } ?>
		<!-- END #primary-nav -->
		</div>
		<?php zilla_nav_after(); ?>
			
	<?php zilla_header_end(); ?>	
	<!--END #header-->
	</div>
	<?php zilla_header_after(); ?>
	
	<?php 
	if( !is_404() ) {
		if( is_search() ) {
			$format = '';
		} else {
			$format = get_post_format();
		}
		if( is_home() || ( $format != 'quote' && $format != 'link' ) && !is_page_template('template-home.php') ) { ?>
			<div class="page-intro block">
				<h1 class="<?php if( is_single() ) { echo 'entry-title'; } else { echo 'page-title'; }?>"><?php echo stripslashes( esc_html( zilla_get_page_title() ) ); ?></h1>

				<?php if( !is_single() || is_singular('portfolio') ) { ?>
					<p><?php echo stripslashes(htmlspecialchars_decode(esc_html(zilla_get_page_caption()))); ?></p>
				<?php } ?>
			</div>
		<?php } 
	} ?>