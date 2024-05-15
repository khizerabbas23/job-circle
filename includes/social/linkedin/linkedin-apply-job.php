<?php

include(plugin_dir_path(__FILE__) . 'linkedin_oauth2.class.php');

/**
 * Class jobcircle_linkedin_apply_job
 */
class jobcircle_linkedin_apply_job
{

    const _AUTHORIZE_URL = 'https://www.linkedin.com/uas/oauth2/authorization';
    const _TOKEN_URL = 'https://www.linkedin.com/uas/oauth2/accessToken';
    const _BASE_URL = 'https://api.linkedin.com/v2/me';

    private $redirect_url = '';

    /**
     * jobcircle_linkedin_apply_job constructor.
     */
    public function __construct()
    {
        $this->redirect_url = home_url('/?jobcircle_social_action=linkedin');

        add_filter('jobcircle_job_single_social_apply_btns', array($this, 'job_single_apply_btn'), 10, 3);

        add_action('wp', array($this, 'apply_job_call'));

        add_action('wp_ajax_jobcircle_apply_job_with_linkedin_call', array($this, 'apply_job_process'));
        add_action('wp_ajax_nopriv_jobcircle_apply_job_with_linkedin_call', array($this, 'apply_job_process'));
    }

    /**
     * Render the url
     *
     * It displays our Login / Register button
     */
    public function render_url()
    {
        global $jobcircle_framework_options;

        $linkedin_app_id = isset($jobcircle_framework_options['jobcircle_linkedin_app_id']) ? $jobcircle_framework_options['jobcircle_linkedin_app_id'] : '';
        $linkedin_app_secret = isset($jobcircle_framework_options['jobcircle_linkedin_secret']) ? $jobcircle_framework_options['jobcircle_linkedin_secret'] : '';

        $auth_url = '';
        if ($linkedin_app_id != '' && $linkedin_app_secret != '') {
            $oauth = new Wp_Jobcircle_OAuth2Client($linkedin_app_id, $linkedin_app_secret);

            $oauth->redirect_uri = $this->redirect_url;
            $oauth->authorize_url = self::_AUTHORIZE_URL;
            $oauth->token_url = self::_TOKEN_URL;
            $oauth->api_base_url = self::_BASE_URL;

            $state = wp_generate_password(12, false);
            $auth_url = $oauth->authorizeUrl(array('scope' => 'openid profile email', 'state' => $state));
        }

        return $auth_url;
    }

    public function job_single_apply_btn($html, $job_id, $view = 'view-1') {
        global $jobcircle_framework_options;
        $apply_platforms = isset($jobcircle_framework_options['social_apply_platforms']) ? $jobcircle_framework_options['social_apply_platforms'] : '';

        if (!empty($this->render_url()) && !empty($apply_platforms) && in_array('linkedin', $apply_platforms)) {
            $html .= '<a href="javascript:;" class="applyjob-social-btn applyjob-with-linkedin">' . esc_html__('Apply with Linkedin', 'jobcircle-frame') . '</a>';
        }

        add_action('wp_footer', function() use($job_id) {
            ?>
            <script>
                jQuery('.applyjob-with-linkedin').on('click', function() {
                    jQuery.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo admin_url('admin-ajax.php') ?>',
                        data: {
                            id: '<?php echo ($job_id) ?>',
                            action: 'jobcircle_apply_job_with_linkedin_call'
                        },
                        success: function(response) {
                            window.location.href = response.apply_url;
                        },
                        error: function() {
                            
                        }
                    });
                });
            </script>
            <?php
        });

        return $html;
    }

    public function apply_job_process() {
        $job_id = $_POST['id'];
        if ($job_id > 0 && get_post_type($job_id) == 'jobs') {
            setcookie('jobcircle_social_apply_jobid', $job_id, time() + (600), "/");
            wp_send_json(array('error' => '0', 'apply_url' => $this->render_url()));
        }
        wp_send_json(array('error' => '1'));
    }

    public function apply_job_call() {
        if (isset($_GET['jobcircle_social_action']) && $_GET['jobcircle_social_action'] == 'linkedin' && isset($_GET['code'])) {
            global $jobcircle_framework_options;

            $code = $_GET['code'];

            $linkedin_app_id = isset($jobcircle_framework_options['jobcircle_linkedin_app_id']) ? $jobcircle_framework_options['jobcircle_linkedin_app_id'] : '';
            $linkedin_app_secret = isset($jobcircle_framework_options['jobcircle_linkedin_secret']) ? $jobcircle_framework_options['jobcircle_linkedin_secret'] : '';

            if ($linkedin_app_id != '' && $linkedin_app_secret != '') {
                
                $oauth = new Wp_Jobcircle_OAuth2Client($linkedin_app_id, $linkedin_app_secret);

                $oauth->redirect_uri = $this->redirect_url;
                $oauth->authorize_url = self::_AUTHORIZE_URL;
                $oauth->token_url = self::_TOKEN_URL;
                $oauth->api_base_url = self::_BASE_URL;

                $oauth->curl_authenticate_method = 'GET';

                // Request access token
                $response = $oauth->authenticate($code);

                $access_token = '';
                if ($response) {
                    $access_token = $response->{'access_token'};
                }

                if ($access_token != '') {
                    $ch = curl_init('https://api.linkedin.com/v2/userinfo');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , 'Authorization: Bearer ' . $access_token));
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $user_details = json_decode($result);

                    //var_dump($user_details);
                }

                if (isset($user_details->email) && $user_details->email != '') {
                    $email = $user_details->email;
                    $first_name = isset($user_details->given_name) ? $user_details->given_name : '';
                    $last_name = isset($user_details->family_name) ? $user_details->family_name : '';
                    $picture = isset($user_details->picture) ? $user_details->picture : '';

                    if (isset($_COOKIE['jobcircle_social_apply_jobid']) && $_COOKIE['jobcircle_social_apply_jobid'] > 0 && get_post_type($_COOKIE['jobcircle_social_apply_jobid']) == 'jobs') {
                        $job_id = $_COOKIE['jobcircle_social_apply_jobid'];

                        if (!jobcircle_job_applied_with_email($email, $job_id)) {
                            $aplicant_name = $first_name . ' ' . $last_name;
                            $aplicant_notes = '';

                            $my_post = array(
                                'post_title' => $aplicant_name,
                                'post_content' => $aplicant_notes,
                                'post_type' => 'job_applic',
                                'post_status' => 'publish',
                            );
                            if (is_user_logged_in()) {
                                global $current_user;
                                $user_id = $current_user->ID;
                                $my_post['post_author'] = $user_id;
                            }
                            $application_id = wp_insert_post($my_post);
                    
                            update_post_meta($application_id, 'applic_job_id', $job_id);
                            update_post_meta($application_id, 'applic_job_title', '');
                            update_post_meta($application_id, 'applic_user_email', $email);
                            update_post_meta($application_id, 'apply_with_social', 'linkedin');

                            $img_urls = jobcircle_attach_aplieduser_img_by_extrnal_url($picture);
                            update_post_meta($application_id, 'applic_user_pic_urls', $img_urls);

                            if (isset($user_id)) {
                                //
                                $candidate_id = jobcircle_user_candidate_id($user_id);
                                if ($candidate_id) {
                                    update_post_meta($application_id, 'user_cand_id', $candidate_id);
                                    $cand_job_title = get_post_meta($candidate_id, 'jobcircle_field_job_title', true);
                                    if ($cand_job_title != '') {
                                        update_post_meta($application_id, 'applic_job_title', $cand_job_title);
                                    }
                                }
                            }
                        }

                        $to_url = add_query_arg(array('apply_with' => 'social', 'social_platform' => 'linkedin'), get_permalink($job_id));
                        wp_safe_redirect($to_url);
                        exit();
                    }
                }
            }
        }
    }
}

global $jobcircle_linkedin_applyjob_obj;

$jobcircle_linkedin_applyjob_obj = new jobcircle_linkedin_apply_job();
