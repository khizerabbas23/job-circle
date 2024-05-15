<?php

add_filter('jobcircle_dashboard_candidate_applied_jobs_html', 'jobcircle_dashboard_candidate_applied_jobs_html');

function jobcircle_dashboard_candidate_applied_jobs_html() {

    global $current_user, $jobcircle_framework_options;

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);

    $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';

    $account_page_id = jobcircle_get_page_id_from_name($account_page_name);

    $account_page_url = home_url('/');
    if ($account_page_id > 0) {
        $account_page_url = get_permalink($account_page_id);
    }

    ob_start();
    ?>
    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <?php
            $args = array(
                'post_type' => 'job_applic',
                'posts_per_page' => '50',
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'user_cand_id',
                        'value' => $candidate_id
                    )
                ),
                'order' => 'DESC',
                'orderby' => 'ID',
            );
    
            $posts_query = new WP_Query($args);
    
            if ($posts_query->have_posts()) {
                ?>
                <div class="table-block">
                    <div class="alert-job-table-container">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col"><?php esc_html_e('Job Title', 'jobcircle-frame') ?></th>
                                    <th scope="col"><?php esc_html_e('Location', 'jobcircle-frame') ?></th>
                                    <th scope="col"><?php esc_html_e('Applied Date', 'jobcircle-frame') ?></th>
                                    <th scope="col"><?php esc_html_e('Action', 'jobcircle-frame') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($posts_query->have_posts()) : $posts_query->the_post();
                                    $applic_id = get_the_id();
                                    $applic_obj = get_post($applic_id);
                                    $applic_post_date = $applic_obj->post_date;
                                    
                                    $job_id = get_post_meta($applic_id, 'applic_job_id', true);
                                    $aplicant_job_title = get_post_meta($applic_id, 'applic_job_title', true);
                                    $aplicant_email = get_post_meta($applic_id, 'applic_user_email', true);
        
                                    $aplicant_resp_status = get_post_meta($applic_id, 'applic_response_status', true);
                                    $applic_status_str = '';
                                    if ($aplicant_resp_status != '') {
                                        $applic_status_str = $aplicant_resp_status == 'shortlisted' ? esc_html__('Shortlisted', 'jobcircle-frame') : esc_html__('Rejected', 'jobcircle-frame');
                                        $applic_status_color = $aplicant_resp_status == 'shortlisted' ? '#01b16f' : '#ff0000';
                                    }

                                    $img_url = jobcircle_job_thumbnail_url($job_id);
                                    ?>
                                    <tr>
                                        <td class="row-first-column">
                                            <div class="image-holder"><img src="<?php echo ($img_url) ?>"></div>
                                            <div class="textbox">
                                                <div><?php echo get_the_title($job_id) ?> <span>(Full Time)</span></div>
                                                <div>
                                                    <span class="job-status">Active</span>
                                                    <?php
                                                    if ($applic_status_str != '') {
                                                        ?>
                                                        &nbsp;<span class="job-status applic-status" style="color: <?php echo ($applic_status_color) ?>;">(<?php echo ($applic_status_str) ?>)</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo jobcircle_post_location_str($job_id) ?></td>
                                        <td><?php echo date_i18n(get_option('date_format'), strtotime($applic_post_date)) ?></td>
                                        <td>
                                            <div class="actions-icons">
                                                <div class="icon-holder blue-color"><a href="<?php echo get_permalink($job_id) ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAOCAYAAAArMezNAAAB0klEQVQ4jXXUS4hPYRgG8N9IyW1B2WhmI8wSC5ERzR+pKSmkFHINKYUaNZKkSXKZWYma5JZbk5pZWIlIbmUhm1lMlhTNaBgyRfTqPXX8O546nfO9l+c83/t+79dQ6xz1H0zHcrRhCWak/ROe4T4eY7gqeXyFrQGbcRjz8DZJ3qV/FlZjF97gHG7gd5lkXB1pJPXiMoawCi2l9VB+t6RvONe9mVupeBFuYTJ2pIpJ6MI2fM24qbiCg1iBLTiLB9iEl2XFUceHGMFKXE97N3ajHQvyaU9bd8Zcy5wvydH2t561ztHW3MoANuBDaQePcAKn60p2BMfRWijEzORpDp5Q3IPPWF8ilQET0V/R4P70NZds75MjuHqCuA9NWFuXHGX5icYK4sb0jdTZ1yRXXxB34CYuZkMKPMcgzmRwgaa0DWZMgci9lFwdcSp+YC++4zzm4Cg+4gDu4VW+A+swJd8RMw2d2IcLOISx4riNYX+qOIWlOJZlWog9eXYDt1PZQJbvJOYmYVchv2qkgzSCF+dkXcWT/HlgApZhK+bjRYp4WiapGukIiKnaiO25zRia6HYgtv4Nr7ETd7OR/6CKOBCB0YQ7eRHVMDt9Ua4YhLiAflVm4w+thnMpIM1DQgAAAABJRU5ErkJggg=="></a></div>
                                                <span class="icon-middle-span"></span>
                                                <div class="icon-holder"><a href="javascript:void(0);"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAAXCAYAAAAGAx/kAAABwklEQVQ4je3VvY9NYRAH4Ofce5ZdQrmJf4BCQSKUEhGNSkKDQiSi0axENPRETUOj0UgkKkFstAq2WoWEgopNZH2LvVwyN3OS2cstdAqTnMyc9535zceZmdMs7d1pjKYxh6PoY5jXveS3cAkfq1k7joKDOIyLeIQ1eb6C7TiPV7g2DjSDfdiErziWd+uxK6MK+oF1GeHxfA/7t7gXqZ3FEbxBg5/59FcHOjqrvNOdxe1ADKBzuJF1+JbeZlJ5nL6k3nRGtx+XA+gJdqfxbPE2TI9NiaRJkGHypUx/MYDO4Cr24C6mSgS9kmqVm6znCbzHyQBajGJhG06n0iB5gH5P404ephz8StZ2oZeVj8NPif4Op7INlnEgv+Ry1mMudT9kL4WTti0p9IscXfoy5a2ldlvybjrBevk0vd8/yogGmUYnD0ovDf5kMAnor+k/0D8ANFV2VVvGpi37aRXVhuw2YfCFbP3o2md4nXfPywipQ92WQdxYPFwo8vUix6qptAGfwz6AooOf5nKLuYpoRm0/Ie1wGlFvxo7c3ytdavdxCDfxuKyNSUAxKjFzD3EngDvlGMB5vMhiToqmo7X5A3gw2hb4BaKkdIzzc43cAAAAAElFTkSuQmCC"></a></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            } else {
                echo '<div class="dashboard-norecord-message">';
                echo '<div class="norec-msg-holdr"><p>' . esc_html__('No results found.', 'jobcircle-frame') . '</p></div>';
                echo '</div>';
            }
            ?>
        </div>
        
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                
            </div>
        </div>
            
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
}
