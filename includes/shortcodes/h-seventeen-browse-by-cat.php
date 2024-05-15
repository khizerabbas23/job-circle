<?php
function home_seventeen_job_cat()
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
            'name' => __('Browse Categories 17'),
            'base' => 'home_seventeen_job_cat',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('heading'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_img',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'home_seventeen_job_cat');
// Frontend Coding  
function home_seventeen_job_cat_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'heading' => '',
            'bg_img' => '',

            'jobcircle_page' => '',
        ), $atts, 'home_seventeen_job_cat'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';

    ob_start();
    ?>
    <section class="section section-theme-17 browse_categories"
        style="background-image: url(<?php echo esc_url_raw($bg_img) ?>);">
        <div class="container">
            <header class="section-header text-center mb-40 mb-md-35">
                <p>
                    <?php echo esc_html($title) ?>
                </p>
                <h2><span class="text-outlined">
                        <?php echo esc_html($heading) ?>
                    </span></h2>
            </header>
            <div class="cats-block">
                <?php
                $exclude_category_ids = array(84, 92, 96);
                $counter = 1;
                // Fetch the terms for the custom taxonomy 'job_featured'
                $terms = get_terms(array(
                    'taxonomy' => 'job_category',
                    'post_type' => 'jobs',
                    'hide_empty' => false,
                    'parent' => 0,
                    'exclude' => $exclude_category_ids,
                )
                );
                foreach ($terms as $term) {
                    if ($counter <= 8) {
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
                        $cat_icon = isset($term_meta['icon']) ? $term_meta['icon'] : '';
                        $cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
                        $category_link = get_category_link($term_id);
                        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                        $jobcircle_page_url = home_url('/');
                        if ($jobcircle_page_id > 0) {
                            $jobcircle_page_url = get_permalink($jobcircle_page_id);
                        }
                        ?>
                        <div class="cat-box">
                            <?php if (!empty($jobcircle_page_url || $term)) {
                                ?>
                                <a href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                <?php }
                            if (!empty($cat_image)) { ?>
                                    <div class="icon-box"><img src="<?php echo esc_url($cat_image); ?>" alt="icon"></div>
                                <?php } ?>
                                <div class="cat-text">
                                    <?php if (!empty($term)) {
                                        ?>
                                        <strong class="title">
                                            <?php echo esc_attr($term->name); ?>
                                        </strong>
                                    <?php }
                                    if (!empty($post_count)) {
                                        ?>
                                        <p>(
                                            <?php echo esc_html($post_count); ?>
                                            <?php echo esc_html_e('open positions', 'jobcircle-frame') ?>)
                                        </p>
                                    <?php } ?>
                                </div>
                            </a>
                        </div>
                        <?php
                        $counter++;
                    } else {
                        break;
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <?php

    return ob_get_clean();
}
add_shortcode('home_seventeen_job_cat', 'home_seventeen_job_cat_front');