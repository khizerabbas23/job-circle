<?php
function jobcircle_featured_job_sventeen()
{
    vc_map(
        array(
            'name' => __('Featured Job 17'),
            'base' => 'jc_featured_job_sventeen',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Sub Title'),
                    'param_name' => 'sub_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('View Btn Url'),
                    'param_name' => 'view_btn_url',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Order By'),
                    'param_name' => 'orderby',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Number Of Post'),
                    'param_name' => 'numofpost',
                ),
               array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Pagination'),
                'param_name' => 'pagination',
                'value' => array(
                    __('Yes', 'your_text_domain') => 'yes',
                    __('No', 'your_text_domain') => 'no',
                ),
            ),
            array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('View All Button'),
                'param_name' => 'view_all_button',
                'value' => array(
                    __('Yes', 'your_text_domain') => 'yes',
                    __('No', 'your_text_domain') => 'no',
                ),
            ),
            
        )
    )

);
}
add_action('vc_before_init', 'jobcircle_featured_job_sventeen');

// popular category frontend
function jobcircle_featured_job_sventeen_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'sub_title' => '',
            'view_btn_url' => '',

            'orderby' => '',
            'numofpost' => '',
            'pagination' => '',
            'view_all_button' => '',
        ), $atts, 'jobcircle_featured_job_sventeen'
    );
    wp_enqueue_script('jobcircle-jobfunctions');
    $title = isset($atts['title']) ? $atts['title'] : '';
    $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
    $view_btn_url = isset($atts['view_btn_url']) ? $atts['view_btn_url'] : '';
    $pagination  = isset($atts['pagination']) ? $atts['pagination'] : '';
    $view_all_button  = isset($atts['view_all_button']) ? $atts['view_all_button'] : '';
    ob_start();
    ?>
    <section class="section section-theme-17 featured_Jobs_Block page-theme-17">
        <div class="container">
            <div class="jobs_info_wrap">
                <!-- Section header -->
                <header class="section-header d-flex flex-column text-center mb-15 mb-md-30 mb-xl-30">
                    <?php
                    if (($title)) {
                        ?>
                        <p>
                            <?php echo esc_html($title) ?>
                        </p>
                        <?php
                    }
                    if (!empty($sub_title)) {
                        ?>
                        <h2>
                            <?php echo esc_html($sub_title) ?>
                        </h2>
                        <?php
                    } ?>
                </header>
                <div class="row">
                    <?php
                    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                    $args = array(
                        'post_type' => 'jobs',
                        'post_status' => 'publish',
                        'posts_per_page' => $numofpost,
                        'order' => 'DESC',
                        'orderby' => $orderby,
                        // 'tax_query' => array(
                        //         array(
                        //             'taxonomy' => 'job_category',
                        //             'field'    => 'slug',
                        //             'terms'    => 'featured-job',
                        //         ),
                        //     ),        
                    );
                    // Custom query.
                    $query = new WP_Query($args);
                    $total_posts = $query->found_posts;
                    // Check that we have query results.
                    if ($query->have_posts()) {
                        // Start looping over the query results.
                        while ($query->have_posts()) {
                            $query->the_post();
                            global $post;
                            $post = get_the_id();
                            $title = get_the_title($post);
                            $permalinkget = get_the_permalink($post);
                            $image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');
                            $job_salary = jobcircle_job_salary_str($post);
                            $job_location = jobcircle_post_location_str($post);
                            $tag = get_post_meta($post, 'tag', true);
                            $job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
                            $job_type_str = jobcircle_job_type_ret_str($job_type);
                          $picbgcolor = get_post_meta($post, 'jobcircle_field_bg_colors', true);
                            // $remote = get_post_meta($post, 'remote', true);
                            $post_terms = wp_get_post_terms($post, 'job_category', array('fields' => 'ids'));
                            $id_post = isset($post_terms[0]) ? $post_terms[0] : '';
                            $date = get_the_date('M d, Y');
                            global $current_user;
            $user_id = $current_user->ID;
        
            $fav_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
            $fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();
            $like_btn_class = 'jobcircle-favjab-btn';
            if(!is_user_logged_in(  )){
                $like_btn_class = 'jobcircle-favjab-btn no-user-follower-btn';
            }else{
                if(!jobcircle_user_candidate_id($user_id)){
                $like_btn_class = 'jobcircle-favjab-btn no-member-follower-btn';
                }
            }
            $fav_icon_class = 'profile-btn';
            $follow = 'fa fa-heart-o';
            
            if (in_array($post, $fav_jobs)) {
                $like_btn_class = 'jobcircle-alrdy-favjab';
                $fav_icon_class = 'profile-btn';
                $follow = 'fa fa-heart';
            }
                            ?>
                            <style>
                                .pin-job{
                                    position: relative;
                                    top: -8px;
                                    right: 7px;   
                                }
                            </style>
                            <div class="col-12 col-lg-6 mb-15 mb-xl-30 d-md-flex">
                                <div class="jobs_info_holder">
                                    <span class="badge">
                                    <a href="javascript:void(0)" class="pin-job <?php echo esc_html($like_btn_class); ?> " data-id="<?php echo esc_html($post); ?>"><i class=" <?php echo esc_html($fav_icon_class); ?> position-absolute <?php echo esc_html($follow); ?>"></i></a>	
                                       
                                        </span>
                                    <div class="wrap_holder">
                                        <div class="icon_holder " style ="background-color:<?php echo jobcircle_esc_the_html($picbgcolor) ?>;">
                                            <?php
                                            if (!empty($image[0])) {
                                                ?>
                                                <img src="<?php echo esc_url_raw($image[0]) ?>" alt="img">
                                                <?php
                                            } ?>
                                        </div>
                                        <div class="info_holder">
                                            <?php
                                            if (!empty($title)) {
                                                ?>
                                                <strong class="h6">
                                                    <?php echo esc_html($title) ?>
                                                </strong>
                                            <?php }
                                            if (!empty($job_salary)) {
                                                ?>
                                                <span class="amount"><strong>
                                                        <?php echo esc_html($job_salary) ?>
                                                    </strong></span>
                                                <?php
                                            } ?>
                                            <ul class="location_info">
                                                <?php
                                                if (!empty($job_location)) {
                                                    ?>
                                                    <li>
                                                        <i class="jobcircle-icon-map-pin icon mpicon"></i>
                                                        <span class="text">
                                                            <?php echo esc_html($job_location) ?>
                                                        </span>
                                                    </li>
                                                <?php }
                                                if (!empty($date)) {
                                                    ?>
                                                    <li>
                                                        <i class="jobcircle-icon-clock icon mpicon"></i>
                                                        <span class="text">
                                                            <?php echo esc_html($date) ?>
                                                        </span>
                                                    </li>
                                                    <?php
                                                } ?>
                                            </ul>
                                            <div class="apply_bar">
                                                <ul class="options">
                                                    <?php
                                                    if (!empty($job_type_str)) {
                                                        ?>
                                                        <li>
                                                            <a><?php echo esc_html($job_type_str['title']); ?></a>
                                                        </li>
                                                    <?php
                                                    } ?>
                                                </ul>
                                                <?php
                                                if (!empty($permalinkget)) {
                                                    ?>
                                                    <a href="<?php echo esc_html($permalinkget) ?>" class="btn btn-orange btn-sm">
                                                        <?php echo esc_html('Apply Now', 'jobcircle-frame') ?>
                                                    </a>
                                                    <?php
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                
                    }
                // Check if there are more posts than the specified number
                if ($total_posts > $numofpost && $pagination != 'no') {
                    ?>
                    <div class="pagination-container">
                        <?php echo jobcircle_pagination($query, true); ?>
                    </div>
                    <?php
                }
                    // Restore original post data
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="d-flex justify-content-center konsiclasss">
                    <?php if(!empty($view_btn_url)){
                        ?>
                    <a class="btn btn-orange btn-sm konsiclasss" href="<?php echo esc_html($view_btn_url) ?>"><span class="btn-text">
                            <?php echo esc_html_e('View All Jobs', 'jobcircle-frame') ?>
                        </span></a>
                        <?php } ?>
                </div>
                            <style>
                            .konsiclasss{
                                display: <?php echo ($view_all_button !== 'no') ? 'block' : 'none'; ?>;
                            }
                        </style>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_featured_job_sventeen', 'jobcircle_featured_job_sventeen_frontend');
