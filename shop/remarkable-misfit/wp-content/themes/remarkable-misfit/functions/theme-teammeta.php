<?php

/*-----------------------------------------------------------------------------------*/
/*	Define Metabox Fields
/*-----------------------------------------------------------------------------------*/

$prefix = 'gt_';
 
$meta_box_team = array(
	'id' => 'team_member',
    'title' => __('Team Member Details', 'kula'),
    'page' => 'team',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
        	'name' =>  __('Speaker Title', 'kula'),
            'desc' => __('Enter the Title of the Speaker', 'kula'),
            'id' => $prefix . 'member_email',
            'type' => 'text',
            'std' => ''
        ),
        array(
           'name' => __('Twitter', 'kula'),
           'desc' => __('Enter your Twitter Profile URL <br />(ie; http://twitter.com/guuthemes)', 'kula'),
           'id' => $prefix . 'member_twitter',
           'type' => 'text',
           'std' => ''
        ),
        array(
           'name' => __('Facebook', 'kula'),
           'desc' => __('Enter your Facebook Profile URL <br />(ie; http://facebook.com/guuthemes)', 'kula'),
           'id' => $prefix . 'member_facebook',
           'type' => 'text',
           'std' => ''
        ),
        array(
           'name' => __('Linkedin', 'kula'),
           'desc' => __('Enter your Linkedin Profile URL <br />(ie; http://linkedin.com/in/guuthemes)', 'kula'),
           'id' => $prefix . 'member_linkedin',
           'type' => 'text',
           'std' => ''
        ),
        array(
           'name' => __('Pinterest', 'kula'),
           'desc' => __('Enter your Pinterest Profile URL <br />(ie; http://pinterest.com/guuthemes)', 'kula'),
           'id' => $prefix . 'member_pinterest',
           'type' => 'text',
           'std' => ''
        ),
        array(
           'name' => __('Google Plus', 'kula'),
           'desc' => __('Enter your Google + Profile URL <br />(ie; http://plus.google.com/1030594445)', 'kula'),
           'id' => $prefix . 'member_googleplus',
           'type' => 'text',
           'std' => ''
        ),
        array(
           'name' => __('Flickr', 'kula'),
           'desc' => __('Enter your Flickr Profile URL <br />(ie; http://flickr.com/guuthemes)', 'kula'),
           'id' => $prefix . 'member_flickr',
           'type' => 'text',
           'std' => ''
        ),
        array(
           'name' => __('Instagram', 'kula'),
           'desc' => __('Enter your Instagram Profile URL <br />(ie; http://Instagram.com/guuthemes)', 'kula'),
           'id' => $prefix . 'member_dribbble',
           'type' => 'text',
           'std' => ''
        ),
        array(
           'name' => __('YouTube', 'kula'),
           'desc' => __('Enter your YouTube Profile URL <br />(ie; http://youtube.com/user/guuthemes)', 'kula'),
           'id' => $prefix . 'member_youtube',
           'type' => 'text',
           'std' => ''
        ),
        array(
           'name' => __('Vimeo', 'kula'),
           'desc' => __('Enter your Vimeo Profile URL <br />(ie; http://vimeo.com/guuthemes)', 'kula'),
           'id' => $prefix . 'member_vimeo',
           'type' => 'text',
           'std' => ''
        )
    )
);

add_action('admin_menu', 'gt_add_box_team');

/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/

function gt_show_box_team() {
    global $meta_box_team, $post;
	
	// Use nonce for verification
	echo '<input type="hidden" name="gt_add_box_team_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

	echo '<table class="form-table">';
		
	foreach ($meta_box_team['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
			
			echo '<tr style="border-bottom:1px solid #eeeeee;">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';
			echo '</td></tr>';
		
		}
		
		echo '</table>';
}

add_action('save_post', 'gt_save_data_team');

/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/
 
function gt_add_box_team() {
	global $meta_box_team;
	
	add_meta_box($meta_box_team['id'], $meta_box_team['title'], 'gt_show_box_team', $meta_box_team['page'], $meta_box_team['context'], $meta_box_team['priority']);
}

// Save data from meta box
function gt_save_data_team($post_id) {
    global $meta_box_team;

    // verify nonce
    if ( !isset($_POST['gt_add_box_team_nonce']) || !wp_verify_nonce($_POST['gt_add_box_team_nonce'], basename(__FILE__))) {
    	return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box_team['fields'] as $field) { // save each option
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) { // compare changes to existing values
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}