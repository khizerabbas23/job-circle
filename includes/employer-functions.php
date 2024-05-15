<?php

function jobcircle_user_employer_id($user_id) {
    global $wpdb;
    
    if (jobcircle_user_account_type($user_id) != 'employer') {
        return false;
    }
    
    $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
    $post_query .= " WHERE posts.post_type='employer' AND posts.post_author={$user_id}";
    $post_query .= " AND (posts.post_status!='auto-draft' AND posts.post_status!='inherit' AND posts.post_status!='trash')";
    $post_query .= " ORDER BY posts.ID DESC LIMIT 1";
    $get_db_res = $wpdb->get_col($post_query);
    
    if (!empty($get_db_res) && isset($get_db_res[0])) {
        return $get_db_res[0];
    }
}

function jobcircle_employer_user_id($employer_id) {
    global $wpdb;
    
    $post_query = "SELECT posts.post_author FROM $wpdb->posts AS posts";
    $post_query .= " WHERE posts.post_type='employer' AND posts.ID={$employer_id}";
    $post_query .= " LIMIT 1";
    $get_db_res = $wpdb->get_col($post_query);
    
    if (!empty($get_db_res) && isset($get_db_res[0])) {
        return $get_db_res[0];
    }
}

function jobcircle_employer_account_menu_items() {
    global $jobcircle_framework_options;

    $employer_post_new_job = 'enabled';
    $employer_manage_jobs = 'enabled';
    $employer_manage_applicants = 'enabled';
    $employer_bookmark_resumes = 'enabled';
    $employer_packages = 'enabled';
    $candidate_reviews_option = 'enabled';
    $jobcricle_reviews_enable = isset($jobcircle_framework_options['jobcricle_reviews_enable']) ? $jobcircle_framework_options['jobcricle_reviews_enable'] : '';
    
    if($jobcricle_reviews_enable !== 'on'){
        $candidate_reviews_option = 'disabled';
    }

    if(isset($jobcircle_framework_options['employer_profile_package']) && ($jobcircle_framework_options['employer_profile_package'] == "on")){

        $user_id = get_current_user_id();
        $employer_id = jobcircle_user_employer_id($user_id);  

        $employer_post_new_job = 'disabled';
        $employer_manage_jobs = 'disabled';
        $employer_manage_applicants = 'disabled';
        $employer_bookmark_resumes = 'disabled';
        $employer_packages = 'disabled';
        
        $employer_post_new_job_status = 'disabled';
        $employer_manage_jobs_status = 'disabled';
        $employer_manage_applicants_status = 'disabled';
        $employer_bookmark_resumes_status = 'disabled';
        $employer_packages_status = 'disabled';

        if(($employer_id) && ($employer_id > 0)){
            $employer_purchased_packages = get_post_meta($employer_id,'employer_purchased_packages',true);

            if($employer_purchased_packages){
                $explode_emp_purchased_packages = explode(",",$employer_purchased_packages);
                if($explode_emp_purchased_packages){
                    foreach($explode_emp_purchased_packages as $emp_purchased_package){
                        $purchased_package_id = $emp_purchased_package;

                        $emp_post_new_job = get_post_meta($purchased_package_id, 'order_emp_post_new_job', true);
                        $emp_manage_jobs = get_post_meta($purchased_package_id, 'order_emp_manage_jobs', true);
                        $emp_manage_applicants = get_post_meta($purchased_package_id, 'order_emp_manage_applicants', true);
                        $emp_bookmark_resumes = get_post_meta($purchased_package_id, 'order_emp_bookmark_resumes', true);
                        $emp_packages = get_post_meta($purchased_package_id, 'order_emp_packages', true);

                        if(($emp_post_new_job === 1) || ($emp_post_new_job == "on")){
                            $employer_post_new_job = 'enabled';
                            $employer_post_new_job_status = 'enabled';
                        }
                        if(($emp_manage_jobs === 1) || ($emp_manage_jobs == "on")){
                            $employer_manage_jobs = 'enabled';
                            $employer_manage_jobs_status = 'enabled';
                        }
                        if(($emp_manage_applicants === 1) || ($emp_manage_applicants == "on")){
                            $employer_manage_applicants = 'enabled';
                            $employer_manage_applicants_status = 'enabled';
                        }
                        if(($emp_bookmark_resumes === 1) || ($emp_bookmark_resumes == "on")){
                            $employer_bookmark_resumes = 'enabled';
                            $employer_bookmark_resumes_status = 'enabled';
                        }
                        if(($emp_packages === 1) || ($emp_packages == "on")){
                            $employer_packages = 'enabled';
                            $employer_packages_status = 'enabled';
                        }
                    }
                }
            }
        }

        $jobcircle_employer_team_member_id = 0;

        if(isset($_SESSION['jobcircle_employer_team_member_id'])){
            $jobcircle_employer_team_member_id = $_SESSION['jobcircle_employer_team_member_id'];
        }
        
        if(isset($jobcircle_employer_team_member_id) && ($jobcircle_employer_team_member_id > 0)){

            $employer_post_new_job = 'disabled';
            $employer_manage_jobs = 'disabled';
            $employer_manage_applicants = 'disabled';
            $employer_bookmark_resumes = 'disabled';
            $employer_packages = 'disabled';

            $get_team_member_access = get_user_meta($jobcircle_employer_team_member_id, 'team_member_access', true);

            $explode_team_member_access = explode(",",$get_team_member_access);
            
            if($explode_team_member_access){
                foreach($explode_team_member_access as $team_member_access){
                    if(trim($team_member_access) == "post_new_job" && $employer_post_new_job_status == "enabled"){
                        $employer_post_new_job = 'enabled';

                    }elseif(trim($team_member_access) == "manage_jobs" && $employer_manage_jobs_status == "enabled"){
                        $employer_manage_jobs = 'enabled';

                    }elseif(trim($team_member_access) == "bookmark_resumes" && $employer_bookmark_resumes_status == "enabled"){
                        $employer_bookmark_resumes = 'enabled';

                    }elseif(trim($team_member_access) == "manage_applicants" && $employer_manage_applicants_status == "enabled"){
                        $employer_manage_applicants = 'enabled';

                    }elseif(trim($team_member_access) == "packages" && $employer_packages_status == "enabled"){
                        $employer_packages = 'enabled';
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
        'post-job' => array(
            'icon' => 'fa fa-pencil-square-o',
            'title' => esc_html__('Post New Job', 'jobcircle-frame'),
            'status' => $employer_post_new_job
        ),
        'manage-jobs' => array(
            'icon' => 'fa fa-file-text-o',
            'title' => esc_html__('Manage Jobs', 'jobcircle-frame'),
            'status' => $employer_manage_jobs
        ),
        'manage-applicants' => array(
            'icon' => 'fa fa-credit-card',
            'title' => esc_html__('Manage Applicants', 'jobcircle-frame'),
            'status' => $employer_manage_applicants
        ),
        'saved-resumes' => array(
            'icon' => 'fa fa-drivers-license-o',
            'title' => esc_html__('Bookmark Resumes', 'jobcircle-frame'),
            'status' => $employer_bookmark_resumes
        ),
        'reviews' => array(
            'icon' => 'fa fa-comments',
            'title' => esc_html__('Reviews', 'jobcircle-frame'),
            'status' => $candidate_reviews_option
        ),
        'packages' => array(
            'icon' => 'fa fa-list-ul',
            'title' => esc_html__('Packages', 'jobcircle-frame'),
            'status' => $employer_packages
        ),
        'transactions' => array(
            'icon' => 'fa fa-money-bill-alt',
            'title' => esc_html__('Transactions', 'jobcircle-frame'),
            'status' => $employer_packages
        ),
    ];
    
    return apply_filters('jobcircle_employer_account_menu_items_list', $items);
}

function jobcircle_job_types_list() {
    $list = array(
        'full_time' => array(
            'title' => esc_html__('Full Time', 'jobcircle-frame'),
            'color' => '#17b67c',
            'bg_color' => 'rgba(40, 182, 97,0.11)'
        ),
        'part_time' => array(
            'title' => esc_html__('Part Time', 'jobcircle-frame'),
            'color' => '#ff9b20',
            'bg_color' => '#fff8ec'
        ),
        'internship' => array(
            'title' => esc_html__('Internship', 'jobcircle-frame'),
            'color' => '#ea2b33',
            'bg_color' => '#ffeced'
        ),
        'contract' => array(
            'title' => esc_html__('Contract', 'jobcircle-frame'),
            'color' => '#7460ee',
            'bg_color' => '#eeebff'
        ),
        'freelancing' => array(
            'title' => esc_html__('Freelancing', 'jobcircle-frame'),
            'color' => '#ff9b20',
            'bg_color' => '#fff8ec'
        )
    );
    return $list;
}

function jobcircle_job_type_ret_str($job_type) {
    if ($job_type == '') {
        $job_type = 'full_time';
    }
    $all_types = jobcircle_job_types_list();
    $type_ar = isset($all_types[$job_type]) ? $all_types[$job_type] : array();

    return $type_ar;
}

function jobcircle_is_employer_job($job_id, $user_id) {
    global $wpdb;
    
    $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
    $post_query .= " WHERE posts.post_type='jobs' AND posts.ID='{$job_id}' AND posts.post_author='{$user_id}'";
    $post_query .= " ORDER BY posts.ID DESC LIMIT 1";
    $get_db_res = $wpdb->get_col($post_query);
    
    if (!empty($get_db_res) && isset($get_db_res[0])) {
        return $get_db_res[0];
    }
}
