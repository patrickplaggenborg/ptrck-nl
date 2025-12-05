<!DOCTYPE html>

<!-- BEGIN html -->
<html <?php language_attributes(); ?>>
<!-- An Orman Clark design (http://www.premiumpixels.com) - Proudly powered by WordPress (http://wordpress.org) -->

<!-- BEGIN head -->
<head>

	<!-- Meta Tags -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<!-- Title -->
	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
	
	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/<?php echo get_option('tz_alt_stylesheet'); ?>" type="text/css" media="screen" />
    <link href="https://fonts.googleapis.com/css?family=PT+Serif:400,400italic,700" rel="stylesheet" type="text/css">
	
	<!-- RSS & Pingbacks -->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php if (get_option('tz_feedburner')) { echo get_option('tz_feedburner'); } else { bloginfo( 'rss2_url' ); } ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>

<!-- END head -->
</head>

<!-- BEGIN body -->
<body <?php body_class(); ?>>

	<!-- BEGIN #container -->
	<div id="container" class="clearfix">
	
		<!-- BEGIN #sidebar -->
		<div id="sidebar">

			<!-- BEGIN #logo -->
			<div id="logo">
				<?php /*
				If "plain text logo" is set in theme options then use text
				if a logo url has been set in theme options then use that
				if none of the above then use the default logo.png */
				if (get_option('tz_plain_logo') == 'true') { ?>
				<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
				<?php } elseif (get_option('tz_logo')) { ?>
				<a href="<?php echo home_url(); ?>"><img src="<?php echo get_option('tz_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
				<?php } else { ?>
				<a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" /></a>
				<?php } ?>
				<p id="tagline"><?php bloginfo( 'description' ); ?></p>
			<!-- END #logo -->
			</div>
			
			<?php get_sidebar(); ?>
			
			<!-- BEGIN #footer -->
            <div id="footer">
                <p class="copyright">&copy; <?php echo date( 'Y' ); ?> Artiste</p>
				<p class="credit">
				    <?php _e('Powered by', 'framework') ?> <a href="http://wordpress.org/">WordPress</a><br />
				    <a href="http://www.themezilla.com/themes/artiste">Artiste</a> by <a href="http://www.themezilla.com">ThemeZilla</a>
				</p>
            </div>
			<!-- END #footer -->
			
		<!--END #sidebar-->
		</div>
		
		<!--BEGIN #content -->
		<div id="content">
		