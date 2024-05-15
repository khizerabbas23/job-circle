<?php

add_filter('jobcircle_dashboard_employer_manage_jobs_html', 'jobcircle_dashboard_employer_manage_jobs_html');

function jobcircle_dashboard_employer_manage_jobs_html() {
    global $current_user, $jobcircle_framework_options;
    $user_id = $current_user->ID;
    
    $page_permissions = jobcircle_check_page_permissions('employer','manage-jobs');    
    if($page_permissions === 0){
        $home_page_url = home_url('/');  
        echo '<script>window.location.href="'.$home_page_url.'"</script>';
        exit;      
    }

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
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="mb-4 tbl-lg rounded overflow-hidden">
                    <div class="table-responsive bg-white jobcircle-mangjobs-con" style="position: relative;">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Application Deadline</th>
                                    <th scope="col">Applications</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <?php
                            
                            
                            $args = array(
                                'post_type' => 'jobs',
                                'posts_per_page' => '50',
                                'post_status' => 'publish',
                                'author' => $user_id,
                                'order' => 'DESC',
                                'orderby' => 'ID',
                            );
                            $posts_query = new WP_Query($args);
                            
                            
                            
                           
                        
                            //
                            $argsw = array(
                                'post_type' => 'job_applic',
                                'author' => $user_id,
                                'post_status' => array('publish'),
                                'fields' => 'ids',
                                'order' => 'DESC',
                                'orderby' => 'ID',
                                'meta_query' => array(
                                    array(
                                        'key' => 'applic_job_id',
                                         
                                    ),
                                ),
                            );
                            $applics_query = new WP_Query($argsw);
                            $total_applics = $applics_query->found_posts;
  
                            ?>
                            <tbody>
                                <?php
                                if ($posts_query->have_posts()) {
                                    while ($posts_query->have_posts()) : $posts_query->the_post();
                                        $job_id = get_the_id();
                                        $job_obj = get_post($job_id);
                                        $job_post_date = $job_obj->post_date;

                                        $application_deadline = get_post_meta($job_id, 'jobcircle_field_job_deadline', true);
                                        ?>
                                        <tr>
                                            <td><div class="dash-title"><strong><?php echo get_the_title($job_id) ?></strong></div></td>
                                            <?php
                                            if ($application_deadline != '') {
                                                ?>
                                                <td><?php echo date_i18n(get_option('date_format'), strtotime($application_deadline)) ?></td>
                                                <?php
                                            } else {
                                                ?>
                                                <td><span>----</span></td>
                                                <?php
                                            }
                                             
                                            ?>
                                            <?php
                                            if ($total_applics != '') {
                                                ?>
                                            <td><?php echo ($total_applics) ?></td>
                                            <?php
                                            } else {
                                                ?>
                                                 <td><span>----</span></td>
                                                <?php
                                            }
                                             
                                            ?>
                                                 
                                               
                                            <td>
                                                <div class="dash-action">
                                                    <a href="<?php echo get_permalink($job_id) ?>" class="p-2 circle text-info bg-light-info d-inline-flex align-items-center justify-content-center me-1"><i class="fa fa-eye"></i></a>
                                                    <a href="<?php echo add_query_arg(array('account_tab' => 'post-job', 'id' => $job_id, 'action' => 'update'), $account_page_url) ?>" class="p-2 circle text-success bg-light-success d-inline-flex align-items-center justify-content-center"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0);" data-id="<?php echo ($job_id) ?>" class="jobcircle-mangjob-delbtn p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    endwhile;
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6">No job found.</td>
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
    $html = ob_get_clean();
    return $html;
}
