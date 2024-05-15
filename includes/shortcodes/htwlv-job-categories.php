<?php
function home_twlve_job_cat()
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
            'name' => __('Jobs Categories Home 12'),
            'base' => 'home_twlve_job_cat',
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
                    'heading' => __('Paragraph'),
                    'param_name' => 'para',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_img',
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
add_action('vc_before_init', 'home_twlve_job_cat');
// Frontend Coding  
function home_twlve_job_cat_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'heading' => '',
            'para' => '',
            'bg_img' => '',
            'jobcircle_page' => '',
            'checkbox_param' => '',
        ), $atts, 'home_twlve_job_cat'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $para = isset($atts['para']) ? $atts['para'] : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
    $bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
	$checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
	$job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    ob_start();
    if (!empty($bg_img)) {
        ?>
        <section class="section section-theme-11 demanding-categories pt-35 pt-md-50 pt-lg-55 pt-xl-60 pb-35 pb-md-50 pb-xl-60"
            style="background-image: url(<?php echo esc_url_raw($bg_img) ?>); background-size: cover;">
            <?php
    }
    ?>
        <div class="container">
            <header class="section-header d-flex flex-column-reverse text-center mb-30 mb-lg-42">
                <?php
                if (!empty($heading)) {
                    ?>
                    <h2 class="help_question_heading">
                        <?php echo esc_html($heading) ?>
                    </h2>
                <?php }
                if (!empty($title)) {
                    ?>
                    <p>
                        <?php echo esc_html($title) ?>
                    </p>
                    <?php
                }
                ?>
            </header>
            <div class="top-txt">
                <p>
                    <?php
                    if (!empty($para)) {
                        ?>
                        <?php echo esc_html($para) ?>
                        <?php
                    }
                    ?>
                </p>
            </div>
            <div class="row align-items-center">
                <div class="col-12 col-lg-12">
                    <ul class="categories-list">
                        <?php
                    	$include_category_ids = $job_type_arr;
                        $counter = 1;
                        // Fetch the terms for the custom taxonomy 'job_featured'
                        $terms = get_terms(array(
                            'taxonomy' => 'job_category',
                            'post_type' => 'jobs',                            
                            'parent' => 0,
                            'include' => $include_category_ids,
                        )
                        );
                        foreach ($terms as $term) {

                            if ($counter <= 9) {
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
                                $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                                $jobcircle_page_url = home_url('/');
                                if ($jobcircle_page_id > 0) {
                                    $jobcircle_page_url = get_permalink($jobcircle_page_id);
                                }
                                $word = $term->name;
                                $words = explode(' ' , $word );
                                $numofwords = count($words);
                                ?>
                                
                                <li>
                                    <?php if (!empty($jobcircle_page_url) && !empty($term)) {
                                        ?>
                                        <a class="categories-item"
                                            href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                            <span class="icon">
                                                <?php if (!empty($cat_image) || $term) {
                                                    ?>
                                                    <img src="<?php echo esc_url($cat_image); ?>" width="30" height="30"
                                                        alt="<?php echo esc_attr($term->name); ?>">
                                                <?php } ?>
                                            </span>
                                            <strong class="title">
                                                <?php
                                                if ($numofwords > 0) {
                                                    echo $words[0];
                                                }
                                                if ($numofwords > 1) {
                                                    echo $words[1];
                                                }
                                                if ($numofwords > 2) {
                                                    echo  $words[2];
                                                }
                                                if ($numofwords > 3) {
                                                    echo  $words[3];
                                                }
                                                if ($numofwords > 4) {
                                                    echo  $words[4];
                                                }
                                                ?>
                                            </strong>
                                            <?php if (!empty($post_count)) {
                                                ?>
                                                <span class="count">
                                                    <?php echo esc_html($post_count); ?>
                                                </span>
                                            <?php } ?>
                                        </a>
                                    <?php } ?>
                                </li>
                                <?php
                                $counter++;
                            } else {
                                break;
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <?php
    return ob_get_clean();
}
add_shortcode('home_twlve_job_cat', 'home_twlve_job_cat_front');