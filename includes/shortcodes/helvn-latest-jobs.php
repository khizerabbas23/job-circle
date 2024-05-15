<?php
function jobcircle_helvn_latest_jobs()
{
    vc_map(
        array(
            'name' => __('H-Eleven Latest Jobs'),
            'base' => 'jc_helvn_latest_jobs',
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
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Tagline'),
                    'param_name' => 'tagline',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Order BY'),
                    'param_name' => 'orderby',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Number Of Post'),
                    'param_name' => 'numofpost',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_helvn_latest_jobs');

// popular category frontend
function jobcircle_helvn_latest_jobs_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'tagline' => '',
            'orderby' => '',
            'numofpost' => '',

        ),
        $atts,
        'jobcircle_helvn_latest_jobs'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $tagline = isset($atts['tagline']) ? $atts['tagline'] : '';

    ob_start();
    ?>
    <section class="section section-theme-6 latest-jobs-block pt-20 pt-md-20 pt-lg-10 pb-35 pb-md-80 pb-lg-100 pb-xxl-120">
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column text-center mb-30 mb-lg-45">
                <h2>
                    <?php if (!empty($title)) { ?>
                        <?php echo esc_html($title) ?>
                    <?php } ?>
                </h2>
                <p>
                    <?php if (!empty($tagline)) { ?>
                        <?php echo esc_html($tagline) ?>
                    <?php } ?>
                </p>
            </header>
            <div class="latest-jobs-carousel">
                <?php

                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';

                $args = array(
                    'post_type' => 'jobs',
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'orderby' => $orderby,
                );
                // Custom query.
                $query = new WP_Query($args);
                // Check that we have query results.
                if ($query->have_posts()) {
                    // Start looping over the query results.
                    while ($query->have_posts()) {

                        $query->the_post();
                        $post = get_post();
                        $postid = $post->ID;
                        $titl = get_the_title($postid);
                        $job_post = get_post($post->ID);
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
                        $permalinkget = get_the_permalink($postid);
                        $content = get_the_content();
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                        $selection = get_post_meta($post->ID, 'jobcircle_field_apply_selection', true);
                        $remote = get_post_meta($post->ID, 'jobcircle_field_remote', true);
                        $job_type = get_post_meta($postid, 'jobcircle_field_job_type', true);
                        $job_salary = jobcircle_job_salary_str($postid, '','sub');
                        // $job_img_url = jobcircle_job_thumbnail_url($postid);
                        // $job_location = jobcircle_post_location_str($postid);
                        // $categories = get_the_terms($postid, 'job_category');
                        // $skills = wp_get_post_terms($postid, 'job_skill');
                        $job_type_str = jobcircle_job_type_ret_str($job_type);
                        global $current_user;
                        $user_id = $current_user->ID;
                        $fav_jobs = get_user_meta($user_id, 'fav_follower_list', true);
                        $fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();
                        $like_btn_class = 'jobcircle-follower-btn';
                        if (!is_user_logged_in()) {
                            $like_btn_class = 'jobcircle-follower-btn no-user-follower-btn';
                        } else {
                            if (!jobcircle_user_candidate_id($user_id)) {
                                $like_btn_class = 'jobcircle-follower-btn no-member-follower-btn';
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
                        <div class="job-slide">
                            <div class="inner-frame frmae-icon">
                                <?php
                                if (!empty($like_btn_class) || !empty($postid) || !empty($fav_icon_class) || !empty($follow)) {
                                    ?>
                                    <a href="" class="fav-tag <?php echo jobcircle_esc_the_html($like_btn_class) ?> " data-id="<?php echo jobcircle_esc_the_html($postid) ?>"><i
                                            class=" <?php echo jobcircle_esc_the_html($fav_icon_class) ?> position-absolute <?php echo jobcircle_esc_the_html($follow) ?>"></i></a>
                                    <?php
                                } ?>
                                
                                    <div>
                                        <div class="slide-top">
                                            <?php if (!empty($image)) {
                                                ?>
                                                <div class="icon"><a href="<?php echo esc_html($permalinkget) ?>"><img src="<?php echo esc_url_raw($image[0]) ?>" alt="icon"></a></div>
                                            <?php }
                                            if (!empty($titl)) { ?>
                                                <h3>
                                                    <a class="text-dark" href="<?php echo esc_html($permalinkget) ?>"><?php echo jobcircle_esc_the_html($titl) ?></a>
                                                </h3>
                                            <?php } ?>
                                            <span class="post-by">
                                                <a class="text-dark" href="<?php echo esc_html($post_author_link) ?>"><?php echo esc_html_e('By ', 'jobcircle-frame')?><?php echo jobcircle_esc_the_html($post_author_name) ?></a>
                                            </span>
                                        </div>
                                        <div class="slide-bottom subclass">
                                            <?php if (!empty($job_salary)) {
                                                ?>
                                                <strong class="price">
                                                    <?php echo ($job_salary) ?>
                                                </strong>
                                            <?php } ?>
                                            <ul class="tags-list">
                                                <?php if (!empty($job_type_str)) { ?>
                                                    <li><span class="tag">
                                                            <?php echo esc_html($job_type_str['title']) ?>
                                                        </span></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                              
                            </div>
                        </div>
                        <?php
                    }
                    // Restore original post data.
                    wp_reset_postdata();
                    ?>

                </div>
            </div>
        </section>

        <script>
            jQuery(document).on('click', '.jobcircle-follower-btn', function () {

                var _this = jQuery(this);
                if (_this.hasClass('no-user-follower-btn')) {
                    jobcircle_submit_msg_alert('<?php esc_html_e('Only logged-in user can save this.', 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
                    return false;
                }
                if (_this.hasClass('no-member-follower-btn')) {
                    jobcircle_submit_msg_alert('<?php esc_html_e('Only a candidate member can save this.', 'jobcircle-frame') ?>', 'jobcircle-alert-warning');
                    return false;
                }
                var this_icon = _this.find('i');
                var post_id = _this.data('id');
                this_icon.attr('class', 'fa fa-heart-shake');
                jQuery.ajax({
                    type: "POST",
                    dataType: "json",
                    url: jobcircle_cscript_vars.ajax_url,
                    data: {
                        post_id: post_id,
                        action: 'jobcircle_candidate_fav_favourite_ajax_helvn'
                    },
                    success: function (data) {
                        var totalFavorites = data.total_favorites;
                        _this.removeClass('jobcircle-follower-btn');
                        _this.addClass('jobcircle-alrdy-favjab');
                        _this.addClass('fa fa-heart');
                    },
                    error: function () {
                        this_icon.attr('class', 'profile-btn position-absolute');
                    }
                });
            });

            jQuery(document).on('click', '.jobcircle-alrdy-favjab', function () {

                var _this = jQuery(this);
                var this_icon = _this.find('i');
                var post_id = _this.data('id');


                jQuery.ajax({
                    type: "POST",
                    dataType: "json",
                    url: jobcircle_cscript_vars.ajax_url,

                    data: {
                        post_id: post_id,
                        action: 'jobcircle_candidate_remove_favourite_ajax_helvn'
                    },
                    success: function (data) {
                        var totalFavorites = data.total_favorites;
                        _this.removeClass('jobcircle-alrdy-favjab');
                        _this.addClass('jobcircle-follower-btn');

                        _this.addClass('fa fa-heart-o');
                    },
                    error: function () {
                        this_icon.attr('class', 'profile-btn position-absolute');
                    }
                });
            });

        </script>
        <?php
        return ob_get_clean();
                }
}
add_shortcode('jc_helvn_latest_jobs', 'jobcircle_helvn_latest_jobs_frontend');
// for favourite button
add_action('wp_ajax_jobcircle_candidate_fav_favourite_ajax_helvn', 'jobcircle_candidate_fav_favourite_ajax_helvn');
add_action('wp_ajax_nopriv_jobcircle_candidate_fav_favourite_ajax_helvn', 'jobcircle_candidate_fav_favourite_ajax_helvn');
function jobcircle_candidate_fav_favourite_ajax_helvn()
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
add_action('wp_ajax_jobcircle_candidate_remove_favourite_ajax_helvn', 'jobcircle_candidate_remove_favourite_ajax_helvn');
add_action('wp_ajax_nopriv_jobcircle_candidate_remove_favourite_ajax_helvn', 'jobcircle_candidate_remove_favourite_ajax_helvn');
function jobcircle_candidate_remove_favourite_ajax_helvn()
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
