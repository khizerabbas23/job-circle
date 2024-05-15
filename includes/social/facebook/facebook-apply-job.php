<?php
session_start();
//include(plugin_dir_path(__FILE__) . 'facebook-sdk/autoload.php');
include(plugin_dir_path(__FILE__) . 'vendor/autoload.php');

use Facebook\Facebook;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Exceptions\FacebookResponseException;

/**
 * Class jobcircle_facebook_apply_job
 */
class jobcircle_facebook_apply_job
{


    private $redirect_url = '';

    /**
     * jobcircle_facebook_apply_job constructor.
     */
    public function __construct()
    {
        $this->redirect_url = home_url('/?jobcircle_social_action=facebook');

        add_filter('jobcircle_login_social_facebook_btn', array($this, 'login_with_btn'), 10, 2);

        add_filter('jobcircle_job_single_social_apply_btns', array($this, 'job_single_apply_btn'), 10, 3);

        add_action('wp', array($this, 'apply_job_call'));

        add_action('wp_ajax_jobcircle_apply_job_with_facebook_call', array($this, 'apply_job_process'));
        add_action('wp_ajax_nopriv_jobcircle_apply_job_with_facebook_call', array($this, 'apply_job_process'));

        add_action('wp_ajax_jobcircle_login_job_with_facebook_call', array($this, 'apply_job_process'));
        add_action('wp_ajax_nopriv_jobcircle_login_job_with_facebook_call', array($this, 'apply_job_process'));
    }

    private function initApi() {

        global $jobcircle_framework_options;

        $facebook_app_id = isset($jobcircle_framework_options['jobcircle-facebook-app-id']) ? $jobcircle_framework_options['jobcircle-facebook-app-id'] : '';
        $facebook_app_secret = isset($jobcircle_framework_options['jobcircle-facebook-app-secret']) ? $jobcircle_framework_options['jobcircle-facebook-app-secret'] : '';

        $facebook = new Facebook([
            'app_id' => $facebook_app_id,
            'app_secret' => $facebook_app_secret,
            'default_graph_version' => 'v2.10',
            'persistent_data_handler' => 'session'
        ]);

        return $facebook;
    }

    /**
     * Render the url
     *
     * It displays our Login / Register button
     */
    public function render_url()
    {
        global $jobcircle_framework_options;

        $facebook_app_id = isset($jobcircle_framework_options['jobcircle-facebook-app-id']) ? $jobcircle_framework_options['jobcircle-facebook-app-id'] : '';
        $facebook_app_secret = isset($jobcircle_framework_options['jobcircle-facebook-app-secret']) ? $jobcircle_framework_options['jobcircle-facebook-app-secret'] : '';

        $auth_url = '';
        if ($facebook_app_id != '' && $facebook_app_secret != '') {
            $fb = $this->initApi();
            if (!is_wp_error($fb)) {
                $helper = $fb->getRedirectLoginHelper();
    
                // Optional permissions
                $permissions = ['email'];
    
                $auth_url = $helper->getLoginUrl($this->redirect_url, $permissions);
            }
        }

        return $auth_url;
    }

    public function login_with_btn($html, $view = 'view-1') {
        global $jobcircle_framework_options;
        $login_platforms = isset($jobcircle_framework_options['social_login_platforms']) ? $jobcircle_framework_options['social_login_platforms'] : '';

        if (!empty($login_platforms) && in_array('facebook', $login_platforms) && !empty($this->render_url()) ) {
            $html .= '<a href="javascript:;" class="facebook login-social-btn socialogin-with-facebook"><img src="' . Jobcircle_Plugin::root_url() . '/images/facebook-icon.svg" alt="Facebook"></a>';
        }

        add_action('wp_footer', function() {
            ?>
            <script>
                jQuery('.socialogin-with-facebook').on('click', function() {
                    jQuery(this).parents('.social-login').append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');

                    jQuery.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo admin_url('admin-ajax.php') ?>',
                        data: {
                            id: 'facebook',
                            action: 'jobcircle_login_job_with_facebook_call'
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
        }, 11);

        return $html;
    }

    public function job_single_apply_btn($html, $job_id, $view = 'view-1') {
        global $jobcircle_framework_options;
        $apply_platforms = isset($jobcircle_framework_options['social_apply_platforms']) ? $jobcircle_framework_options['social_apply_platforms'] : '';

        if (!empty($apply_platforms) && in_array('facebook', $apply_platforms) && !empty($this->render_url()) ) {
            $html .= '<a href="javascript:;" class="applyjob-social-btn applyjob-with-facebook">' . esc_html__('Apply with Facebook', 'jobcircle-frame') . '</a>';
            add_action('wp_footer', function() use($job_id) {
                ?>
                <script>
                    jQuery('.applyjob-with-facebook').on('click', function() {
                        jQuery.ajax({
                            type: "POST",
                            dataType: "json",
                            url: '<?php echo admin_url('admin-ajax.php') ?>',
                            data: {
                                id: '<?php echo ($job_id) ?>',
                                action: 'jobcircle_apply_job_with_facebook_call'
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
        }


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
        if (isset($_GET['jobcircle_social_action']) && $_GET['jobcircle_social_action'] == 'facebook' && isset($_GET['code'])) {
            global $jobcircle_framework_options;

            $code = $_GET['code'];

            $facebook_app_id = isset($jobcircle_framework_options['jobcircle-facebook-app-id']) ? $jobcircle_framework_options['jobcircle-facebook-app-id'] : '';
            $facebook_app_secret = isset($jobcircle_framework_options['jobcircle-facebook-app-secret']) ? $jobcircle_framework_options['jobcircle-facebook-app-secret'] : '';

            if ($facebook_app_id != '' && $facebook_app_secret != '') {
                
                $fb = $this->initApi();

                // We save the token in our instance
                $helper = $fb->getRedirectLoginHelper();

                $access_token = '';
                // Try to get an access token
                try {
                    $access_token = $helper->getAccessToken($this->redirect_url);
                } // When Graph returns an error
                catch (FacebookResponseException $e) {
                    $error = __('Graph returned an error: ', 'jobcircle-frame') . $e->getMessage();
                    exit($error);
                }

                if ($access_token != '') {
                    try {
                        $fb_response = $fb->get('/me?fields=id,name,first_name,last_name,email,link,picture', $access_token);
                    } catch (FacebookResponseException $e) {
                        $error = __('Graph returned an error: ', 'jobcircle-frame') . $e->getMessage();
                        exit($error);
                    }

                    $user_details = $fb_response->getGraphUser();

                    //var_dump($user_details);
                }

                if (isset($user_details['email']) && $user_details['email'] != '') {
                    $email = $user_details['email'];
                    $first_name = isset($user_details['first_name']) ? $user_details['first_name'] : '';
                    $last_name = isset($user_details['last_name']) ? $user_details['last_name'] : '';
                    $picture = isset($user_details['picture']['url']) ? $user_details['picture']['url'] : '';

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
                            update_post_meta($application_id, 'apply_with_social', 'facebook');

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

                        $to_url = add_query_arg(array('apply_with' => 'social', 'social_platform' => 'facebook'), get_permalink($job_id));
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

global $jobcircle_facebook_applyjob_obj;

$jobcircle_facebook_applyjob_obj = new jobcircle_facebook_apply_job();
