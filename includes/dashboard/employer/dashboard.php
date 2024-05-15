<?php

function jobcircle_dashb_employer_dashboard() {
    global $current_user;

    $user_id = $current_user->ID;
    

                 
    $args = array(
        'post_type' => 'jobs',
        'author' => $user_id,
        'post_status' => array('publish'),
        'fields' => 'ids',
        'order' => 'DESC',
        'orderby' => 'ID',
    );
    
    
    $jobs_query = new WP_Query($args);
    $total_jobs = $jobs_query->found_posts;
    

  

    $jobs_ids = $jobs_query->posts;
    if (empty($jobs_ids)) {
        $jobs_ids = array(0);
    }

    //
    $args = array(
        'post_type' => 'job_applic',
        'post_status' => array('publish'),
        'fields' => 'ids',
        'order' => 'DESC',
        'orderby' => 'ID',
        'meta_query' => array(
            array(
                'key' => 'applic_job_id',
                'value' => $jobs_ids,
                'compare' => 'IN',
            ),
        ),
    );
    $applics_query = new WP_Query($args);
    $total_applics = $applics_query->found_posts;

    //
    $bookmarked_resumes_count = 0;
    $bookmarked_resumes = get_user_meta($user_id, 'fav_follower_list', true);
    if (!empty($bookmarked_resumes)) {
        $bookmarked_resumes_count = count($bookmarked_resumes);
    }

    //
    $followers_count = 0;
    $followers_list = get_user_meta($user_id, 'emp_follower_list', true);
    if (!empty($followers_list)) {
        $followers_count = count($followers_list);
    }

    ob_start();
    ?>
    <div class="dashboard-notifications">
        <ul>
            <li class="job">
                <div class="text-box"> <span class="text"><?php esc_html_e('Submit Jobs', 'jobcircle-frame') ?></span> <?php echo ($total_jobs) ?></div>

                <div class="circle">
                    <div class="ico-holder"><img src="<?php echo Jobcircle_Plugin::root_url() ?>images/job.png" alt=""></div>
                </div>
            </li>
            <li class="notification">
                <div class="text-box"> <span class="text"><?php esc_html_e('Job Applications', 'jobcircle-frame') ?></span> <?php echo ($total_applics) ?></div>
                <div class="circle">
                    <div class="ico-holder"><img src="<?php echo Jobcircle_Plugin::root_url() ?>images/notification.png" alt=""></div>
                </div>
            </li>
            <li class="alerts">
                <div class="text-box"> <span class="text"><?php esc_html_e('Followers', 'jobcircle-frame') ?></span> <?php echo ($followers_count) ?></div>
                <div class="circle">
                    <div class="ico-holder"><img src="<?php echo Jobcircle_Plugin::root_url() ?>images/alert.png" alt=""></div>
                </div>
            </li>
            <li class="bookmark">
                <div class="text-box"> <span class="text"><?php esc_html_e('Bookmark resumes', 'jobcircle-frame') ?></span> <?php echo ($bookmarked_resumes_count) ?></div>
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
                $reults_per_page = 15;
                $page_num = 1;
                $jobcircle_args = array(
                    'post_type' => 'shop_order',
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
    
    <div class="row employer-team-members">
        <?php echo do_shortcode('[job_circle_employer_team_members]'); ?>
    </div>
    
    <div class="space-top-footer"></div>
    <?php
    $html = ob_get_clean();
    return $html;
}
