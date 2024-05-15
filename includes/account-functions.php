<?php

add_filter('jobcircle_header_mobile_right_btns_html', function($html) {
    global $jobcircle_framework_options;

    $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';

    $account_page_id = jobcircle_get_page_id_from_name($account_page_name);

    if ($account_page_id > 0 && is_page()) {
        global $post;
        if ($post->ID == $account_page_id) {
            ob_start();
            ?>
            <li>
                <a href="<?php echo jobcircle_account_logout_url() ?>" class="crs_yuo12 w-auto text-dark gray">
                    <span class="embos_45"><i class="lni lni-power-switch me-1 me-1"></i>Logout</span>
                </a>
            </li>
            <?php
            $html = ob_get_clean();
        }
    }
    return $html;
});

add_filter('jobcircle_header_right_btns_html', function($html) {
    global $jobcircle_framework_options;

    $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';

    $account_page_id = jobcircle_get_page_id_from_name($account_page_name);

    if ($account_page_id > 0 && is_page()) {
        global $post;
        if ($post->ID == $account_page_id) {
            ob_start();
            ?>
            <li class="add-listing">
                <a href="<?php echo jobcircle_account_logout_url() ?>">
                    <i class="lni lni-power-switch me-1"></i> Logout
                </a>
            </li>
            <?php
            $html = ob_get_clean();
        }
    }
    return $html;
});

add_filter('jobcircle_theme_main_enqueue_assets', function($bool) {
    global $jobcircle_framework_options;
    $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';

    $account_page_id = jobcircle_get_page_id_from_name($account_page_name);

    if ($account_page_id > 0 && is_page()) {
        global $post;
        if ($post->ID == $account_page_id) {
            $bool = false;
        }
    }
    return $bool;
});

add_action('wp_enqueue_scripts', 'jobcircle_dashboard_enqueue_scripts', 55);

function jobcircle_dashboard_enqueue_scripts() {
    global $jobcircle_framework_options;
    $jobcircle_google_api_keys = isset($jobcircle_framework_options['google_api_keys']) ? $jobcircle_framework_options['google_api_keys'] : '';
    if (function_exists('vc_icon_element_fonts_enqueue')) {
        vc_icon_element_fonts_enqueue('fontawesome');
    } else {
        wp_enqueue_style('jobcircle-font-all-min', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css', array(), JOBCIRCLE_PLUGIN_VERSION);
    }
    wp_register_style('jobcircle-bootstrap', Jobcircle_Plugin::root_url() . 'css/bootstrap.css', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_register_style('jobcircle-bootstrap-modal', Jobcircle_Plugin::root_url() . 'css/bootstrap-modal.css', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_register_style('jobcircle-datetimepicker', Jobcircle_Plugin::root_url() . 'css/jquery.datetimepicker.css', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_register_style('jobcircle-dashboard-gfont', 'https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_register_style('jobcircle-dashboard-bootstrap', Jobcircle_Plugin::root_url() . 'css/dashboard/vendor-assets/bootstrap.css', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_register_style('jobcircle-bootstrap-modal', Jobcircle_Plugin::root_url() . 'css/bootstrap-modal.css', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_register_style('jobcircle-dashboard-fontawesome', Jobcircle_Plugin::root_url() . 'css/dashboard/vendor-assets/fontawesome.css', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_register_style('jobcircle-dashboard-flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_register_style('jobcircle-dashboard-mainstyle', Jobcircle_Plugin::root_url() . 'css/dashboard/main.css', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_register_style('jobcircle-dashboard-custom', Jobcircle_Plugin::root_url() . 'css/customs.css', array(), JOBCIRCLE_PLUGIN_VERSION);
    wp_register_style('jobcircle-dashboard-common', Jobcircle_Plugin::root_url() . 'css/dashboard/dashboard.css', array(), JOBCIRCLE_PLUGIN_VERSION);
    
    //js files
    wp_register_script('jobcircle-bootstrap.min', Jobcircle_Plugin::root_url() . 'js/bootstrap.min.js', array('jquery'), JOBCIRCLE_PLUGIN_VERSION, true);
    wp_register_script('jobcircle-datetimepicker-full', Jobcircle_Plugin::root_url() . 'js/jquery.datetimepicker.full.min.js', array('jquery'), JOBCIRCLE_PLUGIN_VERSION, true);
    wp_register_script('jobcircle-dashboard-jqueryui', Jobcircle_Plugin::root_url() . 'js/dashboard/jquery-ui.js', array('jquery'), JOBCIRCLE_PLUGIN_VERSION, true);
    wp_register_script('jobcircle-dashboard-mainscript', Jobcircle_Plugin::root_url() . 'js/dashboard/main.js', array('jquery'), JOBCIRCLE_PLUGIN_VERSION, true);

    $max_attachvideo_size = '20480';
    $video_files_types = array(
        'video/mp4', //.mp4
        'video/x-m4v', //.m4v
        'video/quicktime', //.mov
        'video/x-ms-asf, video/x-ms-wmv', //.wmv
        'application/x-troff-msvideo, video/avi, video/msvideo, video/x-msvideo', //.avi
    );
    $video_files_types_str = implode('|', $video_files_types);

    $max_attachment_size = '5120';
    $job_attachment_types = array(
        'image/jpeg',
        'image/jpg',
        'image/png',
        'text/plain',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/pdf',
    );
    $job_attachment_types_str = implode('|', $job_attachment_types);

    $max_number_of_attachments = 10;

    $jobcircle_nonce    = wp_create_nonce( 'jobcircle-form-nonce' );

    //JOBCIRCLE_PLUGIN_VERSION
    wp_register_script('jobcircle-job-map-api', 'https://maps.googleapis.com/maps/api/js?key='.$jobcircle_google_api_keys.'&libraries=places', array(), JOBCIRCLE_PLUGIN_VERSION, true);
    wp_register_script('jobcircle-location', Jobcircle_Plugin::root_url() . 'js/dashboard/location.js', array(), '1.0.0.2', true); 
    $js_arr = array(
        'ajax_url' => admin_url('admin-ajax.php'),
    );
    wp_localize_script('jobcircle-location', 'jobcircle_location_vars', $js_arr);

    wp_register_script('jobcircle-dashboard-common', Jobcircle_Plugin::root_url() . 'js/dashboard/dashboard.js', array(), '1.0.0.35', true);
    $js_arr = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'submiting' => esc_html__('Submitting...', 'jobcircle-frame'),
        'file_type_error' => esc_html__('This file format is not allowed.', 'jobcircle-frame'),
        'account_delete_confirm' => esc_html__('You account will be deleted permanently. Are you sure you want to delete your account?', 'jobcircle-frame'),
        'account_switch_confirm' => esc_html__('Are you sure you want to switch account?', 'jobcircle-frame'),
        'account_verfied' => esc_html__('Your account is not verified yet', 'jobcircle-frame'),
        'file_size_error' => sprintf(esc_html__('Your file is too large in size. Max size allowed is %s kb', 'jobcircle-frame'), $max_attachment_size),
        'job_files_mime_types' => $job_attachment_types_str,
        'job_files_max_size' => $max_attachment_size,
        'job_num_files_allow' => $max_number_of_attachments,
        'job_video_mime_types' => $video_files_types_str,
        'job_video_max_size' => $max_attachvideo_size,
        'jobcircle_nonce' => $jobcircle_nonce,
        'videofile_size_error' => sprintf(esc_html__('Your file is too large in size. Max size allowed is %s kb', 'jobcircle-frame'), $max_attachvideo_size),
    );
    wp_localize_script('jobcircle-dashboard-common', 'jobcircle_dashb_vars', $js_arr);

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

    wp_register_script('jobcircle-custom-scripts', Jobcircle_Plugin::root_url() . 'js/custom.js', array(), JOBCIRCLE_PLUGIN_VERSION, true);
    $js_arr = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'submiting' => esc_html__('Submitting...', 'jobcircle-frame'),
        'loggedin_saved' => esc_html__('Only logged-in user can save this.', 'jobcircle-frame'), 
        'candidate_job_saved' => esc_html__('Only a candidate member can save this.', 'jobcircle-frame'), 
        'account_verfied' => esc_html__('Your account is not verified yet', 'jobcircle-frame'),
        'terms_cond_checked' => esc_html__('Please check terms and conditions before register', 'jobcircle-frame'),
        'alredy_saved' => esc_html__('You have already saved this job.', 'jobcircle-frame'),
        'resume_types_msg' => sprintf(esc_html__('Suitable files are %s.', 'jobcircle-frame'), $sutable_files_str),
        'resume_file_types' => stripslashes($cand_files_types_json),
        'cvfile_size_allow' => $cvfile_size,
        'jobcircle_nonce' => $jobcircle_nonce,
        'cvfile_size_err' => sprintf(esc_html__('File size should not greater than %s.', 'jobcircle-frame'), $cvfile_size_str),
    );
    wp_localize_script('jobcircle-custom-scripts', 'jobcircle_cscript_vars', $js_arr);
}

add_action('jobcircle_theme_header_html', function($html) {
    global $jobcircle_framework_options;

    $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';

    $account_page_id = jobcircle_get_page_id_from_name($account_page_name);

    if ($account_page_id > 0 && is_page($account_page_id)) {
        global $post;
        if ($post->ID == $account_page_id) {
            ob_start();
            ?>
            <div class="mobile-search">
                <form action="<?php echo home_url('/') ?>" class="search-form" method="get">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input class="form-control me-sm-2 box-shadow-none" type="search" name="s" placeholder="<?php esc_attr_e('Search...', 'jobcircle-frame');?>" aria-label="<?php esc_attr_e('Search', 'jobcircle-frame');?>">
                </form>
            </div>
            <div class="mobile-author-actions"></div>
            <?php
            if (empty($jobcircle_theme_options)) {
                $logo_default_val = Jobcircle_Plugin::root_url() . '/images/logo.png';
            }
            $jobcircle_logo = isset($jobcircle_framework_options['jobcircle-sites-logo']['url']) && $jobcircle_framework_options['jobcircle-sites-logo']['url'] != '' ? $jobcircle_framework_options['jobcircle-sites-logo']['url'] : $logo_default_val;
            if (isset($jobcircle_framework_options['dashboard_page_logo']['url']) && $jobcircle_framework_options['dashboard_page_logo']['url'] != '') {
                $jobcircle_logo = $jobcircle_framework_options['dashboard_page_logo']['url'];
            }
            ?>
            <header class="header-top">
                <nav class="navbar navbar-light">
                    <div class="navbar-left">
                        <div class="logo-area">
                            <a class="navbar-brand" href="<?php echo home_url('/') ?>">
                                <img src="<?php echo ($jobcircle_logo) ?>" alt="<?php bloginfo('name') ?>">
                            </a>
                            <a href="#" class="sidebar-toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#525768" d="M5,8H19a1,1,0,0,0,0-2H5A1,1,0,0,0,5,8Zm16,3H3a1,1,0,0,0,0,2H21a1,1,0,0,0,0-2Zm-2,5H5a1,1,0,0,0,0,2H19a1,1,0,0,0,0-2Z"/></svg>
                            </a>
                        </div>
                    </div>
                    <!-- ends: navbar-left -->
                    <div class="navbar-right">
                        <div class="navbar-right__mobileAction d-md-none">
                            <a href="#" class="btn-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </a>
                            <a href="#" class="btn-author-action">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg feather more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            </a>
                        </div>
                        <div class="header-rightbtns-con">
                            <?php
                            echo apply_filters('jobcircle_dashboard_header_candprofile_score', '');
                            ?>
                            <a class="log-of" href="<?php echo jobcircle_account_logout_url() ?>"><i class="fas fa-power-off"></i> Log Out</a>
                        </div>
                    </div>
                    <!-- ends: .navbar-right -->
                </nav>
            </header>
            <?php
            $html = ob_get_clean();
        }
    }
    return $html;
});

add_action('wp', 'jobcircle_account_logout_call');

function jobcircle_account_logout_call() {
    if (isset($_GET['account_action']) && $_GET['account_action'] == 'logout' && isset($_GET['_nonce'])) {
        if (!wp_verify_nonce(sanitize_key(wp_unslash($_GET['_nonce'])), 'user-account-logout')) { // WPCS: input var ok, CSRF ok.
            //wp_die(esc_html__('Action failed. Please refresh the page and retry.', 'jobcircle-frame'));
        }
        global $jobcircle_framework_options;

        $login_page_name = isset($jobcircle_framework_options['user_login_page']) ? $jobcircle_framework_options['user_login_page'] : '';

        $login_page_id = jobcircle_get_page_id_from_name($login_page_name);
        
        $login_page_url = home_url('/');
        if ($login_page_id > 0) {
            $login_page_url = get_permalink($login_page_id);
        }
        //
        wp_destroy_current_session();
        wp_clear_auth_cookie();
        wp_set_current_user(0);
        
        wp_safe_redirect($login_page_url);
        exit();
    }
}

function jobcircle_account_logout_url() {
    $url = esc_url(wp_nonce_url(add_query_arg(array('account_action' => 'logout'), home_url('/')), 'user-account-logout', '_nonce'));
    return $url;
}

add_action('wp', function() {
    global $jobcircle_framework_options;

    //
    $login_page_name = isset($jobcircle_framework_options['user_login_page']) ? $jobcircle_framework_options['user_login_page'] : '';

    $login_page_id = jobcircle_get_page_id_from_name($login_page_name);
    //

    $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';

    $account_page_id = jobcircle_get_page_id_from_name($account_page_name);

    $account_page_url = home_url('/');
    if ($account_page_id > 0) {
        $account_page_url = get_permalink($account_page_id);
    }

    if (is_user_logged_in() && ($login_page_id > 0 && is_page($login_page_id))) {
        wp_safe_redirect($account_page_url);
        exit();
    }

    //
    $login_page_url = home_url('/');
    if ($login_page_id > 0) {
        $login_page_url = get_permalink($login_page_id);
    }
    if (!is_user_logged_in() && ($account_page_id > 0 && is_page($account_page_id))) {
        wp_safe_redirect($login_page_url);
        exit();
    }
});

function jobcircle_user_account_type($user_id) {
    $user_type = get_user_meta($user_id, 'user_account_post_type', true);
    
    return $user_type;
}

function jobcircle_general_account_menu_items() {
    $items = [
        'profile' => array(
            'icon' => 'fa fa-user-o',
            'title' => esc_html__('My Profile', 'jobcircle-frame'),
        ),
        'change_password' => array(
            'icon' => 'fa fa-unlock-alt',
            'title' => esc_html__('Change Password', 'jobcircle-frame'),
        ),
    ];
    
    return $items;
}

function jobcircle_get_attachment_id_from_url($attachment_url = '') {

    global $wpdb;
    $attachment_id = false;

    // If there is no url, return.
    if ('' == $attachment_url) {
        return;
    }

    // Get the upload directory paths
    $upload_dir_paths = wp_upload_dir();
    $base_url = $upload_dir_paths['baseurl'];

    // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
    if (false !== strpos($attachment_url, $base_url)) {

        // If this is the URL of an auto-generated thumbnail, get the URL of the original image
        $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);

        // Remove the upload path base directory from the attachment URL
        $attachment_url = str_replace($base_url . '/', '', $attachment_url);

        // Finally, run a custom database query to get the attachment ID from the modified attachment URL
        $perepare_query = $wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url);
        
        $attachment_id = $wpdb->get_var($perepare_query);
    }

    return $attachment_id;
}

function jobcircle_attachments_upload($Fieldname = 'file', $img_count = 0) {

    if (isset($_FILES[$Fieldname]) && $_FILES[$Fieldname] != '') {

        global $current_user;

        $user_id = $current_user->ID;

        $max_gal_imgs_allow = 10;
        $max_attachment_size = 5120;
        $job_attachment_types = array(
            'image/jpeg',
            'image/jpg',
            'image/png',
            'text/plain',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/pdf',
        );

        // Get the path to the upload directory.
        $wp_upload_dir = wp_upload_dir();

        $gall_ids = array();

        $multi_files = $_FILES[$Fieldname];
        if (isset($multi_files['name']) && is_array($multi_files['name'])) {
            $img_name_array = array();
            foreach ($multi_files['name'] as $multi_key => $multi_value) {
                if ($multi_files['name'][$multi_key]) {
                    $upload_file = array(
                        'name' => $multi_files['name'][$multi_key],
                        'type' => $multi_files['type'][$multi_key],
                        'tmp_name' => $multi_files['tmp_name'][$multi_key],
                        'error' => $multi_files['error'][$multi_key],
                        'size' => $multi_files['size'][$multi_key]
                    );

                    $test_uploaded_file = is_uploaded_file($upload_file['tmp_name']);

                    $file_size = isset($upload_file['size']) && $upload_file['size'] > 0 ? $upload_file['size'] : 1;
                    $size_as_kb = round($file_size / 1024);

                    if ($size_as_kb > $max_attachment_size) {
                        continue;
                    }

                    require_once ABSPATH . 'wp-admin/includes/image.php';
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    require_once ABSPATH . 'wp-admin/includes/media.php';

                    $allowed_image_types = array();
                    if (in_array('image/jpeg', $job_attachment_types)) {
                        $allowed_image_types['jpg|jpeg|jpe'] = 'image/jpeg';
                        $allowed_image_types['png'] = 'image/png';
                    }
                    if (in_array('image/png', $job_attachment_types)) {
                        $allowed_image_types['jpg|jpeg|jpe'] = 'image/jpeg';
                        $allowed_image_types['png'] = 'image/png';
                    }
                    if (in_array('text/plain', $job_attachment_types)) {
                        $allowed_image_types['txt|asc|c|cc|h'] = 'text/plain';
                    }
                    if (in_array('application/msword', $job_attachment_types)) {
                        $allowed_image_types['doc'] = 'application/msword';
                    }
                    if (in_array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', $job_attachment_types)) {
                        $allowed_image_types['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                    }
                    if (in_array('application/pdf', $job_attachment_types)) {
                        $allowed_image_types['pdf'] = 'application/pdf';
                    }
                    if (in_array('application/vnd.ms-excel', $job_attachment_types)) {
                        $allowed_image_types['xla|xls|xlt|xlw'] = 'application/vnd.ms-excel';
                    }
                    if (in_array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', $job_attachment_types)) {
                        $allowed_image_types['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                    }

                    $status_upload = wp_handle_upload($upload_file, array('test_form' => false, 'mimes' => $allowed_image_types));

                    if (empty($status_upload['error'])) {

                        $file_url = isset($status_upload['url']) ? $status_upload['url'] : '';

                        $upload_file_path = $wp_upload_dir['path'] . '/' . basename($file_url);

                        // Check the type of file. We'll use this as the 'post_mime_type'.
                        $filetype = wp_check_filetype(basename($file_url), null);

                        // Prepare an array of post data for the attachment.
                        $attachment = array(
                            'guid' => $wp_upload_dir['url'] . '/' . basename($upload_file_path),
                            'post_mime_type' => $filetype['type'],
                            'post_title' => preg_replace('/\.[^.]+$/', '', ($upload_file['name'])),
                            'post_content' => '',
                            'post_author' => $user_id,
                            'post_status' => 'inherit'
                        );

                        // Insert the attachment.
                        $attach_id = wp_insert_attachment($attachment, $upload_file_path);

                        // Generate the metadata for the attachment, and update the database record.
                        $attach_data = wp_generate_attachment_metadata($attach_id, $upload_file_path);
                        wp_update_attachment_metadata($attach_id, $attach_data);

                        $attach_url = wp_get_attachment_url($attach_id);
                        $gall_ids[] = $attach_url;

                        $img_count++;

                        if ($img_count >= $max_gal_imgs_allow) {
                            break;
                        }
                    }
                }
            }
        }

        return $gall_ids;
    }

    return false;
}

function jobcircle_video_upload($field_name = 'file') {

    if (isset($_FILES[$field_name]) && $_FILES[$field_name] != '') {

        global $current_user;

        $user_id = $current_user->ID;

        $max_attachment_size = 20480;
        $job_attachment_types = array(
            'video/mp4', //.mp4
            'video/x-m4v', //.m4v
            'video/quicktime', //.mov
            'video/x-ms-asf, video/x-ms-wmv', //.wmv
            'application/x-troff-msvideo, video/avi, video/msvideo, video/x-msvideo', //.avi
        );

        // Get the path to the upload directory.
        $wp_upload_dir = wp_upload_dir();

        $upload_file = $_FILES[$field_name];

        $file_size = isset($upload_file['size']) && $upload_file['size'] > 0 ? $upload_file['size'] : 1;
        $size_as_kb = round($file_size / 1024);

        if ($size_as_kb > $max_attachment_size) {
            return false;
        }

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $allowed_image_types = array();
        if (in_array('video/mp4', $job_attachment_types)) {
            $allowed_image_types['mp4'] = 'video/mp4';
        }
        if (in_array('video/x-m4v', $job_attachment_types)) {
            $allowed_image_types['m4v'] = 'video/x-m4v';
        }
        if (in_array('video/quicktime', $job_attachment_types)) {
            $allowed_image_types['mov'] = 'video/quicktime';
        }
        if (in_array('video/x-ms-asf, video/x-ms-wmv', $job_attachment_types)) {
            $allowed_image_types['wmv'] = 'video/x-ms-asf, video/x-ms-wmv';
        }
        if (in_array('application/x-troff-msvideo, video/avi, video/msvideo, video/x-msvideo', $job_attachment_types)) {
            $allowed_image_types['avi'] = 'application/x-troff-msvideo, video/avi, video/msvideo, video/x-msvideo';
        }

        $status_upload = wp_handle_upload($upload_file, array('test_form' => false, 'mimes' => $allowed_image_types));

        if (empty($status_upload['error'])) {

            $file_url = isset($status_upload['url']) ? $status_upload['url'] : '';

            $upload_file_path = $wp_upload_dir['path'] . '/' . basename($file_url);

            // Check the type of file. We'll use this as the 'post_mime_type'.
            $filetype = wp_check_filetype(basename($file_url), null);

            // Prepare an array of post data for the attachment.
            $attachment = array(
                'guid' => $wp_upload_dir['url'] . '/' . basename($upload_file_path),
                'post_mime_type' => $filetype['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', ($upload_file['name'])),
                'post_content' => '',
                'post_author' => $user_id,
                'post_status' => 'inherit'
            );

            // Insert the attachment.
            $attach_id = wp_insert_attachment($attachment, $upload_file_path);

            // Generate the metadata for the attachment, and update the database record.
            $attach_data = wp_generate_attachment_metadata($attach_id, $upload_file_path);
            wp_update_attachment_metadata($attach_id, $attach_data);

            $attach_url = wp_get_attachment_url($attach_id);

            return $attach_url;
        }
    }

    return false;
}
