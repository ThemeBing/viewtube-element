<?php

/*
 * Add custom fields to menu item
 */
add_action( 'wp_nav_menu_item_custom_fields', 'viewtube_font_awesome_icon_custom_field', 10, 2 );
function viewtube_font_awesome_icon_custom_field( $item_id, $item ) {

    wp_nonce_field( 'custom_menu_meta_nonce', '_custom_menu_meta_nonce_name' );
    $custom_menu_meta = get_post_meta( $item_id, '_custom_menu_meta', true );
    ?>
    <p class="field-icon description description-wide">
        <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
            <?php echo esc_html__( 'Font Awesome Icon', 'viewtube' ); ?><br />
            <input type="text" id="edit-menu-item-icon-<?php echo $item_id; ?>" class="widefat code edit-menu-item-icon" name="menu-item-icon[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->font_awesome_icon ); ?>" />
        </label>
    </p>
    <?php
}

/*
 * Saves new field navmenu
 */
add_action('wp_update_nav_menu_item', 'viewtube_font_awesome_icon_custom_nav_update',10, 3);
function viewtube_font_awesome_icon_custom_nav_update($menu_id, $menu_item_db_id, $args ) {
    if ( is_array($_REQUEST['menu-item-icon']) ) {
        $custom_value = $_REQUEST['menu-item-icon'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, '_menu_item_icon', $custom_value );
    }
}

/*
 * Add value of new field to Navmenu ( Dashboard )
 */
add_filter( 'wp_setup_nav_menu_item','viewtube_font_awesome_icon_custom_nav_item' );
function viewtube_font_awesome_icon_custom_nav_item($menu_item) {
    $menu_item->font_awesome_icon = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
    return $menu_item;
}

/*
 * Add value to front-end of Navmenu
 */
add_filter( 'walker_nav_menu_start_el', 'viewtube_walker_nav_menu_start_el', 10, 4);
function viewtube_walker_nav_menu_start_el( $item_output, $item, $depth, $args ){

    $item_output = '';
    if ($item->font_awesome_icon !== '') {
        $item_output .= sprintf( '<a href="%s"><i class="%s"></i>%s</a>', $item->url, $item->font_awesome_icon, $item->title);
    } else {
        $item_output .= sprintf( '<a href="%s">%s</a>', $item->url, $item->title);
    }   

    return $item_output;
}