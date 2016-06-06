<?php get_header(); ?>



<body>

	<!-- Start Homepage -->
	
<?php if(get_option('cebo_showslideshow') == 'true') { ?>
	
	<div id="homepage">
		
		<?php include (TEMPLATEPATH . '/library/featured.php'); ?>
			
	</div>
	
<? } ?>	

	<!-- End Homepage -->
	<!-- Start Navigation -->
	
	
	<?php include (TEMPLATEPATH . '/library/navigation.php'); ?>
	

	<!-- End Navigation -->	

<?php if(get_option('cebo_showaboutus') == 'true') { ?>

	<!-- Start About Us Section -->	
	
	<?php include (TEMPLATEPATH . '/library/aboutus.php'); ?>
	
	
	<!-- End About US Section -->
	
<? } ?>
<?php if(get_option('cebo_showaboutme') == 'true') { ?>
	
	<!-- Start About ME Section -->	
	
	
	<?php include (TEMPLATEPATH . '/library/aboutme.php'); ?>
	
	
	<!-- End About ME Section -->

<? } ?>
<?php if(get_option('cebo_showportfolio') == 'true') { ?>

	<!-- Start Portfolio Section -->		
			
	
	<?php include (TEMPLATEPATH . '/library/portfolio.php'); ?>	
	
	
	<!-- End Portfolio Section -->

<? } ?>
<?php if(get_option('cebo_showblog') == 'true') { ?>


	<!-- Begin Blog Section -->		
	
	
	<?php include (TEMPLATEPATH . '/library/blog.php'); ?>
			
	
	<!-- End Blog Section -->	

<? } ?>

<?php if(get_option('cebo_twitter')) { ?>

	<!-- Start Twitter Section  -->
	
	
	<?php include (TEMPLATEPATH . '/library/twitter.php'); ?>
	
	
	<!-- End Twitter Section  -->
	
<? } ?>
<?php if(get_option('cebo_showoffice') == 'true') { ?>

	<!-- Parallax Footer Background -->
	
	
	<?php include (TEMPLATEPATH . '/library/parallax.php'); ?>
	
	
	<!-- End Parallax Section -->
	
<? } ?>

<?php if(get_option('cebo_showmap') == 'true') { ?>

	<!-- Map Footer Background -->
	
	
	<?php include (TEMPLATEPATH . '/library/maps.php'); ?>
	
		
	<!-- End Map Footer Background  -->
	
<? } ?>

	<?php get_footer(); ?>