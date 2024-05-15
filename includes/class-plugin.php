<?php

defined('ABSPATH') || exit;

class Jobcircle_Plugin {
    
    public $version = '1.0';
    
    public function __construct() {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    private function set_locale() {

        if (function_exists('determine_locale')) {
            $locale = determine_locale();
        } else {
            // @todo Remove when start supporting WP 5.0 or later.
            $locale = is_admin() ? get_user_locale() : get_locale();
        }
        $locale = apply_filters('plugin_locale', $locale, 'jobcircle-frame');
        unload_textdomain('jobcircle-frame');
        load_textdomain('jobcircle-frame', WP_LANG_DIR . '/plugins/jobcircle-frame-' . $locale . '.mo');
        load_plugin_textdomain('jobcircle-frame', false, dirname(dirname(plugin_basename(__FILE__))) . '/languages');
    }

    public function set_plugin_locale() {
        $this->set_locale();
    }
    
    private function define_const($name, $value) {
        if (!defined($name)) {
            define($name, $value);
        }
    }
    
    private function define_constants() {
        $this->define_const('JOBCIRCLE_ABSPATH', dirname(JOBCIRCLE_PLUGIN_FILE) . '/');
        $this->define_const('JOBCIRCLE_PLUGIN_VERSION', $this->version);
    }

    private function includes() {
        include_once JOBCIRCLE_ABSPATH . 'envato_setup/setup.php';
        include_once JOBCIRCLE_ABSPATH . 'envato_setup/setup-init.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/data-files/countries.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/data-files/states.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/data-files/currencies.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/common-functions.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/listing-functions.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/job-functions.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/theme-common.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/redux-framework/redux-ext/loader.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/redux-framework/class-redux-framework-plugin.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/redux-framework/framework-options/options-config.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/custom-menu/custom-menu-walker.php';

        //
        include_once JOBCIRCLE_ABSPATH . 'includes/classes/class-job-rss-feed.php';

        include_once JOBCIRCLE_ABSPATH . 'includes/email-notfications/init.php';

        // Page Templates
        include_once JOBCIRCLE_ABSPATH . 'includes/class-page-templates.php';

        // User Account/Dashboard Functions
        include_once JOBCIRCLE_ABSPATH . 'includes/account-functions.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/package-functions.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/candidate-functions.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/employer-functions.php';

        // User Dashboard File
        include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/account-profile.php';

        // taxonomy custom meta
        include_once JOBCIRCLE_ABSPATH . 'includes/custom-taxonomy-meta.php';

        // Mega Menu
        include_once JOBCIRCLE_ABSPATH . 'includes/menu-functions.php';

        //
        include_once JOBCIRCLE_ABSPATH . 'includes/user-custom-column.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/meta-boxes.php';
        
        include_once JOBCIRCLE_ABSPATH . 'includes/custom-post-type.php';

        //
        include_once JOBCIRCLE_ABSPATH . 'includes/class-vc-icons.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/vc-shortcodes.php';

        //
        include_once JOBCIRCLE_ABSPATH . 'includes/class-elementor.php';
        
        // custom fields
        include_once JOBCIRCLE_ABSPATH . 'includes/custom-fields/custom-fields.php';
        
        //Notifications
        include_once JOBCIRCLE_ABSPATH . 'includes/notifications/notifications.php';
        
        // social apps
        include_once JOBCIRCLE_ABSPATH . 'includes/social/social-apps.php';
        // Blog Section
        include_once JOBCIRCLE_ABSPATH . 'includes/blog-section/similar_jobs.php';
        
        // Widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/footer-contact.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/footer-gallery.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/jobcirce-section.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/search.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/category.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/widgets_posts.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/widgets_archive.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/widgets_tag.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/twitter_feeds.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/height-support.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/height-service.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/height-newslater.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/height-contact.php';
        // Home 2 Widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/htwo-service-menus.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/style_two_newsletter_widget.php';

        // Home 3 Widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hthree-company.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hthree-jobcircle.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hthree-support.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hthree-employer.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hthree-candidate.php';

        // Home 4 widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hfour-jobcircle-widget.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hfour-instagram-footer-widget.php';

        // Home 5 Widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hfive-information.php'; 
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hfive-join-newslater.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hfifth-menu-widget.php';
    
        // Home 6 Widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hsix-footer-widget.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/footer_need_help_hsix.php';

         // Home 9 Widgets
         include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hnine-footer-menu.php';
         include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hnine-footer-employer-widget.php';
         include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hnine-footer-info-widget.php';
         include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hnine-menu-links.php';

        // Home 10 Widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/htn-footer-instagram-widget.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hten-footer-jobcircle-widget.php';

        // Home 12 Widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/htwelve-keep-in-touch.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/htwelve-menu-links.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/htwelve-support-menu.php';

        // Home 13 Widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hthirteen-logo-widget.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hthirteen-icons-widgets.php';

        // Home 15 widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hfifteen-jobcircle-contact.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hfifteen-subscribe.php';
 
        // Home 60 Widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/htwelve-menu-links.php';

        // Home 16 Widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hsixteen-multi-menu.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hsixteen-jobcircle.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hsixteen-contact.php';

        // Home 17 Widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hseventeen-jobcircle-widget.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hseventeen-contact-widget.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hseventeen-menu-widgets.php';
      




        // Home 60 Widgets
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/hsixty-jobcircle-widget.php';
        //candidate-detail-page -sidebar-widget
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/candidate-sidebar-widget.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/candidate-sidebar-info.php';

        // Login Register
        include_once JOBCIRCLE_ABSPATH . 'includes/login-register/frontend.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/login-register/save-submit.php';
        
        // Job Alerts
        include_once JOBCIRCLE_ABSPATH . 'includes/job-alerts/job-alerts.php';
        //blog weights
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/blog_weights_post.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/blog_weights_category.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/blog_weigths_quick_link.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/blog_newslater.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/widgets/blog_meta.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/reviews/jobcircle-reviews.php';
        
        include_once JOBCIRCLE_ABSPATH . 'includes/team-members/team-member-actions.php';
        include_once JOBCIRCLE_ABSPATH . 'includes/dynamic-color.php';
    }
    
    private function init_hooks() {
        add_filter('template_include', array($this, 'single_template'));
        add_action('wp_enqueue_scripts', array($this, 'front_enqueues'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueues'));
    }
    
    public function front_enqueues() {
        global $jobcircle_framework_options;
        $google_api_keys = isset($jobcircle_framework_options['google_api_keys']) ? $jobcircle_framework_options['google_api_keys'] : '';
        
        if (!apply_filters('jobcircle_theme_main_enqueue_assets', true)) {
            return false;
        }
        
        if (function_exists('vc_icon_element_fonts_enqueue')) {
            vc_icon_element_fonts_enqueue('fontawesome');
        } else {
            wp_enqueue_style('jobcircle-font-all-min', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        }
        wp_enqueue_style('jobcircle-font-min', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        // wp_enqueue_style('jobcircle-all-min', self::root_url() . 'css/all.min.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        

        wp_enqueue_style('jobcircle-bootstrap', self::root_url() . 'css/bootstrap.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        wp_enqueue_style('jobcircle-vendors', self::root_url() . 'css/vendors.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        
        wp_enqueue_style('jobcircle-bootstrap-modal', self::root_url() . 'css/bootstrap-modal.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        wp_enqueue_style('jobcircle-select2.min', self::root_url() . 'css/select2.min.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        wp_enqueue_style('jobcircle-fancybox', self::root_url() . 'css/fancybox.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        wp_register_style('jobcircle-job-alert', self::root_url() . 'includes/job-alerts/css/job-alert.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        wp_enqueue_style('jobcircle-icons', self::root_url() . 'css/icons.css', array(), JOBCIRCLE_PLUGIN_VERSION); 
        wp_register_style('jobcircle-datetimepicker', self::root_url() . 'css/jquery.datetimepicker.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        wp_register_style('jobcircle-dashboard-main', self::root_url() . 'css/forms/main.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        wp_enqueue_style('jobcircle-customs', self::root_url() . 'css/customs.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        wp_enqueue_style('jobcircle-main-new', self::root_url() . 'css/main-new.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        /*wp_enqueue_style('jobcircle-theme-color', self::root_url() . 'css/theme-colors.css', array(), JOBCIRCLE_PLUGIN_VERSION);*/
        
        

        //js files
        wp_enqueue_script('jobcircle-vendor-main', self::root_url() . 'js/vendor-main.js', array('jquery'), JOBCIRCLE_PLUGIN_VERSION, true);
        // wp_enqueue_script('jobcircle-jquery.caro', self::root_url() . 'js/jquery.caro.js', array('jquery'), JOBCIRCLE_PLUGIN_VERSION, true);
        wp_enqueue_script('jobcircle_google_recaptcha', 'https://www.google.com/recaptcha/api.js?onload=jobcircle_multicap_all_functions&amp;render=explicit', array(), JOBCIRCLE_PLUGIN_VERSION, true);
        wp_enqueue_script('jobcircle-popper.min', self::root_url() . 'js/popper.min.js', array('jquery'), JOBCIRCLE_PLUGIN_VERSION, true);
        wp_enqueue_script('jobcircle-bootstrap.min', self::root_url() . 'js/bootstrap.min.js', array(), JOBCIRCLE_PLUGIN_VERSION, true);
        wp_enqueue_script('jobcircle-jquery-3.6.4.min', self::root_url() . 'js/jquery-3.6.4.min.js', array(), JOBCIRCLE_PLUGIN_VERSION, true);
        wp_enqueue_script('jobcircle-vendor', self::root_url() . 'js/vendor.js', array(), JOBCIRCLE_PLUGIN_VERSION, true);
        wp_enqueue_script('jobcircle-jquery.main', self::root_url() . 'js/jquery.main.js', array(), JOBCIRCLE_PLUGIN_VERSION, true);
        wp_enqueue_script('jobcircle-job-alert', self::root_url() . 'includes/job-alerts/js/job-alert.js', array(), JOBCIRCLE_PLUGIN_VERSION, true);
        wp_enqueue_script('jobcircle-job-map-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDGVKwYyakjeU8FQour1ZEwN8eEMWIj88k', array(), JOBCIRCLE_PLUGIN_VERSION, true);
        wp_register_script('jobcircle-location', Jobcircle_Plugin::root_url() . 'js/dashboard/location.js', array('jobcircle-job-map-api'), JOBCIRCLE_PLUGIN_VERSION, true);
        $js_arr = array(
            'ajax_url' => admin_url('admin-ajax.php'),
        );
        wp_localize_script('jobcircle-location', 'jobcircle_location_vars', $js_arr);
        $cand_files_types = array(
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/pdf',
        );
        $cand_files_types_json = json_encode($cand_files_types);
        $sutable_files_arr = array();
        $file_typs_comarr = array(
            'text/plain' => __('text', 'jobcircle-frame'),
            'image/jpeg' => __('jpeg', 'jobcircle-frame'),
            'image/png' => __('png', 'jobcircle-frame'),
            'application/msword' => __('doc', 'jobcircle-frame'),
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => __('docx', 'jobcircle-frame'),
            'application/vnd.ms-excel' => __('xls', 'jobcircle-frame'),
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => __('xlsx', 'jobcircle-frame'),
            'application/pdf' => __('pdf', 'jobcircle-frame'),
        );
        foreach ($file_typs_comarr as $file_typ_key => $file_typ_comar) {
            if (in_array($file_typ_key, $cand_files_types)) {
                $sutable_files_arr[] = '.' . $file_typ_comar;
            }
        }
        $sutable_files_str = implode(', ', $sutable_files_arr);

        $cvfile_size = '5120';
        $cvfile_size_str = '5MB';
        //
        wp_register_script('jobcircle-datetimepicker-full', self::root_url() . 'js/jquery.datetimepicker.full.min.js', array(), JOBCIRCLE_PLUGIN_VERSION, true);

        wp_enqueue_script('jobcircle-custom-scripts', self::root_url() . 'js/custom.js', array(), JOBCIRCLE_PLUGIN_VERSION, true);
        $js_arr = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'submiting' => esc_html__('Submitting...', 'jobcircle-frame'),
            'loggedin_saved' => esc_html__('Only logged-in user can save this.', 'jobcircle-frame'), 
            'candidate_job_saved' => esc_html__('Only a candidate member can save this.', 'jobcircle-frame'), 
            'alredy_saved' => esc_html__('You have already saved this job.', 'jobcircle-frame'), 
            'resume_types_msg' => sprintf(esc_html__('Suitable files are %s.', 'jobcircle-frame'), $sutable_files_str),
            'resume_file_types' => stripslashes($cand_files_types_json),
            'cvfile_size_allow' => $cvfile_size,
            'cvfile_size_err' => sprintf(esc_html__('File size should not greater than %s.', 'jobcircle-frame'), $cvfile_size_str),
        );
        wp_localize_script('jobcircle-custom-scripts', 'jobcircle_cscript_vars', $js_arr);

        wp_register_script('jobcircle-jobfunctions', Jobcircle_Plugin::root_url() . 'js/job-functions.js', array(), JOBCIRCLE_PLUGIN_VERSION, true);
        $js_arr = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'submiting' => esc_html__('Submitting...', 'jobcircle-frame'),
            'loggedin_saved' => esc_html__('Only logged-in user can save this.', 'jobcircle-frame'), 
            'candidate_job_saved' => esc_html__('Only a candidate member can save this.', 'jobcircle-frame'), 
            'alredy_saved' => esc_html__('You have already saved this job.', 'jobcircle-frame'), 
            'account_verfied' => esc_html__('Your account is not verified yet', 'jobcircle-frame'),
            'terms_cond_checked' => esc_html__('Please check terms and conditions before register', 'jobcircle-frame'),
        );
        wp_localize_script('jobcircle-jobfunctions', 'jobcircle_job_vars', $js_arr);
    }
    
    public function admin_enqueues() {
        global $jobcircle_framework_options;
        $jobcircle_google_api_keys = isset($jobcircle_framework_options['google_api_keys']) ? $jobcircle_framework_options['google_api_keys'] : '';
        wp_enqueue_style('jobcircle-icons', self::root_url() . 'css/icons.css', array(), JOBCIRCLE_PLUGIN_VERSION);

        wp_register_style('jobcircle-datetimepicker', self::root_url() . 'css/jquery.datetimepicker.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        wp_enqueue_style('fonticonpicker', self::root_url() . 'includes/icon-picker/font/jquery.fonticonpicker.min.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        wp_enqueue_style('fonticonpicker-bootstrap', self::root_url() . 'includes/icon-picker/theme/bootstrap-theme/jquery.fonticonpicker.bootstrap.css', array(), JOBCIRCLE_PLUGIN_VERSION);
        wp_enqueue_style('jobcircle-admin-styles', self::root_url() . 'css/admin/admin-styles.css', array(), JOBCIRCLE_PLUGIN_VERSION);

        wp_register_script('jobcircle-icons-loader', self::root_url() . 'includes/icon-picker/js/icons-load.js', array('jquery'), JOBCIRCLE_PLUGIN_VERSION, false);
        $icons_arr = array(
            'plugin_url' => self::root_url(),
            'version' => rand(10000, 99999)
        );
        wp_localize_script('jobcircle-icons-loader', 'jobcircle_icons_vars', $icons_arr);
        wp_enqueue_script('jobcircle-icons-loader');
        
        wp_register_script('jobcircle-datetimepicker-full', self::root_url() . 'js/jquery.datetimepicker.full.min.js', array(), JOBCIRCLE_PLUGIN_VERSION, true);

        wp_register_script('jobcircle-job-map-api', 'https://maps.googleapis.com/maps/api/js?key='.$jobcircle_google_api_keys.'&libraries=places', array(), JOBCIRCLE_PLUGIN_VERSION, true);
        wp_register_script('jobcircle-location', Jobcircle_Plugin::root_url() . 'js/dashboard/location.js', array(), JOBCIRCLE_PLUGIN_VERSION, true);  

        $js_arr = array(
            'ajax_url' => admin_url('admin-ajax.php'),
        );
        wp_localize_script('jobcircle-location', 'jobcircle_location_vars', $js_arr);
        wp_enqueue_script('jobcircle-admin', self::root_url() . 'js/admin/admin.js', array('jquery'), JOBCIRCLE_PLUGIN_VERSION, true);
        wp_localize_script( 'jobcircle-admin', 'jobcircle_admin_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'jobcircle_admin_nonce' => wp_create_nonce( 'jobcircle_ajax_nonce' ) ) );


        wp_enqueue_script('fonticonpicker', self::root_url() . 'includes/icon-picker/js/jquery.fonticonpicker.min.js', array('jobcircle-icons-loader'), JOBCIRCLE_PLUGIN_VERSION, true);
    }
    
    public static function root_url() {
        return trailingslashit(plugins_url('/', JOBCIRCLE_PLUGIN_FILE));
    }
    
    /*Function for detail pages*/
    public function single_template($single_template) 
    {
        global $post;
        if (is_single()) {

            if (get_post_type() == 'candidates') {
                $theme_template = locate_template(array('candidate-detail.php'));
                if (!empty($theme_template)) {
                    $single_template = $theme_template;
                } else {
                    $single_template = plugin_dir_path(__FILE__) . 'single-pages/candidate-detail.php';
                }
            }

            if (get_post_type() == 'jobs') {
                $theme_template = locate_template(array('job-detail.php'));
                if (!empty($theme_template)) {
                    $single_template = $theme_template;
                } else {
                    $single_template = plugin_dir_path(__FILE__) . 'single-pages/job-detail.php';
                }
            }

            if (get_post_type() == 'employer') {
                $theme_template = locate_template(array('employer-detail.php'));
                if (!empty($theme_template)) {
                    $single_template = $theme_template;
                } else {
                    $single_template = plugin_dir_path(__FILE__) . 'single-pages/employer-detail.php';
                }
            }
            
        }        
        return $single_template;
    }   
}
new Jobcircle_Plugin;