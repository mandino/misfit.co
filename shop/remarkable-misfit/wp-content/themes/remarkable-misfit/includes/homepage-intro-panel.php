<?php
	
	/**
	*
	* Homepage Intro Section
	*
 	* The Variables
 	*
 	* Setup default variables, overriding them if the "Theme Options" have been saved.
 	*/
	
	$settings = array(
					'custom_intro_message_text' => '',
					'custom_intro_social' => 'false',
					'connect_rss' => '',
					'connect_twitter' => '',
					'connect_facebook' => '',
					'connect_dribbble' => '',
					'connect_youtube' => '',
					'connect_flickr' => '',
					'connect_linkedin' => '',
					'connect_delicious' => '',
					'connect_rss' => '',
					'connect_googleplus' => ''
					);
					
	$settings = woo_get_dynamic_values( $settings );
	
?>

<section id="intro" class="home-section">
	
	<h1><?php echo stripslashes( $settings['custom_intro_message_text'] ); ?></h1>
	
	<?php if($settings['custom_intro_social'] == 'true') { ?>
	
	<div class="social">
	    <?php if ( $settings['connect_rss' ] == "true" ) { ?>
	    <a href="<?php if ( $settings['feed_url'] ) { echo esc_url( $settings['feed_url'] ); } else { echo get_bloginfo_rss('rss2_url'); } ?>" class="subscribe" title="RSS"></a>

	    <?php } if ( $settings['connect_twitter' ] != "" ) { ?>
	    <a href="<?php echo esc_url( $settings['connect_twitter'] ); ?>" class="twitter" title="Twitter"></a>

	    <?php } if ( $settings['connect_facebook' ] != "" ) { ?>
	    <a href="<?php echo esc_url( $settings['connect_facebook'] ); ?>" class="facebook" title="Facebook"></a>
	    
	    <?php } if ( $settings['connect_dribbble' ] != "" ) { ?>
		<a href="<?php echo esc_url( $settings['connect_dribbble'] ); ?>" class="dribbble" title="Dribbble"></a>

	    <?php } if ( $settings['connect_youtube' ] != "" ) { ?>
	    <a href="<?php echo esc_url( $settings['connect_youtube'] ); ?>" class="youtube" title="YouTube"></a>

	    <?php } if ( $settings['connect_flickr' ] != "" ) { ?>
	    <a href="<?php echo esc_url( $settings['connect_flickr'] ); ?>" class="flickr" title="Flickr"></a>

	    <?php } if ( $settings['connect_linkedin' ] != "" ) { ?>
	    <a href="<?php echo esc_url( $settings['connect_linkedin'] ); ?>" class="linkedin" title="LinkedIn"></a>

	    <?php } if ( $settings['connect_delicious' ] != "" ) { ?>
	    <a href="<?php echo esc_url( $settings['connect_delicious'] ); ?>" class="delicious" title="Delicious"></a>

	    <?php } if ( $settings['connect_googleplus' ] != "" ) { ?>
	    <a href="<?php echo esc_url( $settings['connect_googleplus'] ); ?>" class="googleplus" title="Google+"></a>

	    <?php } ?>
	</div>
	
	<?php } ?>
	
</section>