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
            'author_badges', array(
            'labels' => array(
                'name'          => __( 'Author Badges', 'viewtube' ),
                'singular_name' => __( 'Author Badge', 'viewtube' ),
                'add_new_item'  => __( 'Add New Badge', 'viewtube' )
            ),
            'description'    => __( 'Description.', 'viewtube' ),
            'menu_icon'      => 'dashicons-layout',
            'public'         => true,
            'has_archive'   => false,
            'rewrite'        => array( 'slug' => 'author_badges' ),
            'supports'       => array( 'title','editor','thumbnail' )
        ));

        // Project taxonomy
        register_taxonomy(
            'badge_category',
            'author_badges',
            array(
                'labels' => array(
                    'name' => __( 'Badge Category', 'viewtube' ),
                    'add_new_item'      => __( 'Add New Category', 'viewtube' ),
                ),
                'hierarchical' => true,
                'show_admin_column'     => true
        ));
    }

    add_action( 'init', 'viewtube_custom_post_type' );

}