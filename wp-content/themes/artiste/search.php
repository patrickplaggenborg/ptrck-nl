<?php get_header(); ?>
			
		<!--BEGIN #primary .hfeed-->
		<div id="primary" class="hfeed">
			
			<?php 
				// set page to load all returned results
			    global $query_string;
    			query_posts( $query_string . '&posts_per_page=-1' );
    			if( have_posts() ) : 
			?>

			    <h1 class="page-title"><?php printf( __('Search Results for: &ldquo;%s&rdquo;', 'framework'), get_search_query()); ?></h1>
                
                <div class="search_posts">
                    <h2><?php _e('Posts', 'framework'); ?></h2>
                    <ol>
    			<?php 
    			    // return only our post items
    			    $i = 0;
    			    while( have_posts() ) : the_post(); 
                        if( $post->post_type == 'post' ) {
                            $i++;
                            printf('<li><h4><a href="%1$s">%2$s</a></h4><p>%3$s</p></li>', get_permalink(), get_the_title(), get_the_excerpt()); 
                        }
                    endwhile;
                    if( $i == 0 ) { printf('<li>%s</li>', __('No posts match the search terms', 'framework')); }
                ?>
                    </ol>
                </div>
            
                <div class="search_portfolio">
                    <h2><?php _e('Portfolios', 'framework'); ?></h2>
                    <ol>
                <?php 
                    // rewind the posts to filter for portfolio items
                    rewind_posts();
                    $i = 0;
                    while( have_posts() ) : the_post();
                        if( $post->post_type == 'portfolio' ) {
                            $i++;
                            printf('<li><h4><a href="%1$s">%2$s</a></h4><p>%3$s</p></li>', get_permalink(), get_the_title(), get_the_excerpt()); 
                        }
                    endwhile; 
                    if( $i == 0 ) { printf('<li>%s</li>', __('No portfolios match the search terms', 'framework')); }
                ?>
                    </ol>
                </div>
			<?php else : ?>
				
				<h1 class="page-title"><?php printf( __('Your search for <em>"%s"</em> did not match any entries','framework'), get_search_query() ); ?></h1 >
				
				<!--BEGIN #post-0-->
				<div id="post-0">
					
					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<?php get_search_form(); ?>
						<p><?php _e('Suggestions:','framework') ?></p>
						<ul>
							<li><?php _e('Make sure all words are spelled correctly.', 'framework') ?></li>
							<li><?php _e('Try different keywords.', 'framework') ?></li>
							<li><?php _e('Try more general keywords.', 'framework') ?></li>
						</ul>
					<!--END .entry-content-->
					</div>
					
				<!--END #post-0-->
				</div>

			<?php endif; ?>
			<!--END #primary .hfeed-->
			</div>

<?php get_footer(); ?>