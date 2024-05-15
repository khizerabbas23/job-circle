<?php
function home_fifteen_job_cat()
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
            'name' => __('Browse Categories 15'),
            'base' => 'home_fifteen_job_cat',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Explore Url'),
                    'param_name' => 'explore_url',
                ),
                array(
                    'type' => 'checkbox',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Checkbox Options'),
                    'param_name' => 'checkbox_param',
                    'value' => $job_types,
                ),
            )
        )
    );
}
add_action('vc_before_init', 'home_fifteen_job_cat');
// Frontend Coding  
function home_fifteen_job_cat_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'heading' => '',
            'explore_url' => '',
            'checkbox_param' => '',
            'jobcircle_page' => '',
        ),
        $atts,
        'home_fifteen_job_cat'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $explore_url = isset($atts['explore_url']) ? $atts['explore_url'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';

    ob_start();
    ?>
    <section
        class="section section-theme-15 bg-white pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
        <div class="container">
            <div class="row mb-30 mb-lg-45 align-items-md-end section-header">
                <div class="col-12 col-md-8 d-flex flex-column-reverse p-0">
                    <?php if (!empty($title)) { ?>
                        <h2>
                            <?php echo esc_html($title) ?>
                        </h2>
                    <?php } ?>
                    <?php if (!empty($heading)) { ?>
                        <p>
                            <?php echo esc_html($heading) ?>
                        </p>
                    <?php } ?>
                </div>
                <div class="col-12 col-md-4 p-0 d-flex justify-content-md-end align-items-start">
                    <?php if (!empty($explore_url)) { ?>
                        <a href="<?php echo jobcircle_esc_the_html($explore_url) ?>" class="view-all">
                            <?php echo esc_html_e('Explore all Categories', 'jobcircle-frame') ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <div class="cats-block">

                <?php
                $include_category_ids = $job_type_arr;

                $counter = 1;
                // Fetch the terms for the custom taxonomy 'job_featured'
                $terms = get_terms(array(
                    'taxonomy' => 'job_category',
                    'post_type' => 'jobs',
                    'hide_empty' => false,
                    'parent' => 0,
                    'include' => $include_category_ids,
                ));
                foreach ($terms as $term) {
                    $args = array(
                        'post_type' => 'jobs',
                        'hide_empty' => false,
                        'parent' => 0,
                        'include' => $include_category_ids,
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
                    // $cat_icon = isset($term_meta['icon']) ? $term_meta['icon'] : '';
                    $cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
                    $category_link = get_category_link($term_id);
                    $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                    $jobcircle_page_url = home_url('/');
                    if ($jobcircle_page_id > 0) {
                        $jobcircle_page_url = get_permalink($jobcircle_page_id);
                    }
                    $color = '';
                    if ($counter == 1 || $counter == 9) {
                        $color = 'bg-tutu';
                    } elseif ($counter == 2 || $counter == 6 || $counter == 8) {
                        $color = 'bg-island-spice';
                    } elseif ($counter == 3 || $counter == 4) {
                        $color = 'bg-foam';
                    } elseif ($counter == 7) {
                        $color = 'bg-magnolia';
                    } elseif ($counter == 10) {
                        break;
                    }
                    ?>
                    <div class="cat-box">
                        <?php if (!empty($jobcircle_page_url || $term || $color)) { ?>
                            <a href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>"
                                class="<?php echo esc_html($color) ?>">
                                <?php if (!empty($cat_image)) { ?>
                                    <div class="icon-box"><img src="<?php echo esc_url_raw($cat_image); ?>" alt="icon"></div>
                                <?php } ?>
                                <?php if (!empty($term)) { ?>
                                    <strong class="title">
                                        <?php echo esc_attr($term->name); ?>
                                    </strong>
                                <?php } ?>
                                <?php if (!empty($post_count)) { ?>
                                    <span class="value">
                                        <?php echo esc_html($post_count); ?>
                                    </span>
                                <?php } ?>
                            </a>
                        <?php } ?>
                    </div>
                    <?php
                    $counter++;
                }
                ?>
            </div>
        </div>
    </section>

    <?php
    return ob_get_clean();
}
add_shortcode('home_fifteen_job_cat', 'home_fifteen_job_cat_front');
