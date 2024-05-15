<?php

defined('ABSPATH') || exit;

class jobcircle_theme_menu_walker extends Walker_Nav_Menu
{
    private $CurrentItem;
    public $parent_menu_item_id = 0;
    function start_lvl(&$output, $depth = 0, $args = array(), $id = 0)
    {

        $parent_id = $this->CurrentItem->menu_item_parent;
        $parent_nav_mega = get_post_meta($parent_id, '_menu_item_megamenu', true);
        $this_nav_mega = get_post_meta($this->parent_menu_item_id, '_menu_item_megamenu', true);

        if ($this_nav_mega == 'on') {
            $output .= '<div class="dropdown-menu mega">';
            $output .= '<div class="container">';
            $output .= '<ul class="list-unstyled row">';
        } else {
            $output .= '<ul class="dropdown-menu">';
        }
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $parent_id = $this->CurrentItem->menu_item_parent;
        $parent_nav_mega = get_post_meta($parent_id, '_menu_item_megamenu', true);
        $this_nav_mega = get_post_meta($this->parent_menu_item_id, '_menu_item_megamenu', true);

        $output .= '</ul>';
        if ($this_nav_mega == 'on') {
            $output .= '</div></div>';
        }
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0)
    {
        global $wp_query;
        $this->CurrentItem = $item;
        if ($depth == 0) {
            $this->parent_menu_item_id = $item->ID;
        }
        $parent_menu_id = 0;
        if (isset($item->menu_item_parent) && $item->menu_item_parent > 0) {
            $parent_menu_id = $item->menu_item_parent;
        }
        $parent_mega_menu = get_post_meta($parent_menu_id, '_menu_item_megamenu', true);

        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $item_mega_menu = get_post_meta($item->ID, '_menu_item_megamenu', true);
        $class_names = $value = '';

        if (empty($args)) {
            $args = new stdClass();
        }

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        if ($item_mega_menu == 'on'){
            $classes[] = 'mega-menu';
        }
        if ($parent_mega_menu == 'on') {
            $classes[] = 'col-12 col-lg-3';
        }
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
        $class_names = ' class="' . esc_attr($class_names) . '"';

        $anchr_class = '';
        $anchr_classes = [];
        $rolebtn = [];
        $databstogg = [];
        $ariaexpand = [];

       
        if (isset($args->has_children) && $args->has_children) {
            $anchr_classes[] = 'dropdown-toggle';
            $rolebtn[] = 'button';
            $databstogg[] = 'dropdown';
            $ariaexpand[] = 'false';
        } 
        if (isset($item->menu_item_parent) && $item->menu_item_parent > 0) {
            $anchr_classes[] = 'dropdown-item';
        }
        if (!empty($anchr_classes)) {
            $anchr_class = ' class="' . implode(', ', $anchr_classes) . '"  role="' . implode(', ', $rolebtn) . '"  data-bs-toggle="' . implode(', ', $databstogg) . '"  aria-expanded="' . implode(', ', $ariaexpand) . '"';
        }

        $output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

        $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';

        $menu_icon_tag  = !empty($item->menu_icon) ? '<i class="' . esc_attr($item->menu_icon) . '"></i>' : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . $anchr_class . '>';
        $item_output .= $menu_icon_tag . $args->link_before . apply_filters('the_title', $item->title, $item->ID);
        $item_output .= $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args = '', &$output = '')
    {
        $id_field = $this->db_fields['id'];
        if (is_object($args[0])) {
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);
        }
        return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}
