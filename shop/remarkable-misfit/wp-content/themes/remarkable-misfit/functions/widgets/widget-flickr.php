<?php
/*
Plugin Name: Flickr Widget
Description: Flickr Widget to display your Flickr images.
Author: GuuThemes
Version: 1.0
Author URI: http://guuhuu.com/
*/

add_action( 'widgets_init', 'gt_flickr_widget' );

function gt_flickr_widget() {
	register_widget( 'gt_flickr_widget' );
}

class gt_flickr_widget extends WP_Widget {
		
	function gt_flickr_widget() {
		$widget_style = array('classname' => 'gt_flickr_widget',
							  'description' => __('Display your Flickr images', 'golden'));
							  
		$widget_define = array('show_id' => 'single_flickr',
							   'get_tips' => 'true',
							   'get_title' => 'true');
							   
		$control_styles = array('id_base' => 'gt_flickr_widget');
								
		$widget_change = array('change1' => 'delay',
							   'change2' => 'effect',
							   'change3' => 'slide',
							   'change4' => 100,
							   'change5' => 0);
							   
		$this->WP_Widget( 'gt_flickr_widget', __('Flickr', 'golden'), $widget_style, $control_styles );	
	}
		
	function widget( $args, $cur_instance ) {
		extract( $args );
		
		$title = apply_filters( 'widget_title', $cur_instance['title'] );
		$flickrID = $cur_instance['flickrID'];
		$postcount = $cur_instance['postcount'];
		$type = $cur_instance['type'];
		$display = $cur_instance['display'];

		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;	
		echo '<div class="flickritems">'; ?>
			<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=v&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script><?php 
		echo '</div>';	
		echo $after_widget;	
	}
		
	function update( $new_instance, $org_instance ) {
		$cur_instance = $org_instance;
		$cur_instance['title'] = strip_tags( $new_instance['title'] );
		$cur_instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
		$cur_instance['show'] = $new_instance['slide'];
		$cur_instance['postcount'] = $new_instance['postcount'];
		$cur_instance['type'] = $new_instance['type'];
		$cur_instance['inline'] = $new_instance['true'];
		$cur_instance['display'] = $new_instance['display'];
		return $cur_instance;
	}
		 
	function form( $cur_instance ) {
		$defaults = array('title' => 'Flickr',
						  'flickrID' => '52617155@N08',
						  'postcount' => '9',
						  'type' => 'user',
						  'display' => 'latest');
		
		$cur_instance = wp_parse_args( (array) $cur_instance, $defaults ); ?>

		<p style="border-bottom: 1px solid #DFDFDF;">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php echo __('Title', 'golden'); ?></strong></label>
		</p>
		<p>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $cur_instance['title']; ?>" />		
		</p>

		<p style="border-bottom: 1px solid #DFDFDF;">
			<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><strong><?php echo __('Flickr ID', 'golden'); ?></strong> (see <a href="http://idgettr.com/" target="_blank">idGettr</a>)</label>
		</p>
		<p>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $cur_instance['flickrID']; ?>" />
		</p>
		
		<p style="border-bottom: 1px solid #DFDFDF;">
			<label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><strong><?php echo __('Number of photos', 'golden'); ?></strong></label>
		</p>
		
		<p>
			<select id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" class="widefat">
				<option <?php if ( '1' == $cur_instance['postcount'] ) echo 'selected="selected"'; ?>>1</option>
				<option <?php if ( '2' == $cur_instance['postcount'] ) echo 'selected="selected"'; ?>>2</option>
				<option <?php if ( '3' == $cur_instance['postcount'] ) echo 'selected="selected"'; ?>>3</option>
				<option <?php if ( '4' == $cur_instance['postcount'] ) echo 'selected="selected"'; ?>>4</option>
				<option <?php if ( '5' == $cur_instance['postcount'] ) echo 'selected="selected"'; ?>>5</option>
				<option <?php if ( '6' == $cur_instance['postcount'] ) echo 'selected="selected"'; ?>>6</option>
				<option <?php if ( '7' == $cur_instance['postcount'] ) echo 'selected="selected"'; ?>>7</option>
				<option <?php if ( '8' == $cur_instance['postcount'] ) echo 'selected="selected"'; ?>>8</option>
				<option <?php if ( '9' == $cur_instance['postcount'] ) echo 'selected="selected"'; ?>>9</option>
			</select>		
		</p>
		
		<p style="border-bottom: 1px solid #DFDFDF;">
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><strong><?php echo __('Type (user or group)', 'golden'); ?></strong></label>
		</p>
		<p>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">	
				<option <?php if ( 'user' == $cur_instance['type'] ) echo 'selected="selected"'; ?>>user</option>
				<option <?php if ( 'group' == $cur_instance['type'] ) echo 'selected="selected"'; ?>>group</option>
			</select>
		</p>
		
		<p style="border-bottom: 1px solid #DFDFDF;">
			<label for="<?php echo $this->get_field_id( 'display' ); ?>"><strong><?php echo __('Show (random or most recent)', 'golden'); ?></strong></label>
		</p>
		<p>
			<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
				<option <?php if ( 'random' == $cur_instance['display'] ) echo 'selected="selected"'; ?>>random</option>
				<option <?php if ( 'latest' == $cur_instance['display'] ) echo 'selected="selected"'; ?>>latest</option>
			</select>
		</p><?php
	}
}
?>