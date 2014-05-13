	<footer id="footer-global" role="contentinfo" class="clearfix">
		
		<section id="contact">
		
			<div class="container">
				
				<div class="row">
				
					<div class="sixteen columns">
				  	  
			  			<div id="copyright-details"><?php global $data; echo $data['textarea_footer_text']; ?> <a href="http://misfit-inc.com" target="_blank"><img class="misfit-inc" src="/aj-leon.com/misfit-press/wp-content/themes/misfitpress/remarkable-misfit/images/misfit-inc-logo.png"></a> handcrafted with <img class="heart-icon" src="/aj-leon.com/misfit-press/wp-content/themes/misfitpress/remarkable-misfit/images/ico-red-heart.png"> in NYC</div>
			  		
			  		</div>
			  		
			  	</div><!-- end .row -->  
		  	
			</div><!-- end .container -->
		
		</section><!-- end #contact -->
		
	</footer><!-- end #footer-global -->
	
<script type="text/javascript">
function scrollTo(target) {d
    var targetPosition = $(target).offset().top;
    $('html,body').animate({
        scrollTop: targetPosition
    }, 'slow');
}
jQuery(document).ready(function () {
    jQuery('nav ul').mobileMenu({
        defaultText: '<?php _e("NAVIGATION", "kula");?>',
        className: 'mobile-menu',
        subMenuDash: '&ndash;'
    });
});
</script>

<?php echo $data['google_analytics']; ?>
	
<?php wp_footer(); ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=102493026567659";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	
</body>

</html>