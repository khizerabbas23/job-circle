<?php

namespace JobcircleElementor;

class Plugin
{
    private static $_instance = null;

    public function __construct()
    {
        // Register widget scripts
        add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);
        // Register widgets
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function widget_scripts()
    {
        wp_enqueue_script('jobcircle-elementor', \Jobcircle_Plugin::root_url('js/elementor.js'), ['jquery'], JOBCIRCLE_PLUGIN_VERSION, true);
        $local_args = array(
            'ajax_url' => admin_url('admin-ajax.php'),
        );
        wp_localize_script('jobcircle-elementor', 'jobcircle_elementor_vars', $local_args);
    }

    private function include_widgets_files()
    {
        require_once(__DIR__ . '/elementor-widgets/section-heading.php');
        require_once(__DIR__ . '/elementor-widgets/counters.php');
    }

    public function register_widgets()
    {
        $this->include_widgets_files();
        
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\SectionHeading());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Counters());
        
    }
}

Plugin::instance();