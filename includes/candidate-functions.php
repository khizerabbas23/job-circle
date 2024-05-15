<?php

function jobcircle_user_candidate_id($user_id) {
    global $wpdb;
    
    if (jobcircle_user_account_type($user_id) != 'candidate') {
        return false;
    }
    
    $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
    $post_query .= " WHERE posts.post_type='candidates' AND posts.post_author={$user_id}";
    $post_query .= " AND (posts.post_status!='auto-draft' AND posts.post_status!='inherit' AND posts.post_status!='trash')";
    $post_query .= " ORDER BY posts.ID DESC LIMIT 1";
    $get_db_res = $wpdb->get_col($post_query);
    
    if (!empty($get_db_res) && isset($get_db_res[0])) {
        return $get_db_res[0];
    }
}

function jobcircle_candidate_user_id($candidate_id) {
    global $wpdb;
    
    $post_query = "SELECT posts.post_author FROM $wpdb->posts AS posts";
    $post_query .= " WHERE posts.post_type='candidates' AND posts.ID={$candidate_id}";
    $post_query .= " LIMIT 1";
    $get_db_res = $wpdb->get_col($post_query);
    
    if (!empty($get_db_res) && isset($get_db_res[0])) {
        return $get_db_res[0];
    }
}

function jobcircle_candidate_account_menu_items() {

    global $jobcircle_framework_options;

    $candidate_my_resume_option = 'enabled';
    $candidate_cv_manager_option = 'enabled';
    $candidate_applied_jobs_option = 'enabled';
    $candidate_bookmark_jobs_option = 'enabled';
    $candidate_job_alerts_option = 'enabled';
    $candidate_packages_option = 'enabled';
    $candidate_packages_option = 'enabled';
    $candidate_reviews_option = 'enabled';
    $jobcricle_reviews_enable = isset($jobcircle_framework_options['jobcricle_reviews_enable']) ? $jobcircle_framework_options['jobcricle_reviews_enable'] : '';
    
    if($jobcricle_reviews_enable !== 'on'){
        $candidate_reviews_option = 'disabled';
    }

    if(isset($jobcircle_framework_options['candidate_profile_package']) && ($jobcircle_framework_options['candidate_profile_package'] == "on")){

        $user_id = get_current_user_id();
        $candidate_id = jobcircle_user_candidate_id($user_id);  

        $candidate_my_resume_option = 'disabled';
        $candidate_cv_manager_option = 'disabled';
        $candidate_applied_jobs_option = 'disabled';
        $candidate_bookmark_jobs_option = 'disabled';
        $candidate_job_alerts_option = 'disabled';
        $candidate_packages_option = 'disabled'; 
        
        if(($candidate_id) && ($candidate_id > 0)){

            $candidate_purchased_packages = get_post_meta($candidate_id,'candidate_purchased_packages',true);

            if($candidate_purchased_packages){
                $explode_can_purchased_packages = explode(",",$candidate_purchased_packages);
                if($explode_can_purchased_packages){
                    foreach($explode_can_purchased_packages as $can_purchased_package){
                        $purchased_package_id = $can_purchased_package;

                        $candidate_my_resume_option = get_post_meta($purchased_package_id,'order_cand_my_resume',true);
                        $candidate_cv_manager_option = get_post_meta($purchased_package_id,'order_cand_cv_manager',true);
                        $candidate_applied_jobs_option = get_post_meta($purchased_package_id,'order_cand_applied_jobs',true);
                        $candidate_bookmark_jobs_option = get_post_meta($purchased_package_id,'order_cand_bookmark_jobs',true);
                        $candidate_job_alerts_option = get_post_meta($purchased_package_id,'order_cand_job_alerts',true);
                        $candidate_packages_option = get_post_meta($purchased_package_id,'order_cand_packages',true);

                        if(($candidate_my_resume_option === 1) || ($candidate_my_resume_option == "on")){
                            $candidate_my_resume_option = 'enabled';
                        }
                        if(($candidate_cv_manager_option === 1) || ($candidate_cv_manager_option == "on")){
                            $candidate_cv_manager_option = 'enabled';
                        }
                        if(($candidate_applied_jobs_option === 1) || ($candidate_applied_jobs_option == "on")){
                            $candidate_applied_jobs_option = 'enabled';
                        }
                        if(($candidate_bookmark_jobs_option === 1) || ($candidate_bookmark_jobs_option == "on")){
                            $candidate_bookmark_jobs_option = 'enabled';
                        }
                        if(($candidate_job_alerts_option === 1) || ($candidate_job_alerts_option == "on")){
                            $candidate_job_alerts_option = 'enabled';
                        }
                        if(($candidate_packages_option === 1) || ($candidate_packages_option == "on")){
                            $candidate_packages_option = 'enabled';
                        }                        
                    }
                }
            }
        }
    }  

    $items = [
        'dashboard' => array(
            'icon' => 'fa fa-window-restore',
            'title' => esc_html__('Dashboard', 'jobcircle-frame'),
            'status' => 'enabled'
        ),
        'my-resume' => array(
            'icon' => 'fa fa-address-card-o',
            'title' => esc_html__('My Resume', 'jobcircle-frame'),
            'status' => $candidate_my_resume_option
        ),            
        'resume-manager' => array(
            'icon' => 'fa fa-address-book-o',
            'title' => esc_html__('CV Manager', 'jobcircle-frame'),
            'status' => $candidate_cv_manager_option
        ),
        'applied-jobs' => array(
            'icon' => 'fa fa-pencil-square-o',
            'title' => esc_html__('Applied jobs', 'jobcircle-frame'),
            'status' => $candidate_applied_jobs_option
        ),
        'saved-jobs' => array(
            'icon' => 'fa fa-bookmark-o',
            'title' => esc_html__('Bookmark Jobs', 'jobcircle-frame'),
            'status' => $candidate_bookmark_jobs_option
        ),
        'job-alerts' => array(
            'icon' => 'fa fa-bell-o',
            'title' => esc_html__('Job Alerts', 'jobcircle-frame'),
            'status' => $candidate_job_alerts_option
        ),
        'reviews' => array(
            'icon' => 'fa fa-comments',
            'title' => esc_html__('Reviews', 'jobcircle-frame'),
            'status' => $candidate_reviews_option
        ),
        'packages' => array(
            'icon' => 'fa fa-list-ul',
            'title' => esc_html__('Packages', 'jobcircle-frame'),
            'status' => $candidate_packages_option
        ),
        'transactions' => array(
            'icon' => 'fa fa-money-bill-alt',
            'title' => esc_html__('Transactions', 'jobcircle-frame'),
            'status' => $candidate_packages_option
        ),
    ];
    
    return apply_filters('jobcircle_candidate_account_menu_items_list', $items);
}

function jobcircle_upload_candidate_cv($fieldname = 'file', $post_id = 0)
{

    global $jobcircle_framework_options, $jobcircle__upload_files_extpath;
    $jobcircle__upload_files_extpath = 'candidates-resume';

    if (isset($_FILES[$fieldname]) && $_FILES[$fieldname] != '') {
        add_filter('upload_dir', 'jobcircle__public_upload_files_path');

        // Get the path to the upload directory.
        $wp_upload_dir = wp_upload_dir();

        $orig_upload_file = $upload_file = $_FILES[$fieldname];

        //var_dump($upload_file);

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $allowed_file_types_list = [];
        if (empty($allowed_file_types_list)) {
            $allowed_file_types = array(
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'pdf' => 'application/pdf',
            );
        } else {
            $allowed_file_types = array();
            if (in_array('image/jpeg', $allowed_file_types_list)) {
                $allowed_file_types['jpg|jpeg|jpe'] = 'image/jpeg';
                $allowed_file_types['png'] = 'image/png';
            }
            if (in_array('image/png', $allowed_file_types_list)) {
                $allowed_file_types['jpg|jpeg|jpe'] = 'image/jpeg';
                $allowed_file_types['png'] = 'image/png';
            }
            if (in_array('text/plain', $allowed_file_types_list)) {
                $allowed_file_types['txt|asc|c|cc|h'] = 'text/plain';
            }
            if (in_array('application/msword', $allowed_file_types_list)) {
                $allowed_file_types['doc'] = 'application/msword';
            }
            if (in_array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', $allowed_file_types_list)) {
                $allowed_file_types['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            }
            if (in_array('application/pdf', $allowed_file_types_list)) {
                $allowed_file_types['pdf'] = 'application/pdf';
            }
            if (in_array('application/vnd.ms-excel', $allowed_file_types_list)) {
                $allowed_file_types['xla|xls|xlt|xlw'] = 'application/vnd.ms-excel';
            }
            if (in_array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', $allowed_file_types_list)) {
                $allowed_file_types['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            }
        }

        do_action('jobcircle_trigger_before_cv_file_upload', $orig_upload_file, $post_id);

        $file_name = $upload_file['name'];
        $file_mext_all = explode('.', $file_name);
        $file_extension = end($file_mext_all);

        //
        $candidate_username = 'cv';
        if (get_post_type($post_id) == 'candidates') {
            $candidate_user_id = jobcircle_candidate_user_id($post_id);
            $candidate_user_obj = get_user_by('ID', $candidate_user_id);
            $candidate_username = $candidate_user_obj->user_login . '_cv';
        }

        $file_ex_name = $candidate_username . '_' . rand(10000000, 99999999) . '.' . $file_extension;

        $file_ex_name = apply_filters('jobcircle_cand_cvupload_file_extlabel', $file_ex_name, $post_id);

        $upload_file['name'] = $file_ex_name;

        $status_upload = wp_handle_upload($upload_file, array('test_form' => false, 'mimes' => $allowed_file_types));

        if (empty($status_upload['error'])) {

            do_action('jobcircle_act_after_cand_cv_upload', $status_upload, $post_id, $wp_upload_dir);

            $file_url = isset($status_upload['url']) ? $status_upload['url'] : '';

            $upload_file_path = $wp_upload_dir['path'] . '/' . basename($file_url);

            // Check the type of file. We'll use this as the 'post_mime_type'.
            $filetype = wp_check_filetype(basename($file_url), null);

            $file_cred = array(
                'url' => $file_url,
                'path' => $upload_file_path,
                'mime' => $filetype,
            );

            return $file_cred;
        }

        remove_filter('upload_dir', 'jobcircle__public_upload_files_path');
    }

    return false;
}

add_action('wp_ajax_jobcircle_job_like_favourite_ajax', 'jobcircle_job_like_favourite_ajax');
add_action('wp_ajax_nopriv_jobcircle_job_like_favourite_ajax', 'jobcircle_job_like_favourite_ajax');
function jobcircle_job_like_favourite_ajax() {
    global $current_user;
    $user_id = $current_user->ID;
    $post_id = intval($_POST['post_id']);
    if(!empty($post_id) && !empty($user_id)){

        $fav_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
        $fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();
        if (!in_array($post_id, $fav_jobs)) {
            $fav_jobs[] = $post_id;
        }
        update_user_meta($user_id, 'fav_jobs_list', $fav_jobs);
        $data = array('status' => '1', 'msg' => esc_html__('Job saved successfully.', 'jobcircle-frame'));
        wp_send_json($data);
    }
    $data = array('status' => '2', 'msg' => esc_html__('Something went wrong. Please try again after page refresh.', 'jobcircle-frame'));
    wp_send_json($data);
    wp_die();
}

add_action('wp_ajax_jobcircle_remove_fav_job', 'jobcircle_remove_fav_job');
add_action('wp_ajax_nopriv_jobcircle_remove_fav_job', 'jobcircle_remove_fav_job');
function jobcircle_remove_fav_job() {
    if (isset($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        global $current_user;
        $user_id = $current_user->ID;
        
        // Remove the post from the user's favorite list
        $faver_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
        if (($key = array_search($post_id, $faver_jobs)) !== false) {
            unset($faver_jobs[$key]);
        }
        update_user_meta($user_id, 'fav_jobs_list', $faver_jobs);
        $data = array('status' => '1', 'msg' => esc_html__('Job removed form bookmarks.', 'jobcircle-frame'));
        wp_send_json($data);
    }
    $data = array('status' => '2', 'msg' => esc_html__('Something went wrong. Please try again after page refresh.', 'jobcircle-frame'));
    wp_send_json($data);
    wp_die();
}
add_action('wp_ajax_jobcircle_remove_fav_follower', 'jobcircle_remove_fav_follower');
add_action('wp_ajax_nopriv_jobcircle_remove_fav_follower', 'jobcircle_remove_fav_follower');
function jobcircle_remove_fav_follower() {
    if (isset($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        global $current_user;
        $user_id = $current_user->ID;
        
        // Remove the post from the user's favorite list
        $faver_jobs = get_user_meta($user_id, 'fav_follower_list', true);
        if (($key = array_search($post_id, $faver_jobs)) !== false) {
            unset($faver_jobs[$key]);
        }
        update_user_meta($user_id, 'fav_follower_list', $faver_jobs);
        $data = array('status' => '1', 'msg' => esc_html__('Job removed form bookmarks.', 'jobcircle-frame'));
        wp_send_json($data);
    }
    $data = array('status' => '2', 'msg' => esc_html__('Something went wrong. Please try again after page refresh.', 'jobcircle-frame'));
    wp_send_json($data);
    wp_die();
}



add_action('wp_ajax_jobcircle_candidate_like_favourite_ajax', 'jobcircle_candidate_like_favourite_ajax');
add_action('wp_ajax_nopriv_jobcircle_candidate_like_favourite_ajax', 'jobcircle_candidate_like_favourite_ajax');
function jobcircle_candidate_like_favourite_ajax() {
    global $current_user;
    $user_id = $current_user->ID;
    $post_id = $_POST['post_id'];

    $faver_jobs = get_user_meta($user_id, 'fav_candidate_list', true);
    $faver_jobs = !empty($faver_jobs) ? $faver_jobs : array();
    if (!in_array($post_id, $faver_jobs)) {
        $faver_jobs[] = $post_id;
    }
    update_user_meta($user_id, 'fav_candidate_list', $faver_jobs);

    $data = array(
        'status' => '1',
        'total_favorites' => count($faver_jobs)
    );

    wp_send_json($data);
    wp_die();
}



//candidate function removing jobs
add_action('wp_ajax_jobcircle_remove_from_favorites_ajax', 'jobcircle_remove_from_favorites_ajax');
add_action('wp_ajax_nopriv_jobcircle_remove_from_favorites_ajax', 'jobcircle_remove_from_favorites_ajax');
function jobcircle_remove_from_favorites_ajax() {
    global $current_user;
    $user_id = $current_user->ID;
    $post_id = intval($_POST['post_id']);

    if(!empty($post_id) && !empty($user_id)){    
        // Retrieve the current list of favorite post IDs
        $faver_jobs = get_user_meta($user_id, 'fav_candidate_list', true);
        $faver_jobs = !empty($faver_jobs) ? $faver_jobs : array();
        
        // Remove the post ID from the list
        $updated_faver_jobs = array_diff($faver_jobs, array($post_id));
        
        // Update the user meta with the updated list
        update_user_meta($user_id, 'fav_candidate_list', $updated_faver_jobs);
        
        $data = array('status' => '1', 'msg' => esc_html__('Job removed form bookmarks.', 'jobcircle-frame'));
        wp_send_json($data);
    }
    $data = array('status' => '2', 'msg' => esc_html__('Something went wrong. Please try again after page refresh.', 'jobcircle-frame'));
    wp_send_json($data);
    wp_die();
}




add_action('wp_ajax_jobcircle_filter_category_post_ajax', 'jobcircle_filter_category_post_ajax');

function jobcircle_filter_category_post_ajax() {
    // global $category;
$category = get_the_term();
// $categoryid = $category->ID;
$post = the_post($category->ID);

    update_user_meta($user_id, 'fav_category_list', $fav_jobs);

    $data = array('success' => '1');
    wp_send_json_success($data);
  wp_die();
}


add_filter('jobcircle_candidate_cv_download_url', function($candidate_id, $cvitm_key = '') {
    $cv_files = get_post_meta($candidate_id, 'candidate_cv_files', true);
    $file_url = '';
    if (!empty($cv_files)) {
        foreach ($cv_files as $cv_key => $cv_info) {
            if ($cvitm_key == $cv_key) {
                break;
            }
        }

        if (isset($cv_info['cred']['path'])) {
            $file_url = add_query_arg(array('candid' => $candidate_id, 'key' => $cv_key), home_url('/'));
        }
    }
    return $file_url;
}, 10, 2);

add_action('wp', function() {
    if (isset($_GET['candid']) && isset($_GET['key'])) {
        $candidate_id = $_GET['candid'];
        $cvitm_key = $_GET['key'];
        
        $cv_files = get_post_meta($candidate_id, 'candidate_cv_files', true);

       
    
        if (!empty($cv_files)) {
            foreach ($cv_files as $cv_key => $cv_info) {
                if ($cvitm_key == $cv_key) {
                    if (isset($cv_info['cred']['path'])) {
                        $file_path = $cv_info['cred']['path'];
                        $file_mimetype = isset($cv_info['cred']['mime']['type']) ? $cv_info['cred']['mime']['type'] : '';
                            
                        break;
                    }
                }
            }
    
            if (isset($file_path) && file_exists($file_path)) {
                header('Content-Description: File Transfer');
                header('Content-Type: ' . $file_mimetype);
                header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file_path));
                readfile($file_path);
                exit;
            }
        }
    }
});

function jobcircle_candidate_salary_str($candidate_id, $type = '', $unit_tag = '') {
    global $jobcircle_framework_options, $jobcircle_currencies_list;
    $jobcircle_default_curr = isset($jobcircle_framework_options['jobcircle_default_curr']) ? $jobcircle_framework_options['jobcircle_default_curr'] : '';

    $min_salary = get_post_meta($candidate_id, 'jobcircle_field_salary', true);
    $max_salary = get_post_meta($candidate_id, 'jobcircle_field_max_salary', true);
    $salary_unit = get_post_meta($candidate_id, 'jobcircle_field_salary_unit', true);

    $salry_units = jobcircle_salary_units_list();
    $salary_unit_str = isset($salry_units[$salary_unit]) ? $salry_units[$salary_unit] : esc_html__('Daily', 'jobcircle-frame');
    
    $min_salary = $min_salary != '' ? preg_replace("/[^0-9.]/", '', $min_salary) : 0;
    
    if (!empty($min_salary) && $min_salary > 0) {
        $currency_sign = '$';
        if (!empty($jobcircle_default_curr) && isset($jobcircle_currencies_list[$jobcircle_default_curr]['symbol'])) {
            $currency_sign = $jobcircle_currencies_list[$jobcircle_default_curr]['symbol'];
        }
        if ($type == 'k') {
            $min_salary = jobcircle_thousand_format($min_salary);
            $salary_str = $currency_sign . $min_salary;
        } else {
            $salary_str = $currency_sign . number_format($min_salary);
        }
        if (!empty($max_salary) && $max_salary > 0) {
            $max_salary = preg_replace("/[^0-9.]/", '', $max_salary);
            if ($type == 'k') {
                $max_salary = jobcircle_thousand_format($max_salary);
                $salary_str .= ' - ' . $currency_sign . $max_salary;
            } else {
                $salary_str .= ' - ' . $currency_sign . number_format($max_salary);
            }
        }
        $salary_str .= '/' . ($unit_tag != '' ? '<'. $unit_tag .'>' : '') . $salary_unit_str . ($unit_tag != '' ? '</'. $unit_tag .'>' : '');

        return $salary_str;
    }
}
    add_action('wp_ajax_jobcircle_email_form', 'jobcircle_email_form');
	add_action('wp_ajax_nopriv_jobcircle_email_form', 'jobcircle_email_form');
	function jobcircle_email_form()
	{
	    
	jobcircle_captcha_verify();
	}
				

