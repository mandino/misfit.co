<?php
/*-----------------------------------------------------------------------------------

CLASS INFORMATION

Description: A custom WooThemes Component widget.
Date Created: 2011-07-27.
Last Modified: 2011-07-27.
Author: WooThemes.
Since: 1.0.0


TABLE OF CONTENTS

- var $woo_widget_cssclass
- var $woo_widget_description
- var $woo_widget_idbase
- var $woo_widget_title
- var $woo_widget_component
- var $woo_widget_componentslist

- function (constructor)
- function widget ()
- function update ()
- function form ()

- Register the widget on `widgets_init`.

-----------------------------------------------------------------------------------*/

class Woo_Widget_Component extends WP_Widget {

	var $woo_widget_cssclass;
	var $woo_widget_description;
	var $woo_widget_idbase;
	var $woo_widget_title;
	var $woo_widget_component;
	var $woo_widget_componentslist;
	
	var $widget_ops = array();
	var $control_ops = array();

	/*----------------------------------------
	  Constructor.
	  ----------------------------------------
	  
	  * The constructor. Sets up the widget.
	----------------------------------------*/
	
	function Woo_Widget_Component () {
		
		/* Widget variable settings. */

		$this->woo_widget_cssclass = 'widget_woo_component';
		$this->woo_widget_idbase = 'woo_component';
		$this->woo_widget_componenttitle = __( 'Component', 'woothemes' );
		$this->woo_widget_title = __('Woo - ', 'woothemes' ) . $this->woo_widget_componenttitle;
		$this->woo_widget_description = sprintf( __( 'This is a WooThemes standardized component widget for loading components into a custom layout.', 'woothemes' ) );
		
		$this->woo_widget_componentslist = array(
												'intro' => __( 'Intro Message', 'woothemes' ),
												'slider' => __( 'Slider', 'woothemes' ),
												'features' => __( 'Features', 'woothemes' ),
												'portfolio' => __( 'Portfolio', 'woothemes' ),
												'promotion' => __( 'Promotions', 'woothemes' ),
												'feedback' => __( 'Feedback', 'woothemes' ),
												'blog' => __( 'Horizontal Blog Layout', 'woothemes' ),
												'content' => __( 'Content Layout', 'woothemes' )
												);
		
		if ( is_woocommerce_activated() ) {
			$this->woo_widget_componentslist['shop'] = __( 'Shop', 'woothemes' );
		}
		
		/* Widget settings. */
		$this->widget_ops = array( 'classname' => $this->woo_widget_cssclass, 'description' => $this->woo_widget_description );

		/* Widget control settings. */
		$this->control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => $this->woo_widget_idbase );

		/* Create the widget. */
		$this->WP_Widget( $this->woo_widget_idbase, $this->woo_widget_title, $this->widget_ops, $this->control_ops );
		
	} // End Constructor

	/*----------------------------------------
	  widget()
	  ----------------------------------------
	  
	  * Displays the widget on the frontend.
	----------------------------------------*/

	function widget( $args, $instance ) {  
		global $slider_counter, $slider_instance;
		extract( $args, EXTR_SKIP );
		
		$component = $instance['component'];
		if ( $component == 'slider' ) { $slider_counter++; $slider_instance = $instance; }
		if ( $component != '' ) { get_template_part( 'includes/homepage-' . $component . '-panel' ); }

	} // End widget()

	/*----------------------------------------
	  update()
	  ----------------------------------------
	
	* Function to update the settings from
	* the form() function.
	
	* Params:
	* - Array $new_instance
	* - Array $old_instance
	----------------------------------------*/
	
	function update ( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		/* The select box is returning a text value, so we escape it. */
		$instance['component'] = esc_attr( $new_instance['component'] );
		$instance['featured_entries'] = esc_attr( $new_instance['featured_entries'] );
		$instance['featured_height'] = esc_attr( $new_instance['featured_height'] );
		$instance['featured_order'] = esc_attr( $new_instance['featured_order'] );
		$instance['post_type'] = esc_attr( $new_instance['post_type'] );
		$instance['slider_header_text'] = esc_attr( $new_instance['slider_header_text'] );
		$instance['slider_sub_header_text'] = esc_attr( $new_instance['slider_sub_header_text'] );
		$instance['featured_nextprev'] = esc_attr( $new_instance['featured_nextprev'] );
		$instance['featured_pagination'] = esc_attr( $new_instance['featured_pagination'] );

		return $instance;
		
	} // End update()

   /*----------------------------------------
	 form()
	 ----------------------------------------
	  
	  * The form on the widget control in the
	  * widget administration area.
	  
	  * Make use of the get_field_id() and 
	  * get_field_name() function when creating
	  * your form elements. This handles the confusing stuff.
	  
	  * Params:
	  * - Array $instance
	----------------------------------------*/

    function form( $instance ) {       
   
   		/* Set up some default widget settings. */
		$defaults = array(
						'component' => '',
						'featured_entries' => 3,
						'featured_height' => 380,
						'featured_tags' => '',
						'slider_video_title' => 'true',
						'featured_order' => 'DESC',
						'featured_sliding_direction' => 'vertical',
						'featured_animation' => 'slide',
						'featured_speed' => '7',
						'featured_hover' => 'false',
						'featured_touchswipe' => 'true',
						'featured_animation_speed' => '0.6',
						'featured_pagination' => 'false',
						'featured_nextprev' => 'true',
						'content_width' => '960',
						'post_type' => 'slide',
						'slider_header_text' => '',
						'slider_sub_header_text' => ''
					);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
   		$number_list = array( "0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19" );
   		$ordering_list = array("desc" => __( 'Newest to oldest', 'woothemes' ), "ASC" => "Oldest to newest", "rand" => "Random order");
   		$post_type_list = array("slide" => __( 'Slides', 'woothemes' ), "post" => __( 'Posts', 'woothemes' ), "portfolio" => __( 'Portfolio Items', 'woothemes' ));
   		if ( is_woocommerce_activated() ) {
   			$post_type_list['product'] = __( 'Products', 'woothemes' );
   		}
?>
		<!-- Widget Example Select: Select Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'component' ); ?>"><?php _e( 'Component:', 'woothemes' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'component' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'component' ); ?>">
			<?php foreach ( $this->woo_widget_componentslist as $k => $v ) { ?>
				<option value="<?php echo $k; ?>"<?php selected( $instance['component'], $k ); ?>><?php echo $v; ?></option>
			<?php } ?>       
			</select>
		</p>
<?php
   		if ($instance['component'] == 'slider') { 
   			echo '<p>'.sprintf( __( 'All options for the standard slider are set on the %1$s screen. If you want to override those options, please fill out the details below.', 'woothemes' ), '<a href="' . admin_url( 'admin.php?page=woothemes' ) . '">' . __( 'Theme Options', 'woothemes' ) . '</a>' ).'</p>'; ?>
   		<p>
			<label for="<?php echo $this->get_field_id( 'slider_header_text' ); ?>"><?php _e( 'Title:', 'woothemes' ); ?></label>
			<input name="<?php echo $this->get_field_name( 'slider_header_text' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'slider_header_text' ); ?>" value="<?php echo $instance['slider_header_text']; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'slider_sub_header_text' ); ?>"><?php _e( 'Sub Header:', 'woothemes' ); ?></label>
			<input name="<?php echo $this->get_field_name( 'slider_sub_header_text' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'slider_sub_header_text' ); ?>" value="<?php echo $instance['slider_sub_header_text']; ?>"/>
		</p>
   		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post Type:', 'woothemes' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'post_type' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>">
			<?php foreach ( $post_type_list as $k => $v ) { ?>
				<option value="<?php echo $k; ?>"<?php selected( $instance['post_type'], $k ); ?>><?php echo $v; ?></option>
			<?php } ?>      
			</select>
		</p>
   		<p>
			<label for="<?php echo $this->get_field_id( 'featured_entries' ); ?>"><?php _e( 'Number of Entries:', 'woothemes' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'featured_entries' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'featured_entries' ); ?>">
			<?php foreach ( $number_list as $v ) { ?>
				<option value="<?php echo $v; ?>"<?php selected( $instance['featured_entries'], $v ); ?>><?php echo $v; ?></option>
			<?php } ?>       
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'featured_height' ); ?>"><?php _e( 'Initial height:', 'woothemes' ); ?></label>
			<input name="<?php echo $this->get_field_name( 'featured_height' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'featured_height' ); ?>" value="<?php echo $instance['featured_height']; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'featured_order' ); ?>"><?php _e( 'Slider Ordering:', 'woothemes' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'featured_order' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'featured_order' ); ?>">
			<?php foreach ( $ordering_list as $k => $v ) { ?>
				<option value="<?php echo $k; ?>"<?php selected( $instance['featured_order'], $k ); ?>><?php echo $v; ?></option>
			<?php } ?>       
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'featured_nextprev' ); ?>"><?php _e( 'Slider Next/Prev Buttons:', 'woothemes' ); ?></label>
			<input type="checkbox" name="<?php echo $this->get_field_name( 'featured_nextprev' ); ?>" value="true" <?php checked( $instance['featured_nextprev'], 'true' ); ?> id="<?php echo $this->get_field_id( 'featured_nextprev' ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'featured_pagination' ); ?>"><?php _e( 'Slider Pagination:', 'woothemes' ); ?></label>
			<input type="checkbox" name="<?php echo $this->get_field_name( 'featured_pagination' ); ?>" value="true" <?php checked( $instance['featured_pagination'], 'true' ); ?> id="<?php echo $this->get_field_id( 'featured_pagination' ); ?>" />
		</p>

   		<?php } else {
   			echo sprintf( __( 'All options for the components are set on the %1$s screen.', 'woothemes' ), '<a href="' . admin_url( 'admin.php?page=woothemes' ) . '">' . __( 'Theme Options', 'woothemes' ) . '</a>' );
   		}
   
	} // End form()
	
} // End Class

/*----------------------------------------
  Register the widget on `widgets_init`.
  ----------------------------------------
  
  * Registers this widget.
----------------------------------------*/

add_action( 'widgets_init', create_function( '', 'return register_widget("Woo_Widget_Component");' ), 1 );
?>