<?php

defined('ABSPATH') || exit;

class Jobcircle_Dashboard_Data_Save_Class {
    
    public function __construct() {
        add_action('wp_ajax_jobcircle_dash_user_send_email_verification', array($this, 'jobcircle_dash_user_send_email_verification'));
        add_action('wp_ajax_jobcircle_dash_user_switch_account', array($this, 'jobcircle_dash_user_switch_account'));
        add_action('wp_ajax_jobcircle_user_dashb_change_pass_call', array($this, 'change_password'));
        add_action('wp_ajax_jobcircle_user_dashboard_profile_save_call', array($this, 'user_profile_saving'));
        add_action('wp_ajax_jobcircle_employer_dashboard_profile_save_call', array($this, 'employer_profile_saving'));

        add_action('wp_ajax_jobcircle_user_dashboard_social_save_call', array($this, 'user_general_saving'));
        add_action('wp_ajax_jobcircle_user_dashboard_location_save_call', array($this, 'user_general_saving'));
        add_action('wp_ajax_jobcircle_get_states', array($this, 'jobcircle_get_states'));        
    }

    public function jobcircle_dash_user_send_email_verification(){        
        if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        } 

        $jobcircle_user_id = get_current_user_id();

        if (empty($jobcircle_user_id) || is_wp_error($jobcircle_user_id)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Something went wrong. Please try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        $jobcircle_user = get_user_by('id', $jobcircle_user_id);
        $jobcircle_display_name = $jobcircle_user->display_name;
        $jobcircle_display_name = $jobcircle_user->display_name;
        $jobcircle_user_email = $jobcircle_user->user_email;

        $jobcircle_verification_key = wp_generate_password( 20, false );
        // Store verification key for the user
        update_user_meta( $jobcircle_user_id, 'jobcircle_verification_key', $jobcircle_verification_key );
        $jobcircle_protocol     = is_ssl() ? 'https' : 'http';
        $jobcircle_approval_link  = esc_url(                    
            add_query_arg(
                array(
                    'jobcircle_user_action' => 'verify_email',
                    'key' => $jobcircle_verification_key,
                    'email' => $jobcircle_user_email,
                ), 
                home_url('/', $jobcircle_protocol)
            )
        );
        $jobcircle_args = array(
            'jobcircle_user' => $jobcircle_user,
            'jobcircle_verify_link' => $jobcircle_approval_link,
        );
        do_action('jobcircle_user_register_verify_email', $jobcircle_args);
        wp_send_json(array('error' => '0', 'msg' => esc_html__('Verification email has been sent. Please check your email.', 'jobcircle-frame')));
    }

    public function jobcircle_dash_user_switch_account(){
        global $wpdb, $jobcircle_framework_options, $current_user;
        
        if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        } 
        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';

        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);

        $account_page_url = home_url('/');
        if ($account_page_id > 0) {
            $account_page_url = get_permalink($account_page_id);
        }
        $user_id = $current_user->ID;

        if (empty($user_id)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Something went wrong. Please try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        $display_name = $current_user->display_name;

        if (jobcircle_user_account_type($user_id) == 'candidate') {
            $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
            $post_query .= " WHERE posts.post_type='employer' AND posts.post_author={$user_id}";
            $post_query .= " AND (posts.post_status!='auto-draft' AND posts.post_status!='inherit' AND posts.post_status!='trash')";
            $post_query .= " ORDER BY posts.ID DESC LIMIT 1";
            $get_db_res = $wpdb->get_col($post_query);
            $employer_id    = isset($get_db_res[0]) ? $get_db_res[0] : '';           
            
            if(empty($employer_id)) {
                $my_post = array(
                    'post_title' => $display_name,
                    'post_type' => 'employer',
                    'post_status' => 'publish',
                    'post_author' => $user_id,
                );
                wp_insert_post($my_post);
            }

            $jobcircle_account_type = 'employer';
        } elseif (jobcircle_user_account_type($user_id) == 'employer') {
            $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
            $post_query .= " WHERE posts.post_type='candidates' AND posts.post_author={$user_id}";
            $post_query .= " AND (posts.post_status!='auto-draft' AND posts.post_status!='inherit' AND posts.post_status!='trash')";
            $post_query .= " ORDER BY posts.ID DESC LIMIT 1";
            $get_db_res = $wpdb->get_col($post_query);
            $candidate_id    = isset($get_db_res[0]) ? $get_db_res[0] : '';  

            if(empty($candidate_id)) {
                $my_post = array(
                    'post_title' => $display_name,
                    'post_type' => 'candidates',
                    'post_status' => 'publish',
                    'post_author' => $user_id,
                );
                wp_insert_post($my_post);
            }
            $jobcircle_account_type = 'candidate';
        }
        update_user_meta($user_id, 'user_account_post_type', $jobcircle_account_type);

        wp_send_json(array('error' => '0', 'msg' => esc_html__('Your account has been switched successfully.', 'jobcircle-frame')));
    }

    public function jobcircle_get_states(){
        global $jobcircle_countries_states_list;
        
        $jobcircle_country = !empty($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
        $jobcircle_country_code = !empty($_POST['country_code']) ? sanitize_text_field($_POST['country_code']) : '';

        if (empty($jobcircle_country) || empty($jobcircle_country_code)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Something went wrong. Please try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        $states = array();

        if(!empty($jobcircle_countries_states_list[$jobcircle_country_code])){
            $states = $jobcircle_countries_states_list[$jobcircle_country_code];
        }
        wp_send_json($states);       
    }

    public function change_password() {
        global $current_user;

        if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        $old_pass = $_POST['old_pass'];
        $new_pass = $_POST['new_pass'];
        $conf_pass = $_POST['conf_pass'];

        if ($old_pass == '' || $new_pass == '' || $conf_pass == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all mandatory fields.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        if (!wp_check_password($old_pass, $current_user->data->user_pass, $current_user->ID)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Your old password is not correct.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        
        if ($new_pass != $conf_pass) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Password does not match with confirm password.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        $user_def_array = array('ID' => $current_user->ID);
        $user_def_array['user_pass'] = $new_pass;
        wp_update_user($user_def_array);

        $ret_data = array('error' => '0', 'msg' => esc_html__('Password changed successfully.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    public static function upload_img_logo($upload_file, $user_id, $member_id) {

        if (isset($upload_file['tmp_name']) && $upload_file['tmp_name'] != '') {
            $file_name = $upload_file['name'];
            $filname_exp = explode('.', $file_name);
            $file_ext = end($filname_exp);
    
            if ($file_ext == 'jpg' || $file_ext == 'png') {
                //
            } else {
                return false;
            }
    
            $max_attachment_size = 10400;
                
            // Get the path to the upload directory.
            $wp_upload_dir = wp_upload_dir();
    
            $file_size = isset($upload_file['size']) && $upload_file['size'] > 0 ? $upload_file['size'] : 1;
            $size_as_kb = round($file_size / 1024);
    
            if ($size_as_kb > $max_attachment_size) {
                $ret_data = array('error' => '1', 'msg' => esc_html__('Error: Image size is too big to upload. Please use optimized image only.', 'jobcircle-frame'));
                wp_send_json($ret_data);
            }
    
            //
            $emp_post = get_post($member_id);
            if (isset($emp_post->post_title) && $emp_post->post_title != '') {
    
                $upload_file['name'] = sanitize_title($emp_post->post_title) . '-' . $member_id . '.' . $file_ext;
            }
    
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
    
            $allowed_image_types = array();
            $allowed_image_types['jpg|jpeg|jpe'] = 'image/jpeg';
            $allowed_image_types['png'] = 'image/png';
    
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
                    'post_author' => $user_id,
                    'post_status' => 'inherit'
                );
    
                // Insert the attachment.
                $attach_id = wp_insert_attachment($attachment, $upload_file_path, $member_id);
    
                // Generate the metadata for the attachment, and update the database record.
                $attach_data = wp_generate_attachment_metadata($attach_id, $upload_file_path);
                wp_update_attachment_metadata($attach_id, $attach_data);
    
                set_post_thumbnail($member_id, $attach_id);
            }
        }
    }

    public function user_profile_saving() {
        global $current_user;

        if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        $user_id = $current_user->ID;
        $candidate_id = jobcircle_user_candidate_id($user_id);

        $full_name = $_POST['user_full_name'];
        $jobcircle_full_name = !empty($_POST['user_full_name']) ? jobcircle_esc_html($_POST['user_full_name']) : '';
        $jobcircle_desc = !empty($_POST['info_content']) ? $_POST['info_content'] : '';        

        $jobcircle_field_user_phone = !empty($_POST['jobcircle_field_user_phone']) ? jobcircle_esc_html($_POST['jobcircle_field_user_phone']) : '';
        $jobcircle_sec_category = !empty($_POST['sec_category']) ? jobcircle_esc_html($_POST['sec_category']) : '';
        $jobcircle_field_salary = !empty($_POST['jobcircle_field_salary']) ? jobcircle_esc_html($_POST['jobcircle_field_salary']) : '';

        if (empty($jobcircle_full_name) || empty($jobcircle_desc) || empty($jobcircle_field_user_phone) || empty($jobcircle_sec_category) || empty($jobcircle_field_salary)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill mandatory fields.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }        
        $jobcircle_desc = trim(apply_filters('the_content', $jobcircle_desc));

        $to_redirect = '';
        if (!$candidate_id) {
            $to_redirect = 'same';
            $my_post = array(
                'post_title' => $jobcircle_full_name,
                'post_content' => $jobcircle_desc,
                'post_type' => 'candidates',
                'post_status' => 'publish',
                'post_author' => $user_id,
            );
            $candidate_id = wp_insert_post($my_post);
            update_user_meta($user_id, 'user_account_post_type', 'candidate');
        } else {
            $upd_post = array(
                'ID' => $candidate_id,
                'post_title' => $full_name,
                'post_content' => $jobcircle_desc,
            );
            wp_update_post($upd_post);
        }

        if (isset($_POST['sec_category']) && $_POST['sec_category'] > 0) {
            $cats_to_save = array($_POST['sec_category']);
            wp_set_post_terms($candidate_id, $cats_to_save, 'candidate_cat', false);
        }

        if (isset($_POST['user_skills']) && $_POST['user_skills'] != '') {
            $user_skills = $_POST['user_skills'];
            $user_skills = str_replace(array(', '), array(','), $user_skills);
            $user_skills = explode(',', $user_skills);
            wp_set_post_terms($candidate_id, $user_skills, 'candidate_skill', false);
        }

        $upload_file = isset($_FILES['user_profile_pic']) ? $_FILES['user_profile_pic'] : '';
        self::upload_img_logo($upload_file, $user_id, $candidate_id);

        $ret_data = array('error' => '0', 'redirect' => $to_redirect, 'msg' => esc_html__('Profile changes saved successfully.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    public function employer_profile_saving() {
        global $current_user;
        if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        $jobcircle_user_id = $current_user->ID;
        $jobcircle_employer_id = jobcircle_user_employer_id($jobcircle_user_id);
        $jobcircle_full_name = !empty($_POST['company_name']) ? jobcircle_esc_html($_POST['company_name']) : '';
        $jobcircle_field_user_phone = !empty($_POST['jobcircle_field_user_phone']) ? jobcircle_esc_html($_POST['jobcircle_field_user_phone']) : '';
        $jobcircle_employer_cat = !empty($_POST['employer_cat']) ? $_POST['employer_cat'] : array();
        $jobcircle_desc = !empty($_POST['info_content']) ? jobcircle_esc_the_textarea($_POST['info_content']) : '';

        if (empty($jobcircle_full_name) || empty($jobcircle_field_user_phone) || empty($jobcircle_employer_cat) || empty($jobcircle_desc)) {
            $jobcircle_ret_data = array('error' => '1', 'msg' => esc_html__('Please fill mandatory fields.', 'jobcircle-frame'));
            wp_send_json($jobcircle_ret_data);
        }
        $jobcircle_desc = trim(apply_filters('the_content', $jobcircle_desc));
        $upd_post = array(
            'ID' => $jobcircle_employer_id,
            'post_title' => $jobcircle_full_name,
            'post_content' => $jobcircle_desc,
        );
        wp_update_post($upd_post);
        $jobcircle_website_url = !empty($_POST['web_url']) ? $_POST['web_url'] : '';
        $jobcircle_user_upd = array(
            'ID' => $jobcircle_user_id,
            'display_name' => $jobcircle_full_name,
            'user_url' => $jobcircle_website_url
        );
        wp_update_user($jobcircle_user_upd);

        if (!empty($jobcircle_employer_cat)) {
            $jobcircle_cats_to_save = array($jobcircle_employer_cat);
            wp_set_post_terms($jobcircle_employer_id, $jobcircle_cats_to_save, 'employer_cat', false);
        }

        $jobcircle_upload_file = isset($_FILES['user_profile_pic']) ? $_FILES['user_profile_pic'] : '';
        self::upload_img_logo($jobcircle_upload_file, $jobcircle_user_id, $jobcircle_employer_id);

        $jobcircle_ret_data = array('error' => '0', 'redirect' => '', 'msg' => esc_html__('Profile changes saved successfully.', 'jobcircle-frame'));
        wp_send_json($jobcircle_ret_data);
    }

    public function user_general_saving() {
        global $current_user;

        if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        $user_id = $current_user->ID;

        $jobcircle_field_loc_country = !empty($_POST['jobcircle_field_loc_country']) ? jobcircle_esc_html($_POST['jobcircle_field_loc_country']) : '';
        $jobcircle_field_loc_country = !empty($_POST['jobcircle_field_loc_city']) ? jobcircle_esc_html($_POST['jobcircle_field_loc_city']) : '';
        $jobcircle_field_loc_zipcode = !empty($_POST['jobcircle_field_loc_zipcode']) ? jobcircle_esc_html($_POST['jobcircle_field_loc_zipcode']) : '';
        $jobcircle_field_loc_address = !empty($_POST['jobcircle_field_loc_address']) ? jobcircle_esc_html($_POST['jobcircle_field_loc_address']) : '';

        // if (empty($jobcircle_field_loc_country) || empty($jobcircle_field_loc_country) || empty($jobcircle_field_loc_zipcode) || empty($jobcircle_field_loc_address)) {
        //     $jobcircle_ret_data = array('error' => '1', 'msg' => esc_html__('Please fill location mandatory fields.', 'jobcircle-frame'));
        //     wp_send_json($jobcircle_ret_data);
        // }

        $member_id = 0;
        $candidate_id = jobcircle_user_candidate_id($user_id);
        $employer_id = jobcircle_user_employer_id($user_id);
        if ($candidate_id) {
            $member_id = $candidate_id;
            $display_name = get_the_title($candidate_id);
        } else if ($employer_id) {
            $member_id = $employer_id;
            $display_name = get_the_title($employer_id);
        }

        if ($member_id > 0) {
            $upd_post = array(
                'ID' => $member_id,
                'post_title' => $display_name,
            );
            wp_update_post($upd_post);

            $ret_data = array('error' => '0', 'redirect' => '', 'msg' => esc_html__('Changes saved successfully.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        $ret_data = array('error' => '1', 'redirect' => '', 'msg' => esc_html__('There is some error while updating profile settings.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

}
new Jobcircle_Dashboard_Data_Save_Class;