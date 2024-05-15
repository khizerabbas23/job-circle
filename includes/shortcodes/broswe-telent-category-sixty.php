<?php
function jobcircle_browse_telent_category()
{
    $all_page = array( __('Select Page', 'jobcircle-frame'), '');
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
            'name' => __('Browse Talent Categories 60'),
            'base' => 'jobcircle_browse_telent_category',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Jobcircle Page', 'jobcircle-frame'),
                'param_name' => 'jobcircle_page',
                'description' => __('Select Jobcircle Page', 'jobcircle-frame'),
                'value' =>  $all_page,
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

            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_browse_telent_category');

// Frontend Coding  
function jobcircle_browse_telent_category_front($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'heading' => '',
        	'jobcircle_page' => '',   
        ),
        $atts,
        'jobcircle_browse_telent_category'
    );
    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';

    ob_start();
    ?>
    <section class="section section-theme-12 section-trending-categories pt-35 pt-md-50 pt-lg-65 pb-35px pb-md-50 pb-lg-65">
        <div class="container">
            <header class="section-header text-center mb-30 mb-md-45 mb-xl-60">
                <?php
                if (!empty($title)) { ?>
                    <p>
                        <?php echo jobcircle_esc_the_html($title); ?>
                    </p>
                <?php } ?>
                <?php
                if (!empty($heading)) { ?>
                    <h2 class=" ">
                        <?php echo jobcircle_esc_the_html($heading); ?>
                    </h2>
                <?php } ?>
            </header>
            <div class="trending-categories-slider">
                <?php
                $top_level_categories = get_terms(array(
                    'taxonomy' => 'job_category',
                    'hide_empty' => false,
                    'parent' => 0,
                ));               
                $categories_count = 0;
                foreach ($top_level_categories as $category) {
                    if ($categories_count >= 5) {
                        break; // Limit to 6 categories
                    }
                    $subcategories = get_terms(array(
                        'taxonomy' => 'job_category',
                        'hide_empty' => false,
                        'parent' => $category->term_id,
                    ));                    
                    $term_id = $category->term_id;
                    $term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);
                    $cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
                    $category_link = get_category_link($term_id);
                    $category_count = wp_count_terms('job_category', array('parent' => $term_id)); // Count of subcategories
                    $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                    $jobcircle_page_url = home_url('/');
                    if ($jobcircle_page_id > 0) {
                    $jobcircle_page_url = get_permalink($jobcircle_page_id);
                    }
                    ?>
                    <div class="slick-slide">
                        <?php
                        if (!empty($category_link)) {
                            ?>
                            <a href="<?php echo esc_url($jobcircle_page_url);?>?job_category=<?php echo jobcircle_esc_the_html($category->slug )?>" class="trending-categories-box">
                                <?php
                        }
                        ?>
                            <div class="icon">
                                <?php
                                if (!empty($cat_image)) {
                                    ?>
                                    <img src="<?php echo esc_url($cat_image); ?>" width="49" height="49"
                                        alt="<?php echo esc_attr($category->name); ?>">
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="textbox">
                                <?php
                                if (!empty($category->name)) {
                                    ?>
                                    <strong class="h6">
                                        <?php echo ($category->name); ?>
                                    </strong>
                                    <?php
                                }
                                ?>
                                <span class="subtext">
                                    <?php
                                    $subcategories_count = 0;
                                    foreach ($subcategories as $subcategory) {
                                        if ($subcategories_count >= 3) {
                                            break; // Limit to 3 subcategories
                                        }
                                       echo  jobcircle_esc_the_html($subcategory->name) . ' ';
                                        $subcategories_count++;
                                    }
                                    ?>
                                </span>
                            </div>
                            <?php
                            if (!empty($category_count)) {
                                ?>
                                <strong>
                                    <?php echo jobcircle_esc_the_html($category_count); ?> +
                                </strong>
                                <?php
                            }
                            ?>
                        </a>
                    </div>
                    <?php
                    $categories_count++;  
                }
                ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('jobcircle_browse_telent_category', 'jobcircle_browse_telent_category_front');
