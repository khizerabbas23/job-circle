<?php

class JobCircle_Reviews{

	public function __construct()
    {
		$this->jobcircle_load_files();
		add_action('wp_enqueue_scripts', [$this, 'jobcircle_enqueue_scripts']);
	}

	public function jobcircle_load_files(){
        include_once JOBCIRCLE_ABSPATH . 'includes/reviews/jobcircle-reviews-hooks.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/reviews/jobcircle-reviews-widget.php';
    }

	public function jobcircle_enqueue_scripts(){
		global $jobcircle_framework_options;
		$jobcricle_reviews_enable = isset($jobcircle_framework_options['jobcricle_reviews_enable']) ? $jobcircle_framework_options['jobcricle_reviews_enable'] : '';
        if($jobcricle_reviews_enable == 'on'){
            wp_register_style('jobcircle-reviews', JOBCIRCLE_PLUGIN_URL . 'css/jobcircle-reviews-style.css', array(), JOBCIRCLE_PLUGIN_VERSION);
            wp_register_script('jobcircle-reviews', JOBCIRCLE_PLUGIN_URL . 'js/jobcircle-reviews-scripts.js', array('jquery'), JOBCIRCLE_PLUGIN_VERSION, true);
            wp_localize_script('jobcircle-reviews', 'jobcricle_reviews_obj', array(
                'siteURL' => home_url('/'),
                'ajax_loader' => defined('JOBCIRCLE_CHAT_ASSETS_URL') ? esc_url(JOBCIRCLE_CHAT_ASSETS_URL . 'images/icon-loader.png') : '',
                'root' => esc_url_raw( rest_url() ),
                'security' => wp_create_nonce('jobcircle-loadcomments-nonce'),
                'nonce' => wp_create_nonce( 'wp_rest' ),
                'ajaxUrl' => admin_url('admin-ajax.php'),
            ));
        }
	}
}
new JobCircle_Reviews();