<?php

if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 250, 250, true );
}

add_action('init', 'portfolio_register');  

function portfolio_register() {
    $labels = array(
        'name' => __('Portfolio', 'kula'),
        'add_new' => __('Add New', 'kula'),
        'add_new_item' => __('Add New Portfolio Item', 'kula'),
        'edit_item' => __('Edit Portfolio Item', 'kula'),
        'new_item' => __('New Portfolio Item', 'kula'),
        'view_item' => __('View Portfolio Item', 'kula'),
        'search_items' => __('Search Portfolio Items', 'kula'),
        'not_found' => __('No items found', 'kula'),
        'not_found_in_trash' => __('No items found in Trash', 'kula'), 
        'parent_item_colon' => '',
        'menu_name' => 'Portfolio'
        );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'rewrite' => array('slug' => 'project', 'with_front' => false),
        'supports' => array('title', 'editor', 'thumbnail', 'comments')
       );  

    register_post_type( 'portfolio' , $args );
}

add_action('contextual_help', 'portfolio_help_text', 10, 3);
function portfolio_help_text($contextual_help, $screen_id, $screen) {
    if ('portfolio' == $screen->id) {
        $contextual_help =
        '<h3>' . __('Things to remember when adding a Portfolio item:', 'kula') . '</h3>' .
        '<ul>' .
        '<li>' . __('Give the item a title. The title will be used as the item\'s headline.', 'kula') . '</li>' .
        '<li>' . __('You can choose to insert either single images, image slideshow, or video, below.', 'kula') . '</li>' .
        '<li>' . __('Enter your portfolio item overview into the Visual or HTML area. The text will appear for your project overview.', 'kula') . '</li>' .
        '<li>' . __('Choose (or first create) a Project Type. You will need to use these to enable the filterable Portfolio option.', 'kula') . '</li>' .
        '</ul>';
    }
    elseif ('edit-portfolio' == $screen->id) {
        $contextual_help = '<p>' . __('A list of all Portfolio items appear below. To edit an item, click on the items\'s title.', 'kula') . '</p>';
    }
    return $contextual_help;
}

register_taxonomy("project-type", array("portfolio"), array("hierarchical" => true, "label" => "Project Type", "singular_label" => "Project Type", "rewrite" => true));

add_filter("manage_edit-portfolio_columns", "portfolio_edit_columns");   

function portfolio_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Project Name",
            "type" => "Project Type",
        );  

        return $columns;
}

add_action("manage_posts_custom_column",  "portfolio_custom_columns"); 

function portfolio_custom_columns($column){
        global $post;
        switch ($column)
        {

            case "type":
                echo get_the_term_list($post->ID, 'project-type', '', ', ','');
                break;
        }
}

function enable_portfolio_sort() {
    add_submenu_page('edit.php?post_type=portfolio', 'Sort Portfolio', 'Sort Portfolio Items', 'edit_posts', basename(__FILE__), 'sort_portfolio');
}
add_action('admin_menu' , 'enable_portfolio_sort'); 
 
function sort_portfolio() {
    $portfolios = new WP_Query('post_type=portfolio&posts_per_page=-1&orderby=menu_order&order=ASC');
?>
    <div class="wrap">
    <div id="icon-tools" class="icon32"><br /></div>
    <h2><?php _e('Sort Portfolio Items', 'kula'); ?> <img src="<?php echo home_url(); ?>/wp-admin/images/loading.gif" id="loading-animation" /></h2>
    <p><?php _e('Click, drag, re-order. Repeat as neccessary. Portfolio item at the top will appear first on your page.', 'kula'); ?></p>
    <ul id="post-list">
    <?php while ( $portfolios->have_posts() ) : $portfolios->the_post(); ?>
        <li id="<?php the_id(); ?>"><?php the_title(); ?></li>          
    <?php endwhile; ?>
    </div>
 
<?php
}

function portfolio_print_scripts() {
    global $pagenow;
 
    $pages = array('edit.php');
    if (in_array($pagenow, $pages)) {
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('portfolio-sorter', get_template_directory_uri().'/assets/js/jquery.posttype.sort.js');
    }
}
add_action( 'admin_print_scripts', 'portfolio_print_scripts' );

function portfolio_print_styles() {
    global $pagenow;
 
    $pages = array('edit.php');
    if (in_array($pagenow, $pages))
        wp_enqueue_style('style', get_template_directory_uri('template_url').'/assets/css/custom-admin.css');
}
add_action( 'admin_print_styles', 'portfolio_print_styles' ); 
 
function portfolio_save_order() {
    global $wpdb;
 
    $order = explode(',', $_POST['order']);
    $counter = 0;
 
    foreach ($order as $post_id) {
        $wpdb->update($wpdb->posts, array( 'menu_order' => $counter ), array( 'ID' => $post_id) );
        $counter++;
    }
    die(1);
}
add_action('wp_ajax_post_sort', 'portfolio_save_order');

?>