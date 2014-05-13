<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories = array();  
		$of_categories_obj = get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp = array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages = array();
		$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp = array_unshift($of_pages, "Select a page:");       
	
		$of_options_select = array("one","two","three","four","five"); 
		$of_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		$of_options_latest_work_select = array("3","6","9","12");
		$of_options_quotes_select = array("2","3","4","5","6","7","8","9","10");
		$of_options_services_select = array("3","6","9","12");
		$of_options_meet_team_select = array("3","6","9","12","16","20","24");
		$of_options_latest_news_select = array("3","6","9","12");
		
		//Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"enabled" => array (
				"placebo" => "placebo", //REQUIRED!
				"work_block" => "Latest Work",
				"quotes_top_block" => "Quotes (Top)",
				"services_block" => "Services",
				"logos_block" => "Client Logos",
				"news_block" => "Latest News",
				"quotes_bottom_block" => "Quotes (Bottom)",
				"team_block" => "Meet the Team",
				"quotes_block_1" => "Quote Block 1",
				"quotes_block_2" => "Quote Block 2",
				"quotes_block_3" => "Quote Block 3",
				"quotes_block_4" => "Quote Block 4",
				"the_people" => "The People",
				"local_partners" => "Our Local Partners",
				"their_words" => "Their Words",
			),
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
			),
		);

		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/assets/img/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/assets/img/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		
		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads = get_option('of_uploads');
		$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

$of_options[] = array( "name" => __('Home Settings', 'kula'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Homepage Layout Manager', 'kula'),
					"desc" => __('Organize how you want the layout to appear on the homepage.<br /><br />You can choose to enable/disable sections via drag & drop, or re-order their stacking order on the homepage.<br /><br />NB; Once you have re-ordered or disabled, do not forget to adjust your Menu (Navigation) in the same way.', 'kula'),
					"id" => "homepage_blocks",
					"std" => $of_options_homepage_blocks,
					"type" => "sorter");

$of_options[] = array( "name" => __('Header Settings', 'kula'),
					"type" => "heading");

$of_options[] = array( "name" => __('Custom Logo', 'kula'),
					"desc" => __('Upload your own logo to use on the site.', 'kula'),
					"id" => "custom_logo",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => __('Text Logo', 'kula'),
					"desc" => __('If you do not have a logo you can choose to use a plain text logo instead.', 'kula'),
					"id" => "text_logo",
					"std" => false,
					"type" => "checkbox");
					
$of_options[] = array( "name" => __('Uber Statement', 'kula'),
					"desc" => __('You can add a short introduction to appear in your header (eg; Yes we do some awesome things).<br /><br /><em>*HTML tags are allowed.</em>', 'kula'),
					"id" => "text_uber_statement",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "name" => __('Background Image', 'kula'),
					"desc" => __('Upload a background image to use in your header.', 'kula'),
					"id" => "upload_header_background",
					"std" => "",
					"type" => "media");
					
$of_options[] = array( "name" => __('Portfolio Settings', 'kula'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'kula'),
					"desc" => __('Please enter a title for the Portfolio section. (eg; Our work says a lot about us. Passionate about all we do.)', 'kula'),
					"id" => "text_portfolio_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'kula'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'kula'),
					"id" => "textarea_portfolio_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "name" => __('Button Title (Single Project)', 'kula'),
					"desc" => __('Please enter a global name for your single project button (eg; Launch Project or Visit Website)', 'kula'),
					"id" => "text_project_button_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Service Settings', 'kula'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'kula'),
					"desc" => __('Please enter a title for the Services section. (eg; We provide a multitude of services. Everything is covered.)', 'kula'),
					"id" => "text_services_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'kula'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'kula'),
					"id" => "textarea_services_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "desc" => __('Please select how many items you would like to show in the services section.', 'kula'),
					"id" => "select_services",
					"std" => "6",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_services_select);
					
$of_options[] = array( "name" => __('News Settings', 'kula'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'kula'),
					"desc" => __('Please enter a title for the Latest News section. (eg; Hear what we have to say. It is all good.)', 'kula'),
					"id" => "text_news_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'kula'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'kula'),
					"id" => "textarea_news_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "desc" => __('Please select how many items you would like to show in the latest news section.', 'kula'),
					"id" => "select_news",
					"std" => "3",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_latest_news_select);
					
$of_options[] = array( "name" => __('Comments Closed', 'kula'),
					"desc" => __('Disable the \'Comments are currently closed.\' message on Blog posts.<br />(This applies to Portfolio items also)', 'kula'),
					"id" => "text_comments_closed",
					"std" => false,
					"type" => "checkbox");
					
$of_options[] = array( "name" => __('Team Settings', 'kula'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'kula'),
					"desc" => __('Please enter a title for the Meet the Team section. (eg; We have a team of truly awesome folk. You will love them.)', 'kula'),
					"id" => "text_team_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'kula'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'kula'),
					"id" => "textarea_team_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "desc" => __('Please select how many items you would like to show in the meet the team section.', 'kula'),
					"id" => "select_team",
					"std" => "3",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_meet_team_select);			
					
$of_options[] = array( "name" => __('Contact Settings', 'kula'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'kula'),
					"desc" => __('Please enter a title for the Contact section. (eg; Contact Us)', 'kula'),
					"id" => "text_contact_us_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'kula'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'kula'),
					"id" => "textarea_contact_us_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "name" => __('Contact Address', 'kula'),
					"desc" => __('Please enter your company address (eg; 10 Columbus Circle, New York, NY 10019, United States.)', 'kula'),
					"id" => "text_contact_address",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Contact Telephone Number', 'kula'),
					"desc" => __('Please enter your company telephone number (eg; (212) 823-6000.)', 'kula'),
					"id" => "text_contact_telephone",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Fax Telephone Number', 'kula'),
					"desc" => __('Please enter your company fax number (eg; (212) 823-6005.)', 'kula'),
					"id" => "text_contact_fax",
					"std" => "",
					"type" => "text");	
					
$of_options[] = array( "name" => __('Contact Email', 'kula'),
					"desc" => __('Please enter your company email address (eg; marc@guuthemes.com) This will also populate into your Contact Form.', 'kula'),
					"id" => "text_contact_email",
					"std" => "",
					"type" => "text");			
					
$of_options[] = array( "name" => __('General Settings', 'kula'),
                    "type" => "heading");
					
$of_options[] = array( "name" => __('Custom Favicon', 'kula'),
					"desc" => __('Upload a 32px x 32px PNG/GIF image that will represent your website favicon.', 'kula'),
					"id" => "custom_favicon",
					"std" => "",
					"mod" => "min",
					"type" => "upload");
					
$of_options[] = array( "name" => __('Footer Text', 'kula'),
					"desc" => __('Please enter the text to appear at the bottom of your Footer (eg; All rights reserved. Designed by GuuThemes.)', 'kula'),
					"id" => "textarea_footer_text",
					"std" => "",
					"type" => "textarea");
                
$of_options[] = array( "name" => __('Google Analytics Tracking Code', 'kula'),
					"desc" => __('Paste your Google Analytics tracking code here (Remember you need to paste all the Javascript code, not just your ID). This will be added into the footer template of your theme.<br /><br />Do not have Google Analytics? Unsure what to paste in this box? Visit this <a href="http://www.google.com/analytics">link</a> to find out more.', 'kula'),
					"id" => "google_analytics",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "name" => __('Client Logos Title', 'kula'),
					"desc" => __('Please enter a title for the Client Logos section. (eg; Folks we have worked with)', 'kula'),
					"id" => "text_client_logos_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Client Logo One', 'kula'),
					"desc" => __('Upload client logos to appear in the client logo section. Choose an image around 100px wide to achieve the best layout.', 'kula'),
					"id" => "client_logo_one",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "desc" => __('Enter a URL for your logo to link to. <br />(ie; http://guuthemes.com)', 'kula'),
					"id" => "client_logo_one_url",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Client Logo Two', 'kula'),
					"id" => "client_logo_two",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "desc" => __('Enter a URL for your logo to link to. <br />(ie; http://guuthemes.com)', 'kula'),
					"id" => "client_logo_two_url",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Client Logo Three', 'kula'),
					"id" => "client_logo_three",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "desc" => __('Enter a URL for your logo to link to. <br />(ie; http://guuthemes.com)', 'kula'),
					"id" => "client_logo_three_url",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Client Logo Four', 'kula'),
					"id" => "client_logo_four",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "desc" => __('Enter a URL for your logo to link to. <br />(ie; http://guuthemes.com)', 'kula'),
					"id" => "client_logo_four_url",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Client Logo Five', 'kula'),
					"id" => "client_logo_five",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "desc" => __('Enter a URL for your logo to link to. <br />(ie; http://guuthemes.com)', 'kula'),
					"id" => "client_logo_five_url",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Twitter', 'kula'),
					"desc" => __('Enter your Twitter Profile URL <br />(ie; http://twitter.com/guuthemes)', 'kula'),
					"id" => "text_twitter_profile",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => __('Facebook', 'kula'),
					"desc" => __('Enter your Facebook Profile URL <br />(ie; http://facebook.com/guuthemes)', 'kula'),
					"id" => "text_facebook_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Instagram', 'kula'),
					"desc" => __('Enter your Instagram Profile URL <br />(ie; http://instagram.com/guuthemes)', 'kula'),
					"id" => "text_dribbble_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Forrst', 'kula'),
					"desc" => __('Enter your Forrst Profile URL <br />(ie; http://forrst.com/people/guuthemes)', 'kula'),
					"id" => "text_forrst_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Vimeo', 'kula'),
					"desc" => __('Enter your Vimeo Profile URL <br />(ie; http://vimeo.com/guuthemes)', 'kula'),
					"id" => "text_vimeo_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('YouTube', 'kula'),
					"desc" => __('Enter your YouTube Profile URL <br />(ie; http://youtube.com/user/guuthemes)', 'kula'),
					"id" => "text_youtube_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Flickr', 'kula'),
					"desc" => __('Enter your Flickr Profile URL <br />(ie; http://flickr.com/people/guuthemes)', 'kula'),
					"id" => "text_flickr_profile",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => __('Linkedin', 'kula'),
					"desc" => __('Enter your Linkedin Profile URL <br />(ie; http://linkedin.com/in/guuthemes)', 'kula'),
					"id" => "text_linkedin_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Pinterest', 'kula'),
					"desc" => __('Enter your Pinterest Profile URL <br />(ie; http://pinterest.com/guuthemes)', 'kula'),
					"id" => "text_pinterest_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Google +', 'kula'),
					"desc" => __('Enter your Google + Profile URL <br />(ie; http://plus.google.com/1030594445)', 'kula'),
					"id" => "text_googleplus_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Tumblr', 'kula'),
					"desc" => __('Enter your Tumblr Profile URL <br />(ie; http://guuthemes.tumblr.com)', 'kula'),
					"id" => "text_tumblr_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Soundcloud', 'kula'),
					"desc" => __('Enter your Soundcloud Profile URL <br />(ie; https://soundcloud.com/guuthemes)', 'kula'),
					"id" => "text_soundcloud_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Last FM', 'kula'),
					"desc" => __('Enter your Last FM Profile URL <br />(ie; http://last.fm/user/guuthemes)', 'kula'),
					"id" => "text_lastfm_profile",
					"std" => "",
					"type" => "text");   
					
$of_options[] = array( "name" => __('Styling Options', 'kula'),
					"type" => "heading");                                                    

$of_options[] = array( "name" => __('Text Logo Styling', 'kula'),
					"desc" => __('Specify the text logo font properties (if you chose this option on the previous page).', 'kula'),
					"id" => "logo_font",
					"std" => array('size' => '34px','face' => 'open sans','style' => '800','color' => '#ffffff'),
					"type" => "typography");
					
$of_options[] = array( "name" => __('Body Font Styling', 'kula'),
					"desc" => __('Specify the body font properties.', 'kula'),
					"id" => "body_font",
					"std" => array('size' => '16px','face' => 'open sans','style' => '300','color' => '#333333'),
					"type" => "typography");
					
$of_options[] = array( "name" => __('Headings Styling', 'kula'),
					"desc" => __('Specify the h1, h2, h3, h4, h5 font properties.', 'kula'),
					"id" => "headings_font",
					"std" => array('face' => 'open sans','style' => '800','color' => '#333333'),
					"type" => "typography");
					
$of_options[] = array( "name" => __('Uber-Statement Styling', 'kula'),
					"desc" => __('Specify the uber-statement font properties.', 'kula'),
					"id" => "uber_font",
					"std" => array('face' => 'open sans','style' => '800','color' => '#ffffff'),
					"type" => "typography");

$of_options[] = array( "name" =>  __('Accent Color', 'kula'),
					"desc" => __('Pick an accent color for the theme. (This will affect Header Navigation, Quotes, Blockquotes, Pricing Tables, Tabs, Portfolio Navigation etc...).', 'kula'),
					"id" => "accent_color",
					"std" => "#52a1c6",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Body Link Color', 'kula'),
					"desc" => __('Pick an accent color for the main body links.', 'kula'),
					"id" => "body_link_color",
					"std" => "#52a1c6",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Footer Link Color', 'kula'),
					"desc" => __('Pick an accent color for the footer text links.', 'kula'),
					"id" => "footer_link_color",
					"std" => "#52a1c6",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Service Icons Color', 'kula'),
					"desc" => __('Pick an accent color for the service icons.', 'kula'),
					"id" => "accent_color_service_icons",
					"std" => "#52a1c6",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Team Member Social Icons Color', 'kula'),
					"desc" => __('Pick an accent color for the team member social icons.', 'kula'),
					"id" => "accent_color_team_icons",
					"std" => "#52a1c6",
					"type" => "color");
					
$of_options[] = array( "name" => __('Custom CSS', 'kula'),
                    "desc" => __('Quickly add some CSS to your theme by adding it to this block.', 'kula'),
                    "id" => "custom_css",
                    "std" => "",
                    "type" => "textarea");
                    
$of_options[] = array( "name" => __('Background Settings', 'kula'),
					"type" => "heading");  
                    
$of_options[] = array( "name" => __('Quotes (Top) Background Image', 'kula'),
					"desc" => __('Upload a background image to use in your (top) quotes section.', 'kula'),
					"id" => "upload_quotes_top_background",
					"std" => "",
					"type" => "media");
					
$of_options[] = array( "name" => __('Logos Background Image', 'kula'),
					"desc" => __('Upload a background image to use in your logo section.', 'kula'),
					"id" => "upload_logos_background",
					"std" => "",
					"type" => "media");
					
$of_options[] = array( "name" => __('Quotes (Bottom) Background Image', 'kula'),
					"desc" => __('Upload a background image to use in your (bottom) quotes section.', 'kula'),
					"id" => "upload_quotes_bottom_background",
					"std" => "",
					"type" => "media");

$of_options[] = array( "name" => __('Quotes - Background Image 1', 'kula'),
					"desc" => __('Upload a background image to use in your (Background Image 1) quotes section.', 'kula'),
					"id" => "upload_quotes_bottom_background_1",
					"std" => "",
					"type" => "media");

$of_options[] = array( "name" => __('Quotes - Background Image 2', 'kula'),
					"desc" => __('Upload a background image to use in your (Background Image 2) quotes section.', 'kula'),
					"id" => "upload_quotes_bottom_background_2",
					"std" => "",
					"type" => "media");

$of_options[] = array( "name" => __('Quotes - Background Image 3', 'kula'),
					"desc" => __('Upload a background image to use in your (Background Image 3) quotes section.', 'kula'),
					"id" => "upload_quotes_bottom_background_3",
					"std" => "",
					"type" => "media");

$of_options[] = array( "name" => __('Quotes - Background Image 4', 'kula'),
					"desc" => __('Upload a background image to use in your (Background Image 4) quotes section.', 'kula'),
					"id" => "upload_quotes_bottom_background_4",
					"std" => "",
					"type" => "media");

// Backup Options
$of_options[] = array( "name" => __('Backup Options', 'kula'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Backup and Restore Options', 'kula'),
                    "id" => "of_backup",
                    "std" => "",
                    "type" => "backup",
					"desc" => __('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'kula'),
					);
					
$of_options[] = array( "name" => __('Transfer Theme Options Data', 'kula'),
                    "id" => "of_transfer",
                    "std" => "",
                    "type" => "transfer",
					"desc" => __('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".
						', 'kula'),
					);
					
	}
}
?>