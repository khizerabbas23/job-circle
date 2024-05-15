<?php
if (!class_exists('Jobcirlce_User_Register_Email')) {
    class Jobcirlce_User_Register_Email extends Jobcircle_Email{
        public $jobcircle_user_register_subject;
        public $jobcircle_user_register_content;
        public $jobcircle_user_register_email_verify_content;
        public $jobcircle_user_register_email_verify_subject;
        public $jobcircle_user_account_pending_subject;
        public $jobcircle_user_account_pending_content;
        public $jobcircle_user;
        public $jobcircle_codes;
        public $jobcircle_verify_link;

        public function __construct()
        {
            add_action('init', array($this, 'jobcirlce_template_init'), 1, 0);
            add_action('jobcircle_user_register_auto_approval_email', array($this, 'jobcircle_user_register_auto_approval_email'), 10);        
            add_action('jobcircle_user_register_verify_email', array($this, 'jobcircle_user_register_verify_email'), 10);        
            add_action('jobcircle_user_register_pending_approval_email', array($this, 'jobcircle_user_register_pending_approval_email'), 10);   
        }

        public function jobcirlce_template_init(){
            $this->jobcircle_user_register_subject  = esc_html__('Thank you for registration at {sitename}', 'jobcircle-frame');
            $this->jobcircle_user_register_content  = wp_kses(
                __('Thank you for the registration at "{sitename}', 'jobcircle-frame'),
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
            $this->jobcircle_user_register_email_verify_subject  = esc_html__('User Registeration - {sitename}', 'jobcircle-frame');
            $this->jobcircle_user_register_email_verify_content  = wp_kses(
                __('Thank you for the registration at "{sitename}". Please click below to verify your email<br/> {verify_link}', 'jobcircle-frame'),
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
           
            $this->jobcircle_user_account_pending_subject  = esc_html__('User Account Admin Approval - {sitename}', 'jobcircle-frame');
            $this->jobcircle_user_account_pending_content  = wp_kses(
                __('Your account has been created and please wait administrator will approve your account', 'jobcircle-frame'),
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
                array(
                    'var' => '{verify_link}',
                    'display_text' => esc_html__('Verification Link', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_verify_link'),
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

        public function jobcircle_user_register_verify_email($jobcircle_params = array()){
            global $jobcircle_framework_options;
            extract($jobcircle_params);

            $this->jobcircle_user       = !empty($jobcircle_user) ? $jobcircle_user : '';
            $this->jobcircle_verify_link = !empty($jobcircle_verify_link) ? $jobcircle_verify_link : '';
            $jobcircle_email_to         = !empty($jobcircle_user->user_email) ? $jobcircle_user->user_email : '';
            $jobcircle_email_to         = $this->jobcircle_get_email();       
            $jobcircle_greeting         = !empty( $jobcircle_framework_options['jobcircle_user_register_email_verify_greeting'] ) ? $jobcircle_framework_options['jobcircle_user_register_email_verify_greeting'] : esc_html__( 'Hello {name},','jobcircle-frame');
            $jobcircle_subject          = !empty( $jobcircle_framework_options['jobcircle_user_register_email_verify_subject'] ) ? $jobcircle_framework_options['jobcircle_user_register_email_verify_subject'] : $this->jobcircle_user_register_email_verify_subject;
            $jobcircle_email_content    = !empty( $jobcircle_framework_options['jobcircle_user_register_email_verify_content'] ) ? $jobcircle_framework_options['jobcircle_user_register_email_verify_content'] : $this->jobcircle_user_register_email_verify_content;
            $jobcircle_greeting         = $this->jobcircle_replace_variables($jobcircle_greeting, $this->jobcircle_codes);
            $jobcircle_subject          = $this->jobcircle_replace_variables($jobcircle_subject, $this->jobcircle_codes);
            $jobcircle_email_content    = $this->jobcircle_replace_variables($jobcircle_email_content, $this->jobcircle_codes);  
            $jobcircle_body = $this->jobcircle_email_body($jobcircle_email_content, $jobcircle_greeting);
            $jobcircle_body = apply_filters('jobcircle_user_register_email_content', $jobcircle_body);

            $jobcircle_headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($jobcircle_email_to, $jobcircle_subject, $jobcircle_body, $jobcircle_headers); //send Email  
        }    

        public function jobcircle_user_register_pending_approval_email($jobcircle_params = array()){
            global $jobcircle_framework_options;
            extract($jobcircle_params);

            $this->jobcircle_user       = !empty($jobcircle_user) ? $jobcircle_user : '';
            $jobcircle_email_to         = !empty($jobcircle_user->user_email) ? $jobcircle_user->user_email : '';
            $jobcircle_email_to         = $this->jobcircle_get_email();       
            $jobcircle_greeting         = !empty( $jobcircle_framework_options['jobcircle_user_account_pending_greeting'] ) ? $jobcircle_framework_options['jobcircle_user_account_pending_greeting'] : esc_html__( 'Hello {name},','jobcircle-frame');
            $jobcircle_subject          = !empty( $jobcircle_framework_options['jobcircle_user_account_pending_subject'] ) ? $jobcircle_framework_options['jobcircle_user_account_pending_subject'] : $this->jobcircle_user_account_pending_subject;
            $jobcircle_email_content    = !empty( $jobcircle_framework_options['jobcircle_user_account_pending_content'] ) ? $jobcircle_framework_options['jobcircle_user_account_pending_content'] : $this->jobcircle_user_account_pending_content;
            $jobcircle_greeting         = $this->jobcircle_replace_variables($jobcircle_greeting, $this->jobcircle_codes);
            $jobcircle_subject          = $this->jobcircle_replace_variables($jobcircle_subject, $this->jobcircle_codes);
            $jobcircle_email_content    = $this->jobcircle_replace_variables($jobcircle_email_content, $this->jobcircle_codes);  
            $jobcircle_body = $this->jobcircle_email_body($jobcircle_email_content, $jobcircle_greeting);
            $jobcircle_body = apply_filters('jobcircle_user_register_email_content', $jobcircle_body);

            $jobcircle_headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($jobcircle_email_to, $jobcircle_subject, $jobcircle_body, $jobcircle_headers); //send Email  
        }    

        public function jobcircle_user_register_auto_approval_email($jobcircle_params = array()){
            global $jobcircle_framework_options;
            extract($jobcircle_params);

            $this->jobcircle_user       = !empty($jobcircle_user) ? $jobcircle_user : '';
            $jobcircle_email_to         = !empty($jobcircle_user->user_email) ? $jobcircle_user->user_email : '';
            $jobcircle_email_to         = $this->jobcircle_get_email();       
            $jobcircle_greeting         = !empty( $jobcircle_framework_options['jobcircle_user_register_greeting'] ) ? $jobcircle_framework_options['jobcircle_user_register_greeting'] : esc_html__( 'Hello {name},','jobcircle-frame');
            $jobcircle_subject          = !empty( $jobcircle_framework_options['jobcircle_user_register_subject'] ) ? $jobcircle_framework_options['jobcircle_user_register_subject'] : $this->jobcircle_user_register_subject;
            $jobcircle_email_content    = !empty( $jobcircle_framework_options['jobcircle_user_register_content'] ) ? $jobcircle_framework_options['jobcircle_user_register_content'] : $this->jobcircle_user_register_content;
            $jobcircle_greeting         = $this->jobcircle_replace_variables($jobcircle_greeting, $this->jobcircle_codes);
            $jobcircle_subject          = $this->jobcircle_replace_variables($jobcircle_subject, $this->jobcircle_codes);
            $jobcircle_email_content    = $this->jobcircle_replace_variables($jobcircle_email_content, $this->jobcircle_codes);  
            $jobcircle_body = $this->jobcircle_email_body($jobcircle_email_content, $jobcircle_greeting);
            $jobcircle_body = apply_filters('jobcircle_user_register_email_content', $jobcircle_body);

            $jobcircle_headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($jobcircle_email_to, $jobcircle_subject, $jobcircle_body, $jobcircle_headers); //send Email  
        }  
    }
    new Jobcirlce_User_Register_Email();
}
