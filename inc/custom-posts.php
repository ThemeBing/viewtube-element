<?php

if ( ! function_exists('viewtube_custom_post_type') ) {
	
    /**
     * Register a custom post type.
     *
     * @link http://codex.wordpress.org/Function_Reference/register_post_type
     */
    function viewtube_custom_post_type() {

        //Project
        register_post_type(
            'video', array(
            'labels' => array(
                'name'          => __( 'Videos', 'viewtube' ),
                'singular_name' => __( 'Video', 'viewtube' ),
                'add_new_item'  => __( 'Add New Video', 'viewtube' )
            ),
            'description'    => __( 'Description.', 'viewtube' ),
            'menu_icon'      => 'dashicons-youtube',
            'public'         => true,
            'has_archive'   => false,
            'rewrite'        => array( 'slug' => 'video' ),
            'supports'       => array( 'title','editor','thumbnail' )
        ));

        // Project taxonomy
        register_taxonomy(
            'video_category',
            'video',
            array(
                'labels' => array(
                    'name' => __( 'Video Category', 'viewtube' ),
                    'add_new_item'      => __( 'Add New Category', 'viewtube' ),
                ),
                'hierarchical' => true,
                'show_admin_column'     => true
        ));
    }

    add_action( 'init', 'viewtube_custom_post_type' );

}