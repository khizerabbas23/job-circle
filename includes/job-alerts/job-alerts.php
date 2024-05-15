<?php

/*
  Class : Job Alerts
 */


// this is an include only WP file
if (!defined('ABSPATH')) {
    die;
}

// main plugin class
class JobSearchJobAlerts
{
    public static $jobDetails = array();

    // hook things up
    public function __construct()
    {
        $this->load_files();
        //add_action('init', array($this, 'job_alerts_schedule_callback'));
        add_action('jobcircle_job_alerts_schedule', array($this, 'job_alerts_schedule_callback'));
        add_action('wp_footer', array($this, 'job_alerts_schedule_popup'));
        add_action('side_bar_content', array($this, 'side_bar_content_callback'));

        add_action('wp_ajax_jobcircle_create_job_alert', array($this, 'create_job_alert_callback'));
        add_action('wp_ajax_nopriv_jobcircle_create_job_alert', array($this, 'create_job_alert_callback'));

        add_action('wp_ajax_create_job_alert', array($this, 'create_job_alert_submit_call'));
        add_action('wp_ajax_nopriv_create_job_alert', array($this, 'create_job_alert_submit_call'));

        add_action('wp_ajax_jobcircle_change_user_jobalert_frequency', array($this, 'change_jobalert_frequency'));

        add_action('wp_ajax_jobcircle_user_job_alert_delete', array($this, 'jobcircle_remove_job_alert'));

        add_action('wp_ajax_jobcircle_alrtmodal_popup_show', array($this, 'jobcircle_alrtmodal_popup_show_callback'));
        add_action('wp_ajax_nopriv_jobcircle_alrtmodal_popup_show', array($this, 'jobcircle_alrtmodal_popup_show_callback'));
    }

    public function jobcircle_alrtmodal_popup_show_callback()
    {
        $alertId = isset($_POST['alert_id']) ? $_POST['alert_id'] : "";
        $frequencies = array(
            'frequency_daily' => 'Daily',
            'frequency_weekly' => 'Weekly',
            'frequency_fortnightly' => 'Fortnightly',
            'frequency_monthly' => 'Monthly',
            'frequency_biannually' => 'Biannually',
            'frequency_annually' => 'Annually',
            'frequency_never' => 'Never',
        );
        $alertsEmail = get_post_meta($alertId, 'jobcircle_field_alert_email', true);
        $chekAlertFreq = get_post_meta($alertId, 'jobcircle_field_frequency_daily', true);
        if ($chekAlertFreq == 'on') {
            $alert_freq = 'frequency_daily';
        }
        $chekAlertFreq = get_post_meta($alertId, 'jobcircle_field_frequency_weekly', true);
        if ($chekAlertFreq == 'on') {
            $alert_freq = 'frequency_weekly';
        }
        $chekAlertFreq = get_post_meta($alertId, 'jobcircle_field_frequency_fortnightly', true);
        if ($chekAlertFreq == 'on') {
            $alert_freq = 'frequency_fortnightly';
        }
        $chekAlertFreq = get_post_meta($alertId, 'jobcircle_field_frequency_monthly', true);
        if ($chekAlertFreq == 'on') {
            $alert_freq = 'frequency_monthly';
        }
        $chekAlertFreq = get_post_meta($alertId, 'jobcircle_field_frequency_biannually', true);
        if ($chekAlertFreq == 'on') {
            $alert_freq = 'frequency_biannually';
        }
        $chekAlertFreq = get_post_meta($alertId, 'jobcircle_field_frequency_annually', true);
        if ($chekAlertFreq == 'on') {
            $alert_freq = 'frequency_annually';
        }
        $chekAlertFreq = get_post_meta($alertId, 'jobcircle_field_frequency_never', true);
        if ($chekAlertFreq == 'on') {
            $alert_freq = 'frequency_never';
        }

        $jobcircleFieldSearchTitle = get_post_meta($alertId, 'jobcircle_field_search_title', true);
        $jobcircleFieldLocation = get_post_meta($alertId, 'jobcircle_field_location', true);
        $jobcircleAlertsJobType = get_post_meta($alertId, 'jobcircle_field_job_type', true);
        $jobcircleAlertsJobCat = get_post_meta($alertId, 'jobcircle_field_job_category', true);
        $jobcircleAlertsJobSkills = get_post_meta($alertId, 'jobcircle_field_job_skills', true);
        ob_start(); ?>
        <form id="jobcircle-job-alerts-form" method="post">
            <input type="hidden" name="action" value="jobcircle_create_job_alert">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="job-alert-label" class="form-label">Job Alert Label</label>
                        <input type="text" class="form-control" name="alerts_name" id="job-alert-label"
                               value="<?php echo get_the_title($alertId) ?>">

                        <input type="hidden" class="form-control" name="alerts_email"
                               value="<?php echo($alertsEmail) ?>">
                        <input type="hidden" class="form-control" name="alert_id"
                               value="<?php echo($alertId) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="job-frequency" class="form-label">Select Frequency</label>
                        <select class="form-control" name="alert_frequency">
                            <option value="0">Select Frequency</option>
                            <?php foreach ($frequencies as $frequency => $label) { ?>
                                <option value="<?php echo($frequency) ?>" <?php echo($frequency == $alert_freq ? "selected" : "") ?>><?php echo($label); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="job-alert-keyword" class="form-label">Keyword</label>
                        <input type="text" class="form-control" name="search_title" id="job-alert-keyword"
                               value="<?php echo($jobcircleFieldSearchTitle) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="job-alert-location" class="form-label">Location</label>
                        <input type="text" class="form-control" name="alert_location" id="job-alert-location"
                               placeholder="City, State or ZIP" value="<?php echo($jobcircleFieldLocation) ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php $job_types_list = jobcircle_job_types_list(); ?>
                        <label for="job-type" class="form-label">Job Type</label>
                        <select name="jobcircle_field_job_type[]" multiple="" class="form-control rounded">
                            <?php foreach ($job_types_list as $job_type_key => $job_type_ar) { ?>
                                <option value="<?php echo($job_type_key) ?>" <?php echo(!empty($jobcircleAlertsJobType) && is_array($jobcircleAlertsJobType) && in_array($job_type_key, $jobcircleAlertsJobType) ? 'selected="selected"' : '') ?>><?php echo($job_type_ar['title']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php $cat_terms = get_terms(array(
                        'taxonomy' => 'job_category',
                        'hide_empty' => false,
                    ));
                    if ($cat_terms != '') { ?>
                        <div class="form-group">
                            <label for="job-type" class="form-label">Job Categories</label>
                            <select name="job_category[]" multiple="" class="form-control"
                                    placeholder="Select Job Categories">
                                <?php foreach ($cat_terms as $job_catitem) { ?>
                                    <option value="<?php echo($job_catitem->term_id) ?>" <?php echo(!empty($jobcircleAlertsJobCat) && is_array($jobcircleAlertsJobCat) && in_array($job_catitem->term_id, $jobcircleAlertsJobCat) ? 'selected="selected"' : '') ?>><?php echo($job_catitem->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php $all_skills = get_terms(array(
                        'taxonomy' => 'job_skill',
                        'hide_empty' => false,
                    )); ?>
                    <div class="form-group">
                        <label>Skills</label>
                        <select name="job_skills[]" class="form-control" multiple=""
                                placeholder="Select Skills">
                            <?php foreach ($all_skills as $job_skillitem) { ?>
                                <option value="<?php echo($job_skillitem->name) ?>" <?php echo(!empty($jobcircleAlertsJobSkills) && is_array($jobcircleAlertsJobSkills) && in_array($job_skillitem->name, $jobcircleAlertsJobSkills) ? 'selected="selected"' : '') ?>><?php echo($job_skillitem->name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <?php
        $html = ob_get_clean();
        wp_send_json(array('html' => $html));
        wp_die();
    }

    public function jobcircle_remove_job_alert()
    {
        if (isset($_REQUEST['alert_id'])) {
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                $is_employer = jobcircle_user_employer_id($user_id);
                if ($is_employer) {
                    $return = array('success' => false, "message" => esc_html__("You are not allowed to delete", 'wp-jobcircle'));
                    echo json_encode($return);
                    wp_die();
                }
            } else {
                $return = array('success' => false, "message" => esc_html__("Please login as candidate to create job alert", 'wp-jobcircle'));
                echo json_encode($return);
                wp_die();
            }

            $job_alert_id = sanitize_text_field($_REQUEST['alert_id']);
            $post_data = get_post($job_alert_id);
            if ($post_data) {
                wp_delete_post($job_alert_id, true);
            }
        }
        wp_die();
    }

    public function load_files()
    {
        include plugin_dir_path(dirname(__FILE__)) . 'job-alerts/includes/meta-box.php';
    }

    function create_job_alert_submit_call()
    {
        $alertsName = isset($_POST['alerts_name']) ? $_POST['alerts_name'] : '';
        $alertsEmail = isset($_POST['alerts_email']) ? $_POST['alerts_email'] : '';
        $alertsFrequency = isset($_POST['alerts_frequency']) ? $_POST['alerts_frequency'] : '';

        $frequencies = array(
            'frequency_daily' => 'Daily',
            'frequency_weekly' => 'Weekly',
            'frequency_fortnightly' => 'Fortnightly',
            'frequency_monthly' => 'Monthly',
            'frequency_biannually' => 'Biannually',
            'frequency_annually' => 'Annually',
            'frequency_never' => 'Never',
        );
        ob_start(); ?>
        <form id="jobcircle-job-alerts-form" method="post">
            <input type="hidden" name="action" value="jobcircle_create_job_alert">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="job-alert-label" class="form-label">Job Alert Label</label>
                        <input type="text" class="form-control" name="alerts_name" id="job-alert-label"
                               value="<?php echo($alertsName) ?>">

                        <input type="hidden" class="form-control" name="alerts_email"
                               value="<?php echo($alertsEmail) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="job-frequency" class="form-label">Select Frequency</label>
                        <select class="form-control" name="alert_frequency">
                            <option value="0">Select Frequency</option>
                            <?php foreach ($frequencies as $frequency => $label) { ?>
                                <option value="<?php echo($frequency) ?>" <?php echo($frequency == $alertsFrequency ? "selected" : "") ?>><?php echo($label); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="job-alert-keyword" class="form-label">Keyword</label>
                        <input type="text" class="form-control" name="search_title" id="job-alert-keyword">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="job-alert-location" class="form-label">Location</label>
                        <input type="text" class="form-control" name="alert_location" id="job-alert-location"
                               placeholder="City, State or ZIP">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php $job_types_list = jobcircle_job_types_list(); ?>
                        <label for="job-type" class="form-label">Job Type</label>
                        <select name="jobcircle_field_job_type[]" multiple="" class="form-control rounded">
                            <?php foreach ($job_types_list as $job_type_key => $job_type_ar) { ?>
                                <option value="<?php echo($job_type_key) ?>"><?php echo($job_type_ar['title']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php $cat_terms = get_terms(array(
                        'taxonomy' => 'job_category',
                        'hide_empty' => false,
                    ));
                    if ($cat_terms != '') { ?>
                        <div class="form-group">
                            <label for="job-type" class="form-label">Job Categories</label>
                            <select name="job_category[]" multiple="" class="form-control"
                                    placeholder="Select Job Categories">
                                <?php foreach ($cat_terms as $job_catitem) { ?>
                                    <option value="<?php echo($job_catitem->term_id) ?>"><?php echo($job_catitem->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php $all_skills = get_terms(array(
                        'taxonomy' => 'job_skill',
                        'hide_empty' => false,
                    )); ?>
                    <div class="form-group">
                        <label>Skills</label>
                        <select name="job_skills[]" class="form-control" multiple=""
                                placeholder="Select Skills">
                            <?php foreach ($all_skills as $job_skillitem) { ?>
                                <option value="<?php echo($job_skillitem->name) ?>"><?php echo($job_skillitem->name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <?php
        $html = ob_get_clean();
        wp_send_json(array('html' => $html));
        wp_die();
    }

    function create_job_alert_callback()
    {
        $job_alert_id = isset($_POST['alert_id']) ? $_POST['alert_id'] : '';
        $alerts_name = isset($_POST['alerts_name']) ? $_POST['alerts_name'] : '';
        $alerts_email = isset($_POST['alerts_email']) ? $_POST['alerts_email'] : '';
        $alert_frequency = isset($_POST['alert_frequency']) ? $_POST['alert_frequency'] : '';
        $alert_location = isset($_POST['alert_location']) ? $_POST['alert_location'] : '';
        $search_title = isset($_POST['search_title']) ? $_POST['search_title'] : '';
        $jobcircle_field_job_type = isset($_POST['jobcircle_field_job_type']) ? $_POST['jobcircle_field_job_type'] : '';
        $job_category = isset($_POST['job_category']) ? $_POST['job_category'] : '';
        $job_skills = isset($_POST['job_skills']) ? $_POST['job_skills'] : '';
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $is_employer = jobcircle_user_employer_id($user_id);
            if ($is_employer) {
                $return = array('success' => false, "message" => esc_html__("You cannot create a job alert. Only candidate can", 'wp-jobcircle'));
                echo json_encode($return);
                wp_die();
            }
        } else {
            $return = array('success' => false, "message" => esc_html__("Please login as candidate to create job alert", 'wp-jobcircle'));
            echo json_encode($return);
            wp_die();
        }

        if (empty($alerts_name) || empty($alerts_email) || empty($alert_frequency)) {
            $return = array('success' => false, "message" => esc_html__("Provided data is not completed.", 'wp-jobcircle'));
        } else {
            $meta_query = array(
                array(
                    'key' => '`_alert_email',
                    'value' => $alerts_name,
                    'compare' => '=',
                ),
                array(
                    'key' => 'jobcircle_field_' . $alert_frequency,
                    'value' => 'on',
                    'compare' => '=',
                ),
            );
            $args = array(
                'post_type' => 'job-alert',
                'meta_query' => $meta_query,
            );
            $obj_query = new WP_Query($args);
            $count = $obj_query->post_count;

            if ($count > 0) {
                $return = array('success' => false, "message" => esc_html__("Alert already exists with this criteria", 'wp-jobcircle'));
            } else {
                if (empty($job_alert_id)) {
                    // Insert Job Alert as a post.
                    $job_alert_data = array(
                        'post_title' => $alerts_name,
                        'post_status' => 'publish',
                        'post_type' => 'job-alert',
                        'comment_status' => 'closed',
                        'post_author' => get_current_user_id(),
                    );
                    $job_alert_id = wp_insert_post($job_alert_data);
                } else {
                    $post_update = array(
                        'ID' => $job_alert_id,
                        'post_title' => $alerts_name
                    );
                    wp_update_post($post_update);
                }
                // Update email.
                update_post_meta($job_alert_id, 'jobcircle_field_alert_email', $alerts_email);
                // Update name.
                update_post_meta($job_alert_id, 'jobcircle_field_alert_name', $alerts_name);
                // Update frequencies.
                update_post_meta($job_alert_id, 'jobcircle_field_' . $alert_frequency, 'on');
                // Update search title.
                update_post_meta($job_alert_id, 'jobcircle_field_search_title', $search_title);
                // Update location.
                update_post_meta($job_alert_id, 'jobcircle_field_location', $alert_location);
                // Update job type.
                update_post_meta($job_alert_id, 'jobcircle_field_job_type', $jobcircle_field_job_type);
                // Update category.
                update_post_meta($job_alert_id, 'jobcircle_field_job_category', $job_category);
                // Update category.
                update_post_meta($job_alert_id, 'jobcircle_field_job_skills', $job_skills);
                // Last time email sent.
                update_post_meta($job_alert_id, 'last_time_email_sent', 0);

                $return = array('success' => true, "message" => esc_html__("Job alert successfully added.", 'wp-jobcircle'));
            }
        }
        echo json_encode($return);
        wp_die();

    }

    public function side_bar_content_callback()
    {
        ob_start();
        $user = wp_get_current_user();
        $disabled = '';
        $email = '';
        if ($user->ID > 0) {
            $email = $user->user_email;
            $disabled = ' disabled="disabled"';
        }
        ?>
        <!-- Filter Box -->
        <div class="filter-box">
            <h2 class="h5">Email me new jobs</h2>

            <div class="form-group search-field">
                <input class="form-control" name="alerts_name"
                       placeholder="Job alert name..."
                       type="text">
            </div>
            <div class="form-group">
                <input class="form-control" name="alerts_email"
                       placeholder="example@email.com"
                       type="email" value="<?php echo($email) ?>" <?php echo($disabled) ?>>
            </div>
            <div class="form-group">
                <div class="checkbox-limit">
                    <ul class="checkbox-list">
                        <?php
                        $frequencies = array(
                            'frequency_daily' => 'Daily',
                            'frequency_weekly' => 'Weekly',
                            'frequency_fortnightly' => 'Fortnightly',
                            'frequency_monthly' => 'Monthly',
                            'frequency_biannually' => 'Biannually',
                            'frequency_annually' => 'Annually',
                            'frequency_never' => 'Never',
                        );
                        $rand_id = rand(10000000, 99999999);
                        foreach ($frequencies as $frequency => $label) { ?>
                            <li>
                                <label class="custom-checkbox">
                                    <input id="cat-<?php echo $rand_id; ?>"
                                           name="job_frequency"
                                           value="<?php echo $frequency; ?>"
                                           type="radio" <?php echo $frequency == 'frequency_daily' ? "checked" : "" ?>>
                                    <span class="fake-checkbox"></span>
                                    <span class="label-text"><?php echo $label; ?></span>
                                </label>
                            </li>
                        <?php } ?>
                    </ul>
                    <a class="btn btn-primary btn-sm buttonShowMore jobcircle-alertfilter-btn">
                        <span class="btn-text">Create Alert</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Filter Box -->
        <?php
        $html = ob_get_clean();
        echo $html;

    }

    public function job_alerts_schedule_callback()
    {
        $args = array(
            'posts_per_page' => '-1',
            'post_type' => 'job-alert',
            'post_status' => 'publish',
            'fields' => 'ids',
            'order' => 'DESC',
            'orderby' => 'ID',
        );
        $jobDetails = array();
        $job_alerts = new WP_Query($args);
        if ($job_alerts->have_posts()) {
            foreach ($job_alerts->posts as $alertId) {

                $frequency_annually = get_post_meta($alertId, 'jobcircle_field_frequency_annually', true);
                $frequency_biannually = get_post_meta($alertId, 'jobcircle_field_frequency_biannually', true);
                $frequency_monthly = get_post_meta($alertId, 'jobcircle_field_frequency_monthly', true);
                $frequency_fortnightly = get_post_meta($alertId, 'jobcircle_field_frequency_fortnightly', true);
                $frequency_weekly = get_post_meta($alertId, 'jobcircle_field_frequency_weekly', true);
                $frequency_daily = get_post_meta($alertId, 'jobcircle_field_frequency_daily', true);
                $frequency_never = get_post_meta($alertId, 'jobcircle_field_frequency_never', true);
                $last_time_email_sent = get_post_meta($alertId, 'last_time_email_sent', true);

                $jobcircleAlertsJobType = get_post_meta($alertId, 'jobcircle_field_job_type', true);
                $jobcircleAlertsJobCat = get_post_meta($alertId, 'jobcircle_field_job_category', true);
                $jobcircleAlertsJobSkills = get_post_meta($alertId, 'jobcircle_field_job_skills', true);

                $set_frequency = '';
                if (($frequency_annually) == "on") {
                    $selected_frequency = '+365 days';
                    $set_frequency = esc_html__('Annually', 'wp-jobcircle');
                } else if (($frequency_biannually) == "on") {
                    $selected_frequency = '+182 days';
                    $set_frequency = esc_html__('Biannually', 'wp-jobcircle');
                } else if (($frequency_monthly) == "on") {
                    $selected_frequency = '+30 days';
                    $set_frequency = esc_html__('Monthly', 'wp-jobcircle');
                } else if (($frequency_fortnightly) == "on") {
                    $selected_frequency = '+15 days';
                    $set_frequency = esc_html__('Fortnightly', 'wp-jobcircle');
                } else if (($frequency_weekly) == "on") {
                    $selected_frequency = '+7 days';
                    $set_frequency = esc_html__('Weekly', 'wp-jobcircle');
                } else if (($frequency_daily) == "on") {
                    $selected_frequency = '+1 days';
                    $set_frequency = esc_html__('Daily', 'wp-jobcircle');
                } else if (($frequency_never) == "on") {
                    $selected_frequency = false;
                    $set_frequency = esc_html__('Never', 'wp-jobcircle');
                } else {
                    $selected_frequency = false;
                    $set_frequency = '';
                }

                if ($selected_frequency != false) {
                    if (time() > strtotime($selected_frequency, intval($last_time_email_sent))) {
                        // Set this for email data.
                        $alert_t_title = get_post_meta($alertId, 'jobcircle_field_alert_name', true);
                        $gjobs_query = array();
                        if (isset($gjobs_query['meta_query'])) {
                            $gjobs_query['meta_query'][0][] = array(
                                'key' => 'jobcircle_field_job_expiry_date',
                                'value' => current_time('timestamp'),
                                'compare' => '>=',
                            );
                        }
                        self::$jobDetails = array(
                            'id' => $alertId,
                            'title' => $alert_t_title != '' ? $alert_t_title : '-',
                            'email' => get_post_meta($alertId, 'jobcircle_field_alert_email', true),
                            'frequency' => $selected_frequency,
                            'set_frequency' => $set_frequency,
                            'job_type' => $jobcircleAlertsJobType,
                            'job_cat' => $jobcircleAlertsJobCat,
                            'job_skills' => $jobcircleAlertsJobSkills,
                            'jobs_query' => array(
                                'post_type' => 'jobs',
                                'post_status' => 'publish',
                                'order' => 'DESC',
                                'orderby' => 'ID',
                                'fields' => 'ids'
                            ),
                        );

                        $allJobsCount = self::getJobAlertsCount(self::$jobDetails, self::$jobDetails['frequency']);
                        if ($allJobsCount > 0) {
                            static::NewJobAlertsEmail(self::$jobDetails['jobs_query'], self::$jobDetails['frequency'], $jobcircleAlertsJobType, $jobcircleAlertsJobCat, $jobcircleAlertsJobSkills);
                        }
                    }
                }
            }
        }
        wp_reset_postdata();
    }

    public static function NewJobAlertsEmail($jobsQuery, $frequency, $jobcircleAlertsJobType, $jobcircleAlertsJobCat, $jobcircleAlertsJobSkills)
    {
        $frequency = str_replace('+', '-', $frequency);
        $jobsQuery['jobs_query']['meta_query'][] = array(
            'key' => 'jobcircle_field_posted_date',
            'value' => date('Y-m-d', strtotime($frequency)),
            'compare' => '>=',
        );

        $jobsQuery['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'job_category',
                'field' => 'term_id',
                'terms' => serialize($jobcircleAlertsJobCat),
            ),
            array(
                'taxonomy' => 'job_skill',
                'field' => 'name',
                'terms' => serialize($jobcircleAlertsJobSkills),
            ),
        );
        $jobsQuery['meta_query'][] = array(
            array(
                'key' => 'jobcircle_field_job_type',
                'value' => serialize($jobcircleAlertsJobType),
                'compare' => 'IN',
            ),
        );

        $jobsQuery['jobs_query']['posts_per_page'] = 10;

        $jobLoop = new WP_Query($jobsQuery);
        $jobLoop = $jobLoop->posts;

        ob_start();
        if (!empty($jobLoop)) { ?>
            <table cellspacing="0" width="100%" style="border-spacing: 0em 0.7em;">
                <tbody>
                <?php
                foreach ($jobLoop as $job_id) {
                    $jobPublishDate = get_post_meta($job_id, 'jobcircle_field_frequencyublish_date', true);
                    $jobLocations = get_post_meta($job_id, 'jobcircle_field_place', true);
                    $companyName = get_post_meta($job_id, 'jobcircle_field_companies_name', true);
                    $jobType = get_post_meta($job_id, 'jobcircle_field_job_type', true);
                    $post_thumbnail_src = get_the_post_thumbnail_url($job_id, 'thumbnail');
                    ?>
                    <tr>
                        <td width="100"
                            style="border: 1px solid #ececec; border-right: none; padding: 19px 0px 19px 19px;"><img
                                    src="<?php echo esc_url($post_thumbnail_src) ?>" alt=""
                                    style="border-radius: 100%; width: 100px;"></td>
                        <td style="padding-left: 30px; border: 1px solid #ececec; border-left: none; border-right: none;">
                            <h2 style="display: block; font-size: 18px; margin-bottom: -10px;"><a
                                        href="<?php echo(get_permalink($job_id)) ?>"><?php echo(get_the_title($job_id)) ?></a>
                            </h2>
                            <br>
                            <small style="font-size: 14px;"><?php esc_html_e('Company', 'wp-jobcircle'); ?>
                                : <?php echo($companyName) ?></small>
                            <br>
                            <small style="font-size: 14px;"><?php printf(esc_html__('Published %s', 'wp-jobcircle'), jobcircleTimeElapsedText($jobPublishDate)); ?></small>
                            <br>
                            <small style="font-size: 14px;"><?php esc_html_e('Address', 'wp-jobcircle '); ?>
                                : <?php echo($jobLocations) ?></small>
                            <?php if (!empty($jobType)) {
                                foreach ($jobType as $type) { ?>
                                    <br>
                                    <small style="font-size: 14px;"><?php esc_html_e('Job Type', 'wp-jobcircle '); ?>
                                        : <?php echo($type) ?></small>
                                <?php }
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php
        } else {
            esc_html_e('No new jobs found.', 'wp-jobcircle');
        }

        $jobAlertEmail = ob_get_clean();
        $to = $jobsQuery['to'];
        $subject = 'Jobcircle Job Alert';
        $message = $jobAlertEmail;
        $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Job Circle info@jobcircle.com');
        wp_mail($to, $subject, $message, $headers);
        wp_die();
    }

    public static function getJobAlertsCount($jobs_query, $frequency)
    {
        $frequency = str_replace('+', '-', $frequency);
        $jobs_query['meta_query'] = array(
            'key' => 'jobcircle_field_posted_date',
            'value' => date('Y-m-d', strtotime($frequency)),
            'compare' => '>=',
        );
        $jobs_query['posts_per_page'] = 1;

        $loop_count = new WP_Query($jobs_query);
        return count($loop_count->posts);
    }

    public function job_alerts_schedule_popup()
    {
        wp_enqueue_style('jobcircle-job-alert');
        ob_start();
        ?>
        <div class="modal fade" id="JobCircleJobAlertsModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="jobAlertModalToggleLabel">Job Alerts</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <i class="fa fa-refresh"></i>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success jobcircle-savejobalrts-btn">Save Job Alert</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $html = ob_get_clean();
        echo $html;
    }

    public function change_jobalert_frequency()
    {
        $alertId = $_POST['alert_id'];
        $alert_freq = $_POST['frequency'];
        $alert_frequncies = array(
            '365_days' => 'jobcircle_field_frequency_annually',
            '182_days' => 'jobcircle_field_frequency_biannually',
            '30_days' => 'jobcircle_field_frequency_monthly',
            '15_days' => 'jobcircle_field_frequency_fortnightly',
            '7_days' => 'jobcircle_field_frequency_weekly',
            '1_days' => 'jobcircle_field_frequency_daily',
            'never' => 'jobcircle_field_frequency_never',
        );
        foreach ($alert_frequncies as $freq_key => $freq_val) {
            if ($alert_freq == $freq_key) {
                update_post_meta($alertId, $freq_val, 'on');
            } else {
                update_post_meta($alertId, $freq_val, '');
            }
        }
        wp_send_json(array('error' => '0'));
    }
}

global $JobSearchJobAlerts_obj;
$JobSearchJobAlerts_obj = new JobSearchJobAlerts();
