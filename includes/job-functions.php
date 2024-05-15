<?php

function jobcircle_job_thumbnail_url($job_id) {
    $def_img_url = Jobcircle_Plugin::root_url() . 'images/briefcase.png';
    $img_thumb_id = get_post_thumbnail_id($job_id);
    $img_url = '';
    if ($img_thumb_id > 0) {
        $img_url = wp_get_attachment_image_url($img_thumb_id, 'large');
    }
    if ($img_url == '') {
        $job_post = get_post($job_id);
        $author_id = isset($job_post->post_author) ? $job_post->post_author : '';
        $employer_id = jobcircle_user_employer_id($author_id);
        if ($employer_id > 0 && get_post_type($employer_id) == 'employer') {
            $img_thumb_id = get_post_thumbnail_id($employer_id);
            if ($img_thumb_id > 0) {
                $img_url = wp_get_attachment_image_url($img_thumb_id, 'large');
            }
        }
    }
    if ($img_url == '') {
        $img_url = $def_img_url;
    }

    return $img_url;
}

function jobcircle_thousand_format($number) {
    $number = (int) preg_replace('/[^0-9]/', '', $number);
    if ($number >= 1000) {
        $rn = round($number);
        $format_number = number_format($rn);
        $ar_nbr = explode(',', $format_number);
        $x_parts = array('K', 'M', 'B', 'T', 'Q');
        $x_count_parts = count($ar_nbr) - 1;
        $dn = $ar_nbr[0] . ((int) $ar_nbr[1][0] !== 0 ? '.' . $ar_nbr[1][0] : '');
        $dn .= $x_parts[$x_count_parts - 1];

        return $dn;
    }
    return $number;
}

function jobcircle_job_salary_str($job_id, $type = '', $unit_tag = '') {
    global $jobcircle_framework_options, $jobcircle_currencies_list;
    $jobcircle_default_curr = isset($jobcircle_framework_options['jobcircle_default_curr']) ? $jobcircle_framework_options['jobcircle_default_curr'] : '';
    
    $min_salary = get_post_meta($job_id, 'jobcircle_field_min_salary', true);
    $max_salary = get_post_meta($job_id, 'jobcircle_field_max_salary', true);
    $salary_unit = get_post_meta($job_id, 'jobcircle_field_salary_unit', true);

    $salry_units = jobcircle_salary_units_list();
    $salary_unit_str = isset($salry_units[$salary_unit]) ? $salry_units[$salary_unit] : esc_html__('Daily', 'jobcircle-frame');
    
    $min_salary = $min_salary != '' ? preg_replace("/[^0-9.]/", '', $min_salary) : 0;
    
    if (!empty($min_salary) && $min_salary > 0) {
        $currency_sign = '$';
        if (!empty($jobcircle_default_curr) && isset($jobcircle_currencies_list[$jobcircle_default_curr]['symbol'])) {
            $currency_sign = $jobcircle_currencies_list[$jobcircle_default_curr]['symbol'];
        }
        if ($type == 'k') {
            $min_salary = jobcircle_thousand_format($min_salary);
            $salary_str = $currency_sign . $min_salary;
        } else {
            $salary_str = $currency_sign . number_format($min_salary);
        }
        if (!empty($max_salary) && $max_salary > 0) {
            $max_salary = preg_replace("/[^0-9.]/", '', $max_salary);
            if ($type == 'k') {
                $max_salary = jobcircle_thousand_format($max_salary);
                $salary_str .= ' - ' . $currency_sign . $max_salary;
            } else {
                $salary_str .= ' - ' . $currency_sign . number_format($max_salary);
            }
        }
        $salary_str .= '/' . ($unit_tag != '' ? '<'. $unit_tag .'>' : '') . $salary_unit_str . ($unit_tag != '' ? '</'. $unit_tag .'>' : '');

        return $salary_str;
    }
}

add_filter('jobcircle_job_single_after_the_content', 'jobcircle_job_single_attachments_html', 15, 3);

function jobcircle_job_single_attachments_html($html, $job_id, $view = 'view-1')
{
    $all_attach_files = get_post_meta($job_id, 'jobcircle_field_job_attachment_files', true);
    if (!empty($all_attach_files)) {
        ob_start();
        ?>
        <div class="jobcircle-job-attachments">
            <div class="jobcircle-singlepage-heading">
                <h4><?php esc_html_e('Attachments', 'jobcircle-frame') ?></h4>
            </div>
            <ul>
                <?php
                foreach ($all_attach_files as $_attach_file) {
                    $_attach_id = jobcircle_get_attachment_id_from_url($_attach_file);
                    $_attach_post = get_post($_attach_id);
                    $_attach_mime = isset($_attach_post->post_mime_type) ? $_attach_post->post_mime_type : '';
                    $_attach_guide = isset($_attach_post->guid) ? $_attach_post->guid : '';
                    $attach_name = basename($_attach_guide);
                    $file_icon = 'fa fa-file-text-o';
                    if ($_attach_mime == 'image/png' || $_attach_mime == 'image/jpeg') {
                        $file_icon = 'fa fa-file-image-o';
                    } else if ($_attach_mime == 'application/msword' || $_attach_mime == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                        $file_icon = 'fa fa-file-word-o';
                    } else if ($_attach_mime == 'application/vnd.ms-excel' || $_attach_mime == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                        $file_icon = 'fa fa-file-excel-o';
                    } else if ($_attach_mime == 'application/pdf') {
                        $file_icon = 'fa fa-file-pdf-o';
                    }
                    ?>
                    <li class="jobcircle-attach-itm">
                        <div class="file-container">
                            <a href="<?php echo ($_attach_file) ?>" oncontextmenu="javascript: return false;" onclick="javascript: if ((event.button == 0 && event.ctrlKey)) {return false};" download="<?php echo ($attach_name) ?>"><i class="<?php echo ($file_icon) ?>"></i> <?php echo ($attach_name) ?>
                            </a>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
        $html .= ob_get_clean();
    }

    return $html;
}

add_filter('jobcircle_job_single_after_the_content', 'jobcircle_job_single_video_html', 15, 3);

function jobcircle_job_single_video_html($html, $job_id, $view = 'view-1')
{
    $job_attach_video = get_post_meta($job_id, 'jobcircle_field_job_video_url', true);
    if (!empty($job_attach_video)) {
        ob_start();
    ?>
        <div class="jobcircle-job-attachments">
            <div class="jobcircle-singlepage-heading">
                <h4><?php esc_html_e('Video', 'jobcircle-frame') ?></h4>
            </div>
            <div class="jobcircle-job-videocon">
                <?php
                if (strpos($job_attach_video, home_url('/')) !== false) {
                    echo wp_video_shortcode(array('src' => $job_attach_video));
                } else {
                    $job_attach_video = str_replace(array('youtu.be'), array('youtube.com'), $job_attach_video);
                    echo wp_oembed_get($job_attach_video);
                }
                ?>
            </div>
        </div>
        <?php
        $html .= ob_get_clean();
    }

    return $html;
}

function jobcircle_dashboard_custom_fields_html($post_type = 'jobs', $post_id = '')
{
    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} AS posts";
    $query .= " LEFT JOIN {$wpdb->postmeta} AS postmeta ON posts.ID=postmeta.post_id";
    $query .= " WHERE post_type = 'cstmfield'";
    $query .= " AND postmeta.meta_key='cstmfield_rules' AND postmeta.meta_value LIKE '%\"$post_type\"%'";
    $query .= " group by posts.ID limit 1";

    $results = $wpdb->get_row($query);

    $html = '';
    if (!empty($results) && isset($results->ID)) {
        $fields_id = $results->ID;

        ob_start();

        $input_fields = JOBCIRCLE_CFS()->api->get_input_fields([
            'group_id' => $fields_id,
            'custom_post_id' => $post_id
        ]);

        //var_dump($input_fields);

        if (!empty($input_fields)) {
            foreach ($input_fields as $key => $field) {
                $col_class = 'col-xl-6 col-lg-6 col-md-12';
                if ($field->type == 'textarea') {
                    $col_class = 'col-xl-12 col-lg-12 col-md-12';
                }
                ?>
                <div class="<?php echo ($col_class) ?>">
                    <div class="jobcircle-form-fieldhldr">
                        <label><?php echo (isset($field->label) ? esc_html( $field->label ) : ''); ?></label>
                        <?php
                        JOBCIRCLE_CFS()->create_field([
                            'id'            => $field->id,
                            'group_id'      => $field->group_id,
                            'type'          => $field->type,
                            'input_name'    => "jobcircle_cstmfield[$field->name]",
                            'input_class'   => $field->type,
                            'options'       => $field->options,
                            'value'         => $field->value,
                            'notes'         => $field->notes,
                        ]);
                        ?>
                    </div>
                </div>
                <?php
            }
        }

        $html = ob_get_clean();
    }

    return $html;
}

add_filter('jobcircle_dash_post_job_fields_extra', 'jobcircle_dash_post_job_custom_fields_html', 10, 2);

function jobcircle_dash_post_job_custom_fields_html($html, $job_id)
{
    $html .= jobcircle_dashboard_custom_fields_html('jobs', $job_id);

    return $html;
}

add_filter('jobcircle_dash_employer_profile_fields_extra', 'jobcircle_dash_employer_custom_fields_html', 10, 2);

function jobcircle_dash_employer_custom_fields_html($html, $employer_id)
{
    $html .= jobcircle_dashboard_custom_fields_html('employer', $employer_id);

    return $html;
}

add_filter('jobcircle_dash_candidate_profile_fields_extra', 'jobcircle_dash_candidate_custom_fields_html', 10, 2);

function jobcircle_dash_candidate_custom_fields_html($html, $candidate_id)
{
    $html .= jobcircle_dashboard_custom_fields_html('candidates', $candidate_id);

    return $html;
}


add_action('wp_ajax_jobcircle_jobs_simple_trending_job_one', 'jobcircle_jobs_simple_trending_job_one');
add_action('wp_ajax_nopriv_jobcircle_jobs_simple_trending_job_one', 'jobcircle_jobs_simple_trending_job_one');
function jobcircle_jobs_simple_trending_job_one()
{
	$atts = array(
		'numofpost' => $_POST['numposts'],
		'orderby' => $_POST['orderby']
	);
	$html = jobcircle_jobs_simple_trending_job($atts);
	wp_send_json(array('html' => $html));
}

add_action('jobcircle_save_job', 'jobcircle_save_favourite_job_html', 10, 2);
function jobcircle_save_favourite_job_html($jobcircle_post_id, $jobcircle_tag_class = 'pin-job'){
    global $current_user;
    $user_id = $current_user->ID;
    $fav_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
    $fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();
    $like_btn_class = 'jobcircle-favjab-btn';

    if (!is_user_logged_in()) {
        $like_btn_class = 'jobcircle-favjab-btn no-user-follower-btn';
    } else {
        if (!jobcircle_user_candidate_id($user_id)) {
            $like_btn_class = 'jobcircle-favjab-btn no-member-follower-btn';
        }
    }
    $fav_icon_class = 'profile-btn';
    $follow = 'fa fa-heart-o';
    if (in_array($jobcircle_post_id, $fav_jobs)) {
        $like_btn_class = 'jobcircle-alrdy-favjab';
        $fav_icon_class = 'profile-btn';
        $follow = 'fa fa-heart';
    }
    $like_btn_class = $jobcircle_tag_class.' '.$like_btn_class;
    ob_start();
    ?>
    <a href="" class="<?php echo esc_attr($like_btn_class); ?> " data-id="<?php echo intval($jobcircle_post_id); ?>">
        <i class=" <?php echo esc_html($fav_icon_class); ?> position-absolute <?php echo esc_html($follow); ?>"></i>
    </a>
    <?php
    $jobcircle_save_btn = ob_get_clean();
    echo apply_filters('jobcircle_save_job_filter', $jobcircle_save_btn,$jobcircle_post_id, $jobcircle_tag_class);
}