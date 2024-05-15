<?php
function jobcircle_nine_jobs()
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
function featured_job_nine()
{
    $job_types = jobcircle_nine_jobs();
    vc_map(
        array(
            'name' => __('Feature Job 9'),
            'base' => 'featured_job_nine',
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
                    'heading' => __('See More Label'),
                    'param_name' => 'see_more_btn',
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
add_action('vc_before_init', 'featured_job_nine');
// popular category frontend
function featured_job_nine_frontend($atts, $content)
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
            'pagination' => '',
            'view_all_button' => '',

        ), $atts, 'featured_job_nine');

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $see_more_btn = isset($atts['see_more_btn']) ? $atts['see_more_btn'] : '';
    $see_more_url = isset($atts['see_more_url']) ? $atts['see_more_url'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
     $pagination  = isset($atts['pagination']) ? $atts['pagination'] : '';
    $view_all_button  = isset($atts['view_all_button']) ? $atts['view_all_button'] : '';
    ob_start();
    ?>
    <section class="section section-9 section-theme-9 featured_Jobs_Block page-theme-9">
        <div class="container">
            <div class="jobs_info_wrap">
                <!-- Section header -->
                <header class="section-header d-flex flex-column text-center mb-15 mb-md-30 mb-xl-50">
                    <?php if (!empty($title)) {
                        ?>
                        <p>
                            <?php echo esc_html($title) ?>
                        </p>
                    <?php }
                    if (!empty($heading)) { ?>
                        <h2><span class="text-outlined">
                                <?php echo esc_html($heading) ?>
                            </span></h2>
                    <?php } ?>
                </header>
                <div class="tabs-bar">
                    <ul class="nav nav-tabs">
                        <li><button class="nav-link active nav-for-all-cat" type="button" data-bs-toggle="tab"
                                aria-selected="true">
                                <?php echo esc_html_e('All Jobs', 'jobcircle-frame') ?>
                            </button></li>
                        <?php
                        if (!empty($job_type_arr)) {
                            foreach ($job_type_arr as $job_type_arrays) {
                                $cat = get_term_by('slug', $job_type_arrays, 'job_category');
                                $job_arrays = $cat->name;
                                echo '<li><button data-id="' . $cat->term_id . '" class="nav-link nav-for-filter-job"  type="button" data-bs-toggle="tab" aria-selected="true" > ' . $job_arrays . '</button></li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="row mb-md-40">
                    <?php
                    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
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
                                'terms' => $job_type_arr,
                            ),
                        ),
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
                            $company = get_post_meta($post, 'company', true);
                            $job_salary = jobcircle_job_salary_str($post, '', 'sub');
                            $skills = get_post_meta($post, 'skills', true);
                            $post_date = get_post_field('post_field', $post);
                            $posted_date = get_the_date("d M Y", strtotime($post_date));
                            $post_terms = wp_get_post_terms($post, 'job_category', array('fields' => 'ids'));
                            
                            $job_location = jobcircle_post_location_str($post);
                            $categories = wp_get_post_terms($post, 'job_category');
                            $job_type = get_post_meta($post, 'jobcircle_field_job_type', true);
                            $job_type_str = jobcircle_job_type_ret_str($job_type);
                            $id_post = isset($post_terms[0]) ? $post_terms[0] : '';
                            ?>
                            <div class="cat-<?php echo jobcircle_esc_the_html($id_post) ?> job-ids-forcat col-12 col-lg-6 mb-15 mb-xl-30">
                                <div class="jobs_info_holder">
                                    <?php if (!empty($job_type_str)) {
                                        ?>
                                        <span class="note">
                                            <?php echo esc_html($job_type_str['title']) ?>
                                        </span>
                                        <?php
                                    } ?>
                                    <div class="wrap_holder">
                                        <?php if (!empty($permalinkget) && !empty($image)) {
                                            ?>
                                            <div class="icon_holder">
                                                <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><img src="<?php echo esc_url_raw($image[0]) ?>"
                                                        alt="img"></a>
                                            </div>
                                        <?php } ?>
                                        <div class="info_holder">
                                     <?php
$count = 0; // Initialize the count variable outside the loop
if (!empty($categories)) {
    foreach ($categories as $cat) {
        if ($count === 0) { // Use comparison operator (== or ===) instead of assignment (=)
            $cat_link = get_term_link($cat);
            ?>
            <p>
                <a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat->name); ?></a>
            </p>
        <?php
        } else {
            break; // Break the loop if count is not zero
        }
        $count++; // Increment count inside the loop
    }
}
?>


                                            <?php if (!empty($permalinkget) || !empty($title)) {
                                                ?>
                                                <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><strong class="h6">
                                                        <?php echo esc_html($title) ?>
                                                    </strong></a>
                                            <?php } ?>
                                            <ul class="location_info">
                                                <?php if (!empty($job_location)) {
                                                    ?>
                                                    <li>
                                                        <i class="jobcircle-icon-map-pin icon"></i>
                                                        <span class="text">
                                                            <?php echo esc_html($job_location) ?>
                                                        </span>
                                                    </li>
                                                <?php }
                                                if (!empty($posted_date)) {
                                                    ?>
                                                    <li>
                                                        <i class="jobcircle-icon-clock icon"></i>
                                                        <span class="text">
                                                            <?php echo esc_html($posted_date) ?>
                                                        </span>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="apply_bar">
                                        <?php if (!empty($job_salary)) {
                                            ?>
                                            <span class="amount subclass"><strong  >
                                                    <?php echo jobcircle_esc_the_html($job_salary) ?>
                                                </strong></span>
                                        <?php }
                                        if (!empty($permalinkget)) { ?>
                                            <a href="<?php echo esc_html($permalinkget) ?>" class="btn btn-white btn-sm">
                                                <?php echo esc_html_e('Apply Now', 'jobcircle-frame') ?>
                                            </a>
                                        <?php } ?>
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
                <div class="d-flex justify-content-center konsiclasss">
                    <?php if (!empty($see_more_url) || !empty($see_more_btn)) {
                        ?>
                        <a class="btn btn-blue btn-sm konsiclasss" href="<?php echo esc_html($see_more_url) ?>"><span class="btn-text">
                                <?php echo esc_html($see_more_btn) ?>
                            </span></a>
                    <?php }
                    ?>
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
add_shortcode('featured_job_nine', 'featured_job_nine_frontend');