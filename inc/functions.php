<?php

// Enqueue script
function viewtube_plugin_enqueue_script() {

	// CSS
	wp_enqueue_style('viewtube-plugns', plugin_dir_url( __FILE__ ) . '../assets/css/plugins.css');
	wp_enqueue_style('viewtube-plugn', plugin_dir_url( __FILE__ ) . '../assets/css/plugin.css');

	// JS
	wp_enqueue_script( 'viewtube-plugin', plugin_dir_url( __FILE__ ) . '../assets/js/plugin.js', array('jquery','viewtube-main'), wp_get_theme()->get( 'Version' ), true );
	wp_localize_script( 'viewtube-plugin', 'viewtubePluginAjaxObj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
}
add_action('wp_enqueue_scripts', 'viewtube_plugin_enqueue_script');