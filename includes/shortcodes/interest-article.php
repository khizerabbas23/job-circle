<?php
function get_article_posts_category() {
    $categories = get_terms(array(
        'taxonomy' => 'category',
        'hide_empty' => false,
    ));

    $category_options = array();

    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $category_options[wp_specialchars_decode($category->name)] = $category->slug;
        }
    }

    return $category_options;
}
function jobcircle_interest_article()
{
    $terms = get_terms(
		array(
			'taxonomy' => 'category',
			'hide_empty' => true,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
    vc_map(
        array(
            'name' => __('Interest Article'),
            'base' => 'jobcircle_interest_article',
            'category' => __('Job Circle'),
            'params' => array(
                 array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Select Category For Post'),
					'param_name' => 'category_selector',
					'value' => array_merge(
						array('Select Category' => ''),
						get_article_posts_category()
					),
				),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'interest_title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'interest_short_description',
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
                    'heading' => __('Label Url'),
                    'param_name' => 'view_label_url',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Number Of Post'),
                    'param_name' => 'numofpost',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_interest_article');
// popular category frontend
function jobcircle_interest_article_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'interest_title' => '',
            'interest_short_description' => '',
            'view_label_url' => '',
            'numofpost' => '',
        	'checkbox_param' => '',
        	'category_selector' => '',
        ),
        $atts,
        'jobcircle_interest_article'
    );

    $interest_title = isset($atts['interest_title']) ? $atts['interest_title'] : '';
    $interest_short_description = isset($atts['interest_short_description']) ? $atts['interest_short_description'] : '';
    $view_label_url = isset($atts['view_label_url']) ? $atts['view_label_url'] : '';
    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    $selectedcategory = isset($atts['category_selector']) ? $atts['category_selector'] : '';
   
    ob_start();
    ?>
    <section
        class="section section-theme-1 featured-news-block pt-35 pt-md-50 pt-lg-65 pt-xl-90 pt-xxl-120 pb-35px pb-md-50 pb-lg-65 pb-xl-90 pb-xxl-120">
        <div class="container">
            <div class="row justify-content-between mb-35 mb-lg-55">
                <div class="col-12 col-lg-8">
                    <!-- Section Header -->
                    <header class="section-header text-center text-lg-start mb-30 m-lg-0">
                        <?php if (!empty($interest_title)) { ?>
                            <h2>
                                <?php echo esc_html($interest_title); ?>
                            </h2>
                        <?php } ?>
                        <?php if (!empty($interest_short_description)) { ?>
                            <p>
                                <?php echo esc_html($interest_short_description); ?>
                            </p>
                        <?php } ?>
                    </header>
                </div>
                <div class="col-12 col-lg-4 text-center text-lg-end">
                    <?php if (!empty($view_label_url)) { ?>
                        <a href="<?php echo esc_html($view_label_url) ?>" class="btn-all"><span class="btn-text">
                                <?php esc_html_e('View All News', 'jobcircle-frame') ?>
                            </span><i class="jobcircle-icon-chevron-right"></i></a>
                    <?php } ?>
                </div>
            </div>
            <div class="row align-items-center">
                <?php
                $selectedcategory = isset($atts['category_selector']) ? $atts['category_selector'] : '';
                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                
                $args = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => $numofpost,
                    'order' => 'DESC',
                    'tax_query' => array(
                         array(
    						'taxonomy' => 'category',
    						'field' => 'slug',
    						'terms' => $selectedcategory,
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
                        global $post;
                        $post = get_the_id();
                        $author = get_the_author();
                        $permalink = get_the_permalink();
                        $excerpt = get_the_excerpt();
                        $title = get_the_title($post);
                        $permalinkget = get_the_permalink($post);
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');
                        
            			//$job_post = get_post($post->ID);
            			$job_post = get_post($post);
            		    $post_author = $job_post->post_author;
            	        $post_employer_id = jobcircle_user_employer_id($post_author);
                    	 if ($post_employer_id > 0 && get_post_type($post_employer_id) == 'employer') {
                	     $post_author_name = get_the_title($post_employer_id);
                	     $post_author_link = get_permalink($post_employer_id);
                    	 } else {
                	     $author_user_obj = get_user_by('id', $post_author);
                	     $post_author_name = $author_user_obj->display_name;
                	     $post_author_link = get_author_posts_url($post_author);
                	     } ?>
                        
                        <div class="col-12 col-lg-6">
                            <!-- Article News -->
                            <article class="article-news">
                                <div class="image-holder">
                                    <?php if (!empty($image) || !empty($permalinkget)) { ?>
                                        <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>"><img src="<?php echo esc_url_raw($image[0]); ?>"
                                                alt="Image Description"></a>
                                    <?php } ?>
                                </div>
                                <div class="textbox">
										<?php
                           $include_category_ids = $job_type_arr;
                            $terms = get_terms(
                                array(
                                    'taxonomy' => 'category',
                                    'post_type' => 'post',
                                    'hide_empty' => false,
                                    'parent' => 0,
                                    'include' => $include_category_ids,
                                    'order' => 'DESC',
                                )
                            );

                            $counter = 0;
                           foreach ($terms as $term) {
    if ($counter < 2 && !empty($term)) {
        $term_link = get_term_link($term);
        if (!is_wp_error($term_link)) {
            ?>
            <a class="d-inline-block" href="<?php echo esc_url($term_link); ?>">
                <strong class="subtitle"><?php echo esc_html($term->name); 
                echo ($counter == 1) ? "" : ', ';
                ?>
                </strong>
            </a>
            <?php
        }
        $counter++;
    } else {
        break;
        }
    }
    ?>
    <?php if (!empty($permalink) || !empty($title)) { ?>
        <h5><a href="<?php echo esc_html($permalink); ?>">
                <?php echo esc_html($title); ?>
            </a></h5>
    <?php }
    if (!empty($post_author_name) || !empty($post_author_link)) {
        ?>
        <span class="author">
            <?php echo esc_html_e('By', 'jobcircle-frame') ?> <strong><a
                    href="<?php echo esc_html($post_author_link) ?>">
                    <?php echo esc_html($post_author_name); ?>
                </a></strong>
<style>
    a{
        color: #040404;
        text-decoration: none;
    }
</style>
                                        </span>
                                        <?php
                                    } ?>
                                </div>
                            </article>
                        </div>
                        <?php
                    }
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('jobcircle_interest_article', 'jobcircle_interest_article_frontend');

?>