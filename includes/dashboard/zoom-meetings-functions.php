<?php

defined('ABSPATH') || exit;

class Jobcircle_Zoom_Meetings_Functions {
    
    public function __construct() {
        
        add_filter('jobcircle_dashboard_zoom_get_auth_btn', array($this, 'zoom_get_auth_btn'), 10, 2);

        add_action('wp', array($this, 'get_access_token_zoom'));
    }

    public function zoom_get_auth_btn($html, $employer_id) {
        $zoom_client_id = get_post_meta($employer_id, 'jobcircle_field_zoom_client_id', true);
        $zoom_client_secret = get_post_meta($employer_id, 'jobcircle_field_zoom_client_secret', true);

        if ($zoom_client_id != '' && $zoom_client_secret != '') {
            $redirect_uri = home_url('/');
            $refresh_token = get_post_meta($employer_id, 'jobcircle_zoom_refresh_token', true);
            
            ob_start();
            if ($refresh_token != '') {
                ?>
                <div class="zoom-auth-btncon">
                    <p style="color: #34a853;"><?php esc_html_e('You are connected with Zoom app', 'jobcircle-frame') ?></p>
                </div>
                <?php
            } else {
                ?>
                <div class="zoom-auth-btncon">
                    <a href="javascript:;" class="jobcircle-zoom-authbtn jobcircle-formsubmit-btn"><?php esc_html_e('Connect with Zoom', 'jobcircle-frame') ?></a>
                </div>
                <?php
            }
            ?>
            <hr style="margin: 30px 0;">
            <?php
            $html .= ob_get_clean();

            add_action('wp_footer', function() use($zoom_client_id) {
                $state = base64_encode('zoom_auth_state');

                //$redirect_uri = home_url('/');
                $redirect_uri = 'https://fits.miraclesoftsolutions.com/';
                ?>
                <script>
                    jQuery('.jobcircle-zoom-authbtn').on('click', function() {
                        var zoom_auth_win = window.open('https://zoom.us/oauth/authorize?response_type=code&state=<?php echo ($state) ?>&client_id=<?php echo ($zoom_client_id) ?>&redirect_uri=<?php echo ($redirect_uri) ?>',
                        '', 'scrollbars=no,menubar=no,resizable=yes,toolbar=no,status=no,width=800, height=400');
                        var auth_window_timer = setInterval(function () {
                            if (zoom_auth_win.closed) {
                                clearInterval(auth_window_timer);
                                window.location.reload();
                            }
                        }, 500);
                    });
                </script>
                <?php
            }, 25);
        }

        return $html;
    }

    private function access_token_code_curl($code) {

        $user_id = get_current_user_id();
        $employer_id = jobcircle_user_employer_id($user_id);
        
        $client_id = get_post_meta($employer_id, 'jobcircle_field_zoom_client_id', true);
        $client_secret = get_post_meta($employer_id, 'jobcircle_field_zoom_client_secret', true);

        //$redirect_uri = home_url('/');
        $redirect_uri = 'https://fits.miraclesoftsolutions.com/';

        $data = array(
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect_uri,
        );
        $data_str = http_build_query($data);

        $url = 'https://zoom.us/oauth/token';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        // make sure we are POSTing
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
        // allow us to use the returned data from the request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //we are sending json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($client_id . ':' . $client_secret),
        ));

        $result_token = curl_exec($ch);
        curl_close($ch);

        return $result_token;
    }

    private function refresh_token_code_curl($refresh_token) {

        $user_id = get_current_user_id();
        $employer_id = jobcircle_user_employer_id($user_id);
        
        $client_id = get_post_meta($employer_id, 'jobcircle_field_zoom_client_id', true);
        $client_secret = get_post_meta($employer_id, 'jobcircle_field_zoom_client_secret', true);

        //$redirect_uri = home_url('/');
        $redirect_uri = 'https://fits.miraclesoftsolutions.com/';

        $data = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'redirect_uri' => $redirect_uri,
        );
        $data_str = http_build_query($data);

        $url = 'https://zoom.us/oauth/token';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        // make sure we are POSTing
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
        // allow us to use the returned data from the request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //we are sending json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($client_id . ':' . $client_secret),
        ));

        $result_token = curl_exec($ch);
        curl_close($ch);

        return $result_token;
    }

    public function get_access_token_zoom() {
        $state = base64_encode('zoom_auth_state');
        if (isset($_GET['state']) && $_GET['state'] == $state && isset($_GET['code']) && $_GET['code'] != '') {

            $user_id = get_current_user_id();
            $employer_id = jobcircle_user_employer_id($user_id);

            $code = $_GET['code'];

            $result_token = $this->access_token_code_curl($code);

            $result_token = json_decode($result_token, true);

            if (isset($result_token['access_token']) && $result_token['access_token'] != '') {
                $refresh_token = isset($result_token['refresh_token']) ? $result_token['refresh_token'] : '';
                update_post_meta($employer_id, 'jobcircle_zoom_refresh_token', $refresh_token);
                echo '<script>window.close();</script>';
                die;
            }
        }
    }
}

new Jobcircle_Zoom_Meetings_Functions;