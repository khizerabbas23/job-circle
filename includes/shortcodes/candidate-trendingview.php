<?php
function get_custs_postes_cate() {
    $categories = get_terms(array(
        'taxonomy' => 'candidate_cat',
        'hide_empty' => false,
    ));

    $category_options = array();

    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $category_options[$category->name] = $category->slug;
        }
    }

    return $category_options;
}
function jobcircle_candidate_trendingview()
{
    vc_map(
        array(
            'name' => __('Candidate Trending View'),
            'base' => 'jobcircle_candidate_trendingview',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Order BY'),
                    'param_name' => 'orderby',
                ),
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Sort By' ),
                    'param_name' => 'sortby',
                    'value' => array(
                        'Select Style' => '',
                        'Ascending' => 'ASC',
                        'Descending' => 'DESC',
                    ),
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
                    'heading' => __('Select Category For Post'),
                    'param_name' => 'category_selector',
                    'value' => get_custs_postes_cate(),
                  ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_candidate_trendingview');
// popular category frontend
function jobcircle_candidate_trendingview_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'title' => '',
            'tg_line' => '',
            'orderby' => '',
            'numofpost' => '',
            'sortby' => '',
            'category_selector' => '',
        ),
        $atts,
        'jobcircle_candidate_trendingview'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $tg_line = isset($atts['tg_line']) ? $atts['tg_line'] : '';
    $sortby = isset($atts['sortby']) ? $atts['sortby'] : '';

    ob_start();
    ?>

    <section class="section section-theme-16 faq_block page-theme-16 trending-view-slider-section">
        <div class="container">
            <div class="recent_candidates">
                <!-- Section header -->
                <header class="section-header d-flex flex-column mb-15 mb-md-30 mb-xl-40">
                    <?php if (!empty($tg_line)) { ?>
                        <p>
                            <?php echo jobcircle_esc_the_html($tg_line) ?>
                        </p>
                    <?php } ?>
                    <?php if (!empty($title)) { ?>
                        <h2>
                            <?php echo jobcircle_esc_the_html($title) ?>
                        </h2>
                    <?php } ?>
                </header>
                <div class="slider-holder">
                    <div class="recent_candidate_slider" id="trending-view-slider">
                        <?php

                        $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                        $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                        $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';


                        $page_numbr = get_query_var('paged');
                        $args = array(
                            'post_type' => 'candidates',
                            'post_status' => 'publish',
                            'posts_per_page' => $numofpost,
                            'order' => 'DESC',
                            'paged' => $page_numbr,
                            'orderby' => $orderby,
                            'tax_query' => array(
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'candidate_cat',
                                        'field' => 'slug',
                                        'terms' => $selectedcategory,
                                    ),
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
                                                    <?php echo jobcircle_esc_the_html($job_title) ?>
                                                </span>
                                            <?php }
                                            if (!empty($permalinkget) && !empty($title)) { ?>
                                                <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
                                                    <strong class="title-name">
                                                        <?php echo jobcircle_esc_the_html($title) ?>
                                                    </strong>
                                                </a>
                                            <?php } ?>
                                            <ul class="location_info">
                                                <li>
                                                    <i class="jobcircle-icon-map-pin icon"></i>
                                                    <?php if (!empty($job_location)) {
                                                        ?>
                                                        <span class="text">
                                                            <?php echo jobcircle_esc_the_html($job_location) ?>
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
    if ($total_posts > $numofpost) {  ?>
		        <?php echo jobcircle_pagination($query, true);  ?>
	<?php	}  ?>
	<script>
jQuery(document).ready(function($) {
    // Replace 'your-slider-id' with the ID of your slider element
    $('#trending-view-slider').slick({
        slidesToShow: 4, // Har row mein 4 posts dikhayein
        slidesToScroll: 4, // Har baar 4 posts scroll karein
        rows: Math.ceil($('#trending-view-slider .wrap-slide').length / 4), // Rows count dynamic set karein
        arrows: true,
        dots: true,
        infinite: false, // Looping rokne ke liye infinite ko false set karein
        autoplay: false,
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 1, // Chhote screens par sirf 1 post dikhayein
                slidesToScroll: 1,
                rows: Math.ceil($('#trending-view-slider .wrap-slide').length), // Rows count dynamic set karein chhote screens par
            },
        }],
    });
});
</script>
    <?php
    return ob_get_clean();
}
add_shortcode('jobcircle_candidate_trendingview', 'jobcircle_candidate_trendingview_frontend');