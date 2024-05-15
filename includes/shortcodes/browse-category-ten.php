<?php
function jobcircle_browse_category()
{

    $terms = get_terms(
        array(
            'taxonomy' => 'job_category',
            'hide_empty' => true,
        )
    );
    $job_types = array();
    foreach ($terms as $term) {
        $job_types[$term->name] = $term->term_id;
    }
    ;


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
            'name' => __('Browse Categories Ten'),
            'base' => 'jc_browse_category',
            'category' => __('Job Circle'),
            'params' => array(
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
                    'heading' => __('Title'),
                    'param_name' => 'title',
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
                    'heading' => __('Sub Title'),
                    'param_name' => 'sub_title',
                ),

            )
        )

    );
}
add_action('vc_before_init', 'jobcircle_browse_category');

// popular category frontend
function jobcircle_browse_category_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(
            'title' => '',
            'sub_title' => '',
            'jobcircle_page' => '',
            'checkbox_param' => '',


        ),
        $atts,
        'jobcircle_browse_category'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';

    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';



    ob_start();
    ?>
    <section
        class="section section-theme-10 bg-white pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column-reverse text-center mb-50 mb-lg-75">
                <?php
                if (!empty($title)) { ?>
                    <h2>
                        <?php echo jobcircle_esc_the_html($title); ?>
                    </h2>
                    <?php
                }
                if (!empty($sub_title)) {
                    ?>
                    <p>
                        <?php echo jobcircle_esc_the_html($sub_title); ?>
                    </p>
                    <?php
                }
                ?>
            </header>
            <div class="cats-block">
                <?php
                $include_category_ids = $job_type_arr;

                $terms = get_terms(array(
                    'taxonomy' => 'job_category',
                    'post_type' => 'jobs',
                    'hide_empty' => false,
                    'parent' => 0,
                    'include' => $include_category_ids,
                ));
                shuffle($terms);
                
                $counter = 0;
                foreach ($terms as $term) {
                    if ($counter < 8) {
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
                        <div class="cat-box">
                            <?php
                            if (!empty($jobcircle_page_url) || !empty($term->slug)) {
                                ?>
                                <a href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                    <?php
                            }
                            ?>
                                <?php
                                if (!empty($category_img)) {
                                    ?>
                                    <div class="icon-box"><img src="<?php echo esc_url_raw($category_img); ?>" alt="icon"></div>
                                    <?php
                                }
                                ?>
                                <div class="cat-text">
                                    <?php
                                    if (!empty($term)) {
                                        ?>
                                        <strong class="title">
                                            <?php echo jobcircle_esc_the_html($term->name); ?>
                                        </strong>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (!empty($term)) {
                                        ?>
                                        <p>
                                            <?php echo jobcircle_esc_the_html($term->count); ?>
                                            <?php echo esc_html_e('Jobs available', 'jobcircle-frame') ?>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </a>
                        </div>
                        <?php
                        $counter++;
                    } else {
                        break; // Break the loop after 12 categories
                    }
                }
                // Restore original post data.
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();

}
add_shortcode('jc_browse_category', 'jobcircle_browse_category_frontend');