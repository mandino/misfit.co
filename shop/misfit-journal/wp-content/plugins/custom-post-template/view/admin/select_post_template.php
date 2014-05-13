<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<label class="hidden" for="page_template"><?php _e( 'Post Template', 'custom-post-templates' ); ?></label>
<?php if ( $templates ) : ?>

	<input type="hidden" name="custom_post_template_present" value="1" />
	<select name="custom_post_template" id="custom_post_template">
		<option 
			value='default'
			<?php
				if ( ! $custom_template ) {
					echo "selected='selected'";
				}
			?>><?php _e( 'Default Template' ); ?></option>
		<?php foreach( $templates AS $filename => $name ) { ?>
			<option 
				value='<?php echo $filename; ?>'
				<?php
					if ( $custom_template == $filename ) {
						echo "selected='selected'";
					}
				?>><?php echo $name; ?></option>
		<?php } ?>
	</select>

	<p><?php printf( __( 'Be sure to add the page template using: "Template Name Posts:"', 'custom-post-templates' ), 'http://wordpress.org/extend/plugins/custom-post-template/' ); ?></p>

<?php else : ?>

	<p><?php printf( __( 'This theme has no available <a href="%s" target="_blank">custom post templates</a>.', 'custom-post-templates' ), 'http://wordpress.org/extend/plugins/custom-post-template/' ); ?></p>

<?php endif; ?>