<?php
if (!class_exists('Jobcirlce_Password_Reset_Email')) {
    class Jobcirlce_Password_Reset_Email extends Jobcircle_Email{
        public $jobcircle_default_subject;
        public $jobcircle_default_content;
        public $jobcircle_user;
        public $jobcircle_codes;
        public $jobcircle_reset_link;

        public function __construct()
        {
            add_action('init', array($this, 'jobcirlce_reset_password_template_init'), 1, 0);
            add_action('jobcircle_reset_password_email', array($this, 'jobcircle_reset_password'), 10);        
        }

        public function jobcirlce_reset_password_template_init(){
            $this->jobcircle_default_subject  = esc_html__('Reset password - {sitename}', 'jobcircle-frame');
            $this->jobcircle_default_content  = wp_kses(
                __('Someone requested to reset the password of following account: <br/> Email Address: {account_email} <br/>If this was a mistake, just ignore this email and nothing will happen.<br/>To reset your password, click reset link below:<br/>{reset_link}', 'jobcircle-frame'),
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
                    'display_text' => esc_html__('Name', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_first_name'),
                ),
                array(
                    'var' => '{name}',
                    'display_text' => esc_html__('Name', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_name'),
                ),
                array(
                    'var' => '{email}',
                    'display_text' => esc_html__('Employer Name', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_email'),
                ),
                array(
                    'var' => '{reset_link}',
                    'display_text' => esc_html__('Reset Password Link', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_reset_link'),
                ),
            );
        }

        public function jobcircle_get_first_name(){
            return $this->jobcircle_user->first_name;
        }
        
        public function jobcircle_get_name(){
            return $this->jobcircle_user->display_name;
        }

        public function jobcircle_get_email(){
            return $this->jobcircle_user->user_email;
        }

        public function jobcircle_get_reset_link(){
            return $this->jobcircle_reset_link;
        }

        public function jobcircle_reset_password($jobcircle_params = array()){
            global $jobcircle_framework_options;
            extract($jobcircle_params);

            $this->jobcircle_user       = !empty($jobcircle_user) ? $jobcircle_user : '';
            $this->jobcircle_reset_link = !empty($jobcircle_reset_link) ? $jobcircle_reset_link : '';
            $jobcircle_email_to         = !empty($jobcircle_user->user_email) ? $jobcircle_user->user_email : '';
            $jobcircle_email_to         = $this->jobcircle_get_email();       
            $jobcircle_greeting         = !empty( $jobcircle_framework_options['jobcircle_reset_password_greeting'] ) ? $jobcircle_framework_options['jobcircle_reset_password_greeting'] : esc_html__( 'Hello {name},','jobcircle-frame');
            $jobcircle_subject          = !empty( $jobcircle_framework_options['jobcircle_password_reset_subject'] ) ? $jobcircle_framework_options['jobcircle_password_reset_subject'] : $this->jobcircle_default_subject;
            $jobcircle_email_content    = !empty( $jobcircle_framework_options['jobcircle_reset_password_content'] ) ? $jobcircle_framework_options['jobcircle_reset_password_content'] : $this->jobcircle_default_content;
            $jobcircle_greeting         = $this->jobcircle_replace_variables($jobcircle_greeting, $this->jobcircle_codes);
            $jobcircle_subject          = $this->jobcircle_replace_variables($jobcircle_subject, $this->jobcircle_codes);
            $jobcircle_email_content    = $this->jobcircle_replace_variables($jobcircle_email_content, $this->jobcircle_codes);  
            $jobcircle_body = $this->jobcircle_email_body($jobcircle_email_content, $jobcircle_greeting);
            $jobcircle_body = apply_filters('jobcircle_user_password_reset_content', $jobcircle_body);

            $jobcircle_headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($jobcircle_email_to, $jobcircle_subject, $jobcircle_body, $jobcircle_headers); //send Email  
        }    
    }
    new Jobcirlce_Password_Reset_Email();
}
