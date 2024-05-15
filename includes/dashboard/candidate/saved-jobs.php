<?php

add_filter('jobcircle_dashboard_candidate_saved_jobs_html', 'jobcircle_dashboard_candidate_saved_jobs_html');

function jobcircle_dashboard_candidate_saved_jobs_html() {
    
    $page_permissions = jobcircle_check_page_permissions('candidate','saved-jobs');    
    if($page_permissions === 0){
        $home_page_url = home_url('/');  
        echo '<script>window.location.href="'.$home_page_url.'"</script>';
        exit;      
    }
    
    ob_start();
    ?>

    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <?php
            global $current_user;
            $user_id = $current_user->ID;
            $faver_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
            if (!empty($faver_jobs)) {
                ?>
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="cl-justify">

                        <div class="cl-justify-first">
                            <p class="m-0 p-0 ft-sm"> <?php esc_html_e('You have saved', 'jobcircle-frame') ?> <span class="text-dark ft-medium" id="totalFavoritesCount"><?php echo count($faver_jobs) ?></span> <?php esc_html_e('jobs', 'jobcircle-frame') ?></p>
                        </div>

                    </div>
                </div>
                <?php
            }
            ?>
            <div class="table-responsive bg-white">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><?php esc_html_e('Job Title', 'jobcircle-frame') ?></th>
                            <th scope="col"><?php esc_html_e('Status', 'jobcircle-frame') ?></th>
                            <th scope="col"><?php esc_html_e('Action', 'jobcircle-frame') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($faver_jobs)) {
                            $sort_key = isset($_GET['sortby']) ? $_GET['sortby'] : '';
                            if ($sort_key == 'asc') {
                                $favjobs_with_titles = $new_fav_jobs = [];

                                foreach ($faver_jobs as $candidateId) {
                                    $favjobs_with_titles[$candidateId] = get_the_title($candidateId);
                                }
                               
                                asort($favjobs_with_titles);
                                foreach ($favjobs_with_titles as $fav_id => $fav_title) {
                                    $new_fav_jobs[] = $fav_id;
                                }
                                $faver_jobs = $new_fav_jobs;
                            } else {
                                rsort($faver_jobs);
                            }
                            foreach ($faver_jobs as $candidateId) {
                                $time_tag = get_post_meta($candidateId, 'jobcircle_field_time_tag', true);
                                $categories = get_the_terms($candidateId, 'job_category');
                                
                                                                
                                $experiance = get_post_meta($candidateId, 'jobcircle_field_experiance', true);
                                $location = jobcircle_post_location_str($candidateId, 'jobcircle_field_loc_city', true);
                                $image = wp_get_attachment_image_src(get_post_thumbnail_id($candidateId), '96');
                                $postid = $candidateId; // Use candidateId as the post ID
                                $permalink = get_permalink($postid);

                                
                                ?>
                                <tr>
                                    <td>
                                        <div class="jobcircle-post-item cats-box rounded bg-white d-flex align-items-center">
                                            <div class="text-center"><img src="<?php echo jobcircle_esc_the_html($image[0]); ?>" class="img-fluid" width="55" alt=""></div>
                                            <div class="cats-box-caption px-2">
                                                <h4 class="fs-md mb-0 ft-medium"><?php echo get_the_title($candidateId); ?> (<?php echo jobcircle_esc_the_html($experiance); ?> Exp.)</h4>
                                                <div class="d-block mb-2 position-relative">
                                                    <span class="text-muted medium"><i class="fa fa-map-marker me-1"></i><?php echo  jobcircle_esc_the_html($location) ?></span>
                                                    <?php foreach ($categories as $category){ 
                                                        ?>
                                                    <span class="muted medium ms-2 theme-cl"><i class="fa fa-briefcase me-1"></i><?php echo ($category->name) ?></span>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-info"><?php esc_html_e('Active', 'jobcircle-frame') ?></span></td>
                                    <td>
                                        <div class="dash-action">
                                            <a class="jobcircle-delete-post-btn p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1" data-id="<?php echo jobcircle_esc_the_html($postid) ?>"><i class="fa fa-trash"></i></a>
                                            <a class ="eye-icone" href="<?php echo jobcircle_esc_the_html($permalink) ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAOCAYAAAArMezNAAAB0klEQVQ4jXXUS4hPYRgG8N9IyW1B2WhmI8wSC5ERzR+pKSmkFHINKYUaNZKkSXKZWYma5JZbk5pZWIlIbmUhm1lMlhTNaBgyRfTqPXX8O546nfO9l+c83/t+79dQ6xz1H0zHcrRhCWak/ROe4T4eY7gqeXyFrQGbcRjz8DZJ3qV/FlZjF97gHG7gd5lkXB1pJPXiMoawCi2l9VB+t6RvONe9mVupeBFuYTJ2pIpJ6MI2fM24qbiCg1iBLTiLB9iEl2XFUceHGMFKXE97N3ajHQvyaU9bd8Zcy5wvydH2t561ztHW3MoANuBDaQePcAKn60p2BMfRWijEzORpDp5Q3IPPWF8ilQET0V/R4P70NZds75MjuHqCuA9NWFuXHGX5icYK4sb0jdTZ1yRXXxB34CYuZkMKPMcgzmRwgaa0DWZMgci9lFwdcSp+YC++4zzm4Cg+4gDu4VW+A+swJd8RMw2d2IcLOISx4riNYX+qOIWlOJZlWog9eXYDt1PZQJbvJOYmYVchv2qkgzSCF+dkXcWT/HlgApZhK+bjRYp4WiapGukIiKnaiO25zRia6HYgtv4Nr7ETd7OR/6CKOBCB0YQ7eRHVMDt9Ua4YhLiAflVm4w+thnMpIM1DQgAAAABJRU5ErkJggg==">
                                                    </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="7"><?php esc_html_e('No result found.', 'jobcircle-frame') ?></td>
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
    $html = ob_get_clean();
    return $html;
}
