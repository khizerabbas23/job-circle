<?php
function featured_job_fpurteen()
{
     $all_page = array( __('Select Page', 'jobcircle-frame'), '');
    $args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'meta_key' => '',
        'meta_value' => '',
        'authors' => '',
        'child_of' => 0,
        'parent' => -1,
        'exclude_tree' => '',
        'number' => '',
        'offset' => 0,
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $pages = get_pages($args);
    if (!empty($pages)) {
        foreach ($pages as $page) {
            $all_page[$page->post_title] = $page->post_name;
        }
    }
    vc_map(
        array(
            'name' => __('Feature Job 14'),
            'base' => 'featured_job_fpurteen',
            'category' => __('job Circle'),
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
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button'),
                    'param_name' => 'btn_name',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'btn_url',
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
                'heading' => __('Jobcircle Page', 'jobcircle-frame'),
                'param_name' => 'jobcircle_page',
                'description' => __('Select Jobcircle Page', 'jobcircle-frame'),
                'value' =>  $all_page,
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
add_action('vc_before_init', 'featured_job_fpurteen');

// popular category frontend

function featured_job_fpurteen_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'heading' => '',
            'btn_name' => '',
            'btn_url' => '',
            'orderby' => '',
            'numofpost' => '',
            'pagination' => '',
            'view_all_button' => '',
            
        	'jobcircle_page' => '',      
        ),
        $atts,
        'featured_job_fpurteen'
    );
    wp_enqueue_script('jobcircle-jobfunctions');
    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $btn_name = isset($atts['btn_name']) ? $atts['btn_name'] : '';
    $btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';
    
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
    $pagination  = isset($atts['pagination']) ? $atts['pagination'] : '';
    $view_all_button  = isset($atts['view_all_button']) ? $atts['view_all_button'] : '';
    
    $output = '';
    ob_start();

    ?>
    <section class="section section-theme-14 featured_Jobs_Block featured_jobp">
        <div class="container">
        <div class="jobs_info_wrap">
            <!-- Section header -->
            <header class="section-header d-flex flex-column text-center mb-15 mb-md-30 mb-xl-45">
                <?php
                if (!empty($title)) { ?>
                    <p>
                        <?php echo esc_html($title) ?>
                    </p>
                <?php }
                if (!empty($heading)) {
                    ?>
                    <h2><span class="text-outlined">
                            <?php echo esc_html($heading) ?>
                        </span></h2>
                <?php }
                ?>
            </header>
            <div class="row">
                <?php
                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';

                $args = array(
                    'post_type' => 'jobs',
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'orderby' => $orderby,
                   
                );
                // Custom query.
                $query = new WP_Query($args);
                $total_posts = $query->found_posts;
                // Check that we have query results.
                if ($query->have_posts()) {
                    // Start looping over the query results
                    while ($query->have_posts()) {
                        $query->the_post();
                        global $post;
                        $post = get_the_id();
                        $title = get_the_title($post);
                        $permalinkget = get_the_permalink($post);
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');
                        $job_post = get_post($post);
                        $post_author = $job_post->post_author;
                        $post_employer_id = jobcircle_user_employer_id($post_author);
                        if ($post_employer_id > 0 && get_post_type($post_employer_id) == 'employer') {
                            $post_author_name = get_the_title($post_employer_id);
                            $post_author_link = get_permalink($post_employer_id);
                        } else {
                            $author_user_obj = get_user_by('id', $post_author);
                            $post_author_name = $author_user_obj->display_name;
                            $post_author_link = get_author_posts_url($post_author);
                        }
                        $job_salary = jobcircle_job_salary_str($post , '' ,'sub');
                        $job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
                        $job_type_str = jobcircle_job_type_ret_str($job_type);
                        $date = date('M d Y');
                        $job_location = jobcircle_post_location_str($post);
                        global $current_user;
                        $user_id = $current_user->ID;
                        $fav_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
                        $fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();
                        $like_btn_class = 'jobcircle-favjab-btn';
                        if (!is_user_logged_in()) {
                            $like_btn_class = 'jobcircle-favjab-btn no-user-follower-btn';
                        } else {
                            if (!jobcircle_user_candidate_id($user_id)) {
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
                        <div class="col-12 col-lg-6 mb-15 mb-xl-35">
                            <div class="jobs_info_holder">
                                <span class="star-icon  <?php echo jobcircle_esc_the_html($like_btn_class) ?> " data-id="<?php echo jobcircle_esc_the_html($post) ?>"><i
                                        class=" <?php echo jobcircle_esc_the_html($fav_icon_class) ?> position-absolute <?php echo jobcircle_esc_the_html($follow) ?>"></i></span>
                                <div class="info_holder">
                                    <?php
                                    $include_category_ids = array(72, 103, 74);
                                    $terms = get_terms(
                                        array(
                                            'taxonomy' => 'job_category',
                                            'post_type' => 'jobs',
                                            'hide_empty' => false,
                                            'include' => $include_category_ids,
                                        )
                                    );
                                    $category_count = 0;
                                    foreach ($terms as $term) {
                                        if (!empty($term->name)) {
                                            $term_link = get_term_link($term); // Get the term link
                                            
                                             $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
    $jobcircle_page_url = home_url('/');
    if ($jobcircle_page_id > 0) {
        $jobcircle_page_url = get_permalink($jobcircle_page_id);
    }
                                            ?>
                                            <a class="text-decoration-none" href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                                <span class="job-title">
                                                    <?php echo esc_html($term->name); ?>
                                                </span>
                                            </a>
                                            <?php
                                            $category_count++;
                                            if ($category_count >= 2) {
                                                break; // Stop after displaying 2 categories
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="title-hold">
                                        <?php
                                        if (!empty($title)) { ?>
                                            <strong class="h6"><a href="<?php echo esc_html($permalinkget) ?>">
                                                <?php echo esc_html($title) ?></a>
                                            </strong>
                                        <?php } ?>
                                        <i class="jobcircle-icon-checkmark1 icon"></i>
                                    </div>
                                    <ul class="location_info">
                                        <?php
                                        if (!empty($job_location)) { ?>
                                            <li>
                                                <i class="jobcircle-icon-map-pin icon"></i>
                                                <span class="text">
                                                    <?php echo esc_html($job_location) ?>
                                                </span>
                                            </li>
                                        <?php } ?>
                                        <?php
                                        if (!empty($date)) { ?>
                                            <li>
                                                <i class="jobcircle-icon-clock icon"></i>
                                                <span class="text">
                                                    <?php echo esc_html($date) ?>
                                                </span>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="wrap_holder">
                                    <div class="icon_holder">
                                        <?php
                                        if (!empty($image)) { ?>
                            <img src="<?php echo esc_url_raw($image[0]) ?>" alt="img">
                                        <?php } ?>
                                    </div>
                                    <div class="text_hold">
                                        <?php
                                        if (!empty($post_author_link) || !empty($post_author_name)) { ?>
                                            <span class="by">
                                                <?php esc_html_e('By', 'jobcircle-frame') ?> <a
                                                    href="<?php echo esc_html($post_author_link) ?>">
                                                    <?php echo esc_html($post_author_name) ?>
                                                </a>
                                            </span>
                                        <?php } ?>
                                        <div class="wrap">
                                            <?php
                                            if (!empty($job_salary)) { ?>
                                                <span class="amount subclass">
                                                  <strong><?php echo ($job_salary) ?></strong>
                                                </span>
                                            <?php } ?>
                                            <?php
                                            if (!empty($job_type_str)) { ?>
                                                <span class="note">
                                                    <?php echo esc_attr($job_type_str['title']); ?>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

                <?php
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
                <?php
                if (!empty($btn_url) || !empty($btn_name)) {
                    ?>
                    <a class="btn btn-green btn-sm konsiclasss" href="<?php echo esc_html($btn_url) ?>"><span class="btn-text">
                            <?php echo esc_html($btn_name) ?>
                        </span></a>
                    <?php
                } ?>
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
add_shortcode('featured_job_fpurteen', 'featured_job_fpurteen_frontend');
// for favourite button
add_action('wp_ajax_jobcircle_candidate_fav_favourite_ajax', 'jobcircle_candidate_fav_favourite_ajax');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_favourite_ajax', 'jobcircle_candidate_fav_favourite_ajax');
function jobcircle_candidate_fav_favourite_ajax()
{
    global $current_user;
    $user_id = $current_user->ID;
    $post_id = $_POST['post_id'];
    $faver_jobs = get_user_meta($user_id, 'fav_follower_list', true);
    $faver_jobs = !empty($faver_jobs) ? $faver_jobs : array();
    if (!in_array($post_id, $faver_jobs)) {
        $faver_jobs[] = $post_id;
    }
    update_user_meta($user_id, 'fav_follower_list', $faver_jobs);
    $data = array(
        'success' => '1',
        'total_favorites' => count($faver_jobs)
    );
    wp_send_json_success($data);
    wp_die();
}
add_action('wp_ajax_jobcircle_candidate_remove_favourite_ajax', 'jobcircle_candidate_remove_favourite_ajax');
add_action('wp_ajax_nopriv_jobcircle_candidate_remove_favourite_ajax', 'jobcircle_candidate_remove_favourite_ajax');
function jobcircle_candidate_remove_favourite_ajax()
{
    global $current_user;
    $user_id = $current_user->ID;
    $post_id = $_POST['post_id'];
    $faver_jobs = get_user_meta($user_id, 'fav_follower_list', true);
    $faver_jobs = !empty($faver_jobs) ? $faver_jobs : array();
    if (in_array($post_id, $faver_jobs)) {
        $new_post_array = array_diff($faver_jobs, array($post_id));
        update_user_meta($user_id, 'fav_follower_list', $new_post_array);
    }
    $data = array(
        'success' => '1',
        'total_favorites' => count($faver_jobs)
    );
    wp_send_json_success($data);
    wp_die();
}
;

