<?php
function jobcircle_twelve_jobs()
{
    $terms = get_terms(
        array(
            'taxonomy' => 'job_category',
            'hide_empty' => true,
        )
    );
    $feature_job_types = array();
    foreach ($terms as $term) {
        $feature_job_types[$term->name] = $term->slug;
    }
    ;
    return $feature_job_types;
}
;
function htwlv_pop_job()
{
    $job_types = jobcircle_twelve_jobs();
    vc_map(
        array(
            'name' => __('Feature Job 12'),
            'base' => 'htwlv_pop_job',
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
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('See More Url'),
                    'param_name' => 'see_more_url',
                ),
                array(
                    'type' => 'checkbox',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Checkbox Options'),
                    'param_name' => 'checkbox_param',
                    'value' => $job_types,
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
                    'heading' => __('Jobs Per Category'),
                    'param_name' => 'numofpost',
                ),

            )
        )
    );
}
add_action('vc_before_init', 'htwlv_pop_job');

// popular category frontend
function htwlv_pop_job_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'heading' => '',
            'see_more_btn' => '',
            'see_more_url' => '',
            'checkbox_param' => '',
            'orderby' => '',
            'numofpost' => '',

        ), $atts, 'htwlv_pop_job');
        
    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $see_more_btn = isset($atts['see_more_btn']) ? $atts['see_more_btn'] : '';
    $see_more_url = isset($atts['see_more_url']) ? $atts['see_more_url'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    ob_start();
    ?>
    <section
        class="section section-theme-11 bg-white pt-50 pt-md-80 pb-35 pb-md-50 pb-lg-65 pb-xxl-100 featured_Jobs_Block">
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column-reverse text-center mb-30 mb-lg-42">
                <?php
                if (!empty($heading)) {
                    ?>
                    <h2 class="help_question_heading">
                        <?php echo esc_html($heading) ?>
                    </h2>
                    <?php
                }
                if (!empty($title)) {
                    ?>
                    <p>
                        <?php echo esc_html($title) ?>
                    </p>
                    <?php
                }
                ?>
            </header>
            <div class="jobs-tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <button class="nav-link  active nav-for-all-cat" type="button" data-bs-toggle="tab"
                            aria-selected="true">
                            <?php echo esc_html_e('All Jobs', 'jobcircle-frame') ?>
                        </button>
                    </li>
                    <?php
                    if (!empty($job_type_arr)) {
                        foreach ($job_type_arr as $job_type_arrays) {
                            $cat = get_term_by('slug', $job_type_arrays, 'job_category');                          
                            $job_arrays = $cat->name;
                            echo '<li class="nav-item" role="presentation">
                         <button class="nav-link nav-for-filter-job" data-id="' . $cat->term_id . '" type="button" data-bs-toggle="tab" aria-selected="true">' . $job_arrays . '</button>
                       </li>';
                        }
                    }
                    ?>
                </ul>
                <div class="tab-content">
                    <div class="jobs-frame">
                        <?php
                        $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                        $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                        foreach ($job_type_arr as $job_type_arrays) {
                        $args = array(
                            'post_type' => 'jobs',
                            'post_status' => 'publish',
                            'posts_per_page' => $numofpost,
                            'order' => 'DESC',
                            'orderby' => $orderby,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'job_category',
                                    'field' => 'slug',
                                    'terms' => $job_type_arrays,
                                ),
                            ),
                        );
                        // Custom query.
                        $query = new WP_Query($args);
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
                                $country = get_post_meta($post, 'jobcircle_field_loc_country', true);
                                $company = get_post_meta($post, 'company_name', true);
                                $job_salary = jobcircle_job_salary_str($post, '', 'sub');
                                $skills = get_post_meta($post, 'skills', true);
                                $job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
                                $job_type_str = jobcircle_job_type_ret_str($job_type);
                                $categories = wp_get_post_terms($post, 'job_category');
                                $date = get_the_date('M d, Y');
                                $post_terms = wp_get_post_terms($post, 'job_category', array('fields' => 'ids'));
                                $id_post = isset($post_terms[0]) ? implode(' cat-', $post_terms) : '';
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
                                if (!empty($id_post)) {
                                    ?>
                                    <div class="jobs-card cat-<?php echo jobcircle_esc_the_html($id_post) ?> job-ids-forcat">
                                    <?php } ?>
                                    <div class="row">
                                        <div class="job-content">
                                            <div class="icon-box brdr">
                                                <?php if (!empty($permalinkget) || !empty($image)) {
                                                    ?>
                                                    <a href="<?php echo esc_html($permalinkget) ?>">
                                                        <img src="<?php echo esc_url_raw($image[0]) ?>" alt="image">
                                                    </a>
                                                <?php } ?>
                                            </div>
                                                <?php
                                                $counter = 0;
                                                    foreach ($categories as $cate) {
                                                if ($counter < 1 && !empty($categories)) {
                                                        ?>
                                                        <p>
                                                            <a class="text-decoration-none blurcolor" href="<?php echo esc_url(get_term_link($cate)); ?>">
                                                                <?php echo esc_html($cate->name); ?>
                                                            </a>
                                                        </p>
                                                        <?php
                                                        $counter++;
                                                    }else{
                                                        break;
                                                    }
                                                }
                                                ?>
                                            <?php
                                            if (!empty($permalinkget) && !empty($title)) {
                                                ?>
                                                <h3 class="text-decoration-none"><a class="text-decoration-none"
                                                        href="<?php echo esc_html($permalinkget) ?>">
                                                        <?php echo esc_html($title) ?>
                                                    </a></h3>
                                            <?php }
                                            if (!empty($post_author_link) || !empty($post_author_name)) { ?>
                                                <span class="meta">
                                                    <?php echo esc_html_e('By', 'jobcircle-frame') ?> <a
                                                        href="<?php echo esc_html($post_author_link) ?>">
                                                        <?php echo esc_html($post_author_name) ?>
                                                    </a>
                                                </span>
                                            <?php } ?>

                                            <div class="location-holder">
                                                <strong class="location-txt">
                                                    <i class="jobcircle-icon-map-pin icon"></i>
                                                    <?php if (!empty($country)) {
                                                        ?>
                                                        <span>
                                                            <?php echo esc_html($country); ?>
                                                        </span>
                                                        <?php
                                                    } ?>
                                                </strong>
                                                <strong class="location-txt">
                                                    <i class="jobcircle-icon-clock icon"></i>
                                                    <?php if (!empty($date)) {
                                                        ?>
                                                        <span>
                                                            <?php echo esc_html($date) ?>
                                                        </span>
                                                    <?php } ?>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="align-items-md-end align-items-lg-center bottom-holder">
                                        <div class="col-12 d-flex pl-xl-left">
                                            <?php
                                            if (!empty($job_salary)) {
                                                ?>
                                                <strong class="price">
                                                    <?php echo jobcircle_esc_the_html($job_salary); ?><sub></sub>
                                                </strong>
                                            <?php } ?>
                                            <ul class="tags-list">
                                                <?php if (!empty($job_type_str)) {
                                                    ?>
                                                    <li><span class="tag">
                                                            <?php echo esc_html($job_type_str['title']) ?>
                                                        </span></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        // Restore original post data
                        wp_reset_postdata();
                        }
                        ?>
                        <script>
                            jQuery(document).on('click', '.nav-for-all-cat', function () {

                                var this_val = jQuery(this).attr('data-id');
                                var this_parent = jQuery(this).parents('.featured_Jobs_Block');

                                this_parent.find('.job-ids-forcat').show();
                                this_parent.find('.cat-' + this_val).removeAttr('style');
                            });
                            jQuery(document).on('click', '.nav-for-filter-job', function () {

                                var this_val = jQuery(this).attr('data-id');
                                var this_parent = jQuery(this).parents('.featured_Jobs_Block');

                                this_parent.find('.job-ids-forcat').hide();
                                this_parent.find('.cat-' + this_val).removeAttr('style');
                            });
                        </script>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center pt-lg-20">
                            <?php if (!empty($see_more_url)) {
                                ?>
                                <a href="<?php echo esc_html($see_more_url) ?>"><button class="btn"><span>
                                            <?php echo esc_html_e('See More Jobs', 'jobcircle-frame') ?>
                                        </span></button></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
    </section>

    <?php
    return ob_get_clean();
}
add_shortcode('htwlv_pop_job', 'htwlv_pop_job_frontend');