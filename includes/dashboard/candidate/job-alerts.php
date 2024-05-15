<?php

add_filter('jobcircle_dashboard_candidate_job_alerts_html', 'jobcircle_dashboard_candidate_job_alerts_html');

function jobcircle_dashboard_candidate_job_alerts_html()
{
    global $current_user;
    $user_id = $current_user->ID;
    
    $page_permissions = jobcircle_check_page_permissions('candidate','job-alerts');    
    if($page_permissions === 0){
        $home_page_url = home_url('/');  
        echo '<script>window.location.href="'.$home_page_url.'"</script>';
        exit;      
    }
    
    ob_start();
    ?>
    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="mb-4 tbl-lg rounded overflow-hidden">
                    <div class="table-responsive bg-white">
                        <?php
                        $page_num = isset($_GET['page_num']) ? $_GET['page_num'] : 1;
                        $args = array(
                            'author' => $user_id,
                            'post_type' => 'job-alert',
                            'posts_per_page' => 10,
                            'paged' => $page_num,
                            'orderby' => 'post_date',
                            'order' => 'DESC',
                        );

                        $job_alerts = new WP_Query($args);
                        $total_jobs = $job_alerts->found_posts;
                        if ($job_alerts->have_posts()) {
                            ?>
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th><?php esc_html_e('Title', 'wp-jobcircle') ?></th>
                                    <th><?php esc_html_e('Criteria', 'wp-jobcircle') ?></th>
                                    <th><?php esc_html_e('Frequency', 'wp-jobcircle') ?></th>
                                    <th><?php esc_html_e('Created Date', 'wp-jobcircle') ?></th>
                                    <th><?php esc_html_e('Actions', 'wp-jobcircle') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $frequencies = array(
                                    '365_days' => 'jobcircle_field_frequency_annually',
                                    '182_days' => 'jobcircle_field_frequency_biannually',
                                    '30_days' => 'jobcircle_field_frequency_monthly',
                                    '15_days' => 'jobcircle_field_frequency_fortnightly',
                                    '7_days' => 'jobcircle_field_frequency_weekly',
                                    '1_days' => 'jobcircle_field_frequency_daily',
                                    'never' => 'jobcircle_field_frequency_never',
                                );

                                $alert_frequncies = array(
                                    '365_days' => esc_html__('Annually', 'wp-jobcircle'),
                                    '182_days' => esc_html__('Biannually', 'wp-jobcircle'),
                                    '30_days' => esc_html__('Monthly', 'wp-jobcircle'),
                                    '15_days' => esc_html__('Fortnightly', 'wp-jobcircle'),
                                    '7_days' => esc_html__('Weekly', 'wp-jobcircle'),
                                    '1_days' => esc_html__('Daily', 'wp-jobcircle'),
                                    'never' => esc_html__('Never', 'wp-jobcircle'),
                                );

                                while ($job_alerts->have_posts()) : $job_alerts->the_post();
                                    $alertId = get_the_ID();
                                    $frequencyAnnually = get_post_meta($alertId, 'jobcircle_field_frequency_annually', true);
                                    $frequencyBiannually = get_post_meta($alertId, 'jobcircle_field_frequency_biannually', true);
                                    $frequencyMonthly = get_post_meta($alertId, 'jobcircle_field_frequency_monthly', true);
                                    $frequencyFortnightly = get_post_meta($alertId, 'jobcircle_field_frequency_fortnightly', true);
                                    $frequencyWeekly = get_post_meta($alertId, 'jobcircle_field_frequency_weekly', true);
                                    $frequencyDaily = get_post_meta($alertId, 'jobcircle_field_frequency_daily', true);
                                    $frequencyNever = get_post_meta($alertId, 'jobcircle_field_frequency_never', true);

                                    if (!empty($frequencyAnnually)) {
                                        $selected_frequency = '365_days';
                                    } else if (!empty($frequencyBiannually)) {
                                        $selected_frequency = '182_days';
                                    } else if (!empty($frequencyMonthly)) {
                                        $selected_frequency = '30_days';
                                    } else if (!empty($frequencyFortnightly)) {
                                        $selected_frequency = '15_days';
                                    } else if (!empty($frequencyWeekly)) {
                                        $selected_frequency = '7_days';
                                    } else if (!empty($frequencyDaily)) {
                                        $selected_frequency = '1_days';
                                    } else if (!empty($frequencyNever)) {
                                        $selected_frequency = 'never';
                                    }
                                    $jobcircleFieldSearchTitle = get_post_meta($alertId, 'jobcircle_field_search_title', true);
                                    $jobcircleFieldLocation = get_post_meta($alertId, 'jobcircle_field_location', true);
                                    $jobcircleAlertsJobType = get_post_meta($alertId, 'jobcircle_field_job_type', true);
                                    $jobcircleAlertsJobCat = get_post_meta($alertId, 'jobcircle_field_job_category', true);
                                    $jobcircleAlertsJobSkills = get_post_meta($alertId, 'jobcircle_field_job_skills', true);
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="dash-title"><h4
                                                        class="mb-0 ft-medium fs-sm"><?php echo get_the_title($alertId) ?></h4>
                                                <div class="jbl_location"><i
                                                            class="lni lni-map-marker me-1"></i><span><?php echo($jobcircleFieldLocation) ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="jobalert-criteria-con">
                                                <li>Search Title: <?php echo($jobcircleFieldSearchTitle) ?></li>
                                                <?php if (!empty($jobcircleAlertsJobType)) { ?>
                                                    <li>Job Type: <?php echo implode(', ', str_replace("_", "-", $jobcircleAlertsJobType)) ?></li>
                                                <?php } ?>
                                                <?php if (is_array($jobcircleAlertsJobCat) && !empty($jobcircleAlertsJobCat)) {
                                                    ?>
                                                    <li>Job
                                                        Category: <?php foreach ($jobcircleAlertsJobCat as $cat_info) {
                                                            echo get_term($cat_info)->name . ",";
                                                        } ?>
                                                    </li>
                                                <?php } ?>
                                                <?php if (!empty($jobcircleAlertsJobSkills)) { ?>
                                                    <li>
                                                        Skills: <?php echo implode(', ', $jobcircleAlertsJobSkills) ?></li>
                                                <?php } ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <select class="jobalert-frequency-change" data-id="<?php echo($alertId) ?>">
                                                <?php
                                                foreach ($alert_frequncies as $freq_key => $freq_val) { ?>
                                                    <option value="<?php echo($freq_key) ?>"<?php echo($selected_frequency == $freq_key ? ' selected="selected"' : '') ?>><?php echo($freq_val) ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="cheker-loder"></span>
                                        </td>
                                        <td><?php echo get_the_date() ?></td>
                                        <td>
                                            <div class="dash-action">
                                                <a href="javascript:void(0);" data-id="<?php echo($alertId) ?>"
                                                   class="jobcircle-dash-jobalert-update-btn p-2 circle text-primary bg-light-primary d-inline-flex align-items-center justify-content-center me-1">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                   class="p-2 circle text-info bg-light-info d-inline-flex align-items-center justify-content-center me-1">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="javascript:void(0);" data-id="<?php echo($alertId) ?>" class="jobcircle-delete-user-job-alert p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                                </tbody>
                            </table>
                            <?php
                            add_action('wp_footer', function()

                            use ($alertId)

                            {
                            ?>
                                <script>
                                    jQuery(document).on('change', '.jobalert-frequency-change', function () {
                                        var _this = jQuery(this);
                                        var alert_id = _this.attr('data-id');
                                        var thisLoader = _this.next('.cheker-loder');
                                        thisLoader.html('<i class="fa fa-refresh fa-spin"></i>');
                                        var request = jQuery.ajax({
                                            url: '<?php echo admin_url('admin-ajax.php') ?>',
                                            method: "POST",
                                            data: {
                                                alert_id: alert_id,
                                                frequency: _this.val(),
                                                action: 'jobcircle_change_user_jobalert_frequency',
                                            },
                                            dataType: "json"
                                        });
                                        request.done(function (response) {
                                            if (undefined !== typeof response.error && response.error == '0') {
                                                thisLoader.html('<i class="fa fa-check" style="color: #00ce00;"></i>');
                                                return false;
                                            }
                                            thisLoader.html('');
                                        });

                                        request.fail(function (jqXHR, textStatus) {
                                            thisLoader.html('');
                                        });
                                    });
                                </script>
                                <?php
                            }, 30);

                        } else {
                            ?>
                            <div class="table-responsive bg-white">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th><?php esc_html_e('Title', 'wp-jobcircle') ?></th>
                                            <th><?php esc_html_e('Criteria', 'wp-jobcircle') ?></th>
                                            <th><?php esc_html_e('Frequency', 'wp-jobcircle') ?></th>
                                            <th><?php esc_html_e('Created Date', 'wp-jobcircle') ?></th>
                                            <th><?php esc_html_e('Actions', 'wp-jobcircle') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="7"><?php esc_html_e('No result found.', 'jobcircle-frame') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
}