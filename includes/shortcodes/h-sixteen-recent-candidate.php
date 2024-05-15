<?php
function jobcircle_recent_candidate_h_sixteen()
{
    $terms = get_terms(
		array(
			'taxonomy' => 'candidate_cat',
			'hide_empty' => true,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
    vc_map(
        array(
            'name' => __('RECENT CANDIDATE HSixteen'),
            'base' => 'jobcircle_recent_candidate_h_sixteen',
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
                    'heading' => __('Tag Line'),
                    'param_name' => 'tg_line',
                ),
                array(
        		  'type' => 'dropdown',
        		  'holder' => 'div',
        		  'class' => '',
        		  'heading' => __('Select Category For Post'),
        		  'param_name' => 'checkbox_param',
        		  'value' => $job_types,
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
add_action('vc_before_init', 'jobcircle_recent_candidate_h_sixteen');
// popular category frontend
function jobcircle_recent_candidate_h_sixteen_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'title' => '',
            'tg_line' => '',
            'checkbox_param' => '',
            'orderby' => '',
            'numofpost' => '',
        ),
        $atts,
        'jobcircle_recent_candidate_h_sixteen'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $tg_line = isset($atts['tg_line']) ? $atts['tg_line'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';

    ob_start();
    ?>

    <section class="section section-theme-16 faq_block  th-padng page-theme-16">
        <div class="container">
            <div class="recent_candidates">
                <!-- Section header -->
                <header class="section-header d-flex flex-column mb-15 mb-md-30 mb-xl-40">
                    <?php if (!empty($tg_line)) { ?>
                        <p>
                            <?php echo esc_html($tg_line) ?>
                        </p>
                    <?php } ?>
                    <?php if (!empty($title)) { ?>
                        <h2>
                            <?php echo esc_html($title) ?>
                        </h2>
                    <?php } ?>
                </header>
                <div class="slider-holder">
                    <div class="recent_candidate_slider">
                        <?php

                        $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                        $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                        $include_category_ids = $job_type_arr;
                        $page_numbr = get_query_var('paged');
                        $args = array(
                                    'post_type' => 'candidates',
                                    'posts_per_page' => $numofpost,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'candidate_cat',
                                            'field' => 'term_id', // Use term_id instead of slug
                                            'terms' => $include_category_ids,
                                            'include_children' => false, // Set to true if you want to include posts from child categories
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
                                $post = get_post();
                                $postid = $post->ID;
                                $title = get_the_title($postid);
                                $permalinkget = get_the_permalink($post);
                                $job_location = jobcircle_post_location_str($post->ID);
                                $job_title = get_post_meta($post->ID, 'jobcircle_field_job_title', true);
                                $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                                $job_salary = jobcircle_candidate_salary_str($postid, 'k');

                                ?>
                                <div>
                                    <div class="wrap-slide">
                                        <div class="image-holder">
                                            <?php if (!empty($permalinkget) && !empty($image)) {
                                                ?>
                                                <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
                                                    <img src="<?php echo esc_url_raw($image[0]) ?>" alt="img">
                                                </a>
                                            <?php }
                                            ?>
                                        </div>
                                        <div class="text-holder">
                                            <?php if (!empty($job_title)) {
                                                ?>
                                                <span class="title-post">
                                                    <?php echo esc_html($job_title) ?>
                                                </span>
                                            <?php }
                                            if (!empty($permalinkget) && !empty($title)) { ?>
                                                <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
                                                    <strong class="title-name">
                                                        <?php echo esc_html($title) ?>
                                                    </strong>
                                                </a>
                                            <?php } ?>
                                            <ul class="location_info">
                                                <li>
                                                    <i class="jobcircle-icon-map-pin icon"></i>
                                                    <?php if (!empty($job_location)) {
                                                        ?>
                                                        <span class="text">
                                                            <?php echo esc_html($job_location) ?>
                                                        </span>
                                                    <?php } ?>
                                                </li>
                                            </ul>
                                            <strong class="amount">
                                                <?php echo jobcircle_esc_the_html($job_salary) ?>
                                            </strong>
                                            <?php
                                            if (!empty($permalinkget)) { ?>
                                                <a class="btn btn-pink btn-sm" href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><span
                                                        class="btn-text">
                                                        <?php esc_html_e('View Profile', 'jobcircle-frame') ?>
                                                    </span></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        // Restore original post data.
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    return ob_get_clean();
}
add_shortcode('jobcircle_recent_candidate_h_sixteen', 'jobcircle_recent_candidate_h_sixteen_frontend');