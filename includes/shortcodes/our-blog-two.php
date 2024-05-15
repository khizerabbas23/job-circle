<?php
function jobcircle_latest_blog_tow(){
     $terms = get_terms(
		array(
			'taxonomy' => 'category',
			'hide_empty' => false,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
    vc_map(
        array(
            'name' => __('Our Blog 2'),
            'base' => 'jobcircle_latest_blog_tow',
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
                'heading' => __('Post Title FontSize'),
                'param_name' => 'font_size',
                ),
                array(
        		  'type' => 'dropdown',
        		  'holder' => 'div',
        		  'class' => '',
        		  'heading' => __('Post Selector'),
        		  'param_name' => 'dropdown_param',
        		  'value' => $job_types,
        		),
        		array(
    		       'type' => 'checkbox',
    		       'holder' => 'div',
    		       'class' => '',
    		       'heading' => __('Category Selector'),
    		       'param_name' => 'checkbox_param',
    		       'value' => $job_types,
	         	),
                 array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Order By'),
                    'param_name' => 'orderby',
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
add_action('vc_before_init', 'jobcircle_latest_blog_tow');

// popular category frontend
function jobcircle_latest_blog_tow_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'orderby' => '',
            'numofpost' => '',
            'dropdown_param' => '',
            'checkbox_param' => '',
            'font_size' => '',
            
            'jobcircle_style' => '',
            'blog_page_style' => '',

        ), $atts, 'jobcircle_latest_blog_tow');

        $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
        $dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
        $job_type_arr = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';
        $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
        $job_type_arry = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
        $font_size = isset($atts['font_size']) ? $atts['font_size'] : '';
        
        $jobcircle_style  = isset($atts['jobcircle_style']) ? $atts['jobcircle_style'] : '';
        $blog_page_style  = isset($atts['blog_page_style']) ? $atts['blog_page_style'] : '';
    ob_start();
    
    if ($atts['blog_page_style'] == 'blog_full_width') {
         $container ='container-fluid';
     }else{
         $container ='container';
     }
        ?>
    <section class="section latest-news-block section-theme-1 pt-35 pt-md-50 pt-lg-75 pt-xl-100 pt-xxl-120 pb-0">
        <div class="<?php echo $container ?>">
            <div class="row">
                <?php
                //this one
                $include_category_ids = $job_type_arr;
               $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => $numofpost,
                        'orderby' =>  $orderby,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field' => 'term_id', // Use term_id instead of slug
                                'terms' => $include_category_ids,
                                'include_children' => false, // Set to true if you want to include posts from child categories
                            ),
                        ),
                    );
                // Custom query.// also this one 
                $query = new WP_Query($args);
                $total_posts = $query->found_posts;
                // Check that we have query results.
                if ($query->have_posts()) {
                    // Start looping over the query results.
                    while ($query->have_posts()) {
                        $query->the_post();
                        global $post;
                        $post = get_post();
                        $postid = $post->ID;
                        $title = get_the_title($postid);
                        $excerpt = get_the_excerpt($postid);
                        $comment = get_comments_number($postid);
                        $permalinkget = get_permalink($postid);
                        $posted = get_the_time('U');
                        $minut = human_time_diff($posted, current_time('U')) . "";
                        $admin = get_the_author();
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                        $designation = get_post_meta($postid, 'jobcircle_field_designation', true);
                        $author_id = get_the_author_meta('ID');
                        $author_avatar = get_avatar($author_id, 96);
                        $author_profile_link = get_author_posts_url($author_id);
                        $date = get_the_date('F d, Y');
                        
                        if ($atts['jobcircle_style'] == 'blog_column_2') {
                         $columns='col-12 col-md-6 col-lg-6 mb-35 mb-md-55';
                     }elseif ($atts['jobcircle_style'] == 'blog_column_3') {
                         $columns='col-12 col-md-6 col-lg-4 mb-35 mb-md-55';
                     }elseif ($atts['jobcircle_style'] == 'blog_column_4') {
                         $columns='col-12 col-md-6 col-lg-3 mb-35 mb-md-55';
                     }else{
                         $columns='col-12 col-md-6 col-lg-4 mb-35 mb-md-55';
                     }
                        ?>
                        <div class="<?php echo $columns ?>">
                            <!-- News Post -->
                            <div class="news-post">
                                <?php if (!empty($permalinkget) && !empty($image)) { ?>
                                    <a href="<?php echo esc_html($permalinkget) ?>">
                                        <div class="image-holder">
                                            <img src="<?php echo esc_url_raw($image[0]) ?>" alt="image">
                                        </div>
                                    </a>
                                <?php } ?>
                                <div class="textbox">
                                    <?php
                                   $include_category_ids = $job_type_arry;
                                   $terms = get_terms(
                                                array(
                                                    'taxonomy' => 'category',
                                                    'post_type' => 'post',
                                                    'hide_empty' => false,
                                                    'parent' => 0,
                                                    'include' => $include_category_ids,
                                                    'order' => 'DESC',
                                                )
                                            );?> 
                                            <strong class="subtitle">
                                            <?php
                                            $counter=1;
                                           foreach ($terms as $term){
                                              ?>
                                        <a href="<?php echo esc_url(get_term_link($term)); ?>" style="display:inline-block;">
                                                <?php echo esc_html($term->name); ?><?php echo ($counter ==1)? ', ' : ""; ?>
                                            </a>
                                        <?php
                                        $counter++;
                                    }
                                    ?></strong>
                                    <?php if (!empty($permalinkget) && !empty($title)) { ?>
                                        <a href="<?php echo esc_html($permalinkget) ?>">
                                            <h3 style="font-size:<?php echo $font_size ?>px;">
                                                <?php echo esc_html($title) ?>
                                            </h3>
                                        </a>
                                    <?php } ?>
                                    <ul class="post-meta">
                                        <?php if (!empty($date)) { ?>
                                            <li>
                                                <?php echo esc_html($date) ?>
                                            </li>
                                        <?php } ?>
                                        
                                            <li>
                                                <?php echo esc_html($comment) ?>
                                                <?php echo esc_html_e('Comments', 'jobcircle-frame') ?>
                                            </li>
                                    </ul>
                                    <div class="post-author">
                                            <span class="author-image">
                                                <?php echo jobcircle_esc_the_html($author_avatar) ?>
                                            </span>
                                        <?php if (!empty($author_profile_link) && !empty($admin)) { ?>
                                            <a href="<?php echo esc_html($author_profile_link) ?>">
                                                <span class="post-by">
                                                    <?php echo esc_html_e('By', 'jobcircle-frame') ?> <strong>
                                                        <?php echo esc_html($admin) ?>
                                                    </strong>
                                                </span>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                //also this one      
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
add_shortcode('jobcircle_latest_blog_tow', 'jobcircle_latest_blog_tow_frontend');