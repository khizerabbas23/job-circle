<?php

defined('ABSPATH') || exit;

class Jobcircle_Login_Register_Saving {

    public function __construct() {
        add_action('init', array($this, 'jobcircle_user_email_verify'), 10);
        add_action('wp_ajax_jobcircle_add_form_referrer_field_call', array($this, 'form_add_referrer'));
        add_action('wp_ajax_nopriv_jobcircle_add_form_referrer_field_call', array($this, 'form_add_referrer'));

        add_action('wp_ajax_jobcircle_user_login_action', array($this, 'login_ajax_call'));
        add_action('wp_ajax_nopriv_jobcircle_user_login_action', array($this, 'login_ajax_call'));

        add_action('wp_ajax_jobcircle_user_register_action', array($this, 'registration_ajax_call'));
        add_action('wp_ajax_nopriv_jobcircle_user_register_action', array($this, 'registration_ajax_call'));
        
        //Forget Password 
        add_action('wp_ajax_jobcircle_user_forget_password_action', array($this, 'forget_pass_ajax_call'));
        add_action('wp_ajax_nopriv_jobcircle_user_forget_password_action', array($this, 'forget_pass_ajax_call'));
        add_action('wp_ajax_nopriv_jobcircle_user_reset_password_action', array($this, 'reset_pass_ajax_call'));

        // For register common hook
        add_action('jobcircle_user_register_with_fields', array($this, 'user_register_with_fields'));
    }

    public function jobcircle_user_email_verify(){
        if(!empty($_GET['jobcircle_user_action']) && 
            !empty($_GET['key']) && 
            !empty($_GET['email']) && 
            $_GET['jobcircle_user_action'] == 'verify_email'){  
                $jobcircle_key   = !empty($_GET['key']) ? sanitize_text_field($_GET['key']) : '';
                $jobcircle_user_email   = !empty($_GET['email']) ? sanitize_text_field($_GET['email']) : '';
                $jobcircle_user = get_user_by( 'email', $jobcircle_user_email );
                global $jobcircle_framework_options;
                $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
                $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
                $account_page_url = '';

                if ($account_page_id > 0) {
                    $account_page_url = get_permalink($account_page_id);
                }

                if( isset($jobcircle_user->ID) ){
                    $jobcircle_confirmation_key = get_user_meta($jobcircle_user->ID, 'jobcircle_verification_key', true);

                    if ($jobcircle_confirmation_key === $jobcircle_key) {
                        update_user_meta( $jobcircle_user->ID, 'jobcircle_user_verified', 'yes' );
                        update_user_meta( $jobcircle_user->ID, 'jobcircle_verification_key', '' );

                        $jobcircle_args = array(
                            'jobcircle_user' => $jobcircle_user,
                        );
                        do_action('jobcircle_user_account_admin_approval_email', $jobcircle_args);

                        if (!is_user_logged_in()) {
                            wp_clear_auth_cookie();
                            wp_set_current_user($jobcircle_user->ID, $jobcircle_user->user_login);
                            wp_set_auth_cookie($jobcircle_user->ID);
                            update_user_caches($jobcircle_user);
                            do_action('wp_login', $jobcircle_user->user_login, $jobcircle_user);
                            wp_redirect($account_page_url);
                            exit();                            
                        }
                    }
                }
                wp_redirect($account_page_url);
                exit(); 
        } elseif(!empty($_GET['jobcircle_user_action']) && 
            !empty($_GET['key']) && 
            !empty($_GET['login']) && 
            $_GET['jobcircle_user_action'] == 'reset_password'){
                $jobcircle_key   = !empty($_GET['key']) ? sanitize_text_field($_GET['key']) : '';                
                $jobcircle_user_login   = !empty($_GET['login']) ? sanitize_text_field($_GET['login']) : '';
                $jobcircle_user = get_user_by( 'login', $jobcircle_user_login );               

                if( isset($jobcircle_user->ID) ){                    
                    $status = 'error';
                    $jobcircle_confirmation_key = get_user_meta($jobcircle_user->ID, 'jobcircle_reset_password_key', true);
                    $jobcircle_reset_time = get_user_meta( $jobcircle_user->ID, 'jobcircle_reset_password_time', true );

                    $jobcircle_msg = '';

                    if ( $jobcircle_reset_time && ( time() - $jobcircle_reset_time > 3600 ) ) {
                        $jobcircle_msg = esc_html__('Reset link has expired. Please request a new password reset.', 'jobcircle-frame');
                    } else {
                        $jobcircle_confirmation_key = get_user_meta($jobcircle_user->ID, 'jobcircle_reset_password_key', true);
    
                        if ($jobcircle_confirmation_key === $jobcircle_key) { 
                            $status = 'success';
                        } else {
                            $jobcircle_msg = esc_html__('Invalid reset link. Please request a new password reset.', 'jobcircle-frame');
                        }
                    }
                    $data = array( 'status' => $status, 'user_login' => $jobcircle_user_login, 'msg' => $jobcircle_msg );
                    set_transient( 'jobcircle_reset_pass_transient_'.$jobcircle_user_login, $data, 2 * MINUTE_IN_SECONDS );
                } 
        }
    }

    public function form_add_referrer() {        
        ob_start();
        wp_nonce_field('jobcircle-form-nonce', '_nonce');
        $html = ob_get_clean();
        
        $ret_data = array('html' => $html);
        wp_send_json($ret_data);
    }

    public function login_ajax_call() {

        if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        
        global $jobcircle_framework_options;

        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';

        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);

        $account_page_url = '';
        if ($account_page_id > 0) {
            $account_page_url = get_permalink($account_page_id);
        }

        $username = isset($_POST['user_email']) ? jobcircle_esc_html($_POST['user_email']) : '';
        $user_pass = isset($_POST['user_pass']) ? jobcircle_esc_html($_POST['user_pass']) : '';
        $remember_me = isset($_POST['remember_me']) ? true : false;
        
        if ($username == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Username/Email field cannot be empty.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        if ($user_pass == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Password field cannot be empty.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        
        $user_name = sanitize_user($username);
        $user = get_user_by('login', $user_name);
        if (!$user && strpos($username, '@')) {
            $user = get_user_by('email', $username);
        }
        
        $secure_cookie = is_ssl();
        if (!$secure_cookie && $user && !force_ssl_admin()) {
            if (get_user_option('use_ssl', $user->ID)) {
                $secure_cookie = true;
                force_ssl_admin(true);
            }
        }
        
        $user_info = array();
        $user_info['user_login'] = sanitize_text_field(trim($username));
        $user_info['user_password'] = trim($user_pass);
        $user_info['remember'] = $remember_me;
        
        $user_login_status = 0; 
        unset($_SESSION['jobcircle_employer_team_member_id']);
        $user_authentication = wp_authenticate($user_info['user_login'], $user_info['user_password']);

        if(is_wp_error($user_authentication)){
            $errors = implode('<br/>', $user_authentication->get_error_messages());
            wp_send_json(array(
                'msg' => wp_kses($errors, array('br' => array(), 'strong' => array(), 'p' => array())),
                'error' => '1'
            ));
        }else{
            $authenticated_user_id = $user_authentication->ID;
            $team_member_parent_emp_id = get_user_meta($authenticated_user_id, 'team_member_parent_emp_id', true);
            if($team_member_parent_emp_id > 0){

                $emp_user_id = jobcircle_employer_user_id($team_member_parent_emp_id);
                if($emp_user_id > 0){

                    if(session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    $_SESSION['jobcircle_employer_team_member_id'] = $authenticated_user_id;
                    
                    $emp_user_data = get_userdata($emp_user_id);
                    $emp_user_username = $emp_user_data->user_login;

                    if($emp_user_username){
                        $parent_user = get_user_by('login',$emp_user_username);

                        if($parent_user){
                            if (is_a($parent_user, 'WP_User')) {
                                 wp_clear_auth_cookie();
                                 wp_set_current_user($parent_user->ID, $parent_user->user_login );
                                 wp_set_auth_cookie($parent_user->ID );
                                 $user_login_status = 1;

                                 do_action('wp_login', $parent_user->user_login, $parent_user);
                            }
                        }
                    }
                }
            }
        }

        if($user_login_status === 0){
            $user_signon = wp_signon($user_info, $secure_cookie);
        
            if (is_wp_error($user_signon)) {
                $errors = implode('<br/>', $user_signon->get_error_messages());
                wp_send_json(array(
                    'msg' => wp_kses($errors, array('br' => array(), 'strong' => array(), 'p' => array())),
                    'error' => '1'
                ));
            }
        }
        
        wp_send_json(array('msg' => esc_html__('Logged in successfully.', 'jobcircle-frame'), 'error' => '0', 'redirect' => $account_page_url));
    }

    public function registration_ajax_call() {

        if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        
        global $jobcircle_framework_options;

        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
        $jobcircle_account_approval = isset($jobcircle_framework_options['user_account_approval']) ? $jobcircle_framework_options['user_account_approval'] : 'auto_verify';

        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);

        $account_page_url = '';
        if ($account_page_id > 0) {
            $account_page_url = get_permalink($account_page_id);
        }

        $user_fname = isset($_POST['first_name']) ? jobcircle_esc_html($_POST['first_name']) : '';
        $user_lname = isset($_POST['last_name']) ? jobcircle_esc_html($_POST['last_name']) : '';
        $username = isset($_POST['username']) ? jobcircle_esc_html($_POST['username']) : '';
        $user_email = isset($_POST['user_email']) ? jobcircle_esc_html($_POST['user_email']) : '';
        $user_pass = isset($_POST['user_pass']) ? jobcircle_esc_html($_POST['user_pass']) : '';
        $user_cpass = isset($_POST['confirm_pass']) ? jobcircle_esc_html($_POST['confirm_pass']) : '';

        if (empty($user_fname) || empty($user_lname) || empty($username) || empty($user_email) || empty($user_pass) || empty($user_cpass)) {
            $jobcircle_ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all form fields.', 'jobcircle-frame'));
            wp_send_json($jobcircle_ret_data);
        }

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $jobcircle_ret_data = array('error' => '1', 'msg' => esc_html__('Please use a valid email address.', 'jobcircle-frame'));
            wp_send_json($jobcircle_ret_data);
        }

        if ($user_pass != $user_cpass) {
            $jobcircle_ret_data = array('error' => '1', 'msg' => esc_html__('Confirm password field does not match with the password field.', 'jobcircle-frame'));
            wp_send_json($jobcircle_ret_data);
        }
        
        if (email_exists($user_email)) {
            $jobcircle_ret_data = array('error' => '1', 'msg' => esc_html__('This email address is already taken. Please select another one.', 'jobcircle-frame'));
            wp_send_json($jobcircle_ret_data);
        }

        jobcircle_captcha_verify();

        $user_name = $username;
        if (username_exists($user_name)) {
            $user_name = substr($user_email, 0, strpos($user_email, '@'));
            if (username_exists($user_name)) {
                $user_name = $user_name . rand(10000, 99999);
            }
        }
        
        $atts = array(
            'user_name' => $user_name,
            'email' => $user_email,
            'password' => $user_pass,
            'role' => 'subscriber',
            'is_ajax' => true,
            'set_auth' => true,
            'jobcircle_account_approval' => $jobcircle_account_approval,
        );
        do_action('jobcircle_user_register_with_fields', $atts);

        $jobcircle_msg = esc_html__('Successfully registered an account.', 'jobcircle-frame');

        if($jobcircle_account_approval == 'email_verify'){
            $jobcircle_msg = esc_html__('Thank you for the registration. Please check your email to verify email address.', 'jobcircle-frame');
        } elseif($jobcircle_account_approval == 'admin_verify'){
            $jobcircle_msg = esc_html__(' Your account has been created. Please wait while your account has been approved by administrator', 'jobcircle-frame');
        }

        $jobcircle_ret_data = array(
            'msg' => $jobcircle_msg,
            'error' => '0',
            'redirect' => $account_page_url,
        );
        wp_send_json($jobcircle_ret_data);
    }
    
    public function user_register_with_fields($atts) {
        global $jobcircle_framework_options;
        $user_name = isset($atts['user_name']) ? $atts['user_name'] : '';
        $user_email = isset($atts['email']) ? $atts['email'] : '';
        $user_pass = isset($atts['password']) ? $atts['password'] : '';
        $user_role = isset($atts['role']) ? $atts['role'] : '';
        $is_ajax = isset($atts['is_ajax']) ? $atts['is_ajax'] : '';
        $jobcircle_account_approval = isset($atts['jobcircle_account_approval']) ? $atts['jobcircle_account_approval'] : '';

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

            $_user_obj = get_user_by('id', $user_id);
            $atts['set_auth']   = false;

            if($jobcircle_account_approval == 'email_verify'){
                //$jobcircle_verification_key = md5( $user_email . time() );
                $jobcircle_verification_key = wp_generate_password( 20, false );
                // Store verification key for the user
                update_user_meta( $user_id, 'jobcircle_verification_key', $jobcircle_verification_key );
                $jobcircle_protocol     = is_ssl() ? 'https' : 'http';
                $jobcircle_approval_link  = esc_url(                    
                    add_query_arg(
                        array(
                            'jobcircle_user_action' => 'verify_email',
                            'key' => $jobcircle_verification_key,
                            'email' => $user_email,
                        ), 
                        home_url('/', $jobcircle_protocol)
                    )
                );
                $jobcircle_args = array(
                    'jobcircle_user' => $_user_obj,
                    'jobcircle_verify_link' => $jobcircle_approval_link,
                );
                do_action('jobcircle_user_register_verify_email', $jobcircle_args);
            } elseif($jobcircle_account_approval == 'admin_verify'){
                $jobcircle_args = array(
                    'jobcircle_user' => $_user_obj,
                );
                do_action('jobcircle_user_register_pending_approval_email', $jobcircle_args);
            } else {

                $jobcircle_args = array(
                    'jobcircle_user' => $_user_obj,
                );
                do_action('jobcircle_user_register_auto_approval_email', $jobcircle_args);                
                update_user_meta( $user_id, 'jobcircle_user_verified', 'yes' );
                $atts['set_auth']   = true;
            }
            update_user_option($user_id, 'show_admin_bar_front', false);
            
            if (isset($atts['set_auth']) && $atts['set_auth'] === true) {                
                wp_set_current_user($_user_obj->ID, $_user_obj->user_login);
                wp_set_auth_cookie($user_id);
            }
        }
    }
    public function forget_pass_ajax_call() {

        if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }        
        global $jobcircle_framework_options;
        $jobcircle_account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
        $jobcircle_account_page_id = jobcircle_get_page_id_from_name($jobcircle_account_page_name);
        $jobcircle_account_page_url = '';

        if ($jobcircle_account_page_id > 0) {
            $jobcircle_account_page_url = get_permalink($jobcircle_account_page_id);
        }
        $jobcircle_user_email = isset($_POST['email']) ? jobcircle_esc_html($_POST['email']) : '';
    
        if ($jobcircle_user_email == '') {
            $jobcircle_ret_data = array('error' => '1', 'msg' => esc_html__('username/email field cannot be empty.', 'jobcircle-frame'));
            wp_send_json($jobcircle_ret_data);
        }
        
        $jobcircle_user_name = sanitize_user($jobcircle_user_email);
        $jobcircle_user = get_user_by('login', $jobcircle_user_name);
        if (!$jobcircle_user && strpos($jobcircle_user_email, '@')) {
            $jobcircle_user = get_user_by('email', $jobcircle_user_email);
        }
        
        if (!$jobcircle_user) {
            $jobcircle_ret_data = array('error' => '1', 'msg' => esc_html__('email address you entered not exist.', 'jobcircle-frame'));
            wp_send_json($jobcircle_ret_data);
        }

        $jobcircle_password_reset_key = wp_generate_password( 20, false );
        update_user_meta( $jobcircle_user->ID, 'jobcircle_reset_password_key', $jobcircle_password_reset_key );
        update_user_meta( $jobcircle_user->ID, 'jobcircle_reset_password_time', time() );

        $jobcircle_protocol     = is_ssl() ? 'https' : 'http';
        $jobcircle_reset_link  = esc_url(                    
            add_query_arg(
                array(
                    'jobcircle_user_action' => 'reset_password',
                    'key' => $jobcircle_password_reset_key,
                    'login' => rawurlencode($jobcircle_user->user_login),
                ), 
                home_url('/', $jobcircle_protocol)
            )
        );
        $jobcircle_args = array(
            'jobcircle_reset_link' => $jobcircle_reset_link,
            'jobcircle_user' => $jobcircle_user
        );
        do_action('jobcircle_reset_password_email', $jobcircle_args);
        $jobcircle_ret_data = array(
            'msg' => esc_html__('An email has been sent with instructions to reset your password', 'jobcircle-frame'),
            'error' => '0',
            'redirect' => '',
        );
        wp_send_json($jobcircle_ret_data);
    }    
    public function reset_pass_ajax_call() {

        if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }        
        global $jobcircle_framework_options;
        $jobcircle_account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
        $jobcircle_account_page_id = jobcircle_get_page_id_from_name($jobcircle_account_page_name);
        $jobcircle_account_page_url = '';

        if ($jobcircle_account_page_id > 0) {
            $jobcircle_account_page_url = get_permalink($jobcircle_account_page_id);
        }
        $jobcircle_user_login = isset($_POST['user_login']) ? jobcircle_esc_html($_POST['user_login']) : '';
        $jobcircle_user_pass = isset($_POST['user_pass']) ? jobcircle_esc_html($_POST['user_pass']) : '';
        $jobcircle_confirm_pass = isset($_POST['confirm_pass']) ? jobcircle_esc_html($_POST['confirm_pass']) : '';

    
        if (empty($jobcircle_user_login)) {
            $jobcircle_ret_data = array('error' => '1', 'msg' => esc_html__('Username field cannot be empty.', 'jobcircle-frame'));
            wp_send_json($jobcircle_ret_data);
        }  
        
        if (empty($jobcircle_user_pass) || empty($jobcircle_confirm_pass)) {
            $jobcircle_ret_data = array('error' => '1', 'msg' => esc_html__('Password and confirm password are required.', 'jobcircle-frame'));
            wp_send_json($jobcircle_ret_data);
        } elseif ( $jobcircle_user_pass !== $jobcircle_confirm_pass ) {
            $jobcircle_ret_data = array('error' => '1', 'msg' => esc_html__('Confirm password field does not match with the password field.', 'jobcircle-frame'));
            wp_send_json($jobcircle_ret_data);
        }
        
        $jobcircle_user = get_user_by('login', $jobcircle_user_login);

        if( isset($jobcircle_user->ID) ){
            wp_set_password( $jobcircle_user_pass, $jobcircle_user->ID );
            delete_user_meta( $jobcircle_user->ID, 'reset_password_key' );
            delete_user_meta( $jobcircle_user->ID, 'reset_password_time' );

            wp_clear_auth_cookie();
            wp_set_current_user($jobcircle_user->ID, $jobcircle_user->user_login);
            wp_set_auth_cookie($jobcircle_user->ID);
            update_user_caches($jobcircle_user);
            do_action('wp_login', $jobcircle_user->user_login, $jobcircle_user);

            $jobcircle_ret_data = array(
                'msg' => esc_html__('Password updated successfully', 'jobcircle-frame'),
                'error' => '0',
                'redirect' => $jobcircle_account_page_url,
            );
            wp_send_json($jobcircle_ret_data);
        }
        
        $jobcircle_ret_data = array(
            'msg' => esc_html__('User not found. Please try again later.', 'jobcircle-frame') ,
            'error' => '0',
            'redirect' => '',
        );
        wp_send_json($jobcircle_ret_data);
    }    
}
new Jobcircle_Login_Register_Saving;
