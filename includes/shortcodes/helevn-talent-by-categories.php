<?php
function jobcircle_tallent_by_categories()
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
            'name' => __('Trending Categories eleven'),
            'base' => 'jc_tallent_by_categories',
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
                    'heading' => __('View Button'),
                    'param_name' => 'view_btn',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url'),
                    'param_name' => 'btn_url',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Upload Bachground Image'),
                    'param_name' => 'bg_img',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_tallent_by_categories');
// Frontend Coding  
function jobcircle_tallent_by_categories_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'tagline' => '',
            'view_btn' => '',
            'btn_url' => '',
            'bg_img' => '',
            'checkbox_param' => '',
            'jobcircle_page' => '',

        ), $atts, 'jobcircle_tallent_by_categories'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $tagline = isset($atts['tagline']) ? $atts['tagline'] : '';
    $view_btn = isset($atts['view_btn']) ? $atts['view_btn'] : '';
    $btn_url = isset($atts['btn_url']) ? $atts['btn_url'] : '';
    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
    
	$checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
	$job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';

    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';

    ob_start();
    ?>
    <section
        class="section section-theme-6 talent-block pt-30 pt-md-50 pt-lg-75 pt-xxl-120 pb-35 pb-md-80 pb-lg-100 pb-xxl-120"
        style="background-image: url(<?php echo jobcircle_esc_the_html($bg_img) ?>)">
        <div class="container">
            <!-- Section header -->
            <header class="section-header d-flex flex-column text-center mb-30 mb-lg-45">
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
            <div class="talent-categories">
                
                <?php
                	$include_category_ids = $job_type_arr;
                // Fetch the terms for the custom taxonomy 'job_featured'
                $terms = get_terms(array(
                    'taxonomy' => 'job_category',
                    'post_type' => 'jobs',
                    'hide_empty' => false,
                    'parent' => 0,
                    'include' => $include_category_ids,
                ));
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
                        $cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
                        $category_link = get_category_link($term_id);
                        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                        $jobcircle_page_url = home_url('/');
                        if ($jobcircle_page_id > 0) {
                            $jobcircle_page_url = get_permalink($jobcircle_page_id);
                        }
                        ?>
                        <div class="cat-info-box">
                            <?php if (!empty($jobcircle_page_url) || !empty($term)) {
                                ?>
                                <a href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                    <?php if (!empty($cat_image)) {
                                        ?>
                                        <div class="icon"><img src="<?php echo esc_url($cat_image); ?>" alt="icon"></div>
                                    <?php } ?>
                                    <h3>
                                        <?php echo esc_attr($term->name); ?>
                                    </h3>
                                    <p>
                                        <?php echo esc_html($term->count); ?>
                                        <?php echo esc_html_e('Skills', 'jobcircle-frame') ?>
                                    </p>
                                </a>
                                <?php
                            } ?>
                        </div>
                        <?php
                        $counter++;
                    } else {
                        break; // Break the loop after 12 categories
                    }
                }
                ?>
            </div>
            <div class="row pt-30 pt-md-40 pt-lg-45">
                <div class="col-12 d-flex justify-content-center">
                    <?php if (!empty($btn_url) && !empty($view_btn)) { ?>
                        <a href="<?php echo jobcircle_esc_the_html($btn_url) ?>"><button class="btn"><span>
                                    <?php echo jobcircle_esc_the_html($view_btn) ?>
                                </span></button></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_tallent_by_categories', 'jobcircle_tallent_by_categories_front');