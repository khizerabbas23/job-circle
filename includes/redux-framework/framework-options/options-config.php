<?php

defined('ABSPATH') || exit;

if (!class_exists('ReduxFramework')) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = 'jobcircle_framework_options';

$theme = wp_get_theme();
$args = array(
    // This is where your data is stored in the database and also becomes your global variable name.
    'opt_name' => $opt_name,
    // Name that appears at the top of your panel.
    'display_name' => $theme->get('Name'),
    // Version that appears at the top of your panel.
    'display_version' => $theme->get('Version'),
    // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only).
    'menu_type' => 'menu',
    // Show the sections below the admin menu item or not.
    'allow_sub_menu' => true,
    // The text to appear in the admin menu.
    'menu_title' => __('Theme Options', 'jobcircle-frame'),
    // The text to appear on the page title.
    'page_title' => __('Theme Options', 'jobcircle-frame'),
    // Enabled the Webfonts typography module to use asynchronous fonts.
    'async_typography' => false,
    // Disable to create your own google fonts loader.
    'disable_google_fonts_link' => false,
    // Show the panel pages on the admin bar.
    'admin_bar' => true,
    // Icon for the admin bar menu.
    'admin_bar_icon' => 'dashicons-portfolio',
    // Priority for the admin bar menu.
    'admin_bar_priority' => 50,
    // Sets a different name for your global variable other than the opt_name.
    'global_variable' => '',
    // Show the time the page took to load, etc (forced on while on localhost or when WP_DEBUG is enabled).
    'dev_mode' => false,
    // Enable basic customizer support.
    'customizer' => true,
    // Allow the panel to opened expanded.
    'open_expanded' => false,
    // Disable the save warning when a user changes a field.
    'disable_save_warn' => false,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_priority' => null,
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters.
    'page_parent' => 'themes.php',
    // Permissions needed to access the options panel.
    'page_permissions' => 'manage_options',
    // Specify a custom URL to an icon.
    'menu_icon' => '',
    // Force your panel to always open to a specific tab (by id).
    'last_tab' => '',
    // Icon displayed in the admin panel next to your menu_title.
    'page_icon' => 'icon-themes',
    // Page slug used to denote the panel, will be based off page title, then menu title, then opt_name if not provided.
    'page_slug' => $opt_name,
    // On load save the defaults to DB before user clicks save.
    'save_defaults' => true,
    // Display the default value next to each field when not set to the default value.
    'default_show' => false,
    // What to print by the field's title if the value shown is default.
    'default_mark' => '*',
    // Shows the Import/Export panel when not used as a field.
    'show_import_export' => true,
    // The time transinets will expire when the 'database' arg is set.
    'transient_time' => 60 * MINUTE_IN_SECONDS,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output.
    'output' => true,
    // Allows dynamic CSS to be generated for customizer and google fonts,
    // but stops the dynamic CSS from going to the page head.
    'output_tag' => true,
    // Disable the footer credit of Redux. Please leave if you can help it.
    'footer_credit' => '',
    // If you prefer not to use the CDN for ACE Editor.
    // You may download the Redux Vendor Support plugin to run locally or embed it in your code.
    'use_cdn' => true,
    // Set the theme of the option panel.  Use 'wp' to use a more modern style, default is classic.
    'admin_theme' => 'wp',
    // HINTS.
    'hints' => array(
        'icon' => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color' => 'lightgray',
        'icon_size' => 'normal',
        'tip_style' => array(
            'color' => 'red',
            'shadow' => true,
            'rounded' => false,
            'style' => '',
        ),
        'tip_position' => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect' => array(
            'show' => array(
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'mouseover',
            ),
            'hide' => array(
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'click mouseleave',
            ),
        ),
    ),
    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'database' => '',
    'network_admin' => true,
);

$redux_class = new Redux;

if (class_exists('Redux') && method_exists($redux_class, 'set_args')) {
    Redux::set_args($opt_name, $args);

    $curr_array = jobcircle_currencies_common_list();

    $all_page = array('', __('Select Page', 'jobcircle-frame'));

    $args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'meta_key' => '',
        'meta_value' => '',
        'authors' => '',
        'child_of' => 0,
        'parent' => -1,
        'exclude_tree' => '',
        'number' => '',
        'offset' => 0,
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $pages = get_pages($args);
    if (!empty($pages)) {
        foreach ($pages as $page) {
            $all_page[$page->post_name] = $page->post_title;
        }
    }

    $gen_opts_atts = array();
    $gen_opts_atts[] = array(
        'id' => 'jobcircle-site-logo',
        'type' => 'media',
        'url' => true,
        'title' => __('Site Logo', 'jobcircle-frame'),
        'compiler' => 'true',
        'desc' => __('Site Logo media uploader.', 'jobcircle-frame'),
        'subtitle' => __('Site Logo media uploader.', 'jobcircle-frame'),
        'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
    );
    $gen_opts_atts[] = array(
        'id' => 'jobcircle-sticky-logo',
        'type' => 'media',
        'url' => true,
        'title' => __('Sticky Logo', 'jobcircle-frame'),
        'compiler' => 'true',
        'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
        'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
        'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
    );
     $gen_opts_atts[] = array(
        'id' => 'jobcircle-google-map',
        'type' => 'media',
        'url' => true,
        'title' => __('Google Map Icon', 'jobcircle-frame'),
        'compiler' => 'true',
        'desc' => __('Site Google Map Icon .', 'jobcircle-frame'),
        'subtitle' => __('Site Google Map Icon.', 'jobcircle-frame'),
        'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/map.png'),
    );
    $gen_opts_atts[] = array(
        'id' => 'jobcircle_default_curr',
        'type' => 'select',
        'title' => __('Select Currency', 'jobcircle-frame'),
        'subtitle' => '',
        'desc' => __('Select default currency for site.', 'jobcircle-frame'),
        'options' => $curr_array,
        'default' => ''
    );
    $gen_opts_atts[] = array(
        'id' => 'terms_conditions_page',
        'type' => 'select',
        'title' => __('Terms & Conditions Page', 'jobcircle-frame'),
        'subtitle' => __('Select the terms Page.', 'jobcircle-frame'),
        'desc' => '',
        'options' => $all_page,
        'default' => '',
    );
	
    $redux_genral_options = array(
        'title' => __('General Options', 'jobcircle-frame'),
        'id' => 'general-options',
        'desc' => __('These are really basic options!', 'jobcircle-frame'),
        'icon' => 'el el-home',
        'fields' => apply_filters('jobcircle_framewrok_options_general', $gen_opts_atts)
    );
    Redux::set_section($opt_name, $redux_genral_options);


    add_filter('redux/options/jobcircle_framework_options/sections', 'jobcircle_frame_plugin_core_settings', 1);

    function jobcircle_frame_plugin_core_settings($setting_sections)
    {
        global $jobcircle_framework_options, $wpdb;
        //
        $jobcircle_framework_options = get_option('jobcircle_framework_options');

        $header_opt_settings = array(
            'title' => __('Header', 'jobcircle-frame'),
            'id' => 'general-options-header',
            'desc' => __('Set Header Fields.', 'jobcircle-frame'),
            'icon' => 'el el-credit-card',
            'fields' => array()
        );

        $all_page = array('', __('Select Page', 'jobcircle-frame'));

        $args = array(
            'sort_order' => 'asc',
            'sort_column' => 'post_title',
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'meta_key' => '',
            'meta_value' => '',
            'authors' => '',
            'child_of' => 0,
            'parent' => -1,
            'exclude_tree' => '',
            'number' => '',
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish'
        );
        $pages = get_pages($args);
        if (!empty($pages)) {
            foreach ($pages as $page) {
                $all_page[$page->post_name] = $page->post_title;
            }
        }

        $header_opt_settings['fields'][] = array(
            'id' => 'header-style',
            'type' => 'select',
            'title' => __('Header Styles', 'jobcircle-frame'),
            'subtitle' => '',
            'desc' => '',
            'options' => array(
                'style1' => __('Header Style 1', 'jobcircle-frame'),
                'style2' => __('Header Style 2', 'jobcircle-frame'),
                'style3' => __('Header Style 3', 'jobcircle-frame'),
                'style4' => __('Header Style 4', 'jobcircle-frame'),
                'style5' => __('Header Style 5', 'jobcircle-frame'),
                'style6' => __('Header Style 6', 'jobcircle-frame'),
                'style7' => __('Header Style 7', 'jobcircle-frame'),
                'style8' => __('Header Style 8', 'jobcircle-frame'),
                'style9' => __('Header Style 9', 'jobcircle-frame'),
                'style10' => __('Header Style 10', 'jobcircle-frame'),
                'style11' => __('Header Style 11', 'jobcircle-frame'),
                'style12' => __('Header Style 12', 'jobcircle-frame'),
                'style13' => __('Header Style 13', 'jobcircle-frame'),
                'style14' => __('Header Style 14', 'jobcircle-frame'),
                'style15' => __('Header Style 15', 'jobcircle-frame'),
                'style16' => __('Header Style 16', 'jobcircle-frame'),
                'style17' => __('Header Style 17', 'jobcircle-frame'),
                'style60' => __('Header Style 60', 'jobcircle-frame'),
            ),
            'default' => 'style1',
        );
        // Style 1
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sites-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style1'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-stick-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style1'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        // Style 2
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-two-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style2'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-two-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style2'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        // Style 3
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-three-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style3'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-three-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style3'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        // Style 4
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-four-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style4'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-four-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style4'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        // Style 5
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-five-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style5'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-five-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style5'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-five-number',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style5'),
            'title' => __('Enter Your Number', 'jobcircle-frame'),
            'subtitle' => __('Put Your Number in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-five-google',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style5'),
            'title' => __('Enter Your Instagram Link', 'jobcircle-frame'),
            'subtitle' => __('Put Your Number in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-five-facebook',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style5'),
            'title' => __('Enter Your Facebook Link', 'jobcircle-frame'),
            'subtitle' => __('Put Your Facebook Link in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-five-twitter',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style5'),
            'title' => __('Enter Your Twitter Link', 'jobcircle-frame'),
            'subtitle' => __('Put Your Twitter Link in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-five-linkedin',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style5'),
            'title' => __('Enter Your Linkedin Link', 'jobcircle-frame'),
            'subtitle' => __('Put Your Linkedin Link in Field', 'jobcircle-frame'),
            'default' => '',
        );
        // Style 6
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-six-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style6'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-six-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style6'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        // Style 7
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-seven-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style7'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-seven-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style7'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-seven-alert',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style7'),
            'title' => __('Enter Your Text For Alert', 'jobcircle-frame'),
            'subtitle' => __('Put Your text in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-seven-email',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style7'),
            'title' => __('Enter Your Email', 'jobcircle-frame'),
            'subtitle' => __('Put Your Email in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-seven-number',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style7'),
            'title' => __('Enter Your Number', 'jobcircle-frame'),
            'subtitle' => __('Put Your Number in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-seven-google',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style7'),
            'title' => __('Enter Your Instagram Link', 'jobcircle-frame'),
            'subtitle' => __('Put Your Instagram Link in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-seven-facebook',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style7'),
            'title' => __('Enter Your Facebook Link', 'jobcircle-frame'),
            'subtitle' => __('Put Your Facebook Link in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-seven-twitter',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style7'),
            'title' => __('Enter Your Twitter Link', 'jobcircle-frame'),
            'subtitle' => __('Put Your Twitter Link in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-seven-linkedin',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style7'),
            'title' => __('Enter Your Linkedin Link', 'jobcircle-frame'),
            'subtitle' => __('Put Your Linkedin Link in Field', 'jobcircle-frame'),
            'default' => '',
        );
        // Style 8
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-eight-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style8'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-eight-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style8'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        // Style 9
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-nine-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style9'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-nine-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style9'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        // Style 10
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-ten-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style10'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-ten-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style10'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        // Style 11
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-eleven-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style11'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-eleven-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style11'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        // Style 12
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-twelve-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style12'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-twelve-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style12'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
         // Style 13
         $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-thirteen-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style13'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-thirteen-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style13'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-thirteen-number',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style13'),
            'title' => __('Enter Your Number', 'jobcircle-frame'),
            'subtitle' => __('Put Your Number in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-thirteen-email',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style13'),
            'title' => __('Enter Your Email Address', 'jobcircle-frame'),
            'subtitle' => __('Put Your Email Address in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-thirteen-facebook',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style13'),
            'title' => __('Enter Your Facebook Link', 'jobcircle-frame'),
            'subtitle' => __('Put Your Facebook Link in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-thirteen-youtube',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style13'),
            'title' => __('Enter Your Youtube Link', 'jobcircle-frame'),
            'subtitle' => __('Put Your Youtube Link in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-thirteen-instagram',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style13'),
            'title' => __('Enter Your Instagram Link', 'jobcircle-frame'),
            'subtitle' => __('Put Your Instagram Link in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-thirteen-linkdin',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style13'),
            'title' => __('Enter Your Linkedin Link', 'jobcircle-frame'),
            'subtitle' => __('Put Your Linkedin Link in Field', 'jobcircle-frame'),
            'default' => '',
        );
         // Style 14
         $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-forteen-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style14'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-forteen-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style14'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
         // Style 15
         $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-fifteen-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style15'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-fifteen-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style15'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );   
        // Style 16
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-sixteen-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style16'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-sixteen-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style16'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );    
        // Style 17
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-seventeen-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style17'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-seventeen-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style17'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-seventeen-alert',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style17'),
            'title' => __('Enter Your Alert Tag', 'jobcircle-frame'),
            'subtitle' => __('Put Your Alert Tag in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-seventeen-email',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style17'),
            'title' => __('Enter Your Email Address', 'jobcircle-frame'),
            'subtitle' => __('Put Your Email Address in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-seventeen-number',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style17'),
            'title' => __('Enter Your Number', 'jobcircle-frame'),
            'subtitle' => __('Put Your Number in Field', 'jobcircle-frame'),
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-header-seventeen-domain-email',
            'type' => 'text',
            'required' => array('header-style', 'equals', 'style17'),
            'title' => __('Enter Your Domain E-mail', 'jobcircle-frame'),
            'subtitle' => __('Put Your Domain E-mail Link in Field', 'jobcircle-frame'),
            'default' => '',
        );
         // Style 60
         $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-site-sixty-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style60'),
            'compiler' => 'true',
            'desc' => __('Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'jobcircle-sticky-sixty-logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Home Sticky Logo', 'jobcircle-frame'),
            'required' => array('header-style', 'equals', 'style60'),
            'compiler' => 'true',
            'desc' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'subtitle' => __('Sticky Logo media uploader.', 'jobcircle-frame'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        );      
     
        $header_opt_settings['fields'] = apply_filters('jobcircle_framewrok_options_headers', $header_opt_settings['fields']);
        $setting_sections[] = $header_opt_settings;
        $section_settings = array(
            'title' => __('Sub Header', 'jobcircle-frame'),
            'id' => 'subheader-options',
            'desc' => __('Default Sub Header settings.', 'jobcircle-frame'),
            'icon' => 'el el-lines',
            'fields' => array(
                array(
                    'id' => 'jobcircle-subheader',
                    'type' => 'button_set',
                    'title' => __('Sub Header', 'jobcircle-frame'),
                    'subtitle' => __('Sub Header on/off.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'jobcircle-subheader-height',
                    'type' => 'slider',
                    'title' => __('Sub Header Height', 'jobcircle-frame'),
                    'required' => array('jobcircle-subheader', 'equals', 'on'),
                    'subtitle' => __('Set Sub Header Height', 'jobcircle-frame'),
                    'desc' => __('Set Sub Header Height in (px)', 'jobcircle-frame'),
                    "default" => 0,
                    "min" => 0,
                    "step" => 1,
                    "max" => 1000,
                    'display_value' => 'text'
                ),
                array(
                    'id' => 'jobcircle-subheader-pading-top',
                    'type' => 'slider',
                    'title' => __('Padding Top', 'jobcircle-frame'),
                    'required' => array('jobcircle-subheader', 'equals', 'on'),
                    'subtitle' => __('Set Sub Header Padding Top', 'jobcircle-frame'),
                    'desc' => __('Set Sub Header Padding Top', 'jobcircle-frame'),
                    "default" => 0,
                    "min" => 0,
                    "step" => 1,
                    "max" => 1000,
                    'display_value' => 'text'
                ),
                array(
                    'id' => 'jobcircle-subheader-pading-bottom',
                    'type' => 'slider',
                    'title' => __('Padding Bottom', 'jobcircle-frame'),
                    'required' => array('jobcircle-subheader', 'equals', 'on'),
                    'subtitle' => __('Set Sub Header Padding Bottom', 'jobcircle-frame'),
                    'desc' => __('Set Sub Header Padding Bottom', 'jobcircle-frame'),
                    "default" => 0,
                    "min" => 0,
                    "step" => 1,
                    "max" => 1000,
                    'display_value' => 'text'
                ),
                array(
                    'id' => 'jobcircle-subheader-title',
                    'type' => 'button_set',
                    'title' => __('Sub Header Title', 'jobcircle-frame'),
                    'required' => array('jobcircle-subheader', 'equals', 'on'),
                    'subtitle' => __('Sub Header Title on/off.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'jobcircle-subheader-breadcrumb',
                    'type' => 'button_set',
                    'title' => __('Sub Header Breadcrumb', 'jobcircle-frame'),
                    'required' => array('jobcircle-subheader', 'equals', 'on'),
                    'subtitle' => __('Sub Header Breadcrumb on/off.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'jobcircle-subheader-bg-img',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Sub Header Background Image', 'jobcircle-frame'),
                    'required' => array('jobcircle-subheader', 'equals', 'on'),
                    'compiler' => 'true',
                    'desc' => '',
                    'subtitle' => __('Sub Header media uploader.', 'jobcircle-frame'),
                    'default' => '',
                ),
                array(
                    'id' => 'jobcircle-subheader-bg-color',
                    'type' => 'color_rgba',
                    'transparent' => false,
                    'title' => __('Sub Header Background Color', 'jobcircle-frame'),
                    'required' => array('jobcircle-subheader', 'equals', 'on'),
                    'subtitle' => __('Set Sub Header Background Color.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => 'rgba(17,22,44,0.66)'
                ),

            )
        );

        $setting_sections[] = $section_settings;


        $section_settings = array(
            'title' => __('404 Style', 'jobcircle-frame'),
            'id' => 'header-main-style-error',
            'desc' => __('Set the Header & Footer Style for theme.', 'jobcircle-frame'),
            'icon' => 'el el-credit-card',
            'fields' => array(
                array(
                    'id' => 'header-style-error',
                    'type' => 'select',
                    'title' => __('Header Styles For 404 Page.', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => '',
                    'options' => array(
                        'style1' => __('Header Style 1', 'jobcircle-frame'),
                        'style2' => __('Header Style 2', 'jobcircle-frame'),
                        'style3' => __('Header Style 3', 'jobcircle-frame'),
                        'style4' => __('Header Style 4', 'jobcircle-frame'),
                        'style5' => __('Header Style 5', 'jobcircle-frame'),
                        'style6' => __('Header Style 6', 'jobcircle-frame'),
                        'style7' => __('Header Style 7', 'jobcircle-frame'),
                        'style8' => __('Header Style 8', 'jobcircle-frame'),
                        'style9' => __('Header Style 9', 'jobcircle-frame'),
                        'style10' => __('Header Style 10', 'jobcircle-frame'),
                        'style11' => __('Header Style 11', 'jobcircle-frame'),
                        'style12' => __('Header Style 12', 'jobcircle-frame'),
                        'style13' => __('Header Style 13', 'jobcircle-frame'),
                        'style14' => __('Header Style 14', 'jobcircle-frame'),
                        'style15' => __('Header Style 15', 'jobcircle-frame'),
                        'style16' => __('Header Style 16', 'jobcircle-frame'),
                        'style17' => __('Header Style 17', 'jobcircle-frame'),
                        'style60' => __('Header Style 60', 'jobcircle-frame'),
                    ),
                    'default' => 'style1',
                ),
                array(
                    'id' => 'footer-style-error',
                    'type' => 'select',
                    'title' => __('Footer Style For 404 Page.', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => '',
                    'options' => array(
                        'style1' => __('Footer Style 1', 'jobcircle-frame'),
                        'style2' => __('Footer Style 2', 'jobcircle-frame'),
                        'style3' => __('Footer Style 3', 'jobcircle-frame'),
                        'style4' => __('Footer Style 4', 'jobcircle-frame'),
                        'style5' => __('Footer Style 5', 'jobcircle-frame'),
                        'style6' => __('Footer Style 6', 'jobcircle-frame'),
                        'style7' => __('Footer Style 7', 'jobcircle-frame'),
                        'style8' => __('Footer Style 8', 'jobcircle-frame'),
                        'style9' => __('Footer Style 9', 'jobcircle-frame'),
                        'style10' => __('Footer Style 10', 'jobcircle-frame'),
                        'style11' => __('Footer Style 11', 'jobcircle-frame'),
                        'style12' => __('Footer Style 12', 'jobcircle-frame'),
                        'style13' => __('Footer Style 13', 'jobcircle-frame'),
                        'style14' => __('Footer Style 14', 'jobcircle-frame'),
                        'style15' => __('Footer Style 15', 'jobcircle-frame'),
                        'style16' => __('Footer Style 16', 'jobcircle-frame'),
                        'style17' => __('Footer Style 17', 'jobcircle-frame'),
                        'style60' => __('Footer Style 60', 'jobcircle-frame'),
                    ),
                    'default' => 'style1',
                ),
            ),
        );
        $setting_sections[] = $section_settings;
        
        // footer section start
        $header_opt_settings = array(
            'title' => __('Footer', 'jobcircle-frame'),
            'id' => 'general-options-footer',
            'desc' => __('Set Footer Fields.', 'jobcircle-frame'),
            'icon' => 'el el-tasks',
            'fields' => array(
                array(
                    'id' => 'jobcircle-footer-copyright-text',
                    'type' => 'textarea',
                    'title' => __('Copyright Text', 'jobcircle-frame'),
                    'subtitle' => __('Set Copyright Text here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => sprintf(__('&copy; Copyrights %s. %s All rights reserved.', 'jobcircle-frame'), date('Y'), get_bloginfo('name')),
                ),
                array(
                    'id' => 'jobcircle-footer-facebook-url',
                    'type' => 'text',
                    'title' => __('Footer Facebook Url', 'jobcircle-frame'),
                    'subtitle' => __('Enter Url for Facebook.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),   
                array(
                    'id' => 'jobcircle-footer-instagram-url',
                    'type' => 'text',
                    'title' => __('Footer Instagram Url', 'jobcircle-frame'),
                    'subtitle' => __('Enter Url for Instagram.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),   
                array(
                    'id' => 'jobcircle-footer-twitter-url',
                    'type' => 'text',
                    'title' => __('Footer Twitter Url', 'jobcircle-frame'),
                    'subtitle' => __('Enter Url for Twitter.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),   
                array(
                    'id' => 'jobcircle-footer-youtube-url',
                    'type' => 'text',
                    'title' => __('Footer Youtube Url', 'jobcircle-frame'),
                    'subtitle' => __('Enter Url for Youtube.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ), 
                array(
                    'id' => 'jobcircle-footer-linkdin-url',
                    'type' => 'text',
                    'title' => __('Footer Linkdin Url', 'jobcircle-frame'),
                    'subtitle' => __('Enter Url for Lindkind.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                array(
                    'id' => 'footer-style',
                    'type' => 'select',
                    'title' => __('Footer Style', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => '',
                    'options' => array(
                        'style1' => __('Footer Style 1', 'jobcircle-frame'),
                        'style2' => __('Footer Style 2', 'jobcircle-frame'),
                        'style3' => __('Footer Style 3', 'jobcircle-frame'),
                        'style4' => __('Footer Style 4', 'jobcircle-frame'),
                        'style5' => __('Footer Style 5', 'jobcircle-frame'),
                        'style6' => __('Footer Style 6', 'jobcircle-frame'),
                        'style7' => __('Footer Style 7', 'jobcircle-frame'),
                        'style8' => __('Footer Style 8', 'jobcircle-frame'),
                        'style9' => __('Footer Style 9', 'jobcircle-frame'),
                        'style10' => __('Footer Style 10', 'jobcircle-frame'),
                        'style11' => __('Footer Style 11', 'jobcircle-frame'),
                        'style12' => __('Footer Style 12', 'jobcircle-frame'),
                        'style13' => __('Footer Style 13', 'jobcircle-frame'),
                        'style14' => __('Footer Style 14', 'jobcircle-frame'),
                        'style15' => __('Footer Style 15', 'jobcircle-frame'),
                        'style16' => __('Footer Style 16', 'jobcircle-frame'),
                        'style17' => __('Footer Style 17', 'jobcircle-frame'),
                        'style60' => __('Footer Style 60', 'jobcircle-frame'),
                    ),
                    'default' => 'style1',
                ),
                // Style2
                array(
                    'id' => 'jobcircle-footer-logo',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Footer Logo', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style2'),
                    'compiler' => 'true',
                    'desc' => __('Logo media uploader.', 'jobcircle-frame'),
                    'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),     
                array(
                    'id' => 'jobcircle-job-portal',
                    'type' => 'text',
                    'title' => __('Job Portal', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style2'),
                    'subtitle' => __('Enter text for job portal.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-job-portal-sub',
                    'type' => 'text',
                    'title' => __('Job Portal Sub Title', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style2'),
                    'subtitle' => __('Enter sub title for job portal.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-job-look-job',
                    'type' => 'text',
                    'title' => __('Job Portal Looking Job', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style2'),
                    'subtitle' => __('Enter text for looking job.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),    
                array(
                    'id' => 'jobcircle-job-look-job-url',
                    'type' => 'text',
                    'title' => __('Job Portal Looking Job Link', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style2'),
                    'subtitle' => __('Enter text for looking job link.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ), 
                array(
                    'id' => 'jobcircle-job-for-job',
                    'type' => 'text',
                    'title' => __('Job Portal Job Text', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style2'),
                    'subtitle' => __('Enter text for job.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),    
                array(
                    'id' => 'jobcircle-job-for-job-url',
                    'type' => 'text',
                    'title' => __('Job Portal Job Text Link', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style2'),
                    'subtitle' => __('Enter text for job link.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                 // Style 4
                 array(
                    'id' => 'jobcircle-footer-logo-four',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Logo Image', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'compiler' => 'true',
                    'desc' => __('Loog media uploader.', 'jobcircle-frame'),
                    'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),   
                 array(
                    'id' => 'jobcircle-footer-bgimg-four',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('background Image', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'compiler' => 'true',
                    'desc' => __('Background media uploader.', 'jobcircle-frame'),
                    'subtitle' => __('Background media uploader.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),   
                array(
                    'id' => 'jobcircle-subscription-four',
                    'type' => 'text',
                    'title' => __('Subscription Tag', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'subtitle' => __('Enter text for Subscription Tag.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-notify-four',
                    'type' => 'text',
                    'title' => __('Notificatoin Tag', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'subtitle' => __('Enter Text for Notificatoin Tag.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                array(
                    'id' => 'jobcircle-sub-form-id-four',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Form ID', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'subtitle' => __('Enter Your Footer Form ID.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                array(
                    'id' => 'jobcircle-sub-form-head-four',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Form Title', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'subtitle' => __('Enter Your Footer Form Title.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                array(
                    'id' => 'jobcircle-subscribe-four',
                    'type' => 'text',
                    'title' => __('Subscribe Label Text', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'subtitle' => __('Enter text for Subscribe Label.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),    
                array(
                    'id' => 'jobcircle-candidate-four',
                    'type' => 'text',
                    'title' => __('Candidate Text', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'subtitle' => __('Enter text for Candidate Text.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ), 
                array(
                    'id' => 'jobcircle-candidate-one-four',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Image For Candidate One', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'compiler' => 'true',
                    'desc' => __('Image For Candidate One.', 'jobcircle-frame'),
                    'subtitle' => __('Image For Candidate One.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),  
                array(
                    'id' => 'jobcircle-candidate-one-four-url',
                    'type' => 'text',
                    'title' => __('Candidate Image One Url', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'subtitle' => __('Enter Url for Candidate Image.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ), 
                array(
                    'id' => 'jobcircle-candidate-two-four',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Image For Candidate Two', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'compiler' => 'true',
                    'desc' => __('Image For Candidate Two.', 'jobcircle-frame'),
                    'subtitle' => __('Image For Candidate Two.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),  
                array(
                    'id' => 'jobcircle-candidate-two-four-url',
                    'type' => 'text',
                    'title' => __('Candidate Image Two Url', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'subtitle' => __('Enter Url for Candidate Image.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ), 
                array(
                    'id' => 'jobcircle-candidate-three-four',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Image For Candidate Three', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'compiler' => 'true',
                    'desc' => __('Image For Candidate Three.', 'jobcircle-frame'),
                    'subtitle' => __('Image For Candidate Three.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ), 
                array(
                    'id' => 'jobcircle-candidate-three-four-url',
                    'type' => 'text',
                    'title' => __('Candidate Image Three Url', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'subtitle' => __('Enter Url for Candidate Image.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-candidate-four-four',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Image For Candidate Four', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'compiler' => 'true',
                    'desc' => __('Image For Candidate Four.', 'jobcircle-frame'),
                    'subtitle' => __('Image For Candidate Four.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ), 
                array(
                    'id' => 'jobcircle-candidate-four-four-url',
                    'type' => 'text',
                    'title' => __('Candidate Image Four Url', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'subtitle' => __('Enter Url for Candidate Image.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),   
                array(
                    'id' => 'jobcircle-candidate-five-four-url',
                    'type' => 'text',
                    'title' => __('Candidate Image Five Url', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style4'),
                    'subtitle' => __('Enter Url for Candidate Image.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),    
                 // Style 5
                 array(
                    'id' => 'jobcircle-footer-bgimg-five',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Background Image', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style5'),
                    'compiler' => 'true',
                    'desc' => __('Background Image uploade.', 'jobcircle-frame'),
                    'subtitle' => __('Background Image uploade.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),  
                 array(
                    'id' => 'jobcircle-footer-five-logo',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Footer Logo', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style5'),
                    'compiler' => 'true',
                    'desc' => __('Logo media uploader.', 'jobcircle-frame'),
                    'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),     
                array(
                    'id' => 'jobcircle-employer-five',
                    'type' => 'text',
                    'title' => __('Employer Tag', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style5'),
                    'subtitle' => __('Enter text for Employer Tag.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-advertise-five',
                    'type' => 'text',
                    'title' => __('Advertisement Tag', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style5'),
                    'subtitle' => __('Enter sub title for Advertisement Tag.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-job-label-five',
                    'type' => 'text',
                    'title' => __('Search Label', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style5'),
                    'subtitle' => __('Enter text for Search Label.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),    
                array(
                    'id' => 'jobcircle-job-label-url-five',
                    'type' => 'text',
                    'title' => __('Search Label Link', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style5'),
                    'subtitle' => __('Enter Url for Search Label Link.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ), 
                // Style 6
                array(
                    'id' => 'jobcircle-footer-six-logo',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Footer Logo', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style6'),
                    'compiler' => 'true',
                    'desc' => __('Logo media uploader.', 'jobcircle-frame'),
                    'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),  
                // Style 7 
                array(
                    'id' => 'jobcircle-footer-bgimg-seven',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Background Image', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style7'),
                    'compiler' => 'true',
                    'desc' => __('Background Image uploade.', 'jobcircle-frame'),
                    'subtitle' => __('Background Image uploade.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),  
                 array(
                    'id' => 'jobcircle-footer-seven-logo',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Footer Logo', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style7'),
                    'compiler' => 'true',
                    'desc' => __('Logo media uploader.', 'jobcircle-frame'),
                    'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),     
                array(
                    'id' => 'jobcircle-employer-seven',
                    'type' => 'text',
                    'title' => __('Employer Tag', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style7'),
                    'subtitle' => __('Enter text for Employer Tag.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-advertise-seven',
                    'type' => 'text',
                    'title' => __('Advertisement Tag', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style7'),
                    'subtitle' => __('Enter sub title for Advertisement Tag.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-job-label-seven',
                    'type' => 'text',
                    'title' => __('Search Label', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style7'),
                    'subtitle' => __('Enter text for Search Label.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),    
                array(
                    'id' => 'jobcircle-job-label-url-seven',
                    'type' => 'text',
                    'title' => __('Search Label Link', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style7'),
                    'subtitle' => __('Enter Url for Search Label Link.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ), 
                // Style 8
                array(
                    'id' => 'jobcircle-footer-eight-logo',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Footer Logo', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style8'),
                    'compiler' => 'true',
                    'desc' => __('Logo media uploader.', 'jobcircle-frame'),
                    'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),     
                array(
                    'id' => 'jobcircle-job-portal-eight',
                    'type' => 'text',
                    'title' => __('Job Portal', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style8'),
                    'subtitle' => __('Enter text for job portal.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-job-portal-sub-eight',
                    'type' => 'text',
                    'title' => __('Job Portal Sub Title', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style8'),
                    'subtitle' => __('Enter sub title for job portal.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-job-look-job-eight',
                    'type' => 'text',
                    'title' => __('Job Portal Looking Job', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style8'),
                    'subtitle' => __('Enter text for looking job.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),    
                array(
                    'id' => 'jobcircle-job-look-job-url-eight',
                    'type' => 'text',
                    'title' => __('Job Portal Looking Job Link', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style8'),
                    'subtitle' => __('Enter text for looking job link.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ), 
                array(
                    'id' => 'jobcircle-job-for-job-eight',
                    'type' => 'text',
                    'title' => __('Job Portal Job Text', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style8'),
                    'subtitle' => __('Enter text for job.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),    
                array(
                    'id' => 'jobcircle-job-for-job-url-eight',
                    'type' => 'text',
                    'title' => __('Job Portal Job Text Link', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style8'),
                    'subtitle' => __('Enter text for job link.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                 // Style9
                array(
                    'id' => 'jobcircle-nine-footer-tag',
                    'type' => 'text',
                    'title' => __('Keep Tag', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style9'),
                    'subtitle' => __('Enter text for Keep Tag.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-nine-footer-sub-keep',
                    'type' => 'text',
                    'title' => __('Keep In Touch Sub Title', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style9'),
                    'subtitle' => __('Enter sub title for Keep In Touch.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-nine-footer-label',
                    'type' => 'text',
                    'title' => __('Subscribe Label', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style9'),
                    'subtitle' => __('Enter text for Subscribe Label.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),   
                 array(
                    'id' => 'jobcircle-nine-footer-form-id',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Form ID', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style9'),
                    'subtitle' => __('Enter Your Footer Form ID.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),   
                 array(
                    'id' => 'jobcircle-nine-footer-form-title',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Form Title', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style9'),
                    'subtitle' => __('Enter Your Footer Form Title.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),   
                array(
                    'id' => 'jobcircle-footer-nine-bg-image',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Footer Background Image', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style9'),
                    'compiler' => 'true',
                    'desc' => __('Background media uploader.', 'jobcircle-frame'),
                    'subtitle' => __('Logo media uploader.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),       
                // Style10
                array(
                    'id' => 'jobcircle-footer-ten-logo',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Recruiting Image', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style10'),
                    'compiler' => 'true',
                    'desc' => __('Image media uploader.', 'jobcircle-frame'),
                    'subtitle' => __('Image media uploader.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),     
                array(
                    'id' => 'jobcircle-ten-footer-tag',
                    'type' => 'text',
                    'title' => __('Recruiting Tag', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style10'),
                    'subtitle' => __('Enter text for Recruiting Tag.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-ten-footer-sub-title',
                    'type' => 'text',
                    'title' => __('Recruiting Sub Title', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style10'),
                    'subtitle' => __('Enter sub title for Recruiting Sub Title.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-ten-footer-label',
                    'type' => 'text',
                    'title' => __('Start Label', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style10'),
                    'subtitle' => __('Enter text for Start Label.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),    
                // Style12
                array(
                    'id' => 'jobcircle-footer-twelve-logo',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Logo Image', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style12'),
                    'compiler' => 'true',
                    'desc' => __('Image media uploader.', 'jobcircle-frame'),
                    'subtitle' => __('Image media uploader.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),     
                array(
                    'id' => 'jobcircle-twelve-footer-tag',
                    'type' => 'text',
                    'title' => __('COnsequat Tag', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style12'),
                    'subtitle' => __('Enter text for Consequat Tag.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-twelve-footer-number',
                    'type' => 'text',
                    'title' => __('Phone Number', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style12'),
                    'subtitle' => __('Enter Phone Number for Contacting.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-twelve-footer-address',
                    'type' => 'text',
                    'title' => __('Address', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style12'),
                    'subtitle' => __('Enter Address.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),    
                 // Style13                    
                array(
                    'id' => 'jobcircle-thirteen-footer-number',
                    'type' => 'text',
                    'title' => __('Enter Your Number', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style13'),
                    'subtitle' => __('Enter Number for Contacting.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-thirteen-footer-address',
                    'type' => 'textarea',
                    'title' => __('Put Your Address Here', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style13'),
                    'subtitle' => __('Enter Your Address.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-thirteen-footer-email',
                    'type' => 'text',
                    'title' => __('Put Your E-mail Address Here', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style13'),
                    'subtitle' => __('Put Your E-mail Address.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-thirteen-footer-privacy',
                    'type' => 'text',
                    'title' => __('Put Your Privacy Link Here', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style13'),
                    'subtitle' => __('Put Your Privacy Link Here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-thirteen-footer-terms-service',
                    'type' => 'text',
                    'title' => __('Put Your Terms & Condition Link Here', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style13'),
                    'subtitle' => __('Put Your Terms & Condition Link Here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                // Style14
                array(
                    'id' => 'jobcircle-footer-fourteen-logo',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Logo Image', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style14'),
                    'compiler' => 'true',
                    'desc' => __('Image media uploader.', 'jobcircle-frame'),
                    'subtitle' => __('Image media uploader.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),     
                array(
                    'id' => 'jobcircle-fourteen-footer-tag',
                    'type' => 'text',
                    'title' => __('COnsequat Tag', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style14'),
                    'subtitle' => __('Enter text for Consequat Tag.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-fourteen-footer-number',
                    'type' => 'text',
                    'title' => __('Phone Number', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style14'),
                    'subtitle' => __('Enter Phone Number for Contacting.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-fourteen-footer-address',
                    'type' => 'text',
                    'title' => __('Address', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style14'),
                    'subtitle' => __('Enter Address.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),    
                array(
                    'id' => 'jobcircle-fourteen-footer-subscribe',
                    'type' => 'text',
                    'title' => __('Address', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style14'),
                    'subtitle' => __('Enter Address.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),    
                array(
                    'id' => 'jobcircle-sub-form-id-fourten',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Form ID', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style14'),
                    'subtitle' => __('Enter Your Footer Form ID.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                array(
                    'id' => 'jobcircle-sub-form-head-fourten',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Form Title', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style14'),
                    'subtitle' => __('Enter Your Footer Form Title.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                // Style16                    
                array(
                    'id' => 'jobcircle-sixteen-footer-main-tag',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Main Heading', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style16'),
                    'subtitle' => __('Enter Your Footer Main Heading.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-sixteen-footer-sub-heading',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Sub Heading', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style16'),
                    'subtitle' => __('Enter Your Footer Sub Heading.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                array(
                    'id' => 'jobcircle-sixteen-footer-google-image',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Google Play Image', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style16'),
                    'compiler' => 'true',
                    'desc' => __('Add Your Google Play Image.', 'jobcircle-frame'),
                    'subtitle' => __('Add Your Google Play Image.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),    
                array(
                    'id' => 'jobcircle-sixteen-footer-google-image-url',
                    'type' => 'text',
                    'title' => __('Add Your Google Play Image Url', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style16'),
                    'subtitle' => __('Add Your Google Play Image Url.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-sixteen-footer-app-store',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('App Store Image', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style16'),
                    'compiler' => 'true',
                    'desc' => __('Add Your App Store Image.', 'jobcircle-frame'),
                    'subtitle' => __('Add Your App Store Image.', 'jobcircle-frame'),
                    'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                ),
                array(
                    'id' => 'jobcircle-sixteen-footer-app-store-url',
                    'type' => 'text',
                    'title' => __('Add Your App Store Image Url', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style16'),
                    'subtitle' => __('Add Your App Store Image Url.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ), 
                array(
                    'id' => 'jobcircle-sixteen-footer-privacy',
                    'type' => 'text',
                    'title' => __('Put Your Privacy Link Here', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style16'),
                    'subtitle' => __('Put Your Privacy Link Here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-sixteen-footer-terms-service',
                    'type' => 'text',
                    'title' => __('Put Your Terms & Condition Link Here', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style16'),
                    'subtitle' => __('Put Your Terms & Condition Link Here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),   
                // Style17                    
                array(
                    'id' => 'jobcircle-seventeen-footer-news-tag',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Newsletter Heading', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style17'),
                    'subtitle' => __('Enter Your Footer Newsletter Heading.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-seventeen-footer-news-sub-heading',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Newsletter Sub Heading', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style17'),
                    'subtitle' => __('Enter Your Footer Newsletter Sub Heading.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),   
                array(
                    'id' => 'jobcircle-seventeen-footer-form-id',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Form ID', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style17'),
                    'subtitle' => __('Enter Your Footer Form ID', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                 array(
                    'id' => 'jobcircle-seventeen-footer-form-title',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Form Title', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style17'),
                    'subtitle' => __('Enter Your Footer Form Title', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                array(
                    'id' => 'jobcircle-seventeen-footer-privacy-security',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Privacy Security Url', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style17'),
                    'subtitle' => __('Enter Your Footer Privacy Security Url', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ), 
                array(
                    'id' => 'jobcircle-seventeen-footer-term-service',
                    'type' => 'text',
                    'title' => __('Enter Your Footer Term Service Url', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style17'),
                    'subtitle' => __('Enter Your Footer Term Service Url', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                 // Style60                   
                 array(
                    'id' => 'jobcircle-sixty-footer-number',
                    'type' => 'text',
                    'title' => __('Enter Your Number', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style60'),
                    'subtitle' => __('Enter Number for Contacting.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),     
                array(
                    'id' => 'jobcircle-sixty-footer-address',
                    'type' => 'text',
                    'title' => __('Put Your Address Here', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style60'),
                    'subtitle' => __('Enter Your Address.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
                array(
                    'id' => 'jobcircle-sixty-footer-email',
                    'type' => 'text',
                    'title' => __('Put Your E-mail Address Here', 'jobcircle-frame'),
                    'required' => array('footer-style', 'equals', 'style60'),
                    'subtitle' => __('Put Your E-mail Address.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),  
            )
        );
        $setting_sections[] = $header_opt_settings;

		// footer sidebars section start
		$ads_management = array(
			'title' => __('ADs Management', 'jobcircle-frame'),
			'id' => 'footer-sidebar-options',
			'desc' => __('Set ADs Management.', 'jobcircle-frame'),
			'icon' => 'el el-list-alt',
			'fields' => array(
				// Existing fields...
				
				// New "ADs Management" section
				array(
					'id' => 'ads-management-section',
					'type' => 'section',
					'title' => __('ADs Management', 'jobcircle-frame'),
					'subtitle' => __('Manage ADs', 'jobcircle-frame'),
					'indent' => true,
				),
				
				// Repeater field for "Type"
				array(
					'id' => 'ad_type',
					'type' => 'repeater',
					'title' => 'Type',
					'subtitle' => 'Add new ad types',
					'desc' => '',
					'required' => array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
					'section_id' => 'ads-management-section',
					'fields' => array(
						array(
							'id' => 'ad_type_select',
							'type' => 'button_set', // Change the type to button_set
							'title' => 'Select Ad Type',
							'options' => array(
								'code' => 'Code',
								'image' => 'Image',
							),
							'default' => 'code',
						),
						array(
							'id' => 'ad_code',
							'type' => 'textarea',
							'title' => 'Ad Code',
							'subtitle' => 'Paste the code for the ad',
							// 'desc' => 'Only visible when "Code" is selected as the ad type',
							// 'required' => array('ad_type_select', 'equals', 'code'),
						),
						 array(
							'id' => 'jobcircle-sixteen-ad-image',
							'type' => 'media',
							'url' => true,
							'title' => __('Ad Image', 'jobcircle-frame'),
							'compiler' => 'true',
							'desc' => __('Add Your Ad Image.', 'jobcircle-frame'),
							'subtitle' => __('Add Your Ad Image.', 'jobcircle-frame'),
							// 'required' => array('ad_type_select', 'equals', 'image'),
						),    
						// Radio switch button for "Ad Placement"
						array(
							'id' => 'ad_placement',
							'type' => 'button_set',
							'title' => 'Ad Placement',
							'subtitle' => 'Select where the ad will be displayed',
							'desc' => 'Choose one or more placement options',
							'options' => array(
								'job' => 'Job',
								'job_details' => 'Job Details',
								'candidate' => 'Candidate',
								'candidate_details' => 'Candidate Details',
								'employer' => 'Employer',
								'employer_details' => 'Employer Details',
							),
							'required' => array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
							'section_id' => 'ads-management-section',
						),
						
						// Select field for "AD Location"
						array(
							'id' => 'ad_location',
							'type' => 'select',
							'title' => 'AD Location',
							'subtitle' => 'Select where the ad will be located',
							'desc' => 'Choose a location for the ad',
							'options' => array(
								'top_content' => 'Top of Content',
								'bottom_content' => 'Bottom of Content',
								'top_sidebar' => 'Top of Sidebar',
								'bottom_sidebar' => 'Bottom of Sidebar',
							),
							'required' => array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
							'section_id' => 'ads-management-section',
						),
					),
				),
				
				
				// ...
			)
		);

		$setting_sections[] = $ads_management;


        // footer sidebars section start
        $footer_sidebar_settings = array(
            'title' => __('Footer Sidebars', 'jobcircle-frame'),
            'id' => 'footer-sidebar-options',
            'desc' => __('Set Footer Sidebars.', 'jobcircle-frame'),
            'icon' => 'el el-th',
            'fields' => array(
                array(
                    'id' => 'jobcircle-footer-sidebar-switch',
                    'type' => 'button_set',
                    'title' => __('Footer Widgets Area', 'jobcircle-frame'),
                    'subtitle' => __('Footer Widgets Area on/off', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'off',
                ),
                array(
                    'id' => 'footer-widget-style',
                    'type' => 'select',
                    'title' => __('Footer Widget Style', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => '',
                    'options' => array(
                        'style1' => __('Footer Widget Style 1', 'jobcircle-frame'),
                        'style2' => __('Footer Widget Style 2', 'jobcircle-frame'),
                        'style3' => __('Footer Widget Style 3', 'jobcircle-frame'),
                        'style4' => __('Footer Widget Style 4', 'jobcircle-frame'),
                        'style5' => __('Footer Widget Style 5', 'jobcircle-frame'),
                        'style6' => __('Footer Widget Style 6', 'jobcircle-frame'),
                        'style7' => __('Footer Widget Style 7', 'jobcircle-frame'),
                        'style8' => __('Footer Widget Style 8', 'jobcircle-frame'),
                        'style9' => __('Footer Widget Style 9', 'jobcircle-frame'),
                        'style10' => __('Footer Widget Style 10', 'jobcircle-frame'),
                        'style11' => __('Footer Widget Style 11', 'jobcircle-frame'),
                        'style12' => __('Footer Widget Style 12', 'jobcircle-frame'),
                        'style13' => __('Footer Widget Style 13', 'jobcircle-frame'),
                        'style14' => __('Footer Widget Style 14', 'jobcircle-frame'),
                        'style15' => __('Footer Widget Style 15', 'jobcircle-frame'),
                        'style16' => __('Footer Widget Style 16', 'jobcircle-frame'),
                        'style17' => __('Footer Widget Style 17', 'jobcircle-frame'),
                        'style60' => __('Footer Widget Style 60', 'jobcircle-frame'),
                    ),
                    'default' => 'style1',
                ),
                array(
                    'id' => 'jobcircle-footer-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style1')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 2
                array(
                    'id' => 'jobcircle-footer-widgstyle-two-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style2')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 3
                array(
                    'id' => 'jobcircle-footer-widgstyle-three-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style3')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                 // Widget Style 4
                 array(
                    'id' => 'jobcircle-footer-widgstyle-four-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style4')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 5
                array(
                    'id' => 'jobcircle-footer-widgstyle-five-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style5')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 6
                array(
                    'id' => 'jobcircle-footer-widgstyle-six-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style6')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                 // Widget Style 7
                 array(
                    'id' => 'jobcircle-footer-widgstyle-seven-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style7')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 8
                array(
                    'id' => 'jobcircle-footer-widgstyle-eight-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style8')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 9
                array(
                    'id' => 'jobcircle-footer-widgstyle-nine-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style9')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 10
                array(
                    'id' => 'jobcircle-footer-widgstyle-ten-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style10')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 11
                array(
                    'id' => 'jobcircle-footer-widgstyle-eleven-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style11')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 12
                array(
                    'id' => 'jobcircle-footer-widgstyle-twelve-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style12')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 13
                array(
                    'id' => 'jobcircle-footer-widgstyle-thirteen-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style13')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 14
                array(
                    'id' => 'jobcircle-footer-widgstyle-fourteen-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style14')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 15
                array(
                    'id' => 'jobcircle-footer-widgstyle-fifteen-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style15')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 16
                array(
                    'id' => 'jobcircle-footer-widgstyle-sixteen-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style16')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                 // Widget Style 17
                 array(
                    'id' => 'jobcircle-footer-widgstyle-seventeen-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style17')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                // Widget Style 60
                array(
                    'id' => 'jobcircle-footer-widgstyle-sixty-sidebars',
                    'type' => 'jobcircle_multi_select',
                    'select_title' => __('Select Column Width', 'jobcircle-frame'),
                    'input_title' => __('Sidebar Name', 'jobcircle-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'jobcircle-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'jobcircle-frame'),
                    'required' => array(
                        array('jobcircle-footer-sidebar-switch', 'equals', 'on'),
                        array('footer-widget-style', 'equals', 'style60')
                    ),
                    'subtitle' => __('Set Footer Sidebars here.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
            )
        );
        $setting_sections[] = $footer_sidebar_settings;

        $section_settings = array(
            'title' => __('Color', 'jobcircle-frame'),
            'id' => 'theme-all-colors',
            'desc' => __('Set the First color for theme.', 'jobcircle-frame'),
            'icon' => 'el el-brush',
            'fields' => array(
                
                array(
                    'id' => 'jobcircle-main-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Theme Color', 'jobcircle-frame'),
                    'subtitle' => __('Set Main Theme Color.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                array(
                    'id' => 'jobcircle-body-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Body Background Color', 'jobcircle-frame'),
                    'subtitle' => __('Set Body Background Color.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                array(
                    'id' => 'jobcircle-map-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Google Map Color', 'jobcircle-frame'),
                    'subtitle' => __('Set Google Map Color.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                array(
                    'id' => 'header-colors-section',
                    'type' => 'section',
                    'title' => __('Header Colors', 'jobcircle-frame'),
                    'subtitle' => '',
                    'indent' => true,
                ),
                array(
                    'id' => 'header-bg-color',
                    'type' => 'color_rgba',
                    'transparent' => true,
                    'title' => __('Header Background Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to Header Background.', 'jobcircle-frame'),
                    'default' => '#ffffff',
                ),
                array(
                    'id' => 'header-links-color',
                    'type' => 'color_rgba',
                    'transparent' => true,
                    'title' => __('Link Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to the header links.', 'jobcircle-frame'),
                    'default' => '#6a6a6a',
                ),
                array(
                    'id' => 'header-txts-color',
                    'type' => 'color_rgba',
                    'transparent' => true,
                    'title' => __('Text Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to the header text.', 'jobcircle-frame'),
                    'default' => '#6a6a6a',
                ),
                array(
                    'id' => 'header-icons-color',
                    'type' => 'color_rgba',
                    'transparent' => true,
                    'title' => __('Icons Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to the header icons.', 'jobcircle-frame'),
                    'default' => '#00adef',
                ),
                array(
                    'id' => 'header-btn-bg-color',
                    'type' => 'color_rgba',
                    'transparent' => true,
                    'title' => __('Buttons Background Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to Header Background Buttons.', 'jobcircle-frame'),
                    'default' => '#ffffff',
                ),
                array(
                    'id' => 'header-btn-text-color',
                    'type' => 'color_rgba',
                    'transparent' => true,
                    'title' => __('Buttons Text Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to the header buttons text.', 'jobcircle-frame'),
                    'default' => '#6a6a6a',
                ),
                array(
                    'id' => 'menu-colors-section',
                    'type' => 'section',
                    'title' => __('Header Menu Colors', 'jobcircle-frame'),
                    'subtitle' => '',
                    'indent' => true,
                ),
                array(
                    'id' => 'menu-link-color',
                    'type' => 'link_color',
                    'title' => __('Menu Links Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'visited' => true,
                    'desc' => __('These colors will apply to header navigation menu items.', 'jobcircle-frame'),
                    'default' => array(
                        'regular' => '#656c6c',
                        'hover' => '#13b5ea',
                        'active' => '#13b5ea',
                        'visited' => '',
                    )
                ),
                array(
                    'id' => 'submenu-bg-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('SubMenu Background Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to SubMenu Background.', 'jobcircle-frame'),
                    'default' => '#ffffff',
                ),
                array(
                    'id' => 'submenu-link-color',
                    'type' => 'link_color',
                    'title' => __('SubMenu Links Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'visited' => true,
                    'desc' => __('These colors will apply to header navigation sub-menu items.', 'jobcircle-frame'),
                    'default' => array(
                        'regular' => '#656c6c',
                        'hover' => '#13b5ea',
                        'active' => '#13b5ea',
                        'visited' => '',
                    )
                ),

                array(
                    'id' => 'footer-colors-section',
                    'type' => 'section',
                    'title' => __('Footer Colors', 'jobcircle-frame'),
                    'subtitle' => '',
                    'indent' => true,
                ),
                array(
                    'id' => 'footer-bg-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Footer Background Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply on the Footer Background.', 'jobcircle-frame'),
                    'default' => '#26272b',
                ),
                array(
                    'id' => 'footer-text-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Footer Text Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to Footer Text.', 'jobcircle-frame'),
                    'default' => '#999999',
                ),
                array(
                    'id' => 'footer-link-color',
                    'type' => 'link_color',
                    'title' => __('Footer Links Color Option', 'jobcircle-frame'),
                    'subtitle' => '',
                    'visited' => true,
                    'desc' => __('These colors will apply to Footer links.', 'jobcircle-frame'),
                    'default' => array(
                        'regular' => '#999999',
                        'hover' => '#ffffff',
                        'active' => '#999999',
                        'visited' => '#ffffff',
                    )
                ),
                array(
                    'id' => 'footer-border-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Footer Borders Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply on Footer all Borders like widgets etc.', 'jobcircle-frame'),
                    'default' => '#2e2e2e',
                ),
                array(
                    'id' => 'footer-copyright-bgcolor',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Footer copyright Background', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to Footer copyright Background.', 'jobcircle-frame'),
                    'default' => '#26272b',
                ),
                array(
                    'id' => 'footer-copyright-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Footer copyright Text Color', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to Footer copyright Text.', 'jobcircle-frame'),
                    'default' => '#999999',
                ),
            ),
        );
        $setting_sections[] = $section_settings;

        $footer_sidebar_settings = array(
            'title' => __('Typography', 'jobcircle-frame'),
            'id' => 'custom-typo-sec',
            'desc' => '',
            'icon' => 'el el-font',
            'fields' => array(
                array(
                    'id' => 'body-typo',
                    'type' => 'typography',
                    'title' => __('Body Typography', 'jobcircle-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('body', 'p', 'li'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'menu-typo',
                    'type' => 'typography',
                    'title' => __('Menu Typography', 'jobcircle-frame'),
                    'google' => true,
                    'color' => false,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('.navbar-nav > li > a'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'submenu-typo',
                    'type' => 'typography',
                    'title' => __('SubMenu Typography', 'jobcircle-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'color' => false,
                    'font-backup' => true,
                    'output' => array('.navbar-nav .sub-menu li a'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'h1-typo',
                    'type' => 'typography',
                    'title' => __('H1 Typography', 'jobcircle-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('h1', 'body h1'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'h2-typo',
                    'type' => 'typography',
                    'title' => __('H2 Typography', 'jobcircle-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('h2', 'body h2'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'h3-typo',
                    'type' => 'typography',
                    'title' => __('H3 Typography', 'jobcircle-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('h3', 'body h3'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'h4-typo',
                    'type' => 'typography',
                    'title' => __('H4 Typography', 'jobcircle-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('h4', 'body h4'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'h5-typo',
                    'type' => 'typography',
                    'title' => __('H5 Typography', 'jobcircle-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('h5', 'body h5'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'h6-typo',
                    'type' => 'typography',
                    'title' => __('H6 Typography', 'jobcircle-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('h6', 'body h6'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'fancy-title-typo',
                    'type' => 'typography',
                    'title' => __('Fancy Title Typography', 'jobcircle-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('.jobcircle-fancy-title h2'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '#333333',
                        'font-style' => 'normal',
                        'font-family' => 'Roboto',
                        'google' => true,
                        'font-size' => '24px',
                        'line-height' => '28px'
                    ),
                ),
                array(
                    'id' => 'page-title-typo',
                    'type' => 'typography',
                    'title' => __('Page Title Typography', 'jobcircle-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('.jobcircle-page-title h1'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '#ffffff',
                        'font-style' => '600',
                        'font-family' => 'Roboto',
                        'google' => true,
                        'font-size' => '30px',
                        'line-height' => '34px'
                    ),
                ),
                array(
                    'id' => 'sidebar-widget-typo',
                    'type' => 'typography',
                    'title' => __('Sidebar widget title Typography', 'jobcircle-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('.jobcircle-widget-title h2'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '#333333',
                        'font-style' => 'normal',
                        'font-family' => 'Roboto',
                        'google' => true,
                        'font-size' => '20px',
                        'line-height' => '24px'
                    ),
                ),
                array(
                    'id' => 'footer-widget-typo',
                    'type' => 'typography',
                    'title' => __('Footer widget title Typography', 'jobcircle-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('.footer-widget-title h2'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'jobcircle-frame'),
                    'default' => array(
                        'color' => '#ffffff',
                        'font-style' => 'normal',
                        'font-family' => 'Roboto',
                        'google' => true,
                        'font-size' => '18px',
                        'line-height' => '22px'
                    ),
                ),
            )
        );
        $setting_sections[] = $footer_sidebar_settings;

        $section_settings = array(
            'title' => __('Social Sharing', 'jobcircle-frame'),
            'id' => 'social-sharing',
            'desc' => __('Select platforms to share your posts.', 'jobcircle-frame'),
            'icon' => 'el el-share',
            'fields' => array(
                array(
                    'id' => 'jobcircle-social-sharing-facebook',
                    'type' => 'button_set',
                    'title' => __('Facebook', 'jobcircle-frame'),
                    'subtitle' => __('Social Sharing on Facebook.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'jobcircle-social-sharing-twitter',
                    'type' => 'button_set',
                    'title' => __('Twitter', 'jobcircle-frame'),
                    'subtitle' => __('Social Sharing on Twitter.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'jobcircle-social-sharing-tumblr',
                    'type' => 'button_set',
                    'title' => __('Tumblr', 'jobcircle-frame'),
                    'subtitle' => __('Social Sharing on Tumblr.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'jobcircle-social-sharing-dribbble',
                    'type' => 'button_set',
                    'title' => __('Dribbble', 'jobcircle-frame'),
                    'subtitle' => __('Social Sharing on Dribbble.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'jobcircle-social-sharing-stumbleupon',
                    'type' => 'button_set',
                    'title' => __('StumbleUpon', 'jobcircle-frame'),
                    'subtitle' => __('Social Sharing on StumbleUpon.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'jobcircle-social-sharing-youtube',
                    'type' => 'button_set',
                    'title' => __('Youtube', 'jobcircle-frame'),
                    'subtitle' => __('Social Sharing on Youtube.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'jobcircle-social-sharing-more',
                    'type' => 'button_set',
                    'title' => __('Share More', 'jobcircle-frame'),
                    'subtitle' => __('Social Sharing on other platforms.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
            )
        );
        $setting_sections[] = $section_settings;

        $section_settings = array(
            'title' => __('Social Networking', 'jobcircle-frame'),
            'id' => 'social-networking',
            'desc' => __('Set profile links for your Social Networking platforms.', 'jobcircle-frame'),
            'icon' => 'el el-random',
            'fields' => array(
                array(
                    'id' => 'jobcircle-social-networking-twitter',
                    'type' => 'text',
                    'title' => __('Twitter', 'jobcircle-frame'),
                    'subtitle' => __('Set a profile link for Twitter.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                array(
                    'id' => 'jobcircle-social-networking-facebook',
                    'type' => 'text',
                    'title' => __('Facebook', 'jobcircle-frame'),
                    'subtitle' => __('Set a profile link for Facebook.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                array(
                    'id' => 'jobcircle-social-networking-youtube',
                    'type' => 'text',
                    'title' => __('YouTube', 'jobcircle-frame'),
                    'subtitle' => __('Set a profile link for youtube.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                array(
                    'id' => 'jobcircle-social-networking-vimeo',
                    'type' => 'text',
                    'title' => __('Vimeo', 'jobcircle-frame'),
                    'subtitle' => __('Set a profile link for Vimeo.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                array(
                    'id' => 'jobcircle-social-networking-linkedin',
                    'type' => 'text',
                    'title' => __('Linkedin', 'jobcircle-frame'),
                    'subtitle' => __('Set a profile link for linkedin.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                array(
                    'id' => 'jobcircle-social-networking-pinterest',
                    'type' => 'text',
                    'title' => __('Pinterest', 'jobcircle-frame'),
                    'subtitle' => __('Set a profile link for Pinterest.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                array(
                    'id' => 'jobcircle-social-networking-instagram',
                    'type' => 'text',
                    'title' => __('Instagram', 'jobcircle-frame'),
                    'subtitle' => __('Set a profile link for Instagram.', 'jobcircle-frame'),
                    'desc' => '',
                    'default' => '',
                ),
            )
        );
        $setting_sections[] = $section_settings;

        // footer section start
        $sidebars_array = array('' => esc_html__('Select Sidebar', 'jobcircle-frame'));
        $jobcircle_framework_sidebars = isset($jobcircle_framework_options['jobcircle-themes-sidebars']) ? $jobcircle_framework_options['jobcircle-themes-sidebars'] : '';
        if (is_array($jobcircle_framework_sidebars) && sizeof($jobcircle_framework_sidebars) > 0) {
            foreach ($jobcircle_framework_sidebars as $sidebar) {
                $sidebars_array[sanitize_title($sidebar)] = $sidebar;
            }
        }
        $sidebar_opt_settings = array(
            'title' => __('Layouts', 'jobcircle-frame'),
            'id' => 'themes-layouts',
            'desc' => __('Set Theme layouts and sidebars list.', 'jobcircle-frame'),
            'icon' => 'el el-pause',
            'fields' => array(
                array(
                    'id' => 'jobcircle-themes-sidebars',
                    'type' => 'multi_text',
                    'title' => __('Sidebars', 'jobcircle-frame'),
                    'subtitle' => __('Create a Dynamic List of Sidebars.', 'jobcircle-frame'),
                    'desc' => __('These Sidebars will list in Theme Appearance >> Widgets.', 'jobcircle-frame'),
                    'default' => '',
                ),
                array(
                    'id' => 'jobcircle-default-layout',
                    'type' => 'image_select',
                    'title' => __('Select Layout', 'jobcircle-frame'),
                    'subtitle' => '',
                    'desc' => __('Select default Layout for default pages.', 'jobcircle-frame'),
                    'options' => array(
                        'full' => array(
                            'alt' => __('Full Width', 'jobcircle-frame'),
                            'img' => ReduxFramework::$_url . 'assets/img/1col.png'
                        ),
                        'right' => array(
                            'alt' => __('Right Sidebar', 'jobcircle-frame'),
                            'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
                        ),
                        'left' => array(
                            'alt' => __('Left Sidebar', 'jobcircle-frame'),
                            'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
                        ),
                    ),
                    'default' => ''
                ),
                array(
                    'id' => 'jobcircle-default-sidebar',
                    'type' => 'select',
                    'title' => __('Select Sidebar', 'jobcircle-frame'),
                    'required' => array('jobcircle-default-layout', '!=', 'full'),
                    'subtitle' => '',
                    'desc' => __('Select default Sidebars for default pages.', 'jobcircle-frame'),
                    'options' => $sidebars_array,
                    'default' => ''
                ),
            )
        );
        
        

        $setting_sections[] = $sidebar_opt_settings;

        $account_settings = array(
            'title' => __('User Account', 'jobcircle-frame'),
            'id' => 'custom-accon-setting',
            'desc' => __('Account Settings.', 'jobcircle-frame'),
            'icon' => 'el el-group',
            'fields' => array(
                array(
                    'id' => 'user_account_approval',
                    'type' => 'select',
                    'title' => __('User Account Approval Type', 'jobcircle-frame'),
                    'subtitle' => __('Select the User Approval Type.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'auto_verify' => __('Auto Approve', 'jobcircle-frame'),
                        'email_verify' => __('Verify By Email', 'jobcircle-frame'),
                        'admin_verify' => __('Admin Approve', 'jobcircle-frame'),
                    ),
                    'default' => 'auto_verify',
                ),
                array(
                    'id' => 'user_login_page',
                    'type' => 'select',
                    'title' => __('User Login Page', 'jobcircle-frame'),
                    'subtitle' => __('Select the User Login Page.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => $all_page,
                    'default' => '',
                ),
                array(
                    'id' => 'user_dashboard_page',
                    'type' => 'select',
                    'title' => __('User Dashboard Page', 'jobcircle-frame'),
                    'subtitle' => __('Select the User Dashboard Page.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => $all_page,
                    'default' => '',
                ),
                array(
                    'id' => 'dashboard_page_logo',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Dashboard page Logo', 'jobcircle-frame'),
                    'compiler' => 'true',
                    'desc' => '',
                    'subtitle' => __('This logo will show at dashboard page.', 'jobcircle-frame'),
                    'default' => '',
                ),
                array(
                    'id' => 'social_login_platforms',
                    'type' => 'button_set',
                    'multi' => true,
                    'title' => __('Social Login Platforms', 'jobcircle-frame'),
                    'desc' => '',
                    'subtitle' => __('Select multiple platforms to login with.', 'jobcircle-frame'),
                    'options' => array(
                        'facebook' => __('Facebook', 'jobcircle-frame'),
                        'google' => __('Google', 'jobcircle-frame'),
                    ),
                    'default' => array('facebook', 'google'),
                ),
                array(
                    'id' => 'candidate_profile_package',
                    'type' => 'button_set',
                    'title' => __('Candidate Profile Package', 'jobcircle-frame'),
                    'desc' => '',
                    'subtitle' => __('Candidate Profile Package.', 'jobcircle-frame'),
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'off',
                ),
                array(
                    'id' => 'employer_profile_package',
                    'type' => 'button_set',
                    'title' => __('Employer Profile Package', 'jobcircle-frame'),
                    'desc' => '',
                    'subtitle' => __('Employer Profile Package.', 'jobcircle-frame'),
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'off',
                ),
                array(
                    'id' => 'user_switch_account',
                    'type' => 'button_set',
                    'title' => __('User Switch Account', 'jobcircle-frame'),
                    'desc' => '',
                    'subtitle' => __('User Switch Account.', 'jobcircle-frame'),
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => '',
                ),
                array(
                    'id' => 'employer_zoom_meetings',
                    'type' => 'button_set',
                    'title' => __('Zoom meetings', 'jobcircle-frame'),
                    'desc' => '',
                    'subtitle' => __('Zoom meetings option in dashboard.', 'jobcircle-frame'),
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'off',
                ),
            )
        );
        $setting_sections[] = $account_settings;

        $candidate_settings_fields = array();
        $candidate_settings_fields[] = array(
            'id' => 'candidate_profile_scoring',
            'type' => 'button_set',
            'title' => __('Candidate Profile Score', 'jobcircle-frame'),
            'desc' => '',
            'subtitle' => '',
            'options' => array(
                'on' => __('On', 'jobcircle-frame'),
                'off' => __('Off', 'jobcircle-frame'),
            ),
            'default' => 'off',
        );
        $candidate_settings_fields[] = array(
            'id' => 'skill_low_set_color',
            'type' => 'color',
            'transparent' => false,
            'title' => __('Low Profile Color', 'jobcircle-frame'),
            'subtitle' => '',
            'desc' => __("Set color for Low Profile. Profile Score percentage from 0 to 25%.", 'jobcircle-frame'),
            'default' => '#ff5b5b',
        );
        $candidate_settings_fields[] = array(
            'id' => 'skill_med_set_color',
            'type' => 'color',
            'transparent' => false,
            'title' => __('Basic Profile Color', 'jobcircle-frame'),
            'subtitle' => '',
            'desc' => __("Set color for Basic Profile. Profile Score percentage from 26% to 50%.", 'jobcircle-frame'),
            'default' => '#ffbb00',
        );
        $candidate_settings_fields[] = array(
            'id' => 'skill_high_set_color',
            'type' => 'color',
            'transparent' => false,
            'title' => __('Professional Profile Color', 'jobcircle-frame'),
            'subtitle' => '',
            'desc' => __("Set color for Professional Profile. Profile Score percentage from 51% to 75%.", 'jobcircle-frame'),
            'default' => '#13b5ea',
        );
        $candidate_settings_fields[] = array(
            'id' => 'skill_ahigh_set_color',
            'type' => 'color',
            'transparent' => false,
            'title' => __('Complete Profile Color', 'jobcircle-frame'),
            'subtitle' => '',
            'desc' => __("Set color for Complete Profile. Profile Score percentage from 76% to 100%.", 'jobcircle-frame'),
            'default' => '#40d184',
        );
        $candidate_settings_fields = apply_filters('jobcircle_candidate_profile_score_setting_fields', $candidate_settings_fields);
        $candidate_settings = array(
            'title' => __('Candidates', 'jobcircle-frame'),
            'id' => 'candidates-setting',
            'desc' => __('Candidates Settings.', 'jobcircle-frame'),
            'icon' => 'el el-adult',
            'fields' => $candidate_settings_fields
        );
        $setting_sections[] = $candidate_settings;

        $job_page_setting = array(
            'title' => __('Jobs', 'jobcircle-frame'),
            'id' => 'job-page-setting',
            'desc' => __('Job Page Settings.', 'jobcircle-frame'),
            'icon' => 'el el-cogs',
            'fields' => array(
                array(
                    'id' => 'post_new_job_page',
                    'type' => 'select',
                    'title' => __('Post New Job', 'jobcircle-frame'),
                    'subtitle' => __('Select the User post New Job Page.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => $all_page,
                    'default' => '',
                ),
                array(
                    'id' => 'job_select_page',
                    'type' => 'select',
                    'title' => __('Job Select Page', 'jobcircle-frame'),
                    'subtitle' => __('Select the Job Search Page.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => $all_page,
                    'default' => '',
                ),
                array(
                    'id' => 'free_job_post',
                    'type' => 'button_set',
                    'title' => __('Free Job Posting', 'jobcircle-frame'),
                    'desc' => '',
                    'subtitle' => __('This will allow user to post job without package.', 'jobcircle-frame'),
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'job_select_detail_view',
                    'type' => 'select',
                    'title' => __('Job Detail Style', 'jobcircle-frame'),
                    'subtitle' => __('Select default Job Detail Page Style.', 'jobcircle-frame'),
                    'desc' => '',
                    'options' => array(
                        'style1' => __('Style 1', 'jobcircle-frame'),
                        'style2' => __('Style 2', 'jobcircle-frame'),
                        'style3' => __('Style 3', 'jobcircle-frame'),
                        'style4' => __('Style 4', 'jobcircle-frame'),
                    ),
                    'default' => 'style1',
                ),
                array(
                    'id' => 'social_apply_platforms',
                    'type' => 'button_set',
                    'multi' => true,
                    'title' => __('Job Apply social platforms', 'jobcircle-frame'),
                    'desc' => '',
                    'subtitle' => __('Select multiple platforms to apply job with.', 'jobcircle-frame'),
                    'options' => array(
                        'facebook' => __('Facebook', 'jobcircle-frame'),
                        'google' => __('Google', 'jobcircle-frame'),
                        'linkedin' => __('Linkedin', 'jobcircle-frame'),
                    ),
                    'default' => array('facebook', 'google', 'linkedin'),
                ),
                array(
                    'id' => 'job_attachments',
                    'type' => 'button_set',
                    'title' => __('Job Attachments', 'jobcircle-frame'),
                    'desc' => '',
                    'subtitle' => __('Job file attachments option while job posting.', 'jobcircle-frame'),
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'job_video',
                    'type' => 'button_set',
                    'title' => __('Job Video', 'jobcircle-frame'),
                    'desc' => '',
                    'subtitle' => __('Job video attach option while job posting/updating.', 'jobcircle-frame'),
                    'options' => array(
                        'on' => __('On', 'jobcircle-frame'),
                        'off' => __('Off', 'jobcircle-frame'),
                    ),
                    'default' => 'on',
                ),
            )
        );
        $setting_sections[] = $job_page_setting;

        $footer_sidebar_settings = array(
            'title' => __('Custom Js', 'jobcircle-frame'),
            'id' => 'custom-css-js',
            'desc' => __('Add Custom Js code.', 'jobcircle-frame'),
            'icon' => 'el el-edit',
            'fields' => array(
                array(
                    'id' => 'javascript_editor',
                    'type' => 'ace_editor',
                    'title' => __('Js Code', 'jobcircle-frame'),
                    'subtitle' => __('Paste your Js code here.', 'jobcircle-frame'),
                    'mode' => 'javascript',
                    'theme' => 'chrome',
                    'desc' => __('Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.', 'jobcircle-frame'),
                    'default' => "jQuery(document).ready(function(){\n\n});"
                ),
            )
        );
        $setting_sections[] = $footer_sidebar_settings;

        // API settings fields
        $api_fields_sec = array();
        $api_fields_sec[] = array(
            'id' => 'openai_api_key',
            'type' => 'text',
            'title' => __('OpenAI API Key', 'jobcircle-frame'),
            'subtitle' => __('Put Api Key here', 'jobcircle-frame'),
            'desc' => '',
            'default' => '',
        );
        $api_fields_sec[] = array(
            'id' => 'google-api-section',
            'type' => 'section',
            'title' => __('Google API settings.', 'jobcircle-frame'),
            'subtitle' => '',
            'indent' => true,
        );
        $api_fields_sec[] = array(
            'id' => 'google_api_keys',
            'type' => 'text',
            'title' => __('Google Api Key', 'jobcircle-frame'),
            'subtitle' => __('Put Api Key here to show on Any map', 'jobcircle-frame'),
            'desc' => '',
            'default' => '',
        );
        $api_fields_sec[] = array(
            'id' => 'jobcircle-google-client-id',
            'type' => 'text',
            'transparent' => false,
            'title' => __('Client ID', 'jobcircle-frame'),
            'subtitle' => __('Please enter the Client ID of your Google account.', 'jobcircle-frame'),
            'desc' => '',
            'default' => ''
        );

        $api_fields_sec[] = array(
            'id' => 'jobcircle-google-client-secret',
            'type' => 'text',
            'transparent' => false,
            'title' => __('Client secret', 'jobcircle-frame'),
            'subtitle' => __('Please enter the Client secret of your Google account.', 'jobcircle-frame'),
            'desc' => sprintf(__('Callback URL is: %s', 'jobcircle-frame'), home_url('/?jobcircle_social_action=google')),
            'default' => ''
        );
        $api_fields_sec[] = array(
            'id' => 'captcha_switch',
            'type' => 'button_set',
            'title' => __('Google Captcha', 'jobcircle-frame'),
            'subtitle' => __('Google Captcha Switch.', 'jobcircle-frame'),
            'desc' => '',
            'options' => array(
                'on' => __('On', 'jobcircle-frame'),
                'off' => __('Off', 'jobcircle-frame'),
            ),
            'default' => 'off',
        );
        $api_fields_sec[] = array(
            'id' => 'captcha_sitekey',
            'type' => 'text',
            'transparent' => false,
            'title' => __('Site Key', 'jobcircle-frame'),
            'desc' => '',
            'subtitle' => __('Put your site key for captcha. You can get this site key after registering your site on Google. Make sure while create new site in captcha select version v2.', 'jobcircle-frame'),
            'default' => ''
        );
        $api_fields_sec[] = array(
            'id' => 'captcha_secretkey',
            'type' => 'text',
            'transparent' => false,
            'title' => __('Secret Key', 'jobcircle-frame'),
            'desc' => '',
            'subtitle' => __('Put your site Secret key for captcha. You can get this Secret Key after registering your site on Google.', 'jobcircle-frame'),
            'default' => ''
        );
        $api_fields_sec[] = array(
            'id' => 'mapbox-api-section',
            'type' => 'section',
            'title' => __('MapBox settings.', 'jobcircle-frame'),
            'subtitle' => '',
            'indent' => true,
        );
        $api_fields_sec[] = array(
            'id' => 'mapbox_access_token',
            'type' => 'text',
            'transparent' => false,
            'title' => __('MapBox Access Token', 'jobcircle-frame'),
            'desc' => '',
            'subtitle' => __('Put MapBox Access Token here. Get your MapBox Access Token here <a href="https://www.mapbox.com/" target="_blank">www.mapbox.com/</a>', 'jobcircle-frame'),
            'default' => ''
        );

        $api_fields_sec[] = array(
            'id' => 'facebook-api-section',
            'type' => 'section',
            'title' => __('Facebook API settings section.', 'jobcircle-frame'),
            'subtitle' => sprintf(__('Callback URL is: %s', 'jobcircle-frame'), home_url('/?jobcircle_social_action=facebook')),
            'indent' => true,
        );

        $api_fields_sec[] = array(
            'id' => 'jobcircle-facebook-app-id',
            'type' => 'text',
            'transparent' => false,
            'title' => __('App ID', 'jobcircle-frame'),
            'subtitle' => __('Please enter App the ID of your Facebook account.', 'jobcircle-frame'),
            'desc' => '',
            'default' => ''
        );

        $api_fields_sec[] = array(
            'id' => 'jobcircle-facebook-app-secret',
            'type' => 'text',
            'transparent' => false,
            'title' => __('App Secret', 'jobcircle-frame'),
            'subtitle' => __('Please enter the App Secret of your Facebook account.', 'jobcircle-frame'),
            'desc' => '',
            'default' => ''
        );

        // Linkedin
        $api_fields_sec[] = array(
            'id' => 'linkedin-api-section',
            'type' => 'section',
            'title' => __('Linkedin API settings section.', 'jobcircle-frame'),
            'subtitle' => sprintf(__('Callback URL is: %s', 'jobcircle-frame'), home_url('/?jobcircle_social_action=linkedin')),
            'indent' => true,
        );
        $api_fields_sec[] = array(
            'id' => 'jobcircle_linkedin_app_id',
            'type' => 'text',
            'transparent' => false,
            'title' => __('Client ID', 'jobcircle-frame'),
            'subtitle' => __('Please enter the Client ID of your LinkedIn app.', 'jobcircle-frame'),
            'desc' => '',
            'default' => ''
        );
        $api_fields_sec[] = array(
            'id' => 'jobcircle_linkedin_secret',
            'type' => 'text',
            'transparent' => false,
            'title' => __('Client Secret', 'jobcircle-frame'),
            'subtitle' => __('Please enter the Client Secret of your LinkedIn app.', 'jobcircle-frame'),
            'desc' => '',
            'default' => ''
        );

        $footer_sidebar_settings = array(
            'title' => __('Api Keys', 'jobcircle-frame'),
            'id' => 'custom-css-js-keys',
            'desc' => __('Add Custom Js code.', 'jobcircle-frame'),
            'icon' => 'el el-cogs',
            'fields' =>  apply_filters('jobcircle_theme_options_api_fields_filter', $api_fields_sec)
        );
        $setting_sections[] = $footer_sidebar_settings;

        $jobcircle_reviews_fields = array();
        $jobcircle_reviews_fields[] = array(
            'id' => 'jobcircle-reviews-section',
            'type' => 'section',
            'title' => __('Candidate/Employer Reviews', 'jobcircle-frame'),
            'subtitle' => '',
            'indent' => true,
        );
        
        $jobcircle_reviews_fields[] = array(
            'id' => 'jobcricle_reviews_enable',
            'type' => 'button_set',
            'title' => __('Enable Reviews', 'jobcircle-frame'),
            'subtitle' => __('Enable Reviews for Candidate/Employers.', 'jobcircle-frame'),
            'desc' => '',
            'options' => array(
                'on' => __('On', 'jobcircle-frame'),
                'off' => __('Off', 'jobcircle-frame'),
            ),
            'default' => 'on',
        );
        $jobcircle_reviews_fields[] = array(
            'id' => 'jobcircle_review_title',
            'type' => 'text',
            'transparent' => false,
            'title' => __('Review Title', 'jobcircle-frame'),
            'subtitle' => '',
            'desc' => '',
            'default' => __('Reviews', 'jobcircle-frame')
        );
        $jobcircle_reviews_fields[] = array(
            'id' => 'jobcricle_guest_reviews_enable',
            'type' => 'button_set',
            'title' => __('Enable Guest Reviews', 'jobcircle-frame'),
            'subtitle' => __('Enable Guest Reviews for Candidate/Employers.', 'jobcircle-frame'),
            'desc' => '',
            'options' => array(
                'on' => __('On', 'jobcircle-frame'),
                'off' => __('Off', 'jobcircle-frame'),
            ),
            'default' => 'on',
        );
        $jobcircle_reviews_fields[] = array(
            'id' => 'jobcricle_reviews_approval',
            'type' => 'button_set',
            'title' => __('Reviews Approval', 'jobcircle-frame'),
            'subtitle' => __('Reviews for Candidate/Employers Approval.', 'jobcircle-frame'),
            'desc' => '',
            'options' => array(
                'auto_apporval' => __('Auto Approval', 'jobcircle-frame'),
                'admin_apporval' => __('Admin Approval', 'jobcircle-frame'),
            ),
            'default' => 'auto_apporval',
        );
       
        $jobcircle_reviews_fields[] = array(
            'id' => 'jobcircle_review_text_length',
            'type' => 'text',
            'transparent' => false,
            'title' => __('Review Text Length', 'jobcircle-frame'),
            'subtitle' => __('Max Review Text Length.', 'jobcircle-frame'),
            'desc' => '',
            'default' => 500
        );
        $jobcircle_reviews_settings = array(
            'title' => __('Reviews', 'jobcircle-frame'),
            'id' => 'jobcircle-reviews-settings',
            'desc' => __('Candidate/Employer Reviews', 'jobcircle-frame'),
            'icon' => 'el el-cogs',
            'fields' =>  apply_filters('jobcircle_theme_options_reviews_filter', $jobcircle_reviews_fields)
        );
        $setting_sections[] = $jobcircle_reviews_settings;

        $jobcircle_email_settings = array(
            'title' => __('Email settings', 'jobcircle-frame'),
            'id' => 'jobcircle-email-settings',
            'desc' => __('Email Default Settings', 'jobcircle-frame'),
            'icon' => 'el el-edit',
            'fields' => array(
                array(
                    'id'      => 'jobcircle_email_logo',
                    'type'    => 'media',
                    'compiler'=> 'true',
                    'url'     => true,
                    'title'   => esc_html__( 'Email logo', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Upload your email logo here.', 'jobcircle-frame' ),
                ),
                array(
                    'id'      => 'jobcircle_sender_name',
                    'type'    => 'text',
                    'title'   => esc_html__( 'Email sender name', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Add email sender name here like: John Doe. Default your site name will be used.', 'jobcircle-frame' ),
                    'default' => get_option('blogname'),
                ),
                array(
                    'id'      => 'jobcircle_sender_email',
                    'type'    => 'text',
                    'title'   => esc_html__( 'Email sender email', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Add email sender email here like: info@jobcircle.com. Default your site email will be used.', 'jobcircle-frame' ),
                    'default' => esc_html__( 'info@jobcircle.com', 'jobcircle-frame' ),
                ),
                array(
                    'id'      => 'jobcircle_email_copyrights',
                    'type'    => 'textarea',
                    'title'   => esc_html__( 'Footer copyright text', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Add copyright text for the emails in footer', 'jobcircle-frame' ),
                ),
                array(
                    'id'      => 'jobcircle_email_signature',
                    'type'    => 'textarea',
                    'title'   => esc_html__( 'Email sender signature ', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Add email sender signature here like: team jobcircle-frame.', 'jobcircle-frame' ),
                    'default' => esc_html__( 'Regards,', 'jobcircle-frame' ),
                ),
                array(
                    'id'      => 'jobcircle_email_footer_color',
                    'type'    => 'color',
                    'title'   => esc_html__( 'Email footer color ', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Set email footer background color here', 'jobcircle-frame' ),
                    'default' => '#353648',
                ),
                array(
                    'id'      => 'jobcircle_email_footer_color_text',
                    'type'    => 'color',
                    'title'   => esc_html__( 'Email footer color ', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Set email footer text color here', 'jobcircle-frame' ),
                    'default' => '#FFFFFF',
                ),
            )
        );
        $jobcircle_user_email_settings = array(
            'title' => __('User Email settings', 'jobcircle-frame'),
            'id' => 'jobcircle-user-email-settings',
            'desc' => __('User Email Settings', 'jobcircle-frame'),
            'icon' => 'el el-edit',
            'subsection'	=> true,
            'fields' => array(
                //User registeration auto approval
                array(
                    'id'      => 'jobcircle_user_register_template',
                    'type'    => 'info',
                    'title'   => esc_html__( 'User Register Auto Approve', 'jobcircle-frame' ),
                    'style'   => 'info',
                ),
                array(
                    'id'      	=> 'jobcircle_user_register_subject',
                    'type'    	=> 'text',
                    'title'   	=> esc_html__( 'Subject', 'jobcircle-frame' ),
                    'desc'    	=> esc_html__( 'Please add subject for user registration.', 'jobcircle-frame' ),
                    'default' 	=> esc_html__( 'Thank you for registration at {sitename}','jobcircle-frame'),
                ),
                array(
                    'id'      => 'jobcircle_user_register_info',
                    'desc'    => wp_kses( 
                        __( '{name} — To display the user name.<br>
                            {email} — To display the email<br/>
                            {sitename} — To display the sitename<br/>', 'jobcircle-frame'
                        ),
                    array(
                        'a'	=> array(
                        'href'  => array(),
                        'title' => array()
                        ),
                        'br'      => array(),
                        'em'      => array(),
                        'strong'  => array(),
                    ) ),
                    'title'     => esc_html__( 'Email setting variables', 'jobcircle-frame' ),
                    'type'      => 'info',
                    'class'     => 'dc-center-content',
                    'icon'      => 'el el-info-circle',
                ),
                array(
                    'id'      	=> 'jobcircle_user_register_greeting',
                    'type'    	=> 'text',
                    'title'   	=> esc_html__( 'Greeting', 'jobcircle-frame' ),
                    'desc'    	=> esc_html__( 'Please add text for greeting.', 'jobcircle-frame' ),
                    'default' 	=> esc_html__( 'Hello {name},','jobcircle-frame' ),
              
                ),
                array(
                    'id'        => 'jobcircle_user_register_content',
                    'type'      => 'textarea',
                    'default'   => wp_kses( __( 'Thank you for the registration at "{sitename}".', 'jobcircle-frame'),
                    array(
                        'a'	=> array(
                        'href'  => array(),
                        'title' => array()
                        ),
                        'br'      => array(),
                        'em'      => array(),
                        'strong'  => array(),
                    )),
                    'title'     => esc_html__( 'Email contents', 'jobcircle-frame' ),
                ),
                // User Registeration Verify Email
                array(
                    'id'      => 'jobcircle_user_register_template',
                    'type'    => 'info',
                    'title'   => esc_html__( 'User Email Verification ', 'jobcircle-frame' ),
                    'style'   => 'info',
                ),
                array(
                    'id'      	=> 'jobcircle_user_register_email_verify_subject',
                    'type'    	=> 'text',
                    'title'   	=> esc_html__( 'Subject', 'jobcircle-frame' ),
                    'desc'    	=> esc_html__( 'Please add subject for user registration.', 'jobcircle-frame' ),
                    'default' 	=> esc_html__( 'Thank you for registration at {sitename}','jobcircle-frame'),
                ),
                array(
                    'id'      => 'jobcircle_user_register_email_verify_info',
                    'desc'    => wp_kses( 
                        __( '{name} — To display the user name.<br>
                            {email} — To display the email<br/>
                            {sitename} — To display the sitename<br/>
                            {verify_link} — To display the verification link<br/>', 'jobcircle-frame'
                        ),
                    array(
                        'a'	=> array(
                        'href'  => array(),
                        'title' => array()
                        ),
                        'br'      => array(),
                        'em'      => array(),
                        'strong'  => array(),
                    ) ),
                    'title'     => esc_html__( 'Email setting variables', 'jobcircle-frame' ),
                    'type'      => 'info',
                    'class'     => 'dc-center-content',
                    'icon'      => 'el el-info-circle',
                ),
                array(
                    'id'      	=> 'jobcircle_user_register_email_verify_greeting',
                    'type'    	=> 'text',
                    'title'   	=> esc_html__( 'Greeting', 'jobcircle-frame' ),
                    'desc'    	=> esc_html__( 'Please add text for greeting.', 'jobcircle-frame' ),
                    'default' 	=> esc_html__( 'Hello {name},','jobcircle-frame' ),
              
                ),
                array(
                    'id'        => 'jobcircle_user_register_email_verify_content',
                    'type'      => 'textarea',
                    'default'   => wp_kses( __( 'Thank you for the registration at "{sitename}". Please click below to verify your email<br/> {verify_link}', 'jobcircle-frame'),
                    array(
                        'a'	=> array(
                        'href'  => array(),
                        'title' => array()
                        ),
                        'br'      => array(),
                        'em'      => array(),
                        'strong'  => array(),
                    )),
                    'title'     => esc_html__( 'Email contents', 'jobcircle-frame' ),
                ),

                 //User account pending
                 array(
                    'id'      => 'jobcircle_user_account_pending_template',
                    'type'    => 'info',
                    'title'   =>  esc_html__( 'User Account Admin Approval', 'jobcircle-frame' ),
                    'style'   => 'info',
                ),
        
                array(
                    'id'      => 'jobcircle_user_account_pending_subject',
                    'type'    => 'text',
                    'title'   => esc_html__( 'Subject', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Please add email subject.', 'jobcircle-frame' ),
                    'default' => esc_html__( 'User Account Admin Approval.','jobcircle-frame'),
                ),
                array(
                'id'      => 'jobcircle_user_account_pending_information',
                'desc'    => wp_kses( __( '{name} — To display the user name.<br>
                                        {email} — To display the user email.<br>
                                        {sitename} — To display the sitename.<br>'
                    , 'jobcircle-frame' ),
                    array(
                    'a'       => array(
                        'href'  => array(),
                        'title' => array()
                    ),
                    'br'      => array(),
                    'em'      => array(),
                    'strong'  => array(),
                    ) ),
                'title'     => esc_html__( 'Email setting variables', 'jobcircle-frame' ),
                'type'      => 'info',
                'class'     => 'dc-center-content',
                'icon'      => 'el el-info-circle'
                ),
                array(
                'id'      => 'jobcircle_user_account_pending_greeting',
                'type'    => 'text',
                'title'   => esc_html__( 'Greeting', 'jobcircle-frame' ),
                'desc'    => esc_html__( 'Please add text.', 'jobcircle-frame' ),
                'default' => esc_html__( 'Hello {name},','jobcircle-frame'),
                ),
                array(
                'id'        => 'jobcircle_user_account_pending_content',
                'type'      => 'textarea',
                'default'   => wp_kses( __( 'Your account has been created and please wait administrator will approve your account. It may take time 24 hours.', 'jobcircle-frame'),
                    array(
                        'a'	=> array(
                        'href'  => array(),
                        'title' => array()
                        ),
                        'br'      => array(),
                        'em'      => array(),
                        'strong'  => array(),
                    )),
                'title'     => esc_html__( 'Email contents', 'jobcircle-frame' )
                ),
                

                // Password Reset
                array(
                    'id'      => 'jobcircle_password_reset_info',
                    'type'    => 'info',
                    'title'   =>  esc_html__( 'Password Reset', 'jobcircle-frame' ),
                    'style'   => 'info',
                  ),
                  array(
                    'id'      => 'jobcircle_password_reset_subject',
                    'type'    => 'text',
                    'title'   => esc_html__( 'Subject', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Please add email subject.', 'jobcircle-frame' ),
                    'default' => esc_html__( 'Password Reset Request','jobcircle-frame'),
                  ),
                  array(
                    'id'      => 'jobcircle_user_reset_password_information',
                    'desc'    => wp_kses( __( '{first_name} — To display the first name.<br>
                                            {name} — To display the last name.<br>
                                            {email} — To display the user email.<br>
                                            {sitename} — To display the sitename.<br>
                                            {reset_link} — To display the reset password url.<br>'
                      , 'jobcircle-frame' ),
                      array(
                        'a'       => array(
                          'href'  => array(),
                          'title' => array()
                        ),
                        'br'      => array(),
                        'em'      => array(),
                        'strong'  => array(),
                      ) ),
                    'title'     => esc_html__( 'Email setting variables', 'jobcircle-frame' ),
                    'type'      => 'info',
                    'class'     => 'dc-center-content',
                    'icon'      => 'el el-info-circle'
                  ),
                  array(
                    'id'      => 'jobcircle_reset_password_greeting',
                    'type'    => 'text',
                    'title'   => esc_html__( 'Greeting', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Please add text.', 'jobcircle-frame' ),
                    'default' => esc_html__( 'Hello {name},','jobcircle-frame'),
                  ),
                  array(
                    'id'        => 'jobcircle_reset_password_content',
                    'type'      => 'textarea',
                    'default'   => wp_kses( __( 'To reset your password, please visit the following link <br/><br/> <a href="{reset_link}" >Password Reset</a> <br/><br/>If you did not request a password reset, please ignore this email.', 'jobcircle-frame' ),
                      array(
                        'a'       => array(
                          'href'  => array(),
                          'title' => array()
                        ),
                        'br'      => array(),
                        'em'      => array(),
                        'strong'  => array(),
                      ) ),
                    'title'     => esc_html__( 'Email Contents', 'jobcircle-frame' ),
                  ),
            )
        );
        $jobcircle_candidate_email_settings = array(
            'title' => __('Canidate Email settings', 'jobcircle-frame'),
            'id' => 'jobcircle-candidate-email-settings',
            'desc' => __('Canidate Email Settings', 'jobcircle-frame'),
            'icon' => 'el el-edit',
            'subsection'	=> true,
            'fields' => array(
                // Applicant Message
                array(
                    'id'      => 'jobcircle_applicant_message_template',
                    'type'    => 'info',
                    'title'   => esc_html__( 'Employer Message to Applicant', 'jobcircle-frame' ),
                    'style'   => 'info',
                ),
                array(
                    'id'      	=> 'jobcircle_applicant_message_subject',
                    'type'    	=> 'text',
                    'title'   	=> esc_html__( 'Subject', 'jobcircle-frame' ),
                    'desc'    	=> esc_html__( 'Please add subject for applicant message.', 'jobcircle-frame' ),
                    'default' 	=> esc_html__('Employer Message - {sitename} for {job_title}', 'jobcircle-frame'),
                ),
                array(
                    'id'      => 'jobcircle_applicant_message_info',
                    'desc'    => wp_kses( 
                        __( '{name} — To display the candidate name.<br>
                            {first_name} — To display the candidate first name<br/>
                            {last_name} — To display the candidate last name<br/>
                            {employer_name} — To display the employer name<br/>
                            {job_title} — To display the job title<br/>
                            {applicant_message} — To display the message<br/>
                            {sitename} — To display the sitename<br/>', 'jobcircle-frame'
                        ),
                    array(
                        'a'	=> array(
                        'href'  => array(),
                        'title' => array()
                        ),
                        'br'      => array(),
                        'em'      => array(),
                        'strong'  => array(),
                    ) ),
                    'title'     => esc_html__( 'Email setting variables', 'jobcircle-frame' ),
                    'type'      => 'info',
                    'class'     => 'dc-center-content',
                    'icon'      => 'el el-info-circle',
                ),
                array(
                    'id'      	=> 'jobcircle_applicant_message_greeting',
                    'type'    	=> 'text',
                    'title'   	=> esc_html__( 'Greeting', 'jobcircle-frame' ),
                    'desc'    	=> esc_html__( 'Please add text for greeting.', 'jobcircle-frame' ),
                    'default' 	=> esc_html__( 'Hello {name},','jobcircle-frame' ),
              
                ),
                array(
                    'id'        => 'jobcircle_applicant_message_content',
                    'type'      => 'textarea',
                    'default'   => wp_kses(
                        __('{employer_name} send message for job {job_title}.<br> Here are the following details:<br> Name: {name}<br> message: {applicant_message}', 'jobcircle-frame'),
                        array(
                            'a' => array(
                                'href'  => array(),
                                'title' => array()
                            ),
                            'br'        => array(),
                            'em'        => array(),
                            'strong'    => array(),
                        )
                    ),
                    'title'     => esc_html__( 'Email contents', 'jobcircle-frame' ),
                ),
            )
        );
        $jobcircle_admin_email_settings = array(
            'title' => __('Admin Email settings', 'jobcircle-frame'),
            'id' => 'jobcircle-admin-email-settings',
            'desc' => __('Admin Email Settings', 'jobcircle-frame'),
            'icon' => 'el el-edit',
            'subsection'	=> true,
            'fields' => array(
                //User account approved
                array(
                    'id'      => 'jobcircle_user_account_approved_template',
                    'type'    => 'info',
                    'title'   =>  esc_html__( 'User Account Approved', 'jobcircle-frame' ),
                    'style'   => 'info',
                ),
        
                array(
                    'id'      => 'jobcircle_user_account_approved_subject',
                    'type'    => 'text',
                    'title'   => esc_html__( 'Subject', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Please add email subject.', 'jobcircle-frame' ),
                    'default' => esc_html__( 'Account approved.','jobcircle-frame'),
                ),
                array(
                'id'      => 'jobcircle_user_account_approved_information',
                'desc'    => wp_kses( __( '{name} — To display the user name.<br>
                                        {email} — To display the user email.<br>
                                        {sitename} — To display the sitename.<br>'
                    , 'jobcircle-frame' ),
                    array(
                    'a'       => array(
                        'href'  => array(),
                        'title' => array()
                    ),
                    'br'      => array(),
                    'em'      => array(),
                    'strong'  => array(),
                    ) ),
                'title'     => esc_html__( 'Email setting variables', 'jobcircle-frame' ),
                'type'      => 'info',
                'class'     => 'dc-center-content',
                'icon'      => 'el el-info-circle'
                ),
                array(
                'id'      => 'jobcircle_user_account_approved_greeting',
                'type'    => 'text',
                'title'   => esc_html__( 'Greeting', 'jobcircle-frame' ),
                'desc'    => esc_html__( 'Please add text.', 'jobcircle-frame' ),
                'default' => esc_html__( 'Hello {name},','jobcircle-frame'),
                ),
                array(
                'id'        => 'jobcircle_user_account_approved_content',
                'type'      => 'textarea',
                'default'   => wp_kses( __( 'Congratulations! Your account has been approved by the admin.', 'jobcircle-frame'),
                    array(
                        'a'	=> array(
                        'href'  => array(),
                        'title' => array()
                        ),
                        'br'      => array(),
                        'em'      => array(),
                        'strong'  => array(),
                    )),
                'title'     => esc_html__( 'Email contents', 'jobcircle-frame' )
                ),
                //User account rejected
                array(
                    'id'      => 'jobcircle_user_account_rejected_template',
                    'type'    => 'info',
                    'title'   =>  esc_html__( 'User Account Rejected', 'jobcircle-frame' ),
                    'style'   => 'info',
                ),
        
                array(
                    'id'      => 'jobcircle_user_account_rejected_subject',
                    'type'    => 'text',
                    'title'   => esc_html__( 'Subject', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Please add email subject.', 'jobcircle-frame' ),
                    'default' => esc_html__( 'Account rejected.','jobcircle-frame'),
                ),
                array(
                'id'      => 'jobcircle_user_account_rejected_information',
                'desc'    => wp_kses( __( '{name} — To display the user name.<br>
                                        {email} — To display the user email.<br>
                                        {sitename} — To display the sitename.<br>'
                    , 'jobcircle-frame' ),
                    array(
                    'a'       => array(
                        'href'  => array(),
                        'title' => array()
                    ),
                    'br'      => array(),
                    'em'      => array(),
                    'strong'  => array(),
                    ) ),
                'title'     => esc_html__( 'Email setting variables', 'jobcircle-frame' ),
                'type'      => 'info',
                'class'     => 'dc-center-content',
                'icon'      => 'el el-info-circle'
                ),
                array(
                'id'      => 'jobcircle_user_account_rejected_greeting',
                'type'    => 'text',
                'title'   => esc_html__( 'Greeting', 'jobcircle-frame' ),
                'desc'    => esc_html__( 'Please add text.', 'jobcircle-frame' ),
                'default' => esc_html__( 'Hello {name},','jobcircle-frame'),
                ),
                array(
                'id'        => 'jobcircle_user_account_rejected_content',
                'type'      => 'textarea',
                'default'   => wp_kses( __( 'Your account has been rejected by the admin.', 'jobcircle-frame'),
                    array(
                        'a'	=> array(
                        'href'  => array(),
                        'title' => array()
                        ),
                        'br'      => array(),
                        'em'      => array(),
                        'strong'  => array(),
                    )),
                'title'     => esc_html__( 'Email contents', 'jobcircle-frame' )
                ),
                // user account deletion
                array(
                    'id'      => 'jobcircle_admin_account_deletion_info',
                    'type'    => 'info',
                    'title'   =>  esc_html__( 'Account Deletion', 'jobcircle-frame' ),
                    'style'   => 'info',
                  ),
                  array(
                    'id'      => 'jobcircle_admin_account_deletion_subject',
                    'type'    => 'text',
                    'title'   => esc_html__( 'Subject', 'jobcircle-frame' ),
                    'desc'    => esc_html__( 'Please add email subject.', 'jobcircle-frame' ),
                    'default' => esc_html__( 'Account Deleted','jobcircle-frame'),
                  ),
                  array(
                    'id'      => 'jobcircle_admin_account_deletion_information',
                    'desc'    => wp_kses( __( '{first_name} — To display the first name.<br>
                                            {last_name} — To display the last name.<br>
                                            {name} — To display the full name.<br>
                                            {user_name} — To display the username.<br>
                                            {user_email} — To display the user email.<br>'
                      , 'jobcircle-frame' ),
                      array(
                        'a'       => array(
                          'href'  => array(),
                          'title' => array()
                        ),
                        'br'      => array(),
                        'em'      => array(),
                        'strong'  => array(),
                      ) ),
                    'title'     => esc_html__( 'Email setting variables', 'jobcircle-frame' ),
                    'type'      => 'info',
                    'class'     => 'dc-center-content',
                    'icon'      => 'el el-info-circle'
                  ),                 
                  array(
                    'id'        => 'jobcircle_admin_account_deletion_content',
                    'type'      => 'textarea',
                    'default'   => wp_kses( __( '{name} deleted his/her account.<br> Here are the following account details:<br> Name: {name}<br> Username: {user_name}<br> Email: {user_email}', 'jobcircle-frame' ),
                      array(
                        'a'       => array(
                          'href'  => array(),
                          'title' => array()
                        ),
                        'br'      => array(),
                        'em'      => array(),
                        'strong'  => array(),
                      ) ),
                    'title'     => esc_html__( 'Email Contents', 'jobcircle-frame' ),
                  ),
            )
        );
        $setting_sections[] = $jobcircle_email_settings;
        $setting_sections[] = $jobcircle_user_email_settings;
        $setting_sections[] = $jobcircle_candidate_email_settings;
        $setting_sections[] = $jobcircle_admin_email_settings;
		$setting_sections   = apply_filters('jobcircle_theme_options_settings_filter', $setting_sections);
        return $setting_sections;
    }
}
