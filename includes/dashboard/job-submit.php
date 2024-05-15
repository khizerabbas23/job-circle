<?php

defined('ABSPATH') || exit;

class Jobcircle_Dashboard_Job_Save_Class {
    
    public function __construct() {
        add_action('wp_ajax_jobcircle_dash_job_post_call', array($this, 'job_post_save'));
        add_action('wp_ajax_jobcircle_dash_empjob_remove_call', array($this, 'job_remove'));

        add_action('wp_ajax_jobcircle_job_content_with_ai_call', array($this, 'job_content_with_ai_call'));
    }

    public function job_remove() {
        global $current_user;
        $user_id = $current_user->ID;

        $job_id = isset($_POST['id']) ? $_POST['id'] : '';

        $is_employer_job = jobcircle_is_employer_job($job_id, $user_id);

        if (!$is_employer_job) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('You cannot remove this job.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        wp_delete_post($job_id, true);

        $ret_data = array('error' => '0', 'msg' => esc_html__('Job deleted.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    public function job_post_save() {
        global $current_user, $jobcircle_framework_options;
        $user_id = $current_user->ID;

        $updatin_job = false;

        $job_id = isset($_POST['job_id']) ? $_POST['job_id'] : '';
        $job_title = isset($_POST['job_title']) ? $_POST['job_title'] : '';
        $jobcircle_field_min_salary = isset($_POST['jobcircle_field_min_salary']) ? sanitize_text_field($_POST['jobcircle_field_min_salary']) : '';
        $jobcircle_field_max_salary = isset($_POST['jobcircle_field_max_salary']) ? sanitize_text_field($_POST['jobcircle_field_max_salary']) : '';

        
        $desc = $_POST['job_content'];
        if (empty($desc)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please Enter Job Description', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        $desc = trim(apply_filters('the_content', $desc));

        $employer_id = jobcircle_user_employer_id($user_id);
        if (!$employer_id) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('You are not an Employer/Company.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        if ($job_id > 0 && get_post_type($job_id) == 'jobs') {
            $job_upd = true;
        }
        if (isset($job_upd)) {
            $updatin_job = jobcircle_is_employer_job($job_id, $user_id);
        }

        if ($job_title == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill the job title field first.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        if ($desc == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill the job description field first.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        if (empty($jobcircle_field_min_salary) || empty($jobcircle_field_max_salary)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill the min salary and max salary field', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        if (!$updatin_job) {
            $free_job_post = isset($jobcircle_framework_options['free_job_post']) ? $jobcircle_framework_options['free_job_post'] : '';
            if ($free_job_post == 'off') {
                $selected_pkg = isset($_REQUEST['job_pckg']) && $_REQUEST['job_pckg'] > 0 ? $_REQUEST['job_pckg'] : 0;
                $order_expired = jobcircle_employer_jobs_pkg_expired($selected_pkg);
                if ($order_expired) {
                    $ret_data = array('error' => '1', 'msg' => esc_html__('You don\'t have any package. Please buy a package first to post a job.', 'jobcircle-frame'));
                    wp_send_json($ret_data);
                }
                $pkg_order_id = $selected_pkg;
            }
            $my_post = array(
                'post_title' => jobcircle_esc_html($job_title),
                'post_content' => jobcircle_esc_wp_editor($desc),
                'post_type' => 'jobs',
                'post_status' => 'publish',
                'post_author' => $user_id,
            );
            $job_id = wp_insert_post($my_post);
            if (isset($pkg_order_id) && $job_id > 0 && get_post_type($job_id) == 'jobs') {
                jobcircle_employer_jobs_pkg_consume($selected_pkg, $job_id);
            }
        } else {
            $upd_post = array(
                'ID' => $job_id,
                'post_title' => jobcircle_esc_html($job_title),
                'post_content' => jobcircle_esc_wp_editor($desc),
            );
            wp_update_post($upd_post);
        }

        if (isset($_POST['job_cat']) && $_POST['job_cat'] > 0) {
            $cats_to_save = array($_POST['job_cat']);
            wp_set_post_terms($job_id, $cats_to_save, 'job_category', false);
        }

        if (isset($_POST['job_skills']) && $_POST['job_skills'] != '') {
            $job_skills = $_POST['job_skills'];
            $job_skills = str_replace(array(', '), array(','), $job_skills);
            $job_skills = explode(',', $job_skills);
            wp_set_post_terms($job_id, $job_skills, 'job_skill', false);
        }

        // Attachments ////////////////////////
        $gal_ids_arr = array();

        $max_gal_imgs_allow = 10;

        if (isset($_POST['jobcircle_field_job_attachment_files']) && !empty($_POST['jobcircle_field_job_attachment_files'])) {
            $gal_ids_arr = array_merge($gal_ids_arr, $_POST['jobcircle_field_job_attachment_files']);
        }

        $gal_imgs_count = 0;
        if (!empty($gal_ids_arr)) {
            $gal_imgs_count = sizeof($gal_ids_arr);
        }

        $gall_ids = jobcircle_attachments_upload('job_attach_files', $gal_imgs_count);
        if (!empty($gall_ids)) {
            $gal_ids_arr = array_merge($gal_ids_arr, $gall_ids);
        }
        if (!empty($gal_ids_arr) && $max_gal_imgs_allow > 0) {
            $gal_ids_arr = array_slice($gal_ids_arr, 0, $max_gal_imgs_allow, true);
        }
        update_post_meta($job_id, 'jobcircle_field_job_attachment_files', $gal_ids_arr);

        //

        // Video ////////////////////////
        $video_url = jobcircle_video_upload('job_attach_video');
        if ($video_url && $video_url != '') {
            update_post_meta($job_id, 'jobcircle_field_job_video_url', $video_url);
        } else if (isset($_POST['jobcircle_field_job_video_url'])) {
            $video_url = jobcircle_esc_html($_POST['jobcircle_field_job_video_url']);
            update_post_meta($job_id, 'jobcircle_field_job_video_url', $video_url);
        }

        // custom fields
        if (isset($_POST['jobcircle_cstmfield'])) {
            $cstm_fields = $_POST['jobcircle_cstmfield'];
            if (!empty($cstm_fields)) {
                foreach ($cstm_fields as $cstm_filed_name => $cstm_filed_val) {
                    $cstm_filed_val =  isset($cstm_filed_val[0]) ? $cstm_filed_val[0] : $cstm_filed_val;
                    update_post_meta($job_id, $cstm_filed_name, $cstm_filed_val);
                }
            }
        }

        $msg = esc_html__('Job posted successfully.', 'jobcircle-frame');
        if ($updatin_job) {
            $msg = esc_html__('Job updated successfully.', 'jobcircle-frame');
        }

        $ret_data = array('error' => '0', 'msg' => $msg);
        wp_send_json($ret_data);
    }

    public function job_content_with_ai_call() {

        global $jobcircle_framework_options;

        $openai_api_key = isset($jobcircle_framework_options['openai_api_key']) ? $jobcircle_framework_options['openai_api_key'] : '';

        $title_str = esc_html($_POST['title']);

        if ($title_str == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please add job title first.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        $request_body = [
            "model" => "gpt-3.5-turbo",
            "messages" => [array("role" => "user", "content" => $title_str . ' job description')],
            "temperature" => 0.7,

        ];

        $postfields = json_encode($request_body);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.openai.com/v1/chat/completions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $openai_api_key
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $response_data = '';
        if (!$err) {
            $response_data = json_decode($response, true);
        }

        if (isset($response_data['choices'][0]['message']['content']) && !empty($response_data['choices'][0]['message']['content'])) {
    
            $resp_return_cont = $response_data['choices'][0]['message']['content'];
            //$resp_return_cont = str_replace(array('<br />'), array("\\"), nl2br($resp_return_cont));
            $ret_data = array('error' => '0', 'content' => $resp_return_cont, 'msg' => esc_html__('Content created successfully.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        $ret_data = array(
            'error' => '1', 
            'msg' => esc_html__('There is some error with content writting api.', 'jobcircle-frame')
        );
        wp_send_json($ret_data);
    }

}
new Jobcircle_Dashboard_Job_Save_Class;