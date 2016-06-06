<?php

if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 250, 250, true );
}

add_action('init', 'quotes_register');  

function quotes_register() {
    $labels = array(
        'name' => __('Quotes', 'kula'),
        'add_new' => __('Add New', 'kula'),
        'add_new_item' => __('Add New Quote', 'kula'),
        'edit_item' => __('Edit Quote Item', 'kula'),
        'new_item' => __('New Quote Item', 'kula'),
        'view_item' => __('View Quote Item', 'kula'),
        'search_items' => __('Search Quote Items', 'kula'),
        'not_found' => __('No items found', 'kula'),
        'not_found_in_trash' => __('No items found in Trash', 'kula'), 
        'parent_item_colon' => '',
        'menu_name' => 'Quotes'
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
        'rewrite' => true,
        'exclude_from_search' => true,
        'supports' => array('title')
       );  

    register_post_type( 'quotes' , $args );
}

add_action('contextual_help', 'quotes_help_text', 10, 3);

function quotes_help_text($contextual_help, $screen_id, $screen) {
    if ('quotes' == $screen->id) {
        $contextual_help =
        '<h3>' . __('Things to remember when adding a Quote:', 'kula') . '</h3>' .
        '<ul>' .
        '<li>' . __('Give the Quote a reference name. This will not appear on your site, and is just for reference purposes (ie; Quote from Jules Verne).', 'kula') . '</li>' .
        '<li>' . __('Enter a short quote or testimonial.', 'kula') . '</li>' .
        '<li>' . __('Enter the name of the quote author.', 'kula') . '</li>' .
        '</ul>';
    }
    elseif ('edit-quotes' == $screen->id) {
        $contextual_help = '<p>' . __('A list of all quotes appear below. To edit a quote, click on the quote Reference Name.', 'kula') . '</p>';
    }
    return $contextual_help;
}

add_filter("manage_edit-quotes_columns", "quotes_edit_columns");   

function quotes_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Reference Name",
            "description" => "Quote",
            "text" => "Author Name"
        );  

        return $columns;
}

add_action("manage_posts_custom_column",  "quotes_custom_columns"); 

function quotes_custom_columns($column){
        global $post;
        switch ($column)
        {
            case "description":
                $custom = get_post_custom();
                echo $custom["gt_quotes_quote"][0];
                break;
            case "text":
                $custom = get_post_custom();
                echo $custom["gt_quotes_author"][0];
                break;
        }
}

function enable_quotes_sort() {
    add_submenu_page('edit.php?post_type=quotes', 'Sort Quotes', 'Sort Quote Items', 'edit_posts', basename(__FILE__), 'sort_quotes');
}
add_action('admin_menu' , 'enable_quotes_sort'); 
 
function sort_quotes() {
    $quotes = new WP_Query('post_type=quotes&posts_per_page=-1&orderby=menu_order&order=ASC');
?>
    <div class="wrap">
    <div id="icon-tools" class="icon32"><br /></div>
    <h2><?php _e('Sort Quote Items', 'kula'); ?> <img src="<?php echo home_url(); ?>/wp-admin/images/loading.gif" id="loading-animation" /></h2>
    <p><?php _e('Click, drag, re-order. Repeat as neccessary. Quote item at the top will appear first on your page.', 'kula'); ?></p>
    <ul id="post-list">
    <?php while ( $quotes->have_posts() ) : $quotes->the_post(); ?>
        <li id="<?php the_id(); ?>"><?php the_title(); ?></li>          
    <?php endwhile; ?>
    </div>
 
<?php
}

function quotes_print_scripts() {
    global $pagenow;
 
    $pages = array('edit.php');
    if (in_array($pagenow, $pages)) {
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('quote-sorter', get_template_directory_uri().'/assets/js/jquery.posttype.sort.js');
    }
}
add_action( 'admin_print_scripts', 'quotes_print_scripts' );

function quotes_print_styles() {
    global $pagenow;
 
    $pages = array('edit.php');
    if (in_array($pagenow, $pages))
        wp_enqueue_style('style', get_template_directory_uri('template_url').'/assets/css/custom-admin.css');
}
add_action( 'admin_print_styles', 'quotes_print_styles' ); 
 
function quotes_save_order() {
    global $wpdb;
 
    $order = explode(',', $_POST['order']);
    $counter = 0;
 
    foreach ($order as $post_id) {
        $wpdb->update($wpdb->posts, array( 'menu_order' => $counter ), array( 'ID' => $post_id) );
        $counter++;
    }
    die(1);
}
add_action('wp_ajax_post_sort', 'quotes_save_order');

?>