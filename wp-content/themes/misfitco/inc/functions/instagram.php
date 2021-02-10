<?php if ( ! defined( 'ABSPATH' ) ) exit;

function instagram_get_user_id_photos( $user_id, $access_token, $count = '' ) {

	// CURL

	$api_url = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/?access_token=' . $access_token . '&count=' . $count;

	// Get cURL resource
	$api_curl = curl_init();

	// Set some options - we are passing in a useragent too here
	curl_setopt_array($api_curl, array(
		CURLOPT_URL => $api_url,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_NOBODY => 0,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_SSL_VERIFYPEER => 0,
	));

	// Send the request & save response to $api_json
	$api_json = curl_exec($api_curl);

	// Close request to clear up some resources
	curl_close($api_curl);

	// Convert JSON to PHP
	$api_json = json_decode($api_json);

	return $api_json;
}