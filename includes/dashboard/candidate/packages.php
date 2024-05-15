<?php

add_filter('jobcircle_dashboard_candidate_packages_html', 'jobcircle_dashboard_candidate_packages_html');

function jobcircle_dashboard_candidate_packages_html() {
    global $current_user;
    $user_id = $current_user->ID;
  
    $page_permissions = jobcircle_check_page_permissions('candidate','packages');    
    if($page_permissions === 0){
        $home_page_url = home_url('/');  
        echo '<script>window.location.href="'.$home_page_url.'"</script>';
        exit;      
    }
    $jobcircle_packages_list   = apply_filters('jobcircle_candidate_packages', array());    
    ob_start();
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        ?>
        <div class="dashboard-widg-bar d-block">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <h6 class="my-title"><?php esc_html_e('Active Packages', 'jobcircle-frame');?></h6>
                    <div class="mb-4 tbl-lg rounded overflow-hidden">
                        <div class="table-responsive bg-white">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col"><?php esc_html_e('Order ID.', 'jobcircle-frame') ?></th>
                                        <th scope="col"><?php esc_html_e('Package Title', 'jobcircle-frame') ?></th>
                                        <th scope="col"><?php esc_html_e('Features', 'jobcircle_frame');?></th>
                                        <th scope="col"><?php esc_html_e('Date', 'jobcircle-frame') ?></th>
                                        <th scope="col"><?php esc_html_e('Status', 'jobcircle-frame') ?></th>
                                    </tr>
                                </thead>
                                <?php
                                
                                $jobcircle_args = array(
                                    'limit' => -1,
                                    'post_status' => array('wc-completed'),
                                    'customer_id' => $user_id,
                                    'order' => 'DESC',
                                    'orderby' => 'ID',
                                    'meta_query' => array(
                                        array(
                                            'key' => 'order_attach_with_pkg',
                                            'value' => 'yes',
                                            'compare' => '=',
                                        ),
                                        array(
                                            'key'     => 'order_pkg_type',
                                            'value'   => array_keys( $jobcircle_packages_list ), // get all package types
                                            'compare' => 'IN',
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
                                ?>
                                <tbody>
                                    <?php
                                    if (!empty($jobcircle_orders)) {
                                        foreach ($jobcircle_orders as $jobcircle_order) {
                                            if (is_a($jobcircle_order, 'WC_Order')) {
                                                $order_id = $jobcircle_order->get_id();
                                                $order_type = $jobcircle_order->get_meta('order_pkg_type');
                                                $trans_order_name = $jobcircle_order->get_meta('order_pkg_name');
                                                $total_credits = $jobcircle_order->get_meta('order_numof_applics');
                                                $trans_order_obj = wc_get_order($order_id);

                                                if ($trans_order_name == '') {
                                                    foreach ($jobcircle_order->get_items() as $oitem_id => $oitem_product) {
                                                        //Get the WC_Product object
                                                        $oproduct = $oitem_product->get_product();

                                                        if (is_object($oproduct)) {
                                                            $trans_order_name = get_the_title($oproduct->get_ID());
                                                        }
                                                    }
                                                }
                                                $order_date_obj = $jobcircle_order->get_date_created();
                                                $order_date_array = json_decode(json_encode($order_date_obj), true);
                                                $order_date = isset($order_date_array['date']) ? date_i18n(get_option('date_format'), strtotime($order_date_array['date'])) : '';
                                                //$order_type = $jobcircle_order->get_meta('order_pkg_type');        
                                                $pkg_status = esc_html__('Active', 'jobcircle-frame');   
                                                $status_class = 'theme-cl';                                 
                                                ?>
                                                <tr>
                                                    <td><span>#<?php echo intval($order_id) ?></span></td>
                                                    <td><a href="javascript:void(0);" class="theme-cl"><?php echo ($trans_order_name) ?></a></td>
                                                    <td>
                                                        <?php
                                                        if($order_type == 'cand_applics'){
                                                            $used_credits = jobcircle_candidate_applics_pkg_used_credits($order_id);
                                                            $remainin_credits = jobcircle_candidate_applics_pkg_remainin_credits($order_id);        
                                                            $pkg_expired = jobcircle_candidate_applics_pkg_expired($order_id);                                                        
                                                            
                                                            if ($pkg_expired) {
                                                                $pkg_status = esc_html__('Expired', 'jobcircle_frame');
                                                                $status_class = 'text-danger';
                                                            }
                                                            echo '<div class="jobcircle-features">';
                                                                esc_html_e('Job Applications: ', 'jobcircle-frame');
                                                                echo '<span>'.intval($total_credits).'</span>';
                                                            echo '</div>';   
                                                            echo '<div class="jobcircle-features">';
                                                                esc_html_e('Used Credits: ', 'jobcircle-frame');
                                                                echo '<span>'.intval($used_credits).'</span>';
                                                            echo '</div>';  
                                                            echo '<div class="jobcircle-features">';
                                                                esc_html_e('Remaining Applications: ', 'jobcircle-frame');
                                                                echo '<span>'.intval($remainin_credits).'</span>';
                                                            echo '</div>';       
                                                        } elseif($order_type == 'cand_profile'){
                                                            $candidate_profile_my_resume = $jobcircle_order->get_meta('order_cand_my_resume');
                                                            $candidate_profile_cv_manager = $jobcircle_order->get_meta('order_cand_cv_manager');
                                                            $candidate_profile_applied_jobs = $jobcircle_order->get_meta('order_cand_applied_jobs');
                                                            $candidate_profile_bookmark_jobs = $jobcircle_order->get_meta('order_cand_bookmark_jobs');
                                                            $candidate_profile_job_alerts = $jobcircle_order->get_meta('order_cand_job_alerts');
                                                            $candidate_profile_packages = $jobcircle_order->get_meta('order_cand_packages');

                                                            $candidate_post_new_job  = ($candidate_profile_my_resume == 'on') ? 'Yes' : 'No';
                                                            $candidate_manage_jobs  = ($candidate_profile_cv_manager == 'on') ? 'Yes' : 'No';
                                                            $candidate_profile_applied_jobs  = ($candidate_profile_applied_jobs == 'on') ? 'Yes' : 'No';
                                                            $candidate_profile_bookmark_jobs  = ($candidate_profile_bookmark_jobs == 'on') ? 'Yes' : 'No';
                                                            $candidate_profile_job_alerts  = ($candidate_profile_job_alerts == 'on') ? 'Yes' : 'No';
                                                            $candidate_profile_packages  = ($candidate_profile_packages == 'on') ? 'Yes' : 'No';
                                                                echo '<div class="jobcircle-features">';
                                                                    esc_html_e('My Resume:', 'jobcircle-frame');
                                                                    echo '<span>'.esc_html($candidate_post_new_job).'</span>';
                                                                echo ' </div>';
                                                                echo '<div class="jobcircle-features">';
                                                                    esc_html_e('CV Manager:', 'jobcircle-frame');
                                                                    echo '<span>'.esc_html($candidate_manage_jobs).'</span>';
                                                                echo ' </div>';
                                                                echo '<div class="jobcircle-features">';
                                                                    esc_html_e('Applied Jobs:', 'jobcircle-frame');
                                                                    echo '<span>'.esc_html($candidate_profile_applied_jobs).'</span>';
                                                                echo ' </div>';
                                                                echo '<div class="jobcircle-features">';
                                                                    esc_html_e('Bookmark Jobs:', 'jobcircle-frame');
                                                                    echo '<span>'.esc_html($candidate_profile_bookmark_jobs).'</span>';
                                                                echo ' </div>';
                                                                echo '<div class="jobcircle-features">';
                                                                    esc_html_e('Job Alerts:', 'jobcircle-frame');
                                                                    echo '<span>'.esc_html($candidate_profile_job_alerts).'</span>';
                                                                echo ' </div>';
                                                                echo '<div class="jobcircle-features">';
                                                                    esc_html_e('Packages:', 'jobcircle-frame');
                                                                    echo '<span>'.esc_html($candidate_profile_packages).'</span>';
                                                                echo ' </div>';
                                                                $pkg_status = esc_html__('Active', 'jobcircle_frame');                                                        
                                                        } else {
                                                            do_action('jobcircle_candiate_active_packages_filter', $trans_order_obj);
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo ($order_date) ?></td>
                                                    <td><span class="<?php echo ($status_class) ?>"><?php echo ($pkg_status) ?></span></td>
                                                </tr>
                                                <?php
                                            }
                                        
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="7"><?php esc_html_e('No Purchased package found.', 'jobcircle-frame') ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="mb-4 tbl-lg rounded overflow-hidden">
                        <div class="table-responsive bg-white pricing_wrap">
                            <?php esc_html_e('Purchase Package', 'jobcircle-frame');?>
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>                                    
                                        <th scope="col"><?php esc_html_e('Package Title', 'jobcircle_frame');?></th>
                                        <th scope="col"><?php esc_html_e('Features', 'jobcircle_frame');?></th>
                                        <th scope="col"><?php esc_html_e('Price', 'jobcircle_frame');?></th>
                                        <th scope="col"><?php esc_html_e('Action', 'jobcircle_frame');?></th>
                                    </tr>
                                </thead>
                                <?php                            
                                $args = array(
                                    'post_type' => 'product',
                                    'status'       => 'publish', // Only retrieve published products
                                    'limit'        => -1, // Get all products
                                    'order'         => 'DESC',
                                    'orderby'       => 'ID',
                                    'meta_query'   => array(
                                        array(
                                            'key'     => 'jobcircle_field_prod_attachwith_pkg',
                                            'value'   => 'yes',
                                            'compare' => '=',
                                        ),
                                        array(
                                            'key'     => 'jobcircle_field_prod_pkgtype',
                                            'value'   => array_keys($jobcircle_packages_list),
                                            'compare' => 'IN',
                                        ),
                                    ),
                                );              
                                $products = new WP_Query( $args );
                                ?>
                                <tbody>
                                    <?php
                                    if ( $products->have_posts() ) {
                                        while ( $products->have_posts() ) {
                                            $products->the_post();
                                            $jobcircle_product = wc_get_product(get_the_id());
                                            if ($jobcircle_product) {
                                                $jobcircle_product_id = $jobcircle_product->get_id();
                                                $jobcircle_product_price = $jobcircle_product->get_price();
                                                $prod_pkg_type = get_post_meta($jobcircle_product_id, 'jobcircle_field_prod_pkgtype', true);
                                                ?>
                                                <tr>
                                                    <td><a href="javascript:void(0);" class="theme-cl"><?php echo the_title(); ?></a></td>
                                                    <td>                                                    
                                                        <div class= "jobcircle-package-features">
                                                            <?php
                                                            if($prod_pkg_type == 'cand_applics'){
                                                                $num_of_jobs = get_post_meta($jobcircle_product_id, 'jobcircle_field_numof_applics', true);
                                                                echo '<span>';
                                                                    esc_html_e('Job Applications :', 'jobcircle-frame');
                                                                    echo intval($num_of_jobs);
                                                                echo '</span>';
                                                            } elseif($prod_pkg_type == 'cand_profile'){
                                                                $candidate_profile_my_resume = get_post_meta($jobcircle_product_id, 'jobcircle_field_can_my_resume', true);
                                                                $candidate_profile_cv_manager = get_post_meta($jobcircle_product_id, 'jobcircle_field_can_cv_manager', true);
                                                                $candidate_profile_applied_jobs = get_post_meta($jobcircle_product_id, 'jobcircle_field_can_applied_jobs', true);
                                                                $candidate_profile_bookmark_jobs = get_post_meta($jobcircle_product_id, 'jobcircle_field_can_bookmark_jobs', true);
                                                                $candidate_profile_job_alerts = get_post_meta($jobcircle_product_id, 'jobcircle_field_can_job_alerts', true);
                                                                $candidate_profile_packages = get_post_meta($jobcircle_product_id, 'jobcircle_field_can_packages', true);

                                                                $candidate_post_new_job  = ($candidate_profile_my_resume == 'on') ? 'Yes' : 'No';
                                                                $candidate_manage_jobs  = ($candidate_profile_cv_manager == 'on') ? 'Yes' : 'No';
                                                                $candidate_profile_applied_jobs  = ($candidate_profile_applied_jobs == 'on') ? 'Yes' : 'No';
                                                                $candidate_profile_bookmark_jobs  = ($candidate_profile_bookmark_jobs == 'on') ? 'Yes' : 'No';
                                                                $candidate_profile_job_alerts  = ($candidate_profile_job_alerts == 'on') ? 'Yes' : 'No';
                                                                $candidate_profile_packages  = ($candidate_profile_packages == 'on') ? 'Yes' : 'No';

                                                                echo '<div class="jobcircle-features">';
                                                                    esc_html_e('My Resume:', 'jobcircle-frame');
                                                                    echo '<span>'.esc_html($candidate_post_new_job).'</span>';
                                                                echo ' </div>';
                                                                echo '<div class="jobcircle-features">';
                                                                    esc_html_e('CV Manager:', 'jobcircle-frame');
                                                                    echo '<span>'.esc_html($candidate_manage_jobs).'</span>';
                                                                echo ' </div>';
                                                                echo '<div class="jobcircle-features">';
                                                                    esc_html_e('Applied Jobs:', 'jobcircle-frame');
                                                                    echo '<span>'.esc_html($candidate_profile_applied_jobs).'</span>';
                                                                echo ' </div>';
                                                                echo '<div class="jobcircle-features">';
                                                                    esc_html_e('Bookmark Jobs:', 'jobcircle-frame');
                                                                    echo '<span>'.esc_html($candidate_profile_bookmark_jobs).'</span>';
                                                                echo ' </div>';
                                                                echo '<div class="jobcircle-features">';
                                                                    esc_html_e('Job Alerts:', 'jobcircle-frame');
                                                                    echo '<span>'.esc_html($candidate_profile_job_alerts).'</span>';
                                                                echo ' </div>';
                                                                echo '<div class="jobcircle-features">';
                                                                    esc_html_e('Packages:', 'jobcircle-frame');
                                                                    echo '<span>'.esc_html($candidate_profile_packages).'</span>';
                                                                echo ' </div>';
                                                            } else {
                                                                do_action('jobcirlce_candidate_package_features', $jobcircle_product_id);
                                                            }
                                                            ?>                                            
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript:void(0);" class="theme-cl"><?php echo jobcircle_esc_the_html($jobcircle_product->get_price_html()); ?></a></td>
                                                    <td><a href="javascript:void(0);" class="btn btn-green btn-sm jobcircle-link jobcircle-user-pkg-buybtn" data-id="<?php echo intval($jobcircle_product_id) ?>"><span class="btn-text btn-hover"><?php esc_html_e('Buy Now', 'jobcircle-frame'); ?></span></a></td>
                                                </tr>
                                                <?php
                                                do_action('jobcirlce_candidate_packages_listing_filter', $jobcircle_product);
                                            }
                                        }
                                        wp_reset_postdata();
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="7"><?php esc_html_e('No package found.', 'jobcircle_frame');?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
                
        </div>
        <?php
    } else {
        ?>
        <div class="dashboard-widg-bar d-block">
            <div class="row">
                <div class="postjob-pakges-nofound">
                    <span><?php esc_html_e('You can\'t buy package. Please contact to the administrator.', 'jobcircle-frame') ?></span>
                </div>
            </div>
        </div>
        <?php
    }
    $html = ob_get_clean();
    return $html;
}
