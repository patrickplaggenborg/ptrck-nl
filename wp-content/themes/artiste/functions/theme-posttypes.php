<?php

/*-----------------------------------------------------------------------------------

	Add Portfolio Post Type

-----------------------------------------------------------------------------------*/

/* Create the Portfolio Custom Post Type ------------------------------------------*/
function tz_create_post_type_portfolio() 
{
	$labels = array(
		'name' => __( 'Portfolios','framework'),
		'singular_name' => __( 'Portfolio','framework' ),
		'add_new' => __('Add New','framework'),
		'add_new_item' => __('Add New Portfolio','framework'),
		'edit_item' => __('Edit Portfolio','framework'),
		'new_item' => __('New Portfolio','framework'),
		'view_item' => __('View Portfolio','framework'),
		'search_items' => __('Search Portfolio','framework'),
		'not_found' =>  __('No portfolio found','framework'),
		'not_found_in_trash' => __('No portfolio found in Trash','framework'), 
		'parent_item_colon' => ''
	  );
	  
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','custom-fields', 'page-attributes'),
		'rewrite' => array('slug'=>'portfolio','with_front'=>false)
	  ); 
	  
	  register_post_type('portfolio',$args);
}

/* Create the Skill Type Taxonomy --------------------------------------------*/
function tz_build_taxonomies(){
    $labels = array(
        'name' => __( 'Skill Type', 'framework' ),
        'singular_name' => __( 'Skill Type', 'framework' ),
        'search_items' =>  __( 'Search Skills', 'framework' ),
        'popular_items' => __( 'Popular Skills', 'framework' ),
        'all_items' => __( 'All Skills', 'framework' ),
        'parent_item' => __( 'Parent Skill', 'framework' ),
        'parent_item_colon' => __( 'Parent Skill:', 'framework' ),
        'edit_item' => __( 'Edit Skill', 'framework' ), 
        'update_item' => __( 'Update Skill', 'framework' ),
        'add_new_item' => __( 'Add New Skill', 'framework' ),
        'new_item_name' => __( 'New Skill Name', 'framework' ),
        'separate_items_with_commas' => __( 'Separate skills with commas', 'framework' ),
        'add_or_remove_items' => __( 'Add or remove skills', 'framework' ),
        'choose_from_most_used' => __( 'Choose from the most used skills', 'framework' ),
        'menu_name' => __( 'Skills', 'framework' )
    );
    
	register_taxonomy('skill-type', 'portfolio', array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'skill-type' )
	));
}

/* Enable Sorting of the Portfolio ------------------------------------------*/
function tz_create_portfolio_sort_page() {
    $tz_sort_page = add_submenu_page('edit.php?post_type=portfolio', 'Sort Portfolios', __('Sort Portfolios', 'framework'), 'edit_posts', basename(__FILE__), 'tz_portfolio_sort');
    
    add_action('admin_print_styles-' . $tz_sort_page, 'tz_print_sort_styles');
    add_action('admin_print_scripts-' . $tz_sort_page, 'tz_print_sort_scripts');
}

function tz_portfolio_sort() {
    $portfolios = new WP_Query('post_type=portfolio&posts_per_page=-1&orderby=menu_order&order=ASC');
?>
    <div class="wrap">
        <div id="icon-tools" class="icon32"><br /></div>
        <h2><?php _e('Sort Portfolios', 'framework'); ?></h2>
        <p><?php _e('Click, drag, re-order. Repeat as neccessary. Portfolio at the top will appear first.', 'framework'); ?></p>

        <ul id="portfolio_list">
            <?php while( $portfolios->have_posts() ) : $portfolios->the_post(); ?>
                <?php if( get_post_status() == 'publish' ) { ?>
                    <li id="<?php the_id(); ?>" class="menu-item">
                        <dl class="menu-item-bar">
                            <dt class="menu-item-handle">
                                <span class="menu-item-title"><?php the_title(); ?></span>
                            </dt>
                        </dl>
                        <ul class="menu-item-transport"></ul>
                    </li>
                <?php } ?>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </ul>
    </div>
<?php }

function tz_save_portfolio_sorted_order() {
    global $wpdb;
    
    $order = explode(',', $_POST['order']);
    $counter = 0;
    
    foreach($order as $portfolio_id) {
        $wpdb->update($wpdb->posts, array('menu_order' => $counter), array('ID' => $portfolio_id));
        $counter++;
    }
    die(1);
}

function tz_print_sort_scripts() {
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('tz_portfolio_sort', get_template_directory_uri() . '/admin/js/tz_portfolio_sort.js');
}

function tz_print_sort_styles() {
    wp_enqueue_style('nav-menu');
}


/* Add Custom Columns ------------------------------------------------------*/
function tz_portfolio_edit_columns($columns){  

    $columns = array(  
        "cb" => "<input type=\"checkbox\" />",  
        "title" => __( 'Portfolio Item Title', 'framework' ),
        "type" => __( 'Skill Type', 'framework' )
    );  

    return $columns;  
}  
  
function tz_portfolio_custom_columns($column){  
    global $post;  
    switch ($column)  
    {    
        case __( 'type', 'framework' ):  
            echo get_the_term_list($post->ID, __( 'skill-type', 'framework' ), '', ', ','');  
            break;
    }  
}  

/* Call our custom functions ---------------------------------------------*/
add_action( 'init', 'tz_create_post_type_portfolio' );
add_action( 'init', 'tz_build_taxonomies', 0 );

add_action('admin_menu', 'tz_create_portfolio_sort_page');
add_action('wp_ajax_portfolio_sort', 'tz_save_portfolio_sorted_order');

add_filter("manage_edit-portfolio_columns", "tz_portfolio_edit_columns");  
add_action("manage_posts_custom_column",  "tz_portfolio_custom_columns");