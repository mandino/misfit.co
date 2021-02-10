<?php

// WPML Language Dropdown

function language_selector_special(){
	$languages  = icl_get_languages('skip_missing=1');
		
	if(!empty($languages)){
		$char3Lang = array('es' => 'esp', 'en' => 'eng');
		foreach($languages as $l){
			if(!$l['active']){
				echo "<li class='icl-{$l['language_code']}'><a href='{$l['url']}'><span>" . $char3Lang[$l['language_code']] . "</span></a></li>";
			}
		}
	}
}