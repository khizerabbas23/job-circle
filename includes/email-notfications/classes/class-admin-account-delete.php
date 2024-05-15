<?php
if (!class_exists('Jobcirlce_Admin_Account_Delete_Email')) {
    class Jobcirlce_Admin_Account_Delete_Email extends Jobcircle_Email{
        public $jobcircle_default_subject;
        public $jobcircle_default_content;
        public $jobcircle_user;
        public $jobcircle_codes;

        public function __construct()
        {
            add_action('init', array($this, 'jobcirlce_deleted_user_init'), 1, 0);
            add_action('deleted_user', array($this, 'jobcircle_deleted_user'), 10, 3);        
        }

        public function jobcirlce_deleted_user_init(){
            $this->jobcircle_default_subject  = esc_html__('User Deleted - {sitename}', 'jobcircle-frame');
            $this->jobcircle_default_content  = wp_kses(
                __('{name} deleted his/her account.<br> Here are the following account details:<br> Name: {name}<br> Username: {user_name}<br> Email: {user_email}', 'jobcircle-frame'),
                array(
                    'a' => array(
                        'href'  => array(),
                        'title' => array()
                    ),
                    'br'        => array(),
                    'em'        => array(),
                    'strong'    => array(),
                )
            );
            $this->jobcircle_codes = array(
                array(
                    'var' => '{first_name}',
                    'display_text' => esc_html__('First Name', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_first_name'),
                ),
                array(
                    'var' => '{last_name}',
                    'display_text' => esc_html__('Last Name', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_last_name'),
                ),
                array(
                    'var' => '{name}',
                    'display_text' => esc_html__('Name', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_name'),
                ),
                array(
                    'var' => '{user_name}',
                    'display_text' => esc_html__('Name', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_username'),
                ),
                array(
                    'var' => '{user_email}',
                    'display_text' => esc_html__('User Email', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_email'),
                ),
            );
        }

        public function jobcircle_get_first_name(){
            return $this->jobcircle_user->first_name;
        }

        public function jobcircle_get_username(){
            return $this->jobcircle_user->user_login;
        }

        public function jobcircle_get_last_name(){
            return $this->jobcircle_user->first_name;
        }
        
        public function jobcircle_get_name(){
            return $this->jobcircle_user->display_name;
        }

        public function jobcircle_get_email(){
            return $this->jobcircle_user->user_email;
        }

        public function jobcircle_get_admin_email(){
            return get_bloginfo('admin_email');
        }

        public function jobcircle_deleted_user($jobcircle_user_id, $jobcircle_reassign, $jobcircle_user){
            global $jobcircle_framework_options;

            $this->jobcircle_user       = !empty($jobcircle_user) ? $jobcircle_user : '';
            $jobcircle_email_to         = $this->jobcircle_get_admin_email();       
            $jobcircle_greeting         = esc_html__( 'Hi,','jobcircle-frame');
            $jobcircle_email_subject    = !empty( $jobcircle_framework_options['jobcircle_admin_account_deletion_subject'] ) ? $jobcircle_framework_options['jobcircle_admin_account_deletion_subject'] : $this->jobcircle_default_subject;
            $jobcircle_email_content    = !empty( $jobcircle_framework_options['jobcircle_admin_account_deletion_content'] ) ? $jobcircle_framework_options['jobcircle_admin_account_deletion_content'] : $this->jobcircle_default_content;
           
            $jobcircle_subject          = $this->jobcircle_replace_variables($jobcircle_email_subject, $this->jobcircle_codes);
            $jobcircle_email_content    = $this->jobcircle_replace_variables($jobcircle_email_content, $this->jobcircle_codes);  
            $jobcircle_body = $this->jobcircle_email_body($jobcircle_email_content, $jobcircle_greeting);
            $jobcircle_body = apply_filters('jobcircle_admin_deleted_user_content', $jobcircle_body);

            $jobcircle_headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($jobcircle_email_to, $jobcircle_subject, $jobcircle_body, $jobcircle_headers); //send Email  
        }    
    }
    new Jobcirlce_Admin_Account_Delete_Email();
}
