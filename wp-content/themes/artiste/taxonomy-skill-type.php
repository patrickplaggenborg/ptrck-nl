<?php get_header(); ?>
			
            <!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			<?php global $query_string; query_posts( $query_string . '&posts_per_page=-1&orderby=menu_order&order=ASC'); ?>
			<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
				
				<!--BEGIN .hentry -->
				<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">				
				    <?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
					<div class="post-thumb">
						<a title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
						    <?php the_post_thumbnail('portfolio-thumb'); ?>
						</a>
					</div>
					<?php } ?>
					
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"> <?php the_title(); ?></a></h2>
									
					<!--BEGIN .entry-meta -->
					<div class="entry-meta">
						<span class="entry-skills"><?php the_terms($post->ID, 'skill-type', '', ', ', ''); ?></span>
					<!--END .entry-meta -->
					</div>
                
				<!--END .hentry-->  
				</div>

				<?php endwhile; endif; ?>

			<!--BEGIN .navigation .page-navigation -->
			<div class="navigation page-navigation">
				<div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'framework')) ?></div>
				<div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'framework')) ?></div>
			<!--END .navigation .page-navigation -->
			</div>

			<!--END #primary .hfeed-->
			</div>

<?php get_footer(); ?>