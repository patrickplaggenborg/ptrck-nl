<?php get_header(); ?>

			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			<?php if (have_posts()) : ?>			
	
	 	  	<?php /* If this is a category archive */ if (is_category()) { ?>
				<h1 class="page-title"><?php printf(__('All posts in %s', 'framework'), single_cat_title('',false)); ?></h1>
	 	  	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
				<h1 class="page-title"><?php printf(__('All posts tagged %s', 'framework'), single_tag_title('',false)); ?></h1>
	 	  	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				<h1 class="page-title"><?php _e('Archive for', 'framework') ?> <?php the_time('F jS, Y'); ?></h1>
	 	 	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<h1 class="page-title"><?php _e('Archive for', 'framework') ?> <?php the_time('F, Y'); ?></h1>
	 		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<h1 class="page-title"><?php _e('Archive for', 'framework') ?> <?php the_time('Y'); ?></h1>
		  	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
				<h1 class="page-title"><?php _e('All posts by', 'framework') ?> <?php echo $curauth->display_name; ?></h1>
	 	  	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<h1 class="page-title"><?php _e('Blog Archives', 'framework') ?></h1>
	 	  	<?php } ?>
	
			<?php while (have_posts()) : the_post(); ?>
			
				<!--BEGIN .hentry -->
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
					
					<!--BEGIN .entry-container -->
					<div class="entry-container">
					
    					<!--BEGIN .entry-meta -->
    					<div class="entry-meta">
    						<h4><?php _e('Posted', 'framework'); ?></h4>
    						<span><?php the_time( get_option('date_format') ); ?></span>
                        
                            <h4><?php _e('Categories', 'framework'); ?></h4>
                            <span><?php the_category('<br />'); ?></span>
                        
                            <?php the_tags('<h4>' . __('Tags', 'framework') . '</h4><span>', '<br />', '</span>' ); ?>
                        
                            <h4><?php _e('Comments', 'framework'); ?></h4>
                            <span class="comment-count"><?php comments_popup_link(__('No Comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span>
                        
                            <?php if( is_user_logged_in() ) { echo '<h4>' . __('Edit', 'framework') . '</h4>'; } ?>
    						<?php edit_post_link( __('edit', 'framework'), '<span class="edit-post">[', ']</span>' ); ?>
					
    					<!--END .entry-meta -->
    					</div>

    					<?php /* if the post has a WP 2.9+ Thumbnail */
    					$display_img = get_option('tz_display_featured_img');
    					if ( function_exists('has_post_thumbnail') && has_post_thumbnail() && ($display_img == __('Yes', 'framework')) ) { ?>
    					<div class="post-thumb">
    					    <a title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail-large'); /* post thumbnail settings configured in functions.php */ ?></a>
    					</div>
    					<?php } ?>
	
    					<!--BEGIN .entry-content -->
    					<div class="entry-content">
    						<?php the_content('Continue Reading'); ?>
    					<!--END .entry-content -->
    					</div>
        
                    <!--END .entry-container -->
                    </div>
        
            	<!--END .hentry -->
				</div>
	
			<?php endwhile; ?>
	
			<!--BEGIN .navigation .page-navigation -->
			<div class="navigation page-navigation">
				<div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'framework')) ?></div>
				<div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'framework')) ?></div>
			<!--END .navigation .page-navigation -->
			</div>
			
			<?php else :
	
			if ( is_category() ) { // If this is a category archive
				printf(__('<h2>Sorry, but there aren\'t any posts in the %s category yet.</h2>', 'framework'), single_cat_title('',false));
			} else if ( is_date() ) { // If this is a date archive
				echo(__('<h2>Sorry, but there aren\'t any posts with this date.</h2>', 'framework'));
			} else if ( is_author() ) { // If this is a category archive
				$userdata = get_userdatabylogin(get_query_var('author_name'));
				printf(__('<h2>Sorry, but there aren\'t any posts by %s yet.</h2>', 'framework'), $userdata->display_name);
			} else {
				echo(__('<h2>No posts found.</h2>', 'framework'));
			}
	
			endif; ?>
			
			<!--END #primary .hfeed-->
			</div>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>