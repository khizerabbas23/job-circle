<?php
function jobcircle_deserve_blog()
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
            'name' => __('Deserve Blog'),
            'base' => 'jobcircle_deserve_blog',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                'type' => 'dropdown',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Blog Page Style', 'jobcircle-frame'),
                'param_name' => 'blog_page_style',
                'description' => __('Select Blog Page Style', 'jobcircle-frame'),
                'value' => array(
                    'Select Style' => '',
                    'Blog Full Width' => 'blog_full_width',
                    'Blog Container' => 'blog_containier',
                ),
            ),
            array(
            'type' => 'dropdown',
            'holder' => 'div',
            'class' => '',
            'heading' => __('Blog Columns Style', 'jobcircle-frame'),
            'param_name' => 'jobcircle_style',
            'description' => __('Select Jobcircle Style', 'jobcircle-frame'),
            'value' => array(
                'Select Style' => '',
                'Blog Full Width' => 'blog_full_width',
                'Blog Columns 2' => 'blog_column_2',
                'Blog Columns 3' => 'blog_column_3',
                'Blog Columns 4' => 'blog_column_4',
                ),
              ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Tagline'),
                    'param_name' => 'tagline',
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
            		  'heading' => __('Checkbox Options'),
            		  'param_name' => 'checkbox_param',
            		  'value' => $job_types,
        		),
            )
        )

    );
}
add_action('vc_before_init', 'jobcircle_deserve_blog');
// popular category frontend
function jobcircle_deserve_blog_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'tagline' => '',
            'orderby' => '',
            'checkbox_param' => '',
            'numofpost' => '',
            
            'jobcircle_style' => '',
            'blog_page_style' => '',
        ),
        $atts,
        'jobcircle_deserve_blog'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $tagline = isset($atts['tagline']) ? $atts['tagline'] : '';
    $jobcircle_style  = isset($atts['jobcircle_style']) ? $atts['jobcircle_style'] : '';
    $blog_page_style  = isset($atts['blog_page_style']) ? $atts['blog_page_style'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';

    ob_start();
    if ($atts['blog_page_style'] == 'blog_full_width') {
         $container ='container-fluid';
     }else{
         $container ='container';
     }
    ?>
    <section class="section section-theme-6 latest-news-block pt-30 pt-md-50 pt-lg-80 pb-15 pb-md-10">
        <div class="<?php echo $container ?>">
            <!-- Section header -->
            <header class="section-header d-flex flex-column text-center mb-30 mb-lg-45">
                <?php if (!empty($title)) { ?>
                    <h2>
                        <?php echo esc_html($title) ?>
                    </h2>
                <?php } ?>
                <?php if (!empty($tagline)) { ?>
                    <p>
                        <?php echo jobcircle_esc_the_html($tagline) ?>
                    </p>
                <?php } ?>
            </header>
            <div class="row">
                <?php

                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';

                 $include_category_ids = $job_type_arr;
                 
                $page_numbr = get_query_var('paged');
                $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => $numofpost,
                        'paged' => $page_numbr,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field' => 'term_id', // Use term_id instead of slug
                                'terms' => $include_category_ids,
                                'include_children' => false, // Set to true if you want to include posts from child categories
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
                        $post = get_post();
                        $postid = $post->ID;
                        $title = get_the_title($postid);
                        $author = get_the_author();
                        $permalinkget = get_permalink($postid);
                        $content = get_the_content();
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                        $date = get_the_date();
                        $job_post = get_post($postid);
                             $post_author = $job_post->post_author;
                             $post_employer_id = jobcircle_user_employer_id($post_author);
                             if ($post_employer_id > 0 && get_post_type($post_employer_id) == 'employer') {
                    	     $post_author_name = get_the_title($post_employer_id);
                    	     $post_author_link = get_permalink($post_employer_id);
                    	 } else {
                    	     $author_user_obj = get_user_by('id', $post_author);
                    	     $post_author_name = $author_user_obj->display_name;
                    	     $post_author_link = get_author_posts_url($post_author);
                    	 }
                        $author_id = get_the_author_meta('url');
                        $author_profile_link = get_author_posts_url($author_id);
                        
                         if ($atts['jobcircle_style'] == 'blog_column_2') {
                             $columns='col-12 col-sm-6 col-lg-6 mb-35';
                         }elseif ($atts['jobcircle_style'] == 'blog_column_3') {
                             $columns='col-12 col-sm-6 col-lg-4 mb-35';
                         }elseif ($atts['jobcircle_style'] == 'blog_column_4') {
                             $columns='col-12 col-sm-6 col-lg-3 mb-35';
                         }else{
                             $columns='col-12 col-sm-6 col-lg-3 mb-35';
                         }
                        ?>
                        <div class="<?php echo $columns ?>">
                            <div class="news-post">
                               
                                        <?php if (!empty($image)){
                                            ?>
                                            <div class="image-holder">
                                                <a href="<?php echo esc_html($permalinkget) ?>"><img src="<?php echo esc_url_raw($image[0]) ?>" alt="image"></a>
                                            </div>
                                        <?php }
                                        if (!empty($date)){ ?>
                                            <time class="date" datetime="2023-12-02">
                                                <?php echo esc_html($date) ?>
                                            </time>
                                        <?php }
                                        if (!empty($title)){ ?>
                                            <h3><a href="<?php echo esc_html($permalinkget) ?>">
                                                <?php echo esc_html($title) ?>
                                                </a>
                                            </h3>
                                        <?php }
                                        if (!empty($post_author_name)){ ?>
                                            <span class="post-by">
                                                <?php echo esc_html_e('By', 'jobcircle-frame') ?> <strong><a href="<?php echo jobcircle_esc_the_html($post_author_link) ?>" class="jobcircle-auth"><?php echo esc_html($post_author_name) ?>
                                                    </a>
                                                </strong>
                                            </span>
                                        <?php } ?>
                                </div>
                        </div>
                        <?php
                    }
                    // Restore original post data.
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </section>
        <?php
    if ($total_posts > $numofpost) {
        ?>
        <?php echo jobcircle_pagination($query, true); ?>
        <?php
    }
        return ob_get_clean();
    }
}
add_shortcode('jobcircle_deserve_blog', 'jobcircle_deserve_blog_frontend');