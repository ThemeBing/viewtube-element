<?php 

/**
 * Add functionality for file upload.
 */
function update_edit_form() {
    echo ' enctype="multipart/form-data"';
}
add_action( 'post_edit_form_tag', 'update_edit_form' );

function author_badges_add_custom_box() {

    // **************************
    ///      Auto updater     ///         
    // ************************** 

    add_meta_box(
        'author_earning',    // Unique ID
        'Author Earning',  	 // Box title
        'author_earning_box',  // Content callback, must be of type callable
        'author_badges'        // Post type
    );

    add_meta_box(
        'author_rating',             // Unique ID
        'Author Rating',             // Box title
        'author_rating_box',  // Content callback, must be of type callable
        'author_badges'        // Post type
    );
}
add_action('add_meta_boxes', 'author_badges_add_custom_box');


function author_badges_save_postdata($post) {

    // **************************
    ///     Auto updater      ///              
    // ************************** 

    if (array_key_exists('author_earning', $_POST)) {
        update_post_meta(
            $post,
            'author_earning',
            $_POST['author_earning']
        );
    }

    if (array_key_exists('author_rating', $_POST)) {
        update_post_meta(
            $post,
            'author_rating',
            $_POST['author_rating']
        );
    }


}
add_action('save_post', 'author_badges_save_postdata');




// **************************
///     Author Badges     ///            
// ************************** 

function author_earning_box($post) { ?>
    <input class="widefat" name="author_earning" id="author_earning" type="text" value="<?php echo esc_attr( get_post_meta($post->ID, 'author_earning', true) ) ?>">
    <?php
}

function author_rating_box($post) { ?>
    <input class="widefat" name="author_rating" id="author_rating" type="text" value="<?php echo esc_attr( get_post_meta($post->ID, 'author_rating', true) ) ?>">
    <?php
}