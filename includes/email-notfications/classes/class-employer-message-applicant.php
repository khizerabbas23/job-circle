<?php
if (!class_exists('Jobcirlce_Employer_Message_To_Applicant_Email')) {
    class Jobcirlce_Employer_Message_To_Applicant_Email extends Jobcircle_Email{
        public $jobcircle_default_subject;
        public $jobcircle_default_content;
        public $jobcircle_user;
        public $jobcircle_employer_user_id;
        public $jobcircle_job_id;
        public $jobcircle_job_title;
        public $jobcircle_applicant_message;
        public $jobcircle_codes;

        public function __construct()
        {
            add_action('init', array($this, 'jobcirlce_employer_applicant_message_init'), 1, 0);
            add_action('jobcircle_employer_applicant_message_email', array($this, 'jobcircle_employer_applicant_message_email'), 10, 2);        
        }

        public function jobcirlce_employer_applicant_message_init(){
            $this->jobcircle_default_subject  = esc_html__('Employer Message - {sitename} for {job_title}', 'jobcircle-frame');
            $this->jobcircle_default_content  = wp_kses(
                __('{employer_name} send message for job {job_title}.<br> Here are the following details:<br> Name: {name}<br> Message: {applicant_message}', 'jobcircle-frame'),
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
                    'display_text' => esc_html__('Last Name', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_name'),
                ),
                array(
                    'var' => '{employer_name}',
                    'display_text' => esc_html__('Employer Name', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_employer_name'),
                ),
                array(
                    'var' => '{job_title}',
                    'display_text' => esc_html__('Job Title', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_job_title'),
                ),
                array(
                    'var' => '{applicant_message}',
                    'display_text' => esc_html__('Message', 'jobcircle-frame'),
                    'function_callback' => array($this, 'jobcircle_get_applicant_message'),
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

        public function jobcircle_get_employer_name(){
            $jobcircle_employer = get_user_by('id', $this->jobcircle_employer_user_id);

            if ( ! is_wp_error( $jobcircle_employer ) ) {
                return $jobcircle_employer->display_name;
            }
            return '';
        }

        public function jobcircle_get_job_title(){
            return $this->jobcircle_job_title;
        }

        public function jobcircle_get_applicant_message(){
            return $this->jobcircle_applicant_message;
        }

        public function jobcircle_get_candidate_email(){
            return $this->jobcircle_user->user_email;
        }

        public function jobcircle_get_admin_email(){
            return get_bloginfo('admin_email');
        }

        public function jobcircle_employer_applicant_message_email($jobcircle_user, $jobcircle_args){
            global $jobcircle_framework_options;
            $this->jobcircle_user               = !empty($jobcircle_user) ? $jobcircle_user : '';
            $this->jobcircle_employer_user_id   = !empty($jobcircle_args['jobcircle_employer_id']) ? $jobcircle_args['jobcircle_employer_id'] : '';
            $this->jobcircle_job_id             = !empty($jobcircle_args['jobcircle_job_id']) ? $jobcircle_args['jobcircle_job_id'] : '';
            $this->jobcircle_job_title          = !empty($jobcircle_args['jobcircle_job_title']) ? $jobcircle_args['jobcircle_job_title'] : '';
            $this->jobcircle_applicant_message  = !empty($jobcircle_args['jobcircle_applicant_message']) ? $jobcircle_args['jobcircle_applicant_message'] : '';
            
            $jobcircle_email_to         = $this->jobcircle_get_candidate_email(); 
            $jobcircle_greeting         = !empty( $jobcircle_framework_options['jobcircle_applicant_message_greeting'] ) ? $jobcircle_framework_options['jobcircle_applicant_message_greeting'] : esc_html__( 'Hello {name},','jobcircle-frame');
            $jobcircle_email_subject    = !empty( $jobcircle_framework_options['jobcircle_applicant_message_subject'] ) ? $jobcircle_framework_options['jobcircle_applicant_message_subject'] : $this->jobcircle_default_subject;
            $jobcircle_email_content    = !empty( $jobcircle_framework_options['jobcircle_applicant_message_content'] ) ? $jobcircle_framework_options['jobcircle_applicant_message_content'] : $this->jobcircle_default_content;
            $jobcircle_greeting         = $this->jobcircle_replace_variables($jobcircle_greeting, $this->jobcircle_codes);
            $jobcircle_subject          = $this->jobcircle_replace_variables($jobcircle_email_subject, $this->jobcircle_codes);
            $jobcircle_email_content    = $this->jobcircle_replace_variables($jobcircle_email_content, $this->jobcircle_codes);  
            $jobcircle_body             = $this->jobcircle_email_body($jobcircle_email_content, $jobcircle_greeting);
            $jobcircle_body             = apply_filters('jobcircle_employer_applicant_message_content', $jobcircle_body);
            $jobcircle_headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($jobcircle_email_to, $jobcircle_subject, $jobcircle_body, $jobcircle_headers); //send Email  
        }    
    }
    new Jobcirlce_Employer_Message_To_Applicant_Email();
}
