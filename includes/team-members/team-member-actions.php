<?php

defined('ABSPATH') || exit;

class Jobcircle_Team_Member_Actions {

    public function __construct() {
        // Add Team Members
        add_action('wp_ajax_jobcircle_add_new_team_member', array($this, 'add_team_member_ajax_call'));
        add_action('wp_ajax_nopriv_jobcircle_add_new_team_member', array($this, 'add_team_member_ajax_call'));
        add_action('jobcircle_add_team_member_with_fields', array($this, 'add_team_member_with_fields'));

        add_action('wp_ajax_jobcircle_remove_team_member', array($this, 'remove_team_member'));
        add_action('wp_ajax_nopriv_jobcircle_remove_team_member', array($this, 'remove_team_member'));

        add_action('wp_ajax_jobcircle_get_team_member', array($this, 'get_team_member'));
        add_action('wp_ajax_nopriv_jobcircle_get_team_member', array($this, 'get_team_member'));

        add_action('wp_ajax_jobcircle_update_team_member', array($this, 'update_team_member_ajax_call'));
        add_action('wwp_ajax_nopriv_jobcircle_update_team_member', array($this, 'update_team_member_ajax_call'));
        add_action('jobcircle_update_team_member_with_fields', array($this, 'update_team_member_with_fields'));
    }


    public function update_team_member_ajax_call() {

        if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        
        global $jobcircle_framework_options;

        $member_id = isset($_POST['hdn_member_id']) ? jobcircle_esc_html($_POST['hdn_member_id']) : ''; 
        $user_fname = isset($_POST['first_name']) ? jobcircle_esc_html($_POST['first_name']) : '';
        $user_lname = isset($_POST['last_name']) ? jobcircle_esc_html($_POST['last_name']) : '';
        $member_access_values = '';

        if (empty($member_id)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('You cannot edit this member.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        global $current_user;
        $user_id = $current_user->ID;
        $current_employer_id = jobcircle_user_employer_id($user_id);        
        $check_member_employer = get_user_meta($member_id, 'team_member_parent_emp_id', true);

        if($check_member_employer !== $current_employer_id){
            $ret_data = array('error' => '1', 'msg' => esc_html__('You do not have permission to edit this member.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        if(isset($_POST['member_access'])){
            $counter=1;
            foreach($_POST['member_access'] as $access_value){
                if($counter > 1){
                    $member_access_values .= ',';
                }
                $member_access_values .= $access_value;
                $counter++;
            }
        }

        if (empty($user_fname) || empty($user_lname)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all form fields.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }        
        
        $atts = array(
            'member_id' => $member_id,
            'first_name' => $user_fname,
            'last_name' => $user_lname,
            'is_ajax' => true,
            'set_auth' => false,
            'member_access' => $member_access_values
        );
        do_action('jobcircle_update_team_member_with_fields', $atts);

        global $jobcircle_framework_options;

        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
        $account_page_url = '';
        if ($account_page_id > 0) {
            $account_page_url = get_permalink($account_page_id);
        }

        $ret_data = array(
            'msg' => esc_html__('Successfully team member updated.', 'jobcircle-frame'),
            'error' => '0',
            'redirect' => $account_page_url,
        );
        wp_send_json($ret_data);
    }


    public function update_team_member_with_fields($atts) {
        $is_ajax = isset($atts['is_ajax']) ? $atts['is_ajax'] : '';
        $new_member_access = isset($atts['member_access']) ? $atts['member_access'] : '';
        $user_id = $atts['member_id'];

        $update_user_data = array(
            'ID' => $user_id
        );


        $firstname = $lastname = '';
        if (isset($atts['first_name'])) {
            $firstname = $atts['first_name'];
        } else if (isset($_POST['first_name'])) {
            $firstname = $_POST['first_name'];
        }
        if (isset($atts['last_name'])) {
            $lastname = $atts['last_name'];
        } else if (isset($_POST['last_name'])) {
            $lastname = $_POST['last_name'];
        }

        $display_name = '';
        if ($firstname != '') {
            $first_name = jobcircle_esc_html($firstname);
            $update_user_data['first_name'] = $first_name;
            $display_name = $first_name;
        }
        if ($lastname != '') {
            $last_name = jobcircle_esc_html($lastname);
            $update_user_data['last_name'] = $last_name;
            $display_name = $display_name != '' ? $display_name . ' ' . $last_name : '';
        }
        
        if ($display_name != '') {
            $update_user_data['display_name'] = $display_name;
        }

        wp_update_user($update_user_data);

        if(isset($new_member_access)){
            update_user_meta($user_id, 'team_member_access', $new_member_access);
        }
        
    }

    public function add_team_member_ajax_call() {

        if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        
        global $jobcircle_framework_options;

        $user_fname = isset($_POST['first_name']) ? jobcircle_esc_html($_POST['first_name']) : '';
        $user_lname = isset($_POST['last_name']) ? jobcircle_esc_html($_POST['last_name']) : '';
        $username = isset($_POST['username']) ? jobcircle_esc_html($_POST['username']) : '';
        $user_email = isset($_POST['user_email']) ? jobcircle_esc_html($_POST['user_email']) : '';
        $user_pass = isset($_POST['user_pass']) ? jobcircle_esc_html($_POST['user_pass']) : '';
        $user_cpass = isset($_POST['confirm_pass']) ? jobcircle_esc_html($_POST['confirm_pass']) : '';
        $member_access_values = '';

        if(isset($_POST['member_access'])){
            $counter=1;
            foreach($_POST['member_access'] as $access_value){
                if($counter > 1){
                    $member_access_values .= ',';
                }
                $member_access_values .= $access_value;
                $counter++;
            }
        }

        if (empty($user_fname) || empty($user_lname) || empty($username) || empty($user_email) || empty($user_pass) || empty($user_cpass)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all form fields.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please use a valid email address.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        if ($user_pass != $user_cpass) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Confirm password field does not match with the password field.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        
        if (email_exists($user_email)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('This email address is already taken. Please select another one.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        $user_name = $username;
        if(username_exists($user_name)) {
            $user_name = substr($user_email, 0, strpos($user_email, '@'));
            if(username_exists($user_name)) {
                $user_name = $user_name . rand(10000, 99999);
            }
        }
        
        $atts = array(
            'first_name' => $user_fname,
            'last_name' => $user_lname,
            'user_name' => $user_name,
            'email' => $user_email,
            'password' => $user_pass,
            'role' => 'subscriber',
            'is_ajax' => true,
            'set_auth' => false,
            'member_access' => $member_access_values
        );
        do_action('jobcircle_add_team_member_with_fields', $atts);

        global $jobcircle_framework_options;

        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
        $account_page_url = '';
        if ($account_page_id > 0) {
            $account_page_url = get_permalink($account_page_id);
        }

        $ret_data = array(
            'msg' => esc_html__('Successfully team member added.', 'jobcircle-frame'),
            'error' => '0',
            'redirect' => $account_page_url,
        );
        wp_send_json($ret_data);
    }
    
    public function add_team_member_with_fields($atts) {
        $user_name = isset($atts['user_name']) ? $atts['user_name'] : '';
        $user_email = isset($atts['email']) ? $atts['email'] : '';
        $user_pass = isset($atts['password']) ? $atts['password'] : '';
        $user_role = isset($atts['role']) ? $atts['role'] : '';
        $is_ajax = isset($atts['is_ajax']) ? $atts['is_ajax'] : '';
        $new_member_access = isset($atts['member_access']) ? $atts['member_access'] : '';

        $current_login_user_id = get_current_user_id();
        $user_employer_id = jobcircle_user_employer_id($current_login_user_id);

        $create_user = wp_create_user($user_name, $user_pass, $user_email);
        if (is_wp_error($create_user)) {
            $reg_error_msgs = $create_user->errors;
            
            $error_msg_str = '';
            if (!empty($reg_error_msgs)) {
                foreach ($reg_error_msgs as $error_msg) {
                    $error_msg_str = $error_msg[0];
                }
            }

            if ($is_ajax && $error_msg_str != '') {
                $ret_data = array('error' => '1', 'msg' => wp_kses($error_msg_str, array('strong' => array(), 'p' => array())));
                wp_send_json($ret_data);
            }
        } else {
            $user_id = $create_user;

            if($user_employer_id > 0){
                update_user_meta($user_id, 'team_member_parent_emp_id', $user_employer_id);
            }

            $update_user_data = array(
                'ID' => $user_id,
                'role' => $user_role
            );

            $firstname = $lastname = '';
            if (isset($atts['first_name'])) {
                $firstname = $atts['first_name'];
            } else if (isset($_POST['first_name'])) {
                $firstname = $_POST['first_name'];
            }
            if (isset($atts['last_name'])) {
                $lastname = $atts['last_name'];
            } else if (isset($_POST['last_name'])) {
                $lastname = $_POST['last_name'];
            }

            $display_name = '';
            if ($firstname != '') {
                $first_name = jobcircle_esc_html($firstname);
                $update_user_data['first_name'] = $first_name;
                $display_name = $first_name;
            }
            if ($lastname != '') {
                $last_name = jobcircle_esc_html($lastname);
                $update_user_data['last_name'] = $last_name;
                $display_name = $display_name != '' ? $display_name . ' ' . $last_name : '';
            }
            
            if ($display_name != '') {
                $update_user_data['display_name'] = $display_name;
            }

            wp_update_user($update_user_data);

            if(isset($new_member_access)){
                update_user_meta($user_id, 'team_member_access', $new_member_access);
            }
            //
            
            update_user_option($user_id, 'show_admin_bar_front', false);
            
            if (isset($atts['set_auth']) && $atts['set_auth'] === true) {
                $_user_obj = get_user_by('id', $user_id);
                wp_set_current_user($_user_obj->ID, $_user_obj->user_login);
                wp_set_auth_cookie($user_id);
            }
        }
    }

    public function remove_team_member() {
        global $current_user;
        $user_id = $current_user->ID;
        $current_employer_id = jobcircle_user_employer_id($user_id);

        $member_id = isset($_POST['id']) ? $_POST['id'] : '';
        
        $check_member_employer = get_user_meta($member_id, 'team_member_parent_emp_id', true);
        if($check_member_employer === $current_employer_id){

            wp_delete_user($member_id);

            $ret_data = array('error' => '0', 'msg' => esc_html__('Member deleted succussfully.', 'jobcircle-frame'));
            wp_send_json($ret_data);

        }else{
            $ret_data = array('error' => '1', 'msg' => esc_html__('You cannot remove this member.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }        
    }

    public function get_team_member(){

        $member_id = isset($_POST['id']) ? $_POST['id'] : '';

        if(($member_id) && ($member_id > 0)){
            $member_data = get_userdata($member_id);

            $first_name = $member_data->first_name;
            $last_name =  $member_data->last_name;
            $email =      $member_data->user_email;
            $username =  $member_data->user_login;
            $user_access = get_user_meta($member_data->ID,'team_member_access',true);

            $data = array();
            $data['id'] = $member_data->ID;
            $data['first_name'] = $member_data->first_name;
            $data['last_name'] = $member_data->last_name;
            $data['user_email'] = $member_data->user_email;
            $data['user_login'] = $member_data->user_login;
            $data['user_access'] = $user_access;

            $ret_data = array('error' => '0', 'member_data' => $data);
            wp_send_json($ret_data);

        } else {
            $ret_data = array('error' => '1', 'msg' => esc_html__('You cannot update this member.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

    }
}

new Jobcircle_Team_Member_Actions;
