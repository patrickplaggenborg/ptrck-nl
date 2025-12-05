<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<!--BEGIN .hentry -->
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					
					<!--BEGIN .entry-content -->
					<div class="entry-content">
						<?php the_content(__('Read more...', 'framework')); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'framework').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<!--END .entry-content -->
					</div>
					
					<!--BEGIN .archive-lists -->
					<div class="archive-lists">
						
						<div class="one_third">
    						<h4><?php _e('Last 30 Posts:', 'framework') ?></h4>
						
    						<ul>
    						<?php $archive_30 = get_posts('numberposts=30');
    						foreach($archive_30 as $post) : ?>
    							<li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
    						<?php endforeach; ?>
    						</ul>
						</div>
						
						<div class="one_third">
    						<h4><?php _e('Archives by Month:', 'framework') ?></h4>
						
    						<ul>
    							<?php wp_get_archives('type=monthly'); ?>
    						</ul>
    					</div>
			            
			            <div class="one_third column-last">
    						<h4><?php _e('Archives by Subject:', 'framework') ?></h4>
						
    						<ul>
    					 		<?php wp_list_categories( 'title_li=' ); ?>
    						</ul>
    					</div>
					
					<!--END .archive-lists -->
					</div>
                
                <!--END .hentry-->  
				</div>
				
				<?php endwhile; else: ?>

				<!--BEGIN #post-0-->
				<div id="post-0" <?php post_class() ?>>
				
					<h1 class="entry-title"><?php _e('Error 404 - Not Found', 'framework') ?></h1>
				
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