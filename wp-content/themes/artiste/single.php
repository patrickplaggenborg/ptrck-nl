<?php get_header(); ?>
			
			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<!--BEGIN .hentry -->
				<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">				
					<h2 class="entry-title"><?php the_title(); ?></h2>
					
					<!--BEGIN .entry-container -->
					<div class="entry-container">
					
					   <!--BEGIN .entry-meta -->
					   <div class="entry-meta">
					       <h4><?php _e('Posted', 'framework') ?></h4>
					       <span><?php the_time( get_option('date_format') ); ?></span>
					                           
					                           <h4><?php _e('Categories', 'framework'); ?></h4>
					                           <span><?php the_category('<br />'); ?></span>
					                           
					                           <?php the_tags('<h4>' . __('Tags', 'framework') . '</h4><span>', '<br />', '</span>' ); ?>
					       
					       <h4>Comments</h4>
					       <span class="comment-count"><?php comments_popup_link(__('No Comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span>
					       
					       <?php if( is_user_logged_in() ) { echo '<h4>' . __('Edit', 'framework') . '</h4>'; } ?>
					       <?php edit_post_link( __('edit', 'framework'), '<span class="edit-post">[', ']</span>' ); ?>
					   <!--END .entry-meta -->
					   </div>
					   
					   <?php /* if the post has a WP 2.9+ Thumbnail */
					   $display_img = get_option('tz_display_featured_img');
					   if ( function_exists('has_post_thumbnail') && has_post_thumbnail() && ($display_img == __('Yes', 'framework')) ) { ?>
					   <div class="post-thumb">
					       <?php the_post_thumbnail('thumbnail-large'); /* post thumbnail settings configured in functions.php */ ?>
					   </div>
					   <?php } ?>
					   
					   <!--BEGIN .entry-content -->
					   <div class="entry-content">
					       <?php the_content(); ?>
					       <?php wp_link_pages('before=<p class="page-navigation">Pages:&after=</p>&next_or_number=number&pagelink=%'); ?>
					   <!--END .entry-content -->
					   </div>
					
					<!-- END .entry-container -->   
					</div>		

				<!--END .hentry-->  
				</div>
                
                <?php comments_template('', true); ?>
                
				<?php endwhile; ?>
            
            <?php if( !is_attachment() ) { ?>
			<!--BEGIN .navigation .single-page-navigation -->
			<div class="navigation single-page-navigation clearfix">

				<div class="nav-next"><?php next_post_link('&larr; %link'); ?></div>
				<div class="nav-previous"><?php previous_post_link('%link &rarr;'); ?></div>

			<!--END .navigation .single-page-navigation -->
			</div>
			<?php } ?>

			<?php else : ?>

				<!--BEGIN #post-0-->
				<div id="post-0" <?php post_class(); ?>>
				
					<h2 class="entry-title"><?php _e('Error 404 - Not Found', 'framework') ?></h2>
				
					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e("Sorry, but you are looking for something that isn't here.", "framework") ?></p>
					<!--END .entry-content-->
					</div>
				
				<!--END #post-0-->
				</div>

			<?php endif; ?>
			<!--END #primary .hfeed-->
			</div>

<?php get_footer(); ?>