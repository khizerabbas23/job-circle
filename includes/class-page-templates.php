<?php

/**
 * Page templates class
 * 
 * @return object
 */
class Jobcircle_Page_Templates {

    public function __construct() {

        $this->templates = array();

        add_filter('theme_page_templates', array($this, 'custom_page_templates_callback'), 1, 1);
        add_filter('template_include', array($this, 'user_dashboard_page_templates'));
        add_action('init', array($this, 'all_templates_list_callback'), 3, 0);
    }

    public function all_templates_list_callback() {
        $all_templates = array(
            'user-login-template.php' => __('User Login', 'jobcircle-frame'),
            'user-dashboard-template.php' => __('User Dashboard', 'jobcircle-frame'),
            'post-new-job-seperate.php' => __('Post New Job Regular', 'jobcircle-frame'),
        );
        $this->templates = apply_filters('jobcircle_templates_list_set', $all_templates);
    }

    public function custom_page_templates_callback($post_templates) {
        $post_templates = array_merge($this->templates, $post_templates);
        return $post_templates;
    }

    public function user_dashboard_page_templates($template) {
        global $post;
        if (!isset($post)) {
            return $template;
        }
        if (!isset($this->templates[get_post_meta($post->ID, '_wp_page_template', true)])) {
            return $template;
        }
        if ('user-login-template.php' === get_post_meta($post->ID, '_wp_page_template', true)) {

            $file = JOBCIRCLE_ABSPATH . 'templates/' . get_post_meta($post->ID, '_wp_page_template', true);
            if (file_exists($file)) {
                return $file;
            }
        }
        if ('user-dashboard-template.php' === get_post_meta($post->ID, '_wp_page_template', true)) {

            $file = JOBCIRCLE_ABSPATH . 'templates/' . get_post_meta($post->ID, '_wp_page_template', true);
            if (file_exists($file)) {
                return $file;
            }
        }
        if ('post-new-job-seperate.php' === get_post_meta($post->ID, '_wp_page_template', true)) {

            $file = JOBCIRCLE_ABSPATH . 'templates/' . get_post_meta($post->ID, '_wp_page_template', true);
            if (file_exists($file)) {
                return $file;
            }
        }
        return apply_filters('jobcircle_template_page_file', $template);
    }

}

$Jobcircle_page_templates = new Jobcircle_Page_Templates();
