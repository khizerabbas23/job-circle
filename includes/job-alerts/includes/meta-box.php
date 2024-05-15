<?php

defined('ABSPATH') || exit;

class Jobcircle_Job_Alert_Meta_Boxes
{

    public function __construct()
    {
        add_action('save_post', array($this, 'save_meta_fields'), 5);
        add_action('add_meta_boxes', array($this, 'post_layout_meta_boxes'));
        add_filter('manage_job-alert_posts_columns', array($this, 'job_alert_columns_add'));
        add_action('manage_job-alert_posts_custom_column', array($this, 'job_alert_custom_columns'));
    }

    public function save_meta_fields($post_id = '')
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        foreach ($_POST as $key => $value) {
            if (strstr($key, 'jobcircle_field_')) {
                update_post_meta($post_id, $key, $value);
            }
        }
    }

    public function post_layout_meta_boxes()
    {
        add_meta_box('jobcircle-jobs-alert', __('Job Alerts Options', 'jobcircle-frame'), array($this, 'render_job_alert_metabox'), 'job-alert', 'normal', 'high');
    }

    public function job_alert_columns_add($columns)
    {
        unset($columns['date']);
        $columns['user_email'] = esc_html__('User Email', 'wp-jobcircle');
        $columns['all_frequencies'] = esc_html__('Email Frequencies', 'wp-jobcircle');
        $columns['last_email'] = esc_html__('Last Email Sent', 'wp-jobcircle');
        $columns['next_email'] = esc_html__('Next Email Time', 'wp-jobcircle');
        $columns['date'] = esc_html__('Date', 'wp-jobcircle');
        return $columns;
    }

    public function job_alert_custom_columns($column)
    {
        global $post;
        $alert_id = $post->ID;
        switch ($column) {
            case 'user_email' :
                $user_email = get_post_meta($alert_id, 'jobcircle_field_alert_email', true);
                echo($user_email);
                break;
            case 'all_frequencies' :
                $frequencyAnnually = get_post_meta($alert_id, 'jobcircle_field_frequency_annually', true);
                $frequencyBiannually = get_post_meta($alert_id, 'jobcircle_field_frequency_biannually', true);
                $frequencyMonthly = get_post_meta($alert_id, 'jobcircle_field_frequency_monthly', true);
                $frequencyFortnightly = get_post_meta($alert_id, 'jobcircle_field_frequency_fortnightly', true);
                $frequencyWeekly = get_post_meta($alert_id, 'jobcircle_field_frequency_weekly', true);
                $frequencyDaily = get_post_meta($alert_id, 'jobcircle_field_frequency_daily', true);

                $frequencies_list = array();
                if ($frequencyDaily == 'on') {
                    $frequencies_list[] = esc_html__('Daily', 'wp-jobcircle');
                }
                if ($frequencyWeekly == 'on') {
                    $frequencies_list[] = esc_html__('Weekly', 'wp-jobcircle');
                }
                if ($frequencyFortnightly == 'on') {
                    $frequencies_list[] = esc_html__('Fortnightly', 'wp-jobcircle');
                }
                if ($frequencyMonthly == 'on') {
                    $frequencies_list[] = esc_html__('Monthly', 'wp-jobcircle');
                }
                if ($frequencyBiannually == 'on') {
                    $frequencies_list[] = esc_html__('Biannually', 'wp-jobcircle');
                }
                if ($frequencyAnnually == 'on') {
                    $frequencies_list[] = esc_html__('Annually', 'wp-jobcircle');
                }
                if (!empty($frequencies_list)) {
                    $frequencyType = implode(', ', $frequencies_list);
                } else {
                    $frequencyType = '-';
                }
                echo $frequencyType;
                break;
            case 'last_email' :
                $last_email_sent = get_post_meta($post->ID, 'last_time_email_sent', true);
                if ($last_email_sent > 0) {
                    $time_format = get_option('time_format');
                    if ($time_format == '') {
                        $time_format = 'g:i A';
                    }
                    echo date_i18n(get_option('date_format'), $last_email_sent) . ' ' . date_i18n($time_format, $last_email_sent);
                } else {
                    echo '-';
                }
                break;
            case 'next_email' :
                $last_email_sent = get_post_meta($post->ID, 'last_time_email_sent', true);
                $last_email_sent = $last_email_sent != '' && $last_email_sent > 0 ? $last_email_sent : current_time('timestamp');

                $frequency_annually = get_post_meta($alert_id, 'jobcircle_field_frequency_annually', true);
                $frequency_biannually = get_post_meta($alert_id, 'jobcircle_field_frequency_biannually', true);
                $frequency_monthly = get_post_meta($alert_id, 'jobcircle_field_frequency_monthly', true);
                $frequency_fortnightly = get_post_meta($alert_id, 'jobcircle_field_frequency_fortnightly', true);
                $frequency_weekly = get_post_meta($alert_id, 'jobcircle_field_frequency_weekly', true);
                $frequency_daily = get_post_meta($alert_id, 'jobcircle_field_frequency_daily', true);
                $frequency_hourly = get_post_meta($alert_id, 'jobcircle_field_frequency_never', true);

                if ($frequency_hourly == 'on') {
                    $selected_frequency = '+1 hour';
                } else if ($frequency_daily == 'on') {
                    $selected_frequency = '+1 days';
                } else if ($frequency_weekly == 'on') {
                    $selected_frequency = '+7 days';
                } else if ($frequency_fortnightly == 'on') {
                    $selected_frequency = '+15 days';
                } else if ($frequency_monthly == 'on') {
                    $selected_frequency = '+30 days';
                } else if ($frequency_biannually == 'on') {
                    $selected_frequency = '+182 days';
                } else if ($frequency_annually == 'on') {
                    $selected_frequency = '+365 days';
                }

                if (isset($selected_frequency)) {
                    $next_email_time = strtotime($selected_frequency, intval($last_email_sent));
                    $time_format = get_option('time_format');
                    if ($time_format == '') {
                        $time_format = 'g:i A';
                    }
                    echo date_i18n(get_option('date_format'), $next_email_time) . ' ' . date_i18n($time_format, $next_email_time);
                } else {
                    echo '-';
                }

                break;
        }
    }

    public function render_job_alert_metabox()
    {
        global $post;
        $jobcircleAlertsEmail = get_post_meta($post->ID, 'jobcircle_field_alert_email', true);
        $jobcircleAlertsName = get_post_meta($post->ID, 'jobcircle_field_alert_name', true);
        $jobcircleFieldSearchTitle = get_post_meta($post->ID, 'jobcircle_field_search_title', true);
        $jobcircleFieldLocation = get_post_meta($post->ID, 'jobcircle_field_location', true);
        $jobcircleAlertsJobType = get_post_meta($post->ID, 'jobcircle_field_job_type', true);
        $jobcircleAlertsJobCat = get_post_meta($post->ID, 'jobcircle_field_job_category', true);
        $jobcircleAlertsJobSkills = get_post_meta($post->ID, 'jobcircle_field_job_skills', true);
        //
        $frequencyAnnually = get_post_meta($post->ID, 'jobcircle_field_frequency_annually', true);
        $frequencyBiannually = get_post_meta($post->ID, 'jobcircle_field_frequency_biannually', true);
        $frequencyMonthly = get_post_meta($post->ID, 'jobcircle_field_frequency_monthly', true);
        $frequencyFortnightly = get_post_meta($post->ID, 'jobcircle_field_frequency_fortnightly', true);
        $frequencyWeekly = get_post_meta($post->ID, 'jobcircle_field_frequency_weekly', true);
        $frequencyDaily = get_post_meta($post->ID, 'jobcircle_field_frequency_daily', true);
        $frequencyNever = get_post_meta($post->ID, 'jobcircle_field_frequency_never', true);
        ?>
        <div class="jobcircle-post-layout">
            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Email:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <input type="text" name="jobcircle_alerts_email" value="<?php echo($jobcircleAlertsEmail) ?>">
                </div>
            </div>
            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Name:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <input type="text" name="jobcircle_field_alert_name" value="<?php echo($jobcircleAlertsName) ?>">
                </div>
            </div>
            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Keyword:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <input type="text" name="jobcircle_field_search_title" value="<?php echo($jobcircleFieldSearchTitle) ?>">
                </div>
            </div>
            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Location:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <input type="text" name="jobcircle_field_location" value="<?php echo($jobcircleFieldLocation) ?>">
                </div>
            </div>
            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Job Type:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <?php $job_types_list = jobcircle_job_types_list(); ?>
                    <select name="jobcircle_field_job_type[]" multiple="" class="form-control rounded">
                        <?php foreach ($job_types_list as $job_type_key => $job_type_ar) { ?>
                            <option value="<?php echo($job_type_key) ?>" <?php echo(!empty($jobcircleAlertsJobType) && is_array($jobcircleAlertsJobType) && in_array($job_type_key, $jobcircleAlertsJobType) ? 'selected="selected"' : '') ?>><?php echo($job_type_ar['title']) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php $cat_terms = get_terms(array(
                'taxonomy' => 'job_category',
                'hide_empty' => false,
            ));

            if ($cat_terms != '') { ?>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Job Categories:', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_job_category[]" multiple="" class="form-control"
                                placeholder="Select Job Categories">
                            <?php foreach ($cat_terms as $job_catitem) { ?>
                                <option value="<?php echo($job_catitem->term_id) ?>" <?php echo(!empty($jobcircleAlertsJobCat) && is_array($jobcircleAlertsJobCat) && in_array($job_catitem->term_id, $jobcircleAlertsJobCat) ? 'selected="selected"' : '') ?>><?php echo($job_catitem->name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>

            <?php $all_skills = get_terms(array(
                'taxonomy' => 'job_skill',
                'hide_empty' => false,
            )); ?>
            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Skills:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <select name="jobcircle_field_job_skills[]" class="form-control" multiple=""
                            placeholder="Select Skills">
                        <?php foreach ($all_skills as $job_skillitem) { ?>
                            <option value="<?php echo($job_skillitem->name) ?>" <?php echo(!empty($jobcircleAlertsJobSkills) && is_array($jobcircleAlertsJobSkills) && in_array($job_skillitem->name, $jobcircleAlertsJobSkills) ? 'selected="selected"' : '') ?>><?php echo($job_skillitem->name) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Annually Frequency:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <input type="checkbox" data-name="jobcircle_field_frequency_annually" class="jobcircle-frequency-val"
                           value="<?php echo ($frequencyAnnually == "on") ? "on" : "off" ?>" <?php echo ($frequencyAnnually == "on") ? "checked" : "" ?>>
                    <input type="hidden" name="jobcircle_field_frequency_annually" value="<?php echo ($frequencyAnnually == "on") ? "on" : "off" ?>">
                </div>
            </div>
            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Biannually Frequency:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <input type="checkbox" data-name="jobcircle_field_frequency_biannually" class="jobcircle-frequency-val"
                           value="<?php echo ($frequencyBiannually == "on") ? "on" : "off" ?>" <?php echo ($frequencyBiannually == "on") ? "checked" : "" ?>>
                    <input type="hidden" name="jobcircle_field_frequency_biannually" value="<?php echo ($frequencyBiannually == "on") ? "on" : "off" ?>">

                </div>
            </div>
            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Monthly Frequency:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <input type="checkbox" data-name="jobcircle_field_frequency_monthly" class="jobcircle-frequency-val"
                           value="<?php echo ($frequencyMonthly == "on") ? "on" : "off" ?>" <?php echo ($frequencyMonthly == "on") ? "checked" : "" ?>>
                    <input type="hidden" name="jobcircle_field_frequency_monthly" value="<?php echo ($frequencyMonthly == "on") ? "on" : "off" ?>">

                </div>
            </div>
            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Fortnightly Frequency:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <input type="checkbox" data-name="jobcircle_field_frequency_fortnightly" class="jobcircle-frequency-val"
                           value="<?php echo ($frequencyFortnightly == "on") ? "on" : "off" ?>" <?php echo ($frequencyFortnightly == "on") ? "checked" : "" ?>>
                    <input type="hidden" name="jobcircle_field_frequency_fortnightly" value="<?php echo ($frequencyFortnightly == "on") ? "on" : "off" ?>">
                </div>
            </div>
            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Weekly Frequency:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <input type="checkbox" data-name="jobcircle_field_frequency_weekly" class="jobcircle-frequency-val"
                           value="<?php echo ($frequencyWeekly == "on") ? "on" : "off" ?>" <?php echo ($frequencyWeekly == "on") ? "checked" : "" ?>>
                    <input type="hidden" name="jobcircle_field_frequency_weekly" value="<?php echo ($frequencyWeekly == "on") ? "on" : "off" ?>">

                </div>
            </div>
            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Daily Frequency:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <input type="checkbox" data-name="jobcircle_field_frequency_daily" class="jobcircle-frequency-val"
                           value="<?php echo ($frequencyDaily == "on") ? "on" : "off" ?>" <?php echo ($frequencyDaily == "on") ? "checked" : "" ?>>
                    <input type="hidden" name="jobcircle_field_frequency_daily" value="<?php echo ($frequencyDaily == "on") ? "on" : "off" ?>">

                </div>
            </div>

            <div class="elem-label">
                <label class="label-detail"><?php esc_html_e('Never:', 'jobcircle-frame') ?></label>
                <div class="input-detail">
                    <input type="checkbox" data-name="jobcircle_field_frequency_never" class="jobcircle-frequency-val"
                           value="<?php echo ($frequencyNever == "on") ? "on" : "off" ?>" <?php echo ($frequencyNever == "on") ? "checked" : "" ?>>
                    <input type="hidden" name="jobcircle_field_frequency_never" value="<?php echo ($frequencyNever == "on") ? "on" : "off" ?>">

                </div>
            </div>
        </div>
        <?php
    }

}

new Jobcircle_Job_Alert_Meta_Boxes;
