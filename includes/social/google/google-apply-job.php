<?php
/*
 * Import the Google SDK and load all the classes
 */
include(plugin_dir_path(__FILE__) . 'google-sdk/autoload.php');

/**
 * Class jobcircle_google_apply_job
 */
class jobcircle_google_apply_job
{

    /**
     * Google APP ID
     *
     * @var string
     */

    private $redirect_url = '';

    /**
     * jobcircle_google_apply_job constructor.
     */
    public function __construct()
    {
        $this->redirect_url = home_url('/?jobcircle_social_action=google');

        add_filter('jobcircle_login_social_google_btn', array($this, 'login_with_btn'), 10, 2);

        add_filter('jobcircle_job_single_social_apply_btns', array($this, 'job_single_apply_btn'), 10, 3);

        add_action('wp', array($this, 'apply_job_call'));

        add_action('wp_ajax_jobcircle_apply_job_with_google_call', array($this, 'apply_job_process'));
        add_action('wp_ajax_nopriv_jobcircle_apply_job_with_google_call', array($this, 'apply_job_process'));

        add_action('wp_ajax_jobcircle_login_job_with_google_call', array($this, 'apply_job_process'));
        add_action('wp_ajax_nopriv_jobcircle_login_job_with_google_call', array($this, 'apply_job_process'));
    }

    /**
     * Render the url
     *
     * It displays our Login / Register button
     */
    public function render_url()
    {
        global $jobcircle_framework_options;

        $client_id = isset($jobcircle_framework_options['jobcircle-google-client-id']) ? $jobcircle_framework_options['jobcircle-google-client-id'] : '';
        $client_secret = isset($jobcircle_framework_options['jobcircle-google-client-secret']) ? $jobcircle_framework_options['jobcircle-google-client-secret'] : '';

        $auth_url = '';
        if ($client_id != '' && $client_secret != '') {
            $client = new Google_Client();
            $client->setApplicationName('Login Check');
            $client->setClientId($client_id);
            $client->setClientSecret($client_secret);
            $client->setRedirectUri($this->redirect_url);
            $client->addScope("email");
            $client->addScope("profile");
            $client->setApprovalPrompt("force");

            $service = new Google_Service_Oauth2($client);

            $auth_url = @$client->createAuthUrl();
        }

        return $auth_url;
    }

    public function login_with_btn($html, $view = 'view-1') {
        global $jobcircle_framework_options;
        $login_platforms = isset($jobcircle_framework_options['social_login_platforms']) ? $jobcircle_framework_options['social_login_platforms'] : '';

        if (!empty($this->render_url()) && !empty($login_platforms) && in_array('google', $login_platforms)) {
            $html .= '<a href="javascript:;" class="google login-social-btn socialogin-with-google"><img src="' . Jobcircle_Plugin::root_url() . '/images/google-icon.svg" alt="google"></a>';
        }

        add_action('wp_footer', function() {
            ?>
            <script>
                jQuery('.socialogin-with-google').on('click', function() {
                    jQuery(this).parents('.social-login').append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');

                    jQuery.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo admin_url('admin-ajax.php') ?>',
                        data: {
                            id: 'google',
                            action: 'jobcircle_login_job_with_google_call'
                        },
                        success: function(response) {
                            window.location.href = response.apply_url;
                        },
                        error: function() {
                            //
                        }
                    });
                });
            </script>
            <?php
        }, 12);

        return $html;
    }

    public function job_single_apply_btn($html, $job_id, $view = 'view-1') {
        global $jobcircle_framework_options;
        $apply_platforms = isset($jobcircle_framework_options['social_apply_platforms']) ? $jobcircle_framework_options['social_apply_platforms'] : '';

        if (!empty($this->render_url()) && !empty($apply_platforms) && in_array('google', $apply_platforms)) {
            $html .= '<a href="javascript:;" class="applyjob-social-btn applyjob-with-google">' . esc_html__('Apply with Google', 'jobcircle-frame') . '</a>';
        }

        add_action('wp_footer', function() use($job_id) {
            ?>
            <script>
                jQuery('.applyjob-with-google').on('click', function() {
                    jQuery.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo admin_url('admin-ajax.php') ?>',
                        data: {
                            id: '<?php echo ($job_id) ?>',
                            action: 'jobcircle_apply_job_with_google_call'
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
        } else {
            wp_send_json(array('error' => '0', 'apply_url' => $this->render_url()));
        }
        wp_send_json(array('error' => '1'));
    }

    public function apply_job_call() {
        if (isset($_GET['jobcircle_social_action']) && $_GET['jobcircle_social_action'] == 'google' && isset($_GET['code'])) {
            global $jobcircle_framework_options;

            $code = $_GET['code'];

            $client_id = isset($jobcircle_framework_options['jobcircle-google-client-id']) ? $jobcircle_framework_options['jobcircle-google-client-id'] : '';
            $client_secret = isset($jobcircle_framework_options['jobcircle-google-client-secret']) ? $jobcircle_framework_options['jobcircle-google-client-secret'] : '';

            if ($client_id != '' && $client_secret != '') {
                $client = new Google_Client();
                $client->setApplicationName('Login Check');
                $client->setClientId($client_id);
                $client->setClientSecret($client_secret);
                $client->setRedirectUri($this->redirect_url);
                $client->addScope("email");
                $client->addScope("profile");

                $get_scope = urldecode($_GET['scope']);
                if (strpos($get_scope, 'googleapis') !== false) {
                    $service = new Google_Service_Oauth2($client);

                    $client->authenticate($code);
                    $access_token = $client->getAccessToken();
                    $client->setAccessToken($access_token);
                    $user_details = $service->userinfo->get();

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
                                update_post_meta($application_id, 'apply_with_social', 'google');

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

                            $to_url = add_query_arg(array('apply_with' => 'social', 'social_platform' => 'google'), get_permalink($job_id));
                            wp_safe_redirect($to_url);
                            exit();
                        } else {
                            $user_obj = get_user_by('email', $email);
                            if (isset($user_obj->ID)) {
                                $user_id = $user_obj->ID;
                                wp_set_current_user($user_obj->ID, $user_obj->user_login);
                                wp_set_auth_cookie($user_id);
                            } else {
                                if ($first_name != '' && $last_name != '') {
                                    $username = strtolower($first_name . '-' . $last_name);
                                }
                                $user_name = $username;
                                if (username_exists($user_name)) {
                                    $user_name = substr($email, 0, strpos($email, '@'));
                                    if (username_exists($user_name)) {
                                        $user_name = $user_name . rand(10000, 99999);
                                    }
                                }
                                $user_pass = wp_generate_password(12, false, false, true);
                                $atts = array(
                                    'first_name' => $first_name,
                                    'last_name' => $last_name,
                                    'user_name' => $user_name,
                                    'email' => $email,
                                    'password' => $user_pass,
                                    'role' => 'subscriber',
                                    'is_ajax' => true,
                                    'set_auth' => true,
                                );
                                do_action('jobcircle_user_register_with_fields', $atts);
                            }
                            $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';
    
                            $account_page_id = jobcircle_get_page_id_from_name($account_page_name);
    
                            $account_page_url = home_url('/');
                            if ($account_page_id > 0) {
                                $account_page_url = get_permalink($account_page_id);
                            }
                            wp_safe_redirect($account_page_url);
                            exit();
                        }
                    }
                }
            }
        }
    }
}

global $jobcircle_google_applyjob_obj;

$jobcircle_google_applyjob_obj = new jobcircle_google_apply_job();
