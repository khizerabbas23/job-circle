<?php

function jobcircle_dashb_candidate_dashboard() {
    global $current_user, $jobcircle_framework_options;

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);

    $args = array(
        'post_type' => 'job_applic',
        'post_status' => array('publish'),
        'fields' => 'ids',
        'order' => 'DESC',
        'orderby' => 'ID',
        'meta_query' => array(
            array(
                'key' => 'user_cand_id',
                'value' => $candidate_id
            )
        ),
    );
    $applics_query = new WP_Query($args);
    $total_applics = $applics_query->found_posts;

    $shortlisted_apps = 0;
    if (!empty($total_applics->posts)) {
        $total_applics_posts = $total_applics->posts;
        foreach ($total_applics_posts as $applic_id) {
            $app_status = get_post_meta($applic_id, 'applic_response_status', true);
            if ($app_status == 'shortlisted') {
                $shortlisted_apps += 1;
            }
        }
    }

    //
    $bookmarked_jobs_count = 0;
    $bookmarked_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
    if (!empty($bookmarked_jobs)) {
        $bookmarked_jobs_count = count($bookmarked_jobs);
    }

    //
    $args = array(
        'post_type' => 'job-alert',
        'post_status' => array('publish'),
        'post_author' => $user_id,
        'fields' => 'ids',
        'order' => 'DESC',
        'orderby' => 'ID',
    );
    $alerts_query = new WP_Query($args);
    $job_alerts_count = $alerts_query->found_posts;
    
    ob_start();
    ?>
    <div class="dashboard-notifications">
        <ul>
            <li class="job">
                <div class="text-box"> <span class="text"><?php esc_html_e('Applied jobs', 'jobcircle-frame') ?></span> <?php echo ($total_applics) ?></div>
                <div class="circle">
                    <div class="ico-holder"><img src="<?php echo Jobcircle_Plugin::root_url() ?>images/job.png" alt=""></div>
                </div>
            </li>
            <li class="notification">
                <div class="text-box"> <span class="text"><?php esc_html_e('Job Alerts', 'jobcircle-frame') ?></span> <?php echo ($job_alerts_count) ?></div>
                <div class="circle">
                    <div class="ico-holder"><img src="<?php echo Jobcircle_Plugin::root_url() ?>images/notification.png" alt=""></div>
                </div>
            </li>
            <li class="alerts">
                <div class="text-box"> <span class="text"><?php esc_html_e('Shortlisted', 'jobcircle-frame') ?></span> <?php echo ($shortlisted_apps) ?></div>
                <div class="circle">
                    <div class="ico-holder"><img src="<?php echo Jobcircle_Plugin::root_url() ?>images/alert.png" alt=""></div>
                </div>
            </li>
            <li class="bookmark">
                <div class="text-box"> <span class="text"><?php esc_html_e('Bookmark jobs', 'jobcircle-frame') ?></span> <?php echo ($bookmarked_jobs_count) ?></div>
                <div class="circle">
                    <div class="ico-holder"><img src="<?php echo Jobcircle_Plugin::root_url() ?>images/bookmarks.png" alt="">
                    </div>
                </div>
            </li>
        </ul>
    </div>
    
    <div class="activity-charts">
        <?php 
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            ?>        
            <div class="invoices">
                <div class="heading"><?php esc_html_e('Packages', 'jobcircle-frame') ?></div>
                <?php
                $user_id = $current_user->ID;
                $reults_per_page = 15;
                $page_num = 1;
                $jobcircle_args = array(
                    //'post_type' => 'shop_order',
                    'limit' => $reults_per_page,
                    'paged' => $page_num,
                    'post_status' => array('wc-completed'),
                    'order' => 'DESC',
                    'orderby' => 'ID',
                    'meta_query' => array(
                        array(
                            'key' => 'order_attach_with_pkg',
                            'value' => 'yes',
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'order_user_id',
                            'value' => $user_id,
                            'compare' => '=',
                        ),
                    ),
                );
                $jobcircle_query = new WC_Order_Query($jobcircle_args);
                $jobcircle_orders = $jobcircle_query->get_orders();
                if (!empty($jobcircle_orders)) {
                    ?>
                    <ul>
                        <?php
                        foreach ($jobcircle_orders as $jobcircle_order) {
                            if (is_a($jobcircle_order, 'WC_Order')) {
                                $trans_order_id = $jobcircle_order->get_id();
                                $order_date = get_the_date();
                                $order_title = $jobcircle_order->get_meta('order_pkg_name');
                                ?>
                                <li>
                                    <div class="plan-detail">
                                        <div class="ico-holder" style="background-color: #eaf6ed;"><img src="<?php echo Jobcircle_Plugin::root_url() ?>images/plan-green.png" alt=""></div>
                                        <div class="text"><?php echo ($order_title) ?></div>
                                    </div>
                                    <div class="payment-status">
                                        <div class="text"> <span> <?php printf(esc_html__('Order:#%s', 'jobcircle-frame'), $trans_order_id) ?></span></div>
                                    </div>
                                    <div class="track-order">
                                        <div class="text"><?php printf(esc_html__('Date:%s', 'jobcircle-frame'), $order_date) ?></div>
                                    </div>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                    <?php
                } else {
                    ?>
                    <ul><li><div class="plan-detail" style="width: auto;"><div class="text"><?php esc_html_e('You don\'t have any package yet.', 'jobcircle-frame') ?></div></div></li></ul>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
        <div class="recent-activities">
            <div class="heading"><?php esc_html_e('Recent Activities', 'jobcircle-frame') ?></div>
            <?php echo do_shortcode('[job_cirlce_notifications]'); ?>
        </div>
    </div>

    <?php
    $sugg_jobs_posts = array();
    $job_title = get_post_meta($candidate_id, 'jobcircle_field_job_title', true);
    if ($job_title != '') {
        $args = array(
            'post_type' => 'jobs',
            'posts_per_page' => '10',
            'post_status' => 'publish',
            'fields' => 'ids',
            's' => $job_title
        );
        $posts_query = new WP_Query($args);
        $jobs_posts = $posts_query->posts;
        if (isset($jobs_posts[0])) {
            $sugg_jobs_posts = array_merge($sugg_jobs_posts, $jobs_posts);
        }
    }
    $get_cand_cats = wp_get_post_terms($candidate_id, 'candidate_cat', array('fields' => 'slugs'));
    // var_dump($get_cand_cats);
    if (!empty($get_cand_cats)) {
        $args = array(
            'post_type' => 'jobs',
            'posts_per_page' => '10',
            'post_status' => 'publish',
            'fields' => 'ids',
            'tax_query' => array(
                array(
                    'taxonomy' => 'job_category',
                    'field' => 'slug',
                    'terms' => $get_cand_cats,
                )
            )
        );
        $posts_query = new WP_Query($args);
        $jobs_posts = $posts_query->posts;
        if (isset($jobs_posts[0])) {
            $sugg_jobs_posts = array_merge($sugg_jobs_posts, $jobs_posts);
        }
    }
    if (!empty($sugg_jobs_posts)) {
        $sugg_jobs_posts = array_unique($sugg_jobs_posts);
        ?>
        <div class="candashb-suggested-jobs">
            <div class="jobcircle-dashb-section-upper">
                <div class="dashb-hding-con">
                    <h3><?php esc_html_e('Suggested Jobs for you', 'jobcircle-frame') ?></h3>
                </div>
            </div>
            <div class="table-block">
                <div class="alert-job-table-container">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"><?php esc_html_e('Job Title', 'jobcircle-frame') ?></th>
                                <th scope="col"><?php esc_html_e('Location', 'jobcircle-frame') ?></th>
                                <th scope="col"><?php esc_html_e('Date Posted', 'jobcircle-frame') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($sugg_jobs_posts as $job_id) {
                                $job_obj = get_post($job_id);
                                $job_post_date = $job_obj->post_date;
                                

                                $img_url = jobcircle_job_thumbnail_url($job_id);
                                ?>
                                <tr>
                                    <td class="row-first-column">
                                        <div class="image-holder"><a href="<?php echo get_permalink($job_id) ?>" target="_blank"><img src="<?php echo ($img_url) ?>"></a></div>
                                        <div class="textbox">
                                            <div><a href="<?php echo get_permalink($job_id) ?>" target="_blank"><?php echo get_the_title($job_id) ?></a></div>
                                            <div>
                                                <span class="job-status">Active</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo jobcircle_post_location_str($job_id) ?></td>
                                    <td><?php echo date_i18n(get_option('date_format'), strtotime($job_post_date)) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="space-top-footer"></div>
    <?php
    $html = ob_get_clean();
    return $html;
}
