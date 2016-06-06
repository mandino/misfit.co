<?php

/*-----------------------------------------------------------------------------------*/
/*	Define Metabox Fields
/*-----------------------------------------------------------------------------------*/

$prefix = 'gt_';
 
$meta_box_quotes = array(
		'id' => 'quote_details',
        'title' => __('Quote Details', 'kula'),
        'page' => 'quotes',
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
        	array(
        		'name' => __('Quote', 'kula'),
        	    'desc' => __('Enter a short quote or testimonial', 'kula'),
        	    'id' => $prefix . 'quotes_quote',
        	    'type' => 'text',
        	    'std' => ''
        	),
            array(
            	'name' => __('Author Name', 'kula'),
                'desc' => __('Enter the author name of the above quote <br />(ie; Orson Welles)', 'kula'),
                'id' => $prefix . 'quotes_author',
                'type' => 'text',
                'std' => ''
            )
    )
);

add_action('admin_menu', 'gt_add_box_quotes');

/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/

function gt_show_box_quotes() {
    global $meta_box_quotes, $post;
	
	// Use nonce for verification
	echo '<input type="hidden" name="gt_add_box_quotes_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

	echo '<table class="form-table">';
		
	foreach ($meta_box_quotes['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
			
			echo '<tr>',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';
			echo '</td></tr>';
		
		}
		
		echo '</table>';
}

add_action('save_post', 'gt_save_data_quotes');

/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/
 
function gt_add_box_quotes() {
	global $meta_box_quotes;
	
	add_meta_box($meta_box_quotes['id'], $meta_box_quotes['title'], 'gt_show_box_quotes', $meta_box_quotes['page'], $meta_box_quotes['context'], $meta_box_quotes['priority']);
}

// Save data from meta box
function gt_save_data_quotes($post_id) {
    global $meta_box_quotes;

    // verify nonce
    if ( !isset($_POST['gt_add_box_quotes_nonce']) || !wp_verify_nonce($_POST['gt_add_box_quotes_nonce'], basename(__FILE__))) {
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

    foreach ($meta_box_quotes['fields'] as $field) { // save each option
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) { // compare changes to existing values
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}