<?php

$api_url = 'https://themebing.com/purchase-code-verify/update-checker.php';

$plugin_slug = 'viewtube-element';

// Take over the update check
add_filter('pre_set_site_transient_update_plugins', 'viewtube_check_for_plugin_update');

function viewtube_check_for_plugin_update($checked_data) {
	global $api_url, $plugin_slug, $wp_version;
	
	//Comment out these two lines during testing.
	if (empty($checked_data->checked)){
		return $checked_data;
	}
	
	$args = array(
		'slug' => $plugin_slug,
		'version' => $checked_data->checked[$plugin_slug .'/'. $plugin_slug .'.php'],
	);

	$viewtube_activate_license = !empty( get_option('viewtube_activate_license_option') ) ? get_option('viewtube_activate_license_option') : '';

	$request_string = array(
		'body' => array(
			'action' => 'basic_check', 
			'request' => serialize($args),
			'license' => $viewtube_activate_license
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url()
	);
	
	// Start checking for an update
	$raw_response = wp_remote_post($api_url, $request_string);
	
	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200)){
		$response = unserialize($raw_response['body']);
	}
	
	if (!empty($response)){
		$checked_data->response[$plugin_slug .'/'. $plugin_slug .'.php'] = $response;
	}
	
	return $checked_data;
}


// Take over the Plugin info screen
add_filter('plugins_api', 'viewtube_plugin_api_call', 10, 3);

function viewtube_plugin_api_call($def, $action, $args) {
	global $plugin_slug, $api_url, $wp_version;
	
	if (!isset($args->slug) || ($args->slug != $plugin_slug)){
		return false;
	}
	
	// Get the current version
	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[$plugin_slug .'/'. $plugin_slug .'.php'];
	$args->version = $current_version;

	$viewtube_activate_license = !empty( get_option('viewtube_activate_license_option') ) ? get_option('viewtube_activate_license_option') : '';

	$request_string = array(
		'body' => array(
			'action' => $action, 
			'request' => serialize($args),
			'license' => $viewtube_activate_license
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url()
	);
	
	$request = wp_remote_post($api_url, $request_string);
	
	if (is_wp_error($request)) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);
		
		if ($res === false){
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
		}
	}
	
	return $res;
}