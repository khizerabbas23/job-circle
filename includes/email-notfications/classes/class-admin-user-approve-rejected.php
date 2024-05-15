<?php
if (!class_exists('Jobcirlce_Admin_User_Approval_Email')) {
    class Jobcirlce_Admin_User_Approval_Email extends Jobcircle_Email{
        public $jobcircle_user_account_approved_subject;
        public $jobcircle_user_account_approved_content;
        public $jobcircle_user_account_rejected_subject;
        public $jobcircle_user_account_rejected_content;
        public $jobcircle_user;
        public $jobcircle_codes;
        public $jobcircle_verify_link;

        public function __construct()
        {
            add_action('init', array($this, 'jobcirlce_template_init'), 1, 0);       
            add_action('jobcircle_user_account_admin_approval_email', array($this, 'jobcircle_user_account_admin_approval_email'), 10);        
            add_action('jobcircle_user_account_admin_rejected_email', array($this, 'jobcircle_user_account_admin_rejected_email'), 10);        
        }

        public function jobcirlce_template_init(){          
            $this->jobcircle_user_account_approved_subject  = esc_html__('Account approved - {sitename}', 'jobcircle-frame');
            $this->jobcircle_user_account_approved_content  = wp_kses(
                __('Congratulations! Your account has been approved', 'jobcircle-frame'),
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
            $this->jobcircle_user_account_rejected_subject  = esc_html__('Account Rejected - {sitename}', 'jobcircle-frame');
            $this->jobcircle_user_account_rejected_content  = wp_kses(
                __('Your account has been rejected', 'jobcircle-frame'),
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
                    'display_text' => esc_html__('First Name', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_last_name'),
                ),
                array(
                    'var' => '{name}',
                    'display_text' => esc_html__('Name', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_name'),
                ),
                array(
                    'var' => '{email}',
                    'display_text' => esc_html__('User Email', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_email'),
                ),
            );
        }

        public function jobcircle_get_first_name(){
            return $this->jobcircle_user->first_name;
        }

        public function jobcircle_get_last_name(){
            return $this->jobcircle_user->last_name;
        }
        
        public function jobcircle_get_name(){
            return $this->jobcircle_user->display_name;
        }

        public function jobcircle_get_email(){
            return $this->jobcircle_user->user_email;
        }

        public function jobcircle_get_verify_link(){
            return $this->jobcircle_verify_link;
        }
        public function jobcircle_user_account_admin_approval_email($jobcircle_params = array()){
            global $jobcircle_framework_options;
            extract($jobcircle_params);

            $this->jobcircle_user       = !empty($jobcircle_user) ? $jobcircle_user : '';
            $jobcircle_email_to         = !empty($jobcircle_user->user_email) ? $jobcircle_user->user_email : '';
            $jobcircle_email_to         = $this->jobcircle_get_email();       
            $jobcircle_greeting         = !empty( $jobcircle_framework_options['jobcircle_user_account_approved_greeting'] ) ? $jobcircle_framework_options['jobcircle_user_account_approved_greeting'] : esc_html__( 'Hello {name},','jobcircle-frame');
            $jobcircle_subject          = !empty( $jobcircle_framework_options['jobcircle_user_account_approved_subject'] ) ? $jobcircle_framework_options['jobcircle_user_account_approved_subject'] : $this->jobcircle_user_account_approved_subject;
            $jobcircle_email_content    = !empty( $jobcircle_framework_options['jobcircle_user_account_approved_content'] ) ? $jobcircle_framework_options['jobcircle_user_account_approved_content'] : $this->jobcircle_user_account_approved_content;
            $jobcircle_greeting         = $this->jobcircle_replace_variables($jobcircle_greeting, $this->jobcircle_codes);
            $jobcircle_subject          = $this->jobcircle_replace_variables($jobcircle_subject, $this->jobcircle_codes);
            $jobcircle_email_content    = $this->jobcircle_replace_variables($jobcircle_email_content, $this->jobcircle_codes);  
            $jobcircle_body = $this->jobcircle_email_body($jobcircle_email_content, $jobcircle_greeting);
            $jobcircle_body = apply_filters('jobcircle_user_account_admin_approval_email_content', $jobcircle_body);

            $jobcircle_headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($jobcircle_email_to, $jobcircle_subject, $jobcircle_body, $jobcircle_headers); //send Email  
        }    
        public function jobcircle_user_account_admin_rejected_email($jobcircle_params = array()){
            global $jobcircle_framework_options;
            extract($jobcircle_params);

            $this->jobcircle_user       = !empty($jobcircle_user) ? $jobcircle_user : '';
            $jobcircle_email_to         = !empty($jobcircle_user->user_email) ? $jobcircle_user->user_email : '';
            $jobcircle_email_to         = $this->jobcircle_get_email();       
            $jobcircle_greeting         = !empty( $jobcircle_framework_options['jobcircle_user_account_rejected_greeting'] ) ? $jobcircle_framework_options['jobcircle_user_account_rejected_greeting'] : esc_html__( 'Hello {name},','jobcircle-frame');
            $jobcircle_subject          = !empty( $jobcircle_framework_options['jobcircle_user_account_rejected_subject'] ) ? $jobcircle_framework_options['jobcircle_user_account_rejected_subject'] : $this->jobcircle_user_account_rejected_subject;
            $jobcircle_email_content    = !empty( $jobcircle_framework_options['jobcircle_user_account_rejected_content'] ) ? $jobcircle_framework_options['jobcircle_user_account_rejected_content'] : $this->jobcircle_user_account_rejected_content;
            $jobcircle_greeting         = $this->jobcircle_replace_variables($jobcircle_greeting, $this->jobcircle_codes);
            $jobcircle_subject          = $this->jobcircle_replace_variables($jobcircle_subject, $this->jobcircle_codes);
            $jobcircle_email_content    = $this->jobcircle_replace_variables($jobcircle_email_content, $this->jobcircle_codes);  
            $jobcircle_body = $this->jobcircle_email_body($jobcircle_email_content, $jobcircle_greeting);
            $jobcircle_body = apply_filters('jobcircle_user_account_admin_approval_email_content', $jobcircle_body);

            $jobcircle_headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($jobcircle_email_to, $jobcircle_subject, $jobcircle_body, $jobcircle_headers); //send Email  
        }    
    }
    new Jobcirlce_Admin_User_Approval_Email();
}
