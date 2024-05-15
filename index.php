<?php

/**
 * Plugin Name:       Jobcircle Framework
 * Plugin URI:        https://miraclesoftsolutions.com
 * Description:       Framework plugin for jobcircle theme.
 * Version:           1.0
 * Author:            Miraclesoftsolutions
 * Author URI:        https://miraclesoftsolutions.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jobcircle-frame
 * Domain Path:       /languages
 */

defined('ABSPATH') || exit;

if (!defined('JOBCIRCLE_PLUGIN_FILE')) {
    define('JOBCIRCLE_PLUGIN_FILE', __FILE__);
}

if (!defined('JOBCIRCLE_PLUGIN_URL')) {
    define('JOBCIRCLE_PLUGIN_URL', plugin_dir_url(__FILE__));
}

function JOBCIRCLE__activate_plugin() {
    require_once plugin_dir_path(__FILE__) . 'includes/classes/class-activator.php';
    $activate = new JOBCIRCLE_Plugin_Activator();
}

register_activation_hook(__FILE__, 'JOBCIRCLE__activate_plugin');

function jobcircle_framework_get_url($path = '') {
    return plugin_dir_url(__FILE__) . $path;
}

function jobcircle_framework_get_path($path = '') {
    return plugin_dir_path(__FILE__) . $path;
}

include_once dirname(JOBCIRCLE_PLUGIN_FILE) . '/includes/class-plugin.php';