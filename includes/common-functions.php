<?php

function jobcircle_pagination($jobcircle_query = '', $return = false) {

    global $wp_query;

    $jobcircle_big = 999999999; // need an unlikely integer

    $jobcircle_cus_query = $wp_query;

    if (!empty($jobcircle_query)) {
        $jobcircle_cus_query = $jobcircle_query;
    }
    //var_dump(str_replace($jobcircle_big, '%#%', esc_url(get_pagenum_link($jobcircle_big))));
    $jobcircle_pagination = paginate_links(array(
        'base' => str_replace($jobcircle_big, '%#%', esc_url(get_pagenum_link($jobcircle_big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $jobcircle_cus_query->max_num_pages,
        'prev_text' => '<i class="jobcircle-icon-arrow-left1"></i> <span>' . esc_html__('', 'jobcircle-frame') . '</span>',
        'next_text' => '<span>' . esc_html__('', 'jobcircle-frame') . '</span> <i class="jobcircle-icon-arrow-right"></i>',
        'type' => 'array'
    ));


    if (is_array($jobcircle_pagination) && sizeof($jobcircle_pagination) > 0) {
        $current_page = max(1, get_query_var('paged')); // Get the current page number
        $total_pages = $jobcircle_cus_query->max_num_pages; 
        $jobcircle_html = '<div class="pagination-block pb-50 pb-md-50 pb-lg-75 pb-xl-100">';
        $jobcircle_html .= '<div class="container d-flex align-items-center justify-content-center">';
        $jobcircle_html .= '<ul class="pagination">';
        if ($current_page == 1) {
             $jobcircle_html .= '<li class="page-item"><a class="page-numbers not-allowed"><span></span> <i class="jobcircle-icon-arrow-left1"></i></a></li>';
        }
        foreach ($jobcircle_pagination as $jobcircle_link) {
            if (strpos($jobcircle_link, 'current') !== false) {
                $jobcircle_html .= '<li class="page-item active"><a class="page-link">' . preg_replace("/[^0-9]/", "", $jobcircle_link) . '</a></li>';
            } else {
                $jobcircle_html .= '<li class="page-item">' . $jobcircle_link . '</li>';
            }
        }
        if ($current_page == $total_pages) {
             $jobcircle_html .= '<li class="page-item"><a class="page-numbers not-allowed"><span></span> <i class="jobcircle-icon-arrow-right"></i></a></li>';
        }
        $jobcircle_html .= '</ul>';

        $jobcircle_html .= '</div>';
        $jobcircle_html .= '</div>';

        if ($return === false) {
            echo ($jobcircle_html);
        } else {
            return $jobcircle_html;
        }
    }
}

// For wp bakery image field
add_action('vc_before_init', function() {
    if (function_exists('vc_add_shortcode_param')) {
        vc_add_shortcode_param('jobcircle_browse_img', 'bassetth_vc_image_browse_field');
    }
});

function bassetth_vc_image_browse_field($settings, $value) {
    $_class = 'wpb_vc_param_value wpb-textinput ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field';
    $id = esc_attr($settings['param_name']) . rand(1000000, 9999999);
    $image_display = $value == '' ? 'none' : 'block';

    $_html = '
    <div class="bkimg-uploder-con">
    <div id="' . $id . '-box" class="jobcircle-browse-med-image" style="display: ' . $image_display . ';">
        <a class="jobcircle-rem-media-b" data-id="' . $id . '"><i class="dashicons-before dashicons-no-alt"></i></a>
        <img id="' . $id . '-img" src="' . $value . '" alt="" />
    </div>';

    $_html .= '<input type="hidden" id="' . $id . '" class="' . esc_html($_class) . '" name="' . esc_attr($settings['param_name']) . '" value="' . $value . '" />';
    $_html .= '<input type="button" class="jobcircle-upload-media jobcircle-bk-btn button" data-id="' . $id . '" value="' . __('Browse', 'jobcircle-frame') . '" />';
    $_html .= '</div>';
    return $_html;
}

function jobcircle_post_page_title() {

	if (function_exists('is_shop') && is_shop()) {
		$jobcircle_page_id = wc_get_page_id('shop');
		echo get_the_title($jobcircle_page_id);
	} else if (is_404()) {
		echo '404';
	} else if (is_page() || is_singular()) {
		echo apply_filters('jobcircle_post_page_title', get_the_title(), get_the_ID());
	} else if (is_search()) {
		printf(__('Search for : %s', 'jobcircle-frame'), '<span>' . get_search_query() . '</span>');
	} else {
		the_archive_title();
	}
}

function jobcircle_icon_picker($name = '', $value = '') {
    $id = rand(10000000, 99999999);
    $html = "
    <script>
    jQuery(document).ready(function ($) {
        var this_icons;
        var rand_num = " . $id . ";
        var e9_element = $('#e9_element_' + rand_num).fontIconPicker({
            theme: 'fip-bootstrap'
        });
        icons_load_call.always(function () {
            this_icons = loaded_icons;
            // Get the class prefix
            var classPrefix = this_icons.preferences.fontPref.prefix,
                icomoon_json_icons = [],
                icomoon_json_search = [];
            $.each(this_icons.icons, function (i, v) {
                icomoon_json_icons.push(classPrefix + v.properties.name);
                if (v.icon && v.icon.tags && v.icon.tags.length) {
                    icomoon_json_search.push(v.properties.name + ' ' + v.icon.tags.join(' '));
                } else {
                    icomoon_json_search.push(v.properties.name);
                }
            });
            // Set new fonts on fontIconPicker
            e9_element.setIcons(icomoon_json_icons, icomoon_json_search);
            // Show success message and disable
            $('#e9_buttons_' + rand_num + ' button').removeClass('btn-primary').addClass('btn-success').text('Successfully loaded icons').prop('disabled', true);
        })
        .fail(function () {
            // Show error message and enable
            $('#e9_buttons_' + rand_num + ' button').removeClass('btn-primary').addClass('btn-danger').text('Error: Try Again?').prop('disabled', false);
        });
    });
    </script>";

    $html .= '
    <input type="text" id="e9_element_' . $id . '" class="jobcircle-icon-pickerr" name="' . $name . '" value="' . $value . '">
    <span id="e9_buttons_' . $id . '" style="display:none">\
        <button autocomplete="off" type="button" class="btn btn-primary">Load from IcoMoon selection.json</button>
    </span>';

    return $html;
}

function get_total_post_count() {
    global $wp_query;
    return $wp_query->found_posts;
}

function jobcircle_get_page_id_from_name($page_name, $post_type = 'page') {
    global $wpdb;
    if ($page_name != '') {
        $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
        $post_query .= " WHERE posts.post_name='{$page_name}' AND posts.post_type='{$post_type}'";
        $post_query .= " LIMIT 1";
        $get_db_res = $wpdb->get_col($post_query);
        if (isset($get_db_res[0])) {
            return $get_db_res[0];
        }
    }
    return 0;
}

function jobcircle_esc_the_input($input) {
    if ($input != '') {
        $input = wp_kses($input, array());
        $input = str_replace(array("='", '="', 'alert(', '<script'), array('', '', '', ''), $input);
    }
    return $input;
}

function jobcircle_esc_the_data($input, $esc_filtr = false) {
    if ($input != '') {
        $input = str_replace(array('alert()', '<script.>'), array('', ''), $input);
        $input = $esc_filtr ? wp_kses($input, array()) : $input;
    }
    return $input;
}

function jobcircle_inhereted_array_field_validation($input, $arr_data = false) {
    if (is_array($input)) {
        $new_valid_input = array();
        if (!empty($input)) {
            foreach ($input as $input_key => $input_val) {
                if (is_array($input_val)) {
                    $new_valid_input[$input_key] = $input_val;
                } else {
                    if ($arr_data) {
                        $new_valid_input[$input_key] = jobcircle_esc_the_data($input_val);
                    } else {
                        $new_valid_input[$input_key] = jobcircle_esc_the_input($input_val);
                    }
                }
            }
        }
        return $new_valid_input;
    }
    return $input;
}

function jobcircle_esc_html($input) {
    if (is_array($input) && !empty($input)) {
        $new_valid_input = array();
        if (!empty($input)) {
            foreach ($input as $input_key => $input_val) {
                if (is_array($input_val)) {
                    $new_valid_input[$input_key] = jobcircle_inhereted_array_field_validation($input_val);
                } else {
                    $new_valid_input[$input_key] = jobcircle_esc_the_input($input_val);
                }
            }
        }
        return $new_valid_input;
    } else {
        if ($input != '') {
            $input = jobcircle_esc_the_input($input);
        }
    }
    return $input;
}

function jobcircle_esc_the_html($input) {
    if (is_array($input) && !empty($input)) {
        $new_valid_input = array();
        if (!empty($input)) {
            foreach ($input as $input_key => $input_val) {
                if (is_array($input_val)) {
                    $new_valid_input[$input_key] = jobcircle_inhereted_array_field_validation($input_val, true);
                } else {
                    $new_valid_input[$input_key] = jobcircle_esc_the_data($input_val);
                }
            }
        }
        return $new_valid_input;
    } else {
        if ($input != '') {
            
            $input = jobcircle_esc_the_data($input);
            
        }
    }
    return $input;
}

function jobcircle_esc_the_textarea($input) {
    $allowed_tags = array();

    $allowed_atts = array(
        'class' => array(),
        'style' => array(),
        'href' => array(),
        'rel' => array(),
        'target' => array(),
        'width' => array(),
        'height' => array(),
        'title' => array(),
    );
    $allowed_tags['label'] = $allowed_atts;
    $allowed_tags['div'] = $allowed_atts;
    $allowed_tags['strong'] = $allowed_atts;
    $allowed_tags['small'] = $allowed_atts;
    $allowed_tags['span'] = $allowed_atts;
    $allowed_tags['table'] = $allowed_atts;
    $allowed_tags['tbody'] = $allowed_atts;
    $allowed_tags['thead'] = $allowed_atts;
    $allowed_tags['tfoot'] = $allowed_atts;
    $allowed_tags['th'] = $allowed_atts;
    $allowed_tags['tr'] = $allowed_atts;
    $allowed_tags['td'] = $allowed_atts;
    $allowed_tags['h1'] = $allowed_atts;
    $allowed_tags['h2'] = $allowed_atts;
    $allowed_tags['h3'] = $allowed_atts;
    $allowed_tags['h4'] = $allowed_atts;
    $allowed_tags['h5'] = $allowed_atts;
    $allowed_tags['h6'] = $allowed_atts;
    $allowed_tags['ol'] = $allowed_atts;
    $allowed_tags['ul'] = $allowed_atts;
    $allowed_tags['li'] = $allowed_atts;
    $allowed_tags['em'] = $allowed_atts;
    $allowed_tags['hr'] = $allowed_atts;
    $allowed_tags['br'] = $allowed_atts;
    $allowed_tags['p'] = $allowed_atts;
    $allowed_tags['a'] = $allowed_atts;
    $allowed_tags['b'] = $allowed_atts;
    $allowed_tags['i'] = $allowed_atts;

    if ($input != '') {
        $input = wp_kses($input, $allowed_tags);
        $input = str_replace(array('alert(', '<script'), array('', ''), $input);
    }
    return $input;
}

function jobcircle_esc_wp_editor($input) {
    if (is_array($input)) {
        $new_valid_input = array();
        if (!empty($input)) {
            foreach ($input as $input_key => $input_val) {
                if (is_array($input_val)) {
                    $new_valid_input[$input_key] = ($input_val);
                } else {
                    $new_valid_input[$input_key] = jobcircle_esc_the_textarea($input_val);
                }
            }
        }
        return $new_valid_input;
    } else {
        $input = jobcircle_esc_the_textarea($input);
    }
    return $input;
}

function jobcircle_currencies_common_list() {
    global $jobcircle_currencies_list;

    $currency_list = array();
    foreach ($jobcircle_currencies_list as $cus_currency_key => $cus_currency) {
        $cur_name = isset($cus_currency['name']) ? $cus_currency['name'] : '';
        $cur_symbol = isset($cus_currency['symbol']) ? $cus_currency['symbol'] : '';
        $currency_list[$cus_currency_key] = $cur_name . ' - ' . $cur_symbol;
    }

    return $currency_list;
}

function jobcircle__public_upload_files_path($dir = '') {
    global $jobcircle__upload_files_extpath;
    
    $cus_dir = 'wp-jobcircle' . ($jobcircle__upload_files_extpath != '' ? '/' . $jobcircle__upload_files_extpath : '');
    
    $sub_dir = isset($dir['subdir']) && $dir['subdir'] != '' ? $dir['subdir'] : '';
    $dir_path = array(
        'path' => $dir['basedir'] . '/' . $cus_dir . $sub_dir,
        'url' => $dir['baseurl'] . '/' . $cus_dir . $sub_dir,
        'subdir' => $sub_dir,
    );
    return $dir_path + $dir;
}

//add_action('init', 'jobcircle_check_public_folder');

function jobcircle_check_public_folder() {
    //global $jobcircle__upload_files_extpath;
    //$jobcircle__upload_files_extpath = 'wp-jobcircle-files';
    
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    WP_Filesystem();
    global $wp_filesystem;

    add_filter('upload_dir', 'jobcircle__public_upload_files_path');
    $wp_upload_dir = wp_upload_dir();
    echo '<pre>';
    var_dump($wp_upload_dir);
    echo '</pre>';

    remove_filter('upload_dir', 'jobcircle__public_upload_files_path');
}

function jobcircle_salary_units_list() {
    $items = [
        'monthly' => esc_html__('Monthly', 'jobcircle-frame'),
        'annually' => esc_html__('Annually', 'jobcircle-frame'),
        'weekly' => esc_html__('Weekly', 'jobcircle-frame'),
        'daily' => esc_html__('Daily', 'jobcircle-frame'),
        'hourly' => esc_html__('Hourly', 'jobcircle-frame'),
    ];

    return $items;
}

function jobcircle_post_location_str($id) {
    $loc_addr = get_post_meta($id, 'jobcircle_field_loc_address', true);
    $loc_city = get_post_meta($id, 'jobcircle_field_loc_city', true);
    $loc_country = get_post_meta($id, 'jobcircle_field_loc_country', true);
    
    if ($loc_city != '' && $loc_country != '') {
        $str = $loc_city . ', ' . $loc_country;
    } else if($loc_city == '' && $loc_country != '') {
        $str = $loc_country;
    } else if($loc_city == '' && $loc_country == '') {
        $str = $loc_addr;
    }
    
    return $str;
}

if (!function_exists('jobcircleTimeElapsedText')) {

    function jobcircleTimeElapsedText($ptime, $before = '', $after = '', $break_time = false)
    {

        if ($ptime != '') {
            $b_time = human_time_diff($ptime, current_time('timestamp'));
            if ($break_time === true) {
                $b_time = explode(' ', $b_time);
                $b_time = implode('<br>', $b_time);
            }
            $date_string = $before . " " . $b_time . " " . esc_html__('ago', 'jobcircle-frame') . $after;
            return $date_string;
        } else {
            return '';
        }
    }
}

add_action('wp_ajax_jobcircle_get_user_address_from_lat_lng', 'jobcircle_get_user_address_from_lat_lng_ajax');
add_action('wp_ajax_nopriv_jobcircle_get_user_address_from_lat_lng', 'jobcircle_get_user_address_from_lat_lng_ajax');

function jobcircle_get_user_address_from_lat_lng_ajax() {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];

    $res = jobcircle_get_user_address_from_lat_lng($lat, $lng);

    wp_send_json($res);
}

function jobcircle_get_user_address_from_lat_lng($lat, $lng) {
    global $jobcircle_framework_options;

    $response_array = array();
    $response_array['address'] = '';

    $mapbox_api_key = isset($jobcircle_framework_options['mapbox_access_token']) ? $jobcircle_framework_options['mapbox_access_token'] : '';

    $geo_loc_url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' . $lng . ',' . $lat . '.json?access_token=' . $mapbox_api_key;
    $location_geo = wp_remote_get($geo_loc_url);
    if (!is_wp_error($location_geo)) {
        if (isset($location_geo['body'])) {
            $cords_info = json_decode($location_geo['body'], true);
            $format_address = isset($cords_info['features'][0]['place_name']) ? $cords_info['features'][0]['place_name'] : '';
            $cords = isset($cords_info['features'][0]['geometry']['coordinates']) ? $cords_info['features'][0]['geometry']['coordinates'] : '';
            $latitude = isset($cords[1]) ? $cords[1] : '';
            $longitude = isset($cords[0]) ? $cords[0] : '';

            $response_array['address'] = $format_address;
        }
    }

    return $response_array;
}

if(!function_exists('jobcircle_check_page_permissions')){
    function jobcircle_check_page_permissions($user_type,$page_name){
        global $current_user, $jobcircle_framework_options;
        $user_id = $current_user->ID;

        $status = 1;

        if(isset($jobcircle_framework_options['employer_profile_package']) && ($jobcircle_framework_options['employer_profile_package'] == "on") && ($user_type == "employer")){
            $status = 0;
            $employer_id = jobcircle_user_employer_id($user_id);  
            if(($employer_id) && ($employer_id > 0)){

                $employer_purchased_packages = get_post_meta($employer_id,'employer_purchased_packages',true);

                $cf_name = '';
                $cf_result = 0;
                if($page_name == 'post-job'){
                    $cf_name = 'order_emp_post_new_job';

                }elseif($page_name == 'manage-jobs'){
                    $cf_name = 'order_emp_manage_jobs';

                }elseif($page_name == 'manage-applicants'){
                    $cf_name = 'order_emp_manage_applicants';

                }elseif($page_name == 'saved-resumes'){
                    $cf_name = 'order_emp_bookmark_resumes';

                }elseif($page_name == 'packages'){
                    $cf_name = 'order_emp_packages';
                }

                if($employer_purchased_packages){
                    $explode_emp_purchased_packages = explode(",",$employer_purchased_packages);
                    if($explode_emp_purchased_packages){
                        foreach($explode_emp_purchased_packages as $emp_purchased_package){
                            $purchased_package_id = $emp_purchased_package;
                            if($cf_name){
                                $cf_result = get_post_meta($purchased_package_id, $cf_name , true);
                            }
                        }

                        if($cf_result === 1 || $cf_result == "on"){
                            $team_member_access = jobcircle_check_team_member_page_permissions($page_name);

                            if($team_member_access === 1){
                                $status = 1;
                            }
                        }
                    }
                }
            }


        }elseif(isset($jobcircle_framework_options['employer_profile_package']) && ($jobcircle_framework_options['employer_profile_package'] == "on") && ($user_type == "candidate")){
            $status = 0;
            $candidate_id = jobcircle_user_candidate_id($user_id);  
            if(($candidate_id) && ($candidate_id > 0)){

                $candidate_purchased_packages = get_post_meta($candidate_id,'candidate_purchased_packages',true);

                $cf_name = '';
                $cf_result = 0;
                if($page_name == 'my-resume'){
                    $cf_name = 'candidate_my_resume';

                }elseif($page_name == 'resume-manager'){
                    $cf_name = 'candidate_cv_manager';

                }elseif($page_name == 'applied-jobs'){
                    $cf_name = 'candidate_applied_jobs';

                }elseif($page_name == 'saved-jobs'){
                    $cf_name = 'candidate_bookmark_jobs';

                }elseif($page_name == 'job-alerts'){
                    $cf_name = 'candidate_job_alerts';

                }elseif($page_name == 'packages'){
                    $cf_name = 'candidate_packages';
                }

                if($candidate_purchased_packages){
                    $explode_candidate_purchased_packages = explode(",",$candidate_purchased_packages);
                    if($explode_candidate_purchased_packages){
                        foreach($explode_candidate_purchased_packages as $cand_purchased_packages){
                            $purchased_package_id = $cand_purchased_packages;
                            if($cf_name){
                                $cf_result = get_post_meta($purchased_package_id, $cf_name , true);
                            }
                        }

                        if($cf_result === 1 || $cf_result == "on"){
                            $status = 1;
                        }
                    }
                }
            }
        }

        return $status;
    }
}

if (!function_exists('jobcircle_recaptcha')) {

    function jobcircle_recaptcha($id = '')
    {
        global $jobcircle_framework_options;
        $captcha_switch = isset($jobcircle_framework_options['captcha_switch']) ? $jobcircle_framework_options['captcha_switch'] : '';
        $sitekey = isset($jobcircle_framework_options['captcha_sitekey']) ? $jobcircle_framework_options['captcha_sitekey'] : '';
        $secretkey = isset($jobcircle_framework_options['captcha_secretkey']) ? $jobcircle_framework_options['captcha_secretkey'] : '';
        $output = '';
        if ($captcha_switch == 'on') {
            wp_enqueue_script('jobcircle_google_recaptcha');
            if ($sitekey != '' && $secretkey != '') {
                $output .= '<div class="g-recaptcha" data-theme="light" id="' . $id . '" data-sitekey="' . $sitekey . '">'
                    . '</div> <a class="recaptcha-reload-a" href="javascript:void(0);" onclick="jobcircle_captcha_reload(\'' . admin_url('admin-ajax.php') . '\', \'' . $id . '\');">'
                    . '<i class="fa fa-refresh"></i> ' . esc_html__('Reload', 'jobcircle-frame') . '</a>';
            } else {
                $output = '<p>' . esc_html__('Please provide google captcha API keys', 'jobcircle-frame') . '</p>';
            }
        }
        return $output;
    }

}

/*
 * Start Function for create form validation/verify captcha
 */
if (!function_exists('jobcircle_captcha_verify')) {

    function jobcircle_captcha_verify($page = '')
    {
        global $jobcircle_framework_options;
        $jobcircle_captcha = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
        $captcha_switch = isset($jobcircle_framework_options['captcha_switch']) ? $jobcircle_framework_options['captcha_switch'] : '';
        if ($captcha_switch == 'on') {
            if ($page == true) {
                if (empty($jobcircle_captcha)) {
                    return true;
                }
            } else {
                $json = array();
                if (empty($jobcircle_captcha)) {
                    $msg = esc_html__('Please fill the captcha field.', 'jobcircle-frame');
                    $json['error'] = '1';
                    $json['msg'] = $msg;
                    echo json_encode($json);
                    exit();
                }
            }
        }
    }

}

/*
 * Start Function for create captcha reload
 */
if (!function_exists('jobcircle_captcha_reload')) {

    function jobcircle_captcha_reload($atts = '')
    {
        global $jobcircle_framework_options;
        $captcha_id = isset($_REQUEST['captcha_id']) ? $_REQUEST['captcha_id'] : '';
        $sitekey = isset($jobcircle_framework_options['captcha_sitekey']) ? $jobcircle_framework_options['captcha_sitekey'] : '';
        $html = "<script>
        var " . $captcha_id . ";
            " . $captcha_id . " = grecaptcha.render('" . $captcha_id . "', {
                'sitekey': '" . $sitekey . "', //Replace this with your Site key
                'theme': 'light'
            });"
            . "</script>";
        $html .= jobcircle_recaptcha($captcha_id);
        echo force_balance_tags($html);
        die();
    }

    add_action('wp_ajax_jobcircle_captcha_reload', 'jobcircle_captcha_reload');
    add_action('wp_ajax_nopriv_jobcircle_captcha_reload', 'jobcircle_captcha_reload');
}


if (!function_exists('jobcircle_check_team_member_page_permissions')) {
    function jobcircle_check_team_member_page_permissions($pagename){
        $jobcircle_employer_team_member_id = 0;
    
        $page_access = 1;
    
        if(isset($_SESSION['jobcircle_employer_team_member_id']) && $_SESSION['jobcircle_employer_team_member_id'] > 0){
            $jobcircle_employer_team_member_id = $_SESSION['jobcircle_employer_team_member_id'];
    
            $page_access = 0;
    
            $get_team_member_access = get_user_meta($jobcircle_employer_team_member_id, 'team_member_access', true);
            $explode_team_member_access = explode(",",$get_team_member_access);
    
            $find_access = '';
            if($pagename == "post-job"){
                $find_access = 'post_new_job';
    
            }elseif($pagename == "manage-jobs"){
                $find_access = 'manage_jobs';
                
            }elseif($pagename == "manage-applicants"){
                $find_access = 'manage_applicants';
                
            }elseif($pagename == "saved-resumes"){
                $find_access = 'bookmark_resumes';
                
            }elseif($pagename == "packages"){
                $find_access = 'packages';            
            }
    
    
            if(($find_access) && in_array($find_access, $explode_team_member_access)){
                $page_access = 1;
            }
        }
    
        return $page_access;
    }
}

function jobcircle_terms_and_con_link_txt()
{
    global $jobcircle_framework_options;
    $terms_page = isset($jobcircle_framework_options['terms_conditions_page']) ? $jobcircle_framework_options['terms_conditions_page'] : '';
    $terms_page_id = jobcircle_get_page_id_from_name($terms_page, 'page');
    $privcy_page_id = get_option('wp_page_for_privacy_policy');

    $terms_page_url = '';
    if ($terms_page_id > 0) {
        $terms_page_url = get_permalink($terms_page_id);
    }

    ob_start();
    if ($privcy_page_id != '') {
        ?>
        <span class="label-text"> <?php echo wp_kses(sprintf(__('By hitting checkbox, you agree to our <a href="%s" class="link" target="_blank">Terms and Conditions</a> and <a href="%s" class="link" target="_blank">Privacy Policy</a>', 'jobcircle-frame'), $terms_page_url, get_permalink($privcy_page_id)), array('a' => array('href' => array(), 'target' => array(), 'title' => array(), 'class' => array()))) ?>
        </span>
        <?php
    } else {
        ?>
        <span class="label-text"> <?php echo wp_kses(sprintf(__('By hitting checkbox, you agree to our <a href="%s" class="link" target="_blank">Terms and Conditions</a>', 'jobcircle-frame'), $terms_page_url), array('a' => array('href' => array(), 'target' => array(), 'title' => array(), 'class' => array()))) ?>
        </span>
        <?php
    }
    $terms_html = ob_get_clean();
    echo apply_filters('jobcircle_terms_nd_policy_txthtml', $terms_html, $terms_page_url, $privcy_page_id);
}

add_action('wp_ajax_jobcircle_dash_user_account_del', function() {    
    if (!check_ajax_referer('jobcircle-form-nonce', '_nonce', false)) {
        $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }
    $user_id = get_current_user_id();
    wp_delete_user($user_id);
    wp_send_json(array('error' => '0', 'msg' => esc_html__('Your account has been deleted successfully.', 'jobcircle-frame')));
});