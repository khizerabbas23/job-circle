<?php
function jobcircle_browse_category_hthirteen()
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
            'name' => __('Browse Category Thirteen'),
            'base' => 'jobcircle_browse_category_hthirteen',
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
                    'heading' => __('Tagline'),
                    'param_name' => 'tagline',

                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'btn_url',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_browse_category_hthirteen');
// Frontend Coding  
function jobcircle_browse_category_hthirteen_front($atts, $content)
{
    $atts = shortcode_atts(
        array(

            'title' => '',
            'tagline' => '',
            'btn_url' => '',

            'jobcircle_page' => '',

        ), $atts, 'jobcircle_browse_category_hthirteen'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $tagline = isset($atts['tagline']) ? $atts['tagline'] : '';
    $btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
    ob_start();
    ?>
    <section
        class="section section-theme-13 bg-white pt-35 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-50 pb-lg-65 pb-xxl-100">
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column-reverse text-center">
                <?php if (!empty($title)) { ?>
                    <h2>
                        <?php echo jobcircle_esc_the_html($title) ?>
                    </h2>
                <?php } ?>
                <?php if (!empty($tagline)) { ?>
                    <p>
                        <?php echo jobcircle_esc_the_html($tagline) ?>
                    </p>
                <?php } ?>
            </header>
            <div class="cats-block">
                <?php
                $exclude_category_ids = array(99, 98, 96, 44);
                // Fetch the terms for the custom taxonomy 'job_featured'
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
                        $cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
                        $category_link = get_category_link($term_id);
                        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                        $jobcircle_page_url = home_url('/');
                        if ($jobcircle_page_id > 0) {
                            $jobcircle_page_url = get_permalink($jobcircle_page_id);
                        }

                        ?>
                        <div class="cat-box">
                            <?php
                            if (!empty($jobcircle_page_url)) {
                                ?>
                                <a href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php jobcircle_esc_the_html($term->slug) ?>">
                                    <?php
                            }
                            ?>
                                <?php
                                if (!empty($cat_image)) {
                                    ?>
                                    <div class="icon-box"><img src="<?php echo esc_url_raw($cat_image); ?>" alt="icon"></div>
                                    <?php
                                }
                                ?>
                                <div class="cat-text">
                                    <?php
                                    if (!empty($term->name)) {
                                        ?>
                                        <strong class="title">
                                            <?php echo esc_attr($term->name); ?>
                                        </strong>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (!empty($term->count)) {
                                        ?>
                                        <p>
                                            <?php jobcircle_esc_the_html($term->count); ?>
                                            <?php echo esc_html_e(' available jobs', 'jobcircle-frame') ?>
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
                ?>
            </div>
        </div>
        <div class="row mt-30 mt-md-40 mt-xl-48">
            <div class="col-12 d-flex justify-content-center">
                <?php if (!empty($btn_url)) { ?>
                    <a href="<?php jobcircle_esc_the_html($btn_url) ?>" class="view-all">
                        <?php echo esc_html_e('View all categories', 'jobcircle-frame') ?>
                    </a>
                <?php } ?>
            </div>
        </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('jobcircle_browse_category_hthirteen', 'jobcircle_browse_category_hthirteen_front');