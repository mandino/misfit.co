<?php

if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 250, 250, true );
}

add_action('init', 'team_register');  

function team_register() {
    $labels = array(
        'name' => __('Team', 'kula'),
        'add_new' => __('Add New', 'kula'),
        'add_new_item' => __('Add New Team Member', 'kula'),
        'edit_item' => __('Edit Team Member', 'kula'),
        'new_item' => __('New Team Member', 'kula'),
        'view_item' => __('View Team Member', 'kula'),
        'search_items' => __('Search Team Members', 'kula'),
        'not_found' => __('No items found', 'kula'),
        'not_found_in_trash' => __('No items found in Trash', 'kula'), 
        'parent_item_colon' => '',
        'menu_name' => 'Team'
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
        'supports' => array('title','thumbnail','editor')
       );  

    register_post_type( 'team' , $args );
}

add_action('contextual_help', 'team_help_text', 10, 3);

function team_help_text($contextual_help, $screen_id, $screen) {
    if ('team' == $screen->id) {
        $contextual_help =
        '<h3>' . __('Things to remember when adding a Team Member:', 'kula') . '</h3>' .
        '<ul>' .
        '<li>' . __('Add your Team Member name. (ie; Lana Del Rey).', 'kula') . '</li>' .
        '<li>' . __('Add a short description (Bio) for your member.', 'kula') . '</li>' .
        '<li>' . __('Add a featured image (headshot possibly) to appear above your team member.', 'kula') . '</li>' .
        '<li>' . __('Add a Job Title for your member. (ie; The Boss or Managing Director).', 'kula') . '</li>' .
        '<li>' . __('Add any Social Networks your Team Member belongs to. (ie; Twitter or Linkedin).', 'kula') . '</li>' .
        '</ul>';
    }
    elseif ('edit-team' == $screen->id) {
        $contextual_help = '<p>' . __('A list of all team members appear below. To edit a member, click on the Team Member name.', 'kula') . '</p>';
    }
    return $contextual_help;
}

function team_image_box() {
 	// Remove the orginal "Set Featured Image" Metabox
	remove_meta_box('postimagediv', 'team', 'side');
 	// Add it again with another title
	add_meta_box('postimagediv', __('Team Member Image', 'kula'), 'post_thumbnail_meta_box', 'team', 'side', 'low');
}
add_action('do_meta_boxes', 'team_image_box');

add_filter("manage_edit-team_columns", "team_edit_columns");

function team_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Team Member Name",
            "member_email" => "Member Title",
            "member_description" => "Bio",
        );  

        return $columns;
}

add_action("manage_posts_custom_column",  "team_custom_columns"); 

function team_custom_columns($column){
        global $post;
        switch ($column)
        {

            case "member_email":
                $custom = get_post_custom();
                echo $custom["gt_member_email"][0];
                break;
            case "member_description":
                the_content();
                break;
        }
}

function enable_team_sort() {
    add_submenu_page('edit.php?post_type=team', 'Sort Team', 'Sort Team Members', 'edit_posts', basename(__FILE__), 'sort_team');
}
add_action('admin_menu' , 'enable_team_sort'); 
 
function sort_team() {
    $team = new WP_Query('post_type=team&posts_per_page=-1&orderby=menu_order&order=ASC');
?>
    <div class="wrap">
    <div id="icon-tools" class="icon32"><br /></div>
    <h2><?php _e('Sort Team Members', 'kula'); ?> <img src="<?php echo home_url(); ?>/wp-admin/images/loading.gif" id="loading-animation" /></h2>
    <p><?php _e('Click, drag, re-order. Repeat as neccessary. Team Member at the top will appear first on your page.', 'kula'); ?></p>
    <ul id="post-list">
    <?php while ( $team->have_posts() ) : $team->the_post(); ?>
        <li id="<?php the_id(); ?>"><?php the_title(); ?></li>          
    <?php endwhile; ?>
    </div>
 
<?php
}

function team_print_scripts() {
    global $pagenow;
 
    $pages = array('edit.php');
    if (in_array($pagenow, $pages)) {
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('quote-sorter', get_template_directory_uri().'/assets/js/jquery.posttype.sort.js');
    }
}
add_action( 'admin_print_scripts', 'team_print_scripts' );

function team_print_styles() {
    global $pagenow;
 
    $pages = array('edit.php');
    if (in_array($pagenow, $pages))
        wp_enqueue_style('style', get_template_directory_uri('template_url').'/assets/css/custom-admin.css');
}
add_action( 'admin_print_styles', 'team_print_styles' ); 
 
function team_save_order() {
    global $wpdb;
 
    $order = explode(',', $_POST['order']);
    $counter = 0;
 
    foreach ($order as $post_id) {
        $wpdb->update($wpdb->posts, array( 'menu_order' => $counter ), array( 'ID' => $post_id) );
        $counter++;
    }
    die(1);
}
add_action('wp_ajax_post_sort', 'team_save_order');

?>