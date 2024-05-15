<?php

function jobcircle_modern_blog()
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
            'name' => __('Modern Blog'),
            'base' => 'jobcircle_modern_blog',
            'category' => __('Job Circle'),
            'params' => array(
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
                // array(
                //     'type' => 'textfield',
                //     'holder' => 'div',
                //     'class' => '',
                //     'heading' => __('Label Url'),
                //     'param_name' => 'view_label_url',
                // ),
                 array(
        		  'type' => 'dropdown',
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
                    'heading' => __('Number Of Post'),
                    'param_name' => 'numofpost',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_modern_blog');
// popular category frontend
function jobcircle_modern_blog_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'interest_title' => '',
            'interest_short_description' => '',
            'checkbox_param' => '',
            'numofpost' => '',
        ),
        $atts,
        'jobcircle_modern_blog'
    );

    $interest_title = isset($atts['interest_title']) ? $atts['interest_title'] : '';
    $interest_short_description = isset($atts['interest_short_description']) ? $atts['interest_short_description'] : '';
    $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
   
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
                     <?php 
                        $include_category_ids = $job_type_arr;
                        $cat_terms = get_terms( array(
                            'taxonomy'   => 'category',
                            'hide_empty' => false,
                            'include' => $include_category_ids,
                        ) );
                        
                        if (!empty($cat_terms)) {
                            foreach ($cat_terms as $cat_term) {
                                ?>
                             <a href="<?php echo esc_url(get_term_link($cat_term)); ?>" class="btn-all"><span class="btn-text">
                                <?php echo jobcircle_esc_the_html($cat_term->name); ?>
                            </span><i class="jobcircle-icon-chevron-right"></i></a>
                                <?php
                                // Display only the link for the first term
                                break;
                            }
                        }
                        ?>
                </div>
            </div>
            <div class="row align-items-center">
                <?php
                $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $page_numbr = get_query_var('paged');
               $include_category_ids = $job_type_arr;

               $args = array(
                        'post_type' => 'post',
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
                        global $post;
                        $post =  get_post(); 
                $author_id = get_the_author_meta( 'url' );
                $postid =  $post->ID;       
                $title = get_the_title($postid);
                $excerpt = get_the_excerpt($postid);
                $comment = get_comments_number($postid);
                $permalinkget = get_permalink($postid);
                $posted_date = get_the_date('F j, Y');
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'single-post-thumbnail' );
                $author_avatar = get_avatar($author_id, 96); // 96 is the size of the avatar in pixels
                $job_post = get_post($post->ID);
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
                        ?>
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
                                    $cat_terms = get_terms( array(
                                        'taxonomy'   => 'job_category',
                                        'hide_empty' => false,
                                    ) );
                                    
                                    if (!empty($cat_terms)) {
                                        foreach ($cat_terms as $cat_term) {
                                            ?>
                                            <strong class="subtitle">
                                                <a href="<?php echo esc_url(get_term_link($cat_term)); ?>">
                                                    <?php echo esc_html($cat_term->name); ?>
                                                </a>
                                            </strong>
                                            <?php
                                            // Display only the link for the first term
                                            break;
                                        }
                                    }
                                    ?>
                                    <?php if (!empty($permalink) || !empty($title)) { ?>
                                        <h5><a href="<?php echo esc_html($permalink); ?>">
                                                <?php echo esc_html($title); ?>
                                            </a></h5>
                                    <?php }
                                    if (!empty($post_author_link) || !empty($post_author_name)) {
                                        ?>
                                        <span class="author">
                                            <?php echo esc_html_e('By', 'jobcircle-frame') ?> <strong><a href="<?php echo esc_html($post_author_link); ?>"><?php echo esc_html($post_author_name); ?></a></strong>
                                                <style>
                                                    a {
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
    if ($total_posts > $numofpost) {
        ?>
        <?php echo jobcircle_pagination($query, true); ?>
        <?php
    }
    return ob_get_clean();
}
add_shortcode('jobcircle_modern_blog', 'jobcircle_modern_blog_frontend');

?>