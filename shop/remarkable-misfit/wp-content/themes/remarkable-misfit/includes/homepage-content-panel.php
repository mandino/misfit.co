<?php
/**
 * Homepage Blog Panel
 */
 
    global $woo_options;

	/**
 	* The Variables
 	*
 	* Setup default variables, overriding them if the "Theme Options" have been saved.
 	*/
	
	$settings = array(
					'content_area_content' => 'blog',
					'content_area_entries' => 3,
					'content_area_page' => '',
					'content_area_heading' => '',
					'content_area_sub' => '',
					'content_area_link_text' => '',
					'content_area_link_URL' => '',
                    'thumb_w' => 180,
                    'thumb_h' => 110,
                    'thumb_align' => 'alignright'                    
					);
					
	$settings = woo_get_dynamic_values( $settings );
		
?>

<div id="blog" class="home-section fix">
    
    <header class="section-title fix">
        <h1><?php echo stripslashes( $settings['content_area_heading'] ); ?></h1>
        <?php if( $settings['content_area_sub'] != '') { ?>
        	<span class="sub"><?php echo stripslashes( $settings['content_area_sub'] ); ?></span>
        <?php } ?>
        <a class="section-more" href="<?php if ( $settings['content_area_link_URL'] != '' ) echo $settings['content_area_link_URL']; else echo next_posts(); ?>" title="<?php echo stripslashes( $settings['content_area_link_text'] ); ?>"><?php echo stripslashes( $settings['content_area_link_text'] ); ?></a>
    </header>

    <section id="main" class="col-left">  

    <?php
    	if ( have_posts() ) : $count = 0;
    ?>
    
    	<?php /* Start the Loop */ ?>
    	<?php while ( have_posts() ) : the_post(); $count++; ?>

            <article <?php post_class(); ?>>

                <?php
                    if ( isset( $woo_options['woo_post_content'] ) && $woo_options['woo_post_content'] != 'content' ) {
                        woo_image( 'width=' . $settings['thumb_w'] . '&height=' . $settings['thumb_h'] . '&class=thumbnail ' . $settings['thumb_align'] );
                    }
                ?>

                <header>
                    <h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                </header>
     
                <section class="entry">
                    <?php the_content(); ?>
                </section>

            </article><!-- /.post -->

    	<?php endwhile; ?>

    <?php else : ?>
    
        <article <?php post_class(); ?>>
            <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
        </article><!-- /.post -->
    
    <?php endif; ?>
    
    <?php woo_pagenav(); ?>
            
    </section><!-- /#main -->

    <?php get_sidebar(); ?>
    
</div>