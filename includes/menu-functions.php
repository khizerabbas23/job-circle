<?php

class jobcircle_mega_custom_menu
{
    /* --------------------------------------------*
         * Constructor
         * -------------------------------------------- */
    /**
     * Initializes the plugin by setting localization, 
     * filters, and administration functions.
     */
    function __construct()
    {
        // add custom menu fields to menu
        add_filter('wp_setup_nav_menu_item', array($this, 'jobcircle_mega_add_custom_nav_fields'));
        // save menu custom fields
        add_action('wp_update_nav_menu_item', array($this, 'jobcircle_mega_update_custom_nav_fields'), 10, 3);
        //
        add_filter('wp_nav_menu_item_custom_fields', array($this, 'menu_item_cus_fields'), 10, 4);
    }

    public function menu_item_cus_fields($id, $item, $depth, $args)
    {
        $item_id = $id;
        do_action('jobcircle_mega_menu_cus_items_before', $item, $item_id);
        if (isset($item->menu_item_parent) && $item->menu_item_parent == '0') { ?>
            <p class="field-custom description description-wide custom_onof">
                <label for="edit-menu-item-megamenu-<?php echo intval($item_id); ?>">
                    <?php _e('Active Mega Menu', 'jobcircle-frame'); ?><br />
                    <input type="checkbox" id="edit-menu-item-megamenu-<?php echo intval($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-megamenu[<?php echo intval($item_id); ?>]" <?php
                    if (esc_attr($item->megamenu) == 'on') {
                    echo 'checked="checked"';
                    }
                    ?>>
                </label>
            </p>
        <?php } ?>
        <?php
        do_action('jobcircle_mega_menu_cus_items_after', $item, $item_id);
    }

    /**
     * Add custom fields to $item nav object
     * in order to be used in custom Walker
     * @access      public
     * @return      void
     */
    function jobcircle_mega_add_custom_nav_fields($menu_item)
    {
        $menu_item->megamenu = get_post_meta($menu_item->ID, '_menu_item_megamenu', true);
        $menu_item = apply_filters('jobcircle_mega_add_custom_nav_fields_filtr', $menu_item);
        return $menu_item;
    }

    /**
     * Save menu custom fields
     * @access      public
     * @return      void
     */
    function jobcircle_mega_update_custom_nav_fields($menu_id, $menu_item_db_id, $args)
    {
        // Check if element is properly sent
        $megamenu_value = 'off';

        if (isset($_POST['menu-item-megamenu'][$menu_item_db_id])) {
            $megamenu_value = $_POST['menu-item-megamenu'][$menu_item_db_id];
        } else {
            $megamenu_value = 'off';
        }

        update_post_meta($menu_item_db_id, '_menu_item_megamenu', sanitize_text_field($megamenu_value));
        do_action('jobcircle_mega_menu_items_save', $menu_item_db_id);
    }
}

new jobcircle_mega_custom_menu();
