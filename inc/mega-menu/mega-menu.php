<?php 

function viewtube_megamenu_scripts() {

	wp_enqueue_style( 'viewtube-mega-menu', plugin_dir_url( __FILE__ ) . '/assets/css/mega-menu.css');

	wp_enqueue_script( 'viewtube-mega-menu', plugin_dir_url( __FILE__ ) . '/assets/js/mega-menu.js' , array('jquery'), wp_get_theme()->get( 'Version' ), true );
}

add_action( 'wp_enqueue_scripts', 'viewtube_megamenu_scripts' );

// Includes file
require_once dirname( __FILE__ ) . '/nav-walker.php';