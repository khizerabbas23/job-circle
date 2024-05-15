<?php
function jobcircle_demanding_categories()
{
    $all_page = array(__('Select Page', 'jobcircle-frame'), '');
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
            'name' => __('Demainding Categories Eight'),
            'base' => 'jc_demanding_categories',
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
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Jobcircle Page', 'jobcircle-frame'),
                    'param_name' => 'jobcircle_page',
                    'description' => __('Select Jobcircle Page', 'jobcircle-frame'),
                    'value' => $all_page,
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
                    'heading' => __('Explore Fields'),
                    'param_name' => 'explore_fields',
                ),

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Explore Fields Url'),
                    'param_name' => 'explore_fields_url',
                ),

                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'img',
                ),

                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image'),
                    'param_name' => 'upld_img',
                ),
            )
        ),

    );
}
add_action('vc_before_init', 'jobcircle_demanding_categories');

// popular category frontend
function jobcircle_demanding_categories_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'span_title' => '',
            'explore_fields' => '',
            'explore_fields_url' => '',
            'img' => '',
            'upld_img' => '',

            'jobcircle_page' => '',


        ),
        $atts,
        'jobcircle_demanding_categories'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $span_title = isset($atts['span_title']) ? $atts['span_title'] : '';
    $explore_fields = isset($atts['explore_fields']) ? $atts['explore_fields'] : '';
    $explore_fields_url = isset($atts['explore_fields_url']) ? $atts['explore_fields_url'] : '';
    $img = isset($atts['img']) ? $atts['img'] : '';
    $upld_img = isset($atts['upld_img']) ? $atts['upld_img'] : '';

    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';


    ob_start();
    ?>

    <style>
        .section-theme-8 .section-header h2 .text-outlined {
            position: relative;
        }
    </style>

    <section class="section section-theme-8 demanding-categories pt-35 pt-md-50 pt-lg-55 pt-xl-60 pb-35 pb-md-50 pb-xl-60">
        <div class="container">
            <div class="row justify-content-between mb-35 mb-lg-40">
                <div class="col-12 col-lg-8">
                    <!-- Section header -->
                    <header class="section-header text-center text-lg-start mb-10 m-lg-0">
                        <?php
                        if (!empty($title) || !empty($span_title)) {
                            ?>
                            <h2>
                                <?php echo esc_html($title); ?> <span class="text-outlined">
                                    <?php echo esc_html($span_title); ?>
                                </span>
                            </h2>
                            <?php
                        }
                        ?>
                    </header>
                </div>
                <div class="col-12 col-lg-4 text-center text-lg-end">
                    <?php
                    if (!empty($explore_fields_url) || !empty($explore_fields)) {
                        ?>
                        <a href="<?php echo esc_url($explore_fields_url); ?> " class="btn-all"><span class="btn-text">
                                <?php echo esc_html($explore_fields); ?>
                            </span><i class="jobcircle-icon-chevron-right"></i></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12 col-lg-4 position-relative">
                    <?php
                    if (!empty($upld_img)) {
                        ?>
                        <div class="img-pattern"><img src="<?php echo esc_url_raw($upld_img); ?> " alt="Image Description"></div>
                        <?php
                    }
                    ?>
                    <div class="image-holder">
                        <?php
                        if (!empty($img)) {
                            ?>
                            <img src="<?php echo esc_url_raw($img); ?>" width="440" height="440" alt="San Francisco, CA">
                        </div>
                        <?php
                        }
                        ?>
                </div>
                <div class="col-12 col-lg-8">
                    <ul class="categories-list">
                        <?php
                        $exclude_category_ids = array(98, 99, 96, 84);

                        $terms = get_terms(array(
                            'taxonomy' => 'job_category',
                            'post_type' => 'jobs',
                            'hide_empty' => false,
                            'parent' => 0,
                            'exclude' => $exclude_category_ids,
                        ));
                        $counter = 0;
                        foreach ($terms as $term) {
                            if ($counter < 9) {
                                // Query to get the post count for each term
                                $args = array(
                                    'post_type' => 'jobs',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'job_category',
                                            'field' => 'term_id',
                                            'terms' => $term->term_id,
                                        ),
                                    ),
                                );
                                $query = new WP_Query($args);
                                $post_count = $query->found_posts;
                                $term_id = $term->term_id;
                                $term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);
                                $category_img = isset($term_meta['image']) ? $term_meta['image'] : '';
                                $category_link = get_category_link($term_id);
                                $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                                $jobcircle_page_url = home_url('/');
                                if ($jobcircle_page_id > 0) {
                                    $jobcircle_page_url = get_permalink($jobcircle_page_id);
                                }
                                ?>
                                <li>
                                    <a class="categories-item"
                                        href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                        <span class="icon">
                                            <img src="<?php echo esc_html($category_img); ?>" width="30" height="30"
                                                alt="Writing & Translation">
                                        </span>
                                        <strong class="title">
                                            <?php echo esc_html($term->name); ?>
                                        </strong>
                                    </a>
                                </li>
                                <?php
                                $counter++;
                            } else {
                                break; // Break the loop after 12 categories
                            }
                        }
                        // Restore original post data.
                        wp_reset_postdata();
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();

}
add_shortcode('jc_demanding_categories', 'jobcircle_demanding_categories_frontend');