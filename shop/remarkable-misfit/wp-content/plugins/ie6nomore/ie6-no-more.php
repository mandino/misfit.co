<?php

/*
Plugin Name: IE6 No More
Plugin URI: http://aboutenjay.com/tag/ie6nomore/
Description: Encourages IE6 users to upgrade to a more modern browser by displaying a box at the top of the page informing them that they are using an outdated browser.
Author: Jerico Veloso
Version: 0.3.0
Author URI: http://aboutenjay.com/
*/

function callback($buffer) {
	global $is_IE;
	
	if ($is_IE) {
		$ie6nomore_code = "
			<!--[if lt IE 9]>
			<style>
				#ie-no-more {
					border: 1px solid #999;
					background: #FFF;
					text-align: center;
					clear: both;
					height: 75px;
					position: relative;
				}

				#ie-no-more .close-no-more {
					position: absolute;
					right: 3px;
					top: 3px;
					font-family: courier new;
					font-weight: bold;
				}

				#ie-no-more .browser-block {
					width: 610px;
					margin: 0 auto;
					text-align: left;
					padding: 0;
					overflow: hidden;
					color: #333;
				}

				#ie-no-more .warning {
					width: 75px;
					float: left;
				}

				#ie-no-more .no-more-text {
					width: 275px;
					float: left;
					font-family: Arial, sans-serif;
				}

				#ie-no-more .no-more-text div {
					font-size: 14px;
					font-weight: bold;
					margin-top: 12px;
				}

				#ie-no-more .no-more-text div.text-below {
					font-size: 12px;
					margin-top: 6px;
					line-height: 12px;
					font-weight: normal;
				}

				#ie-no-more .fl {
					width: 65px;
					float: left;
					margin-top: 13px;
				}
				
				#ie-no-more .sa-no-more.fl {
					width: 59px;
				}

				#ie-no-more .browser-block .fl {
					border: none;
				}
			</style>
			
			<div id='ie-no-more'>
				<div class='close-no-more'>
					<a href='#' onclick='javascript:this.parentNode.parentNode.style.display=\"none\"; return false;'>
						<img src='/book/remarkable-misfit/wp-content/plugins/ie6nomore/images/ie-no-more-close.png' style='border: none;' alt='Close this notice'/>
					</a>
				</div>
				
				<div class='browser-block'>
					<div class='warning'><img src='/book/remarkable-misfit/wp-content/plugins/ie6nomore/images/ie-no-more-warning.png' alt='Warning!'/></div>
					
					<div class='no-more-text'>
						<div>You are using an outdated browser</div>
						<div class='text-below'>For a better experience using this site, please upgrade to a modern web browser.</div>
					</div>
					
					<div class='ff-nm fl'>
						<a href='http://www.firefox.com' target='_blank'>
							<img src='/book/remarkable-misfit/wp-content/plugins/ie6nomore/images/icon-ie-firefox.png' alt='Firefox'/>
						</a>
					</div>
					
					<div class='intex-no-more fl'>
						<a href='http://windows.microsoft.com/en-US/internet-explorer/download-ie' target='_blank'>
							<img src='/book/remarkable-misfit/wp-content/plugins/ie6nomore/images/icon-ie-ie.png' alt='Internet Explorer'/>
						</a>
					</div>
					
					<div class='sa-no-more fl'>
						<a href='http://support.apple.com/kb/DL1531' target='_blank'>
							<img src='/book/remarkable-misfit/wp-content/plugins/ie6nomore/images/icon-ie-safari.png' alt='Safari'/>
						</a>
					</div>
					
					<div class='ch-no-more fl'>
						<a href='http://www.google.com/chrome' target='_blank'>
							<img src='/book/remarkable-misfit/wp-content/plugins/ie6nomore/images/icon-ie-chrome.png' alt='Google Chrome'/>
						</a>
					</div>
				</div>
			</div>
			<![endif]-->
		";
		$buffer = preg_replace('/(<body.*>)/', "$1\n".$ie6nomore_code, $buffer, 1);
	}
	
	return $buffer;
}

function buffer_start() {
	ob_start("callback");
}

function buffer_end() {
	ob_end_flush();
}

add_action('wp_head', 'buffer_start');
add_action('wp_footer', 'buffer_end');

?>