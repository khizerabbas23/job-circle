<?php
function get_cust_post_categories() {
    $categories = get_terms(array(
        'taxonomy' => 'our_team',
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
function jobcircle_candidate_dmview() {
    vc_map(
        array(
            'name' => __('Candidate Demand View'),
            'base' => 'jobcircle_candidate_dmview',
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
                    'heading' => __('Span Title'),
                    'param_name' => 'span_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Order BY'),
                    'param_name' => 'orderby',
                ),
                array(
                    'type' => 'textfield',
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
                    'value' => get_cust_post_categories(),
                  ),
            )
        )

    );
}
add_action('vc_before_init', 'jobcircle_candidate_dmview');

// popular category frontend
function jobcircle_candidate_dmview_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'span_title' => '',
            'orderby' => '',
            'numofpost' => '',
            'category_selector' => '',
        ),
        $atts,
        'jobcircle_candidate_dmview'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $span_title = isset($atts['span_title']) ? $atts['span_title'] : '';

    ob_start();
    ?>
    <section class="section section-theme-8 talented-expert-block bg-light-sky pt-35 pt-md-50 pt-lg-55 pt-xl-80 pt-xxl-110 pb-50 pb-lg-50">
        <div class="container">
            <div class="row justify-content-between mb-35 mb-lg-40">
                <div class="col-12 col-lg-8 col-xl-5">
                    <!-- Section header -->
                    <header class="section-header text-center text-lg-start mb-10 m-lg-0">
                        <?php
                        if (!empty($title) || !empty($span_title)) {
                            ?>
                            <h2>
                                <?php echo jobcircle_esc_the_html($title) ?> <span class="text-outlined">
                                    <?php echo jobcircle_esc_the_html($span_title) ?>
                                </span>
                            </h2>
                            <?php
                        }
                        ?>
                    </header>
                </div>
            </div>
            <div class="row slider-remover-class">
                <div class="col-12">
                    <div class="jobs-listing-slider" id="slider-remove">
                        <?php
                        $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                        $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
                        $selectedcategory  = isset($atts['category_selector']) ? $atts['category_selector'] : '';
                        $page_numbr = get_query_var('paged');

                        $args = array(
                            'post_type' => 'talented_team',
                            'post_status' => 'publish',
                            'posts_per_page' => $numofpost,
                            'order' => 'DESC',
                            'orderby' => $orderby,
                            'tax_query' => array(
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'our_team',
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
                                // $id = get_the_id();
                                $post = get_post();
                                $postid = $post->ID;
                                $title = get_the_title($postid);
                                $permalinkget = get_the_permalink($postid);
                                $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                                $location = get_post_meta($post->ID, 'jobcircle_field_location', true);
                                $amount = get_post_meta($post->ID, 'jobcircle_field_amount', true);
                                $categories = get_the_terms( $post, 'our_team' );
                                $duration = get_post_meta($post->ID, 'jobcircle_field_duration', true);
                                ?>

                                <div class="slick-slide">
                                    <!-- Featured Category Box -->
                                    <article class="featured-category-box">
                                        <div class="textbox">
                                        <?php 
                                        if (!empty($categories)) {
                                            foreach ($categories as $category) { 
                                                $category_link = esc_url(get_term_link($category)); ?>
                                                <span class="designation">
                                                    <a class="text-warning" href="<?php echo jobcircle_esc_the_html($category_link); ?>">
                                                        <?php echo jobcircle_esc_the_html($category->name); ?>
                                                    </a>
                                                </span>         
                                            <?php }
                                        }
                                        ?>
                                            <?php
                                            if (!empty($permalinkget)) {
                                                ?>
                                                <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
                                                    <?php
                                            }
                                            ?>
                                                <?php
                                                if (!empty($title)) {
                                                    ?>
                                                    <strong class="h5">
                                                        <?php echo jobcircle_esc_the_html($title) ?>
                                                    </strong>
                                                    <?php
                                                }
                                                ?>
                                            </a>
                                            <?php
                                            if (!empty($location)) {
                                                ?>
                                                <address class="location"><i class="jobcircle-icon-map-pin icon"></i><span class="text">
                                                        <?php echo jobcircle_esc_the_html($location); ?>
                                                    </span></address>
                                                <?php
                                            }
                                            ?>
                                            <div class="job-info">
                                                <?php if (!empty($amount) || !empty($duration)) {
                                                    ?>
                                                    <span class="amount"><strong>
                                                            <?php echo jobcircle_esc_the_html($amount); ?>
                                                            <?php esc_html_e('/', 'jobcircle-frame') ?>
                                                        </strong>
                                                        <?php echo jobcircle_esc_the_html($duration); ?>
                                                    </span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="image-holder">
                                            <?php
                                            if (!empty($permalinkget)) {
                                                ?>
                                                <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
                                                    <?php
                                            }
                                            ?>
                                                <?php if (!empty($image)) {
                                                    ?>
                                                    <img src="<?php echo jobcircle_esc_the_html($image[0]) ?>" width="300" height="320"
                                                        alt="<?php echo jobcircle_esc_the_html($title) ?>">
                                                    <?php
                                                }
                                                ?>
                                            </a>
                                        </div>
                                    </article>
                                </div>
                                <?php
                            }
                        }else { ?>
            		<p><?php esc_html_e('No Candidate found.', 'jobcircle-frame') ?></p>
            		<?php     	}
                        // Restore original post data.
                        wp_reset_postdata();        ?>
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
    $('#slider-remove').slick({
        slidesToShow: 4, // Har row mein 4 posts dikhayein
        slidesToScroll: 4, // Har baar 4 posts scroll karein
        rows: Math.ceil($('#slider-remove .slick-slide').length / 4), // Rows count dynamic set karein
        arrows: true,
        dots: true,
        infinite: false, // Looping rokne ke liye infinite ko false set karein
        autoplay: false,
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 1, // Chhote screens par sirf 1 post dikhayein
                slidesToScroll: 1,
                rows: Math.ceil($('#slider-remove .slick-slide').length), // Rows count dynamic set karein chhote screens par
            },
        }],
    });
});
</script>

    <?php
    $output = ob_get_clean();
	return $output;
}
add_shortcode('jobcircle_candidate_dmview', 'jobcircle_candidate_dmview_frontend');