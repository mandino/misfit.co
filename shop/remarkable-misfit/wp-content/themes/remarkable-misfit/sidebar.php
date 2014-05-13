	<aside id="sidebar" class="five columns omega offset-by-one">
	
	<?php if (is_page()): ?>
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Page Sidebar') ) : else : ?>
		<?php endif; ?>
	<?php else: ?>
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Blog Sidebar') ) : else : ?>
		<?php endif; ?>
	<?php endif; ?>	
	
	</aside><!-- end #sidebar -->