<?php
function jobcircle_latest_blog_three()
{
    
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
            'name' => __('Our Blog 3'),
            'base' => 'jobcircle_latest_blog_three',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                'type' => 'textfield',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Post Title FontSize'),
                'param_name' => 'font_size',
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
                array(
        		  'type' => 'dropdown',
        		  'holder' => 'div',
        		  'class' => '',
        		  'heading' => __('Select Category For Post'),
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
            )
        )

    );
}
add_action('vc_before_init', 'jobcircle_latest_blog_three');

// popular category frontend
function jobcircle_latest_blog_three_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'font_size' => '',
            'orderby' => '',
            'numofpost' => '',
            'dropdown_param' => '',
            'checkbox_param' => '',

        ), $atts, 'jobcircle_latest_blog_three');

    ob_start()
        ?>
    <section class="latest-news-block latest-blog section-theme-1">
        <div class="container">
        <?php

        $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
        $font_size = isset($atts['font_size']) ? $atts['font_size'] : '';
        $dropdown_param = isset($atts['dropdown_param']) ? $atts['dropdown_param'] : '';
        $job_type_arr = !empty($dropdown_param) ? explode(',', $dropdown_param) : '';
        $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
        $job_type_arry = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
        
        //this one
         $include_category_ids = $job_type_arr;

        
        $page_numbr = get_query_var('paged');
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $numofpost,
            'order' => 'DESC',
            'paged' => $page_numbr,
            'orderby' => $orderby,
             'tax_query' => array(
                  array(
                      'taxonomy' => 'category',
                      'field' => 'term_id', // Use term_id instead of slug
                      'terms' => $include_category_ids,
                      'include_children' => false, // Set to true if you want to include posts from child 
                      
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

                $date = get_the_date('F d Y')
                    ?>
                <!-- Blog Post -->
                <article class="news-post">
                    <div class="image-holder">
                        <?php
                        if (!empty($image[0])) {
                            ?>
                            <img src="<?php echo esc_url_raw($image[0]) ?>" alt="image">
                            <?php
                        }
                        ?>
                    </div>
                    <div class="textbox">
                        <?php
                                   $include_category_ids = $job_type_arry;
                                   $terms = get_terms(
                                                array(
                                                    'taxonomy' => 'category',
                                                    'post_type' => 'post',
                                                    'hide_empty' => false,
                                                    'order' => 'DESC',
                                                    'parent' => 0,
                                                    'include' => $include_category_ids,
                                                )
                                            );?> 
                                            <strong class="subtitle">
                                            <?php
                $counter=1;
                                           foreach ($terms as $term){
                                              ?>

                                        <a href="<?php echo esc_url(get_term_link($term)); ?>" style="display:inline-block;">
                                                <?php echo jobcircle_esc_the_html($term->name); ?><?php echo ($counter ==1)? ', ' : ""; ?>
                                            </a>
                                        <?php
                                        $counter++;
                                       
                                    }?>
                                    </strong>
                                    <?php
                        
                        if (!empty($permalinkget) || !empty($title)) {
                            ?>
                            <h2 class="h3" style="font-size:<?php echo $font_size ?>px;"><a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>">
                                    <?php echo jobcircle_esc_the_html($title) ?>
                                </a></h2>
                            <?php
                        }
                        ?>
                        <div class="post-meta-wrap">
                            <ul class="post-meta">
                                <?php
                                if (!empty($date)) {
                                    ?>
                                    <li>
                                        <?php echo jobcircle_esc_the_html($date) ?>
                                    </li>
                                    <?php
                                }
                                ?>
                                <li>
                                    <?php echo jobcircle_esc_the_html($comment) ?>
                                    <?php echo esc_html_e('Comments', 'jobcircle-frame') ?>
                                </li>
                            </ul>
                            <div class="post-author">
                                        
                                            <span class="author-image">
                                                <?php echo jobcircle_esc_the_html($author_avatar) ?>
                                            </span>
                                <?php
                                if (!empty($author_profile_link) || !empty($admin)) {
                                    ?>
                                    <span class="post-by">
                                    <?php echo esc_html_e('By', 'jobcircle-frame') ?><a href="<?php echo jobcircle_esc_the_html($author_profile_link) ?>"> <strong><?php echo jobcircle_esc_the_html($admin) ?>
                                                    </strong>
                                                </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if (!empty($excerpt)) {
                            ?>
                            <p>
                                <?php echo jobcircle_esc_the_html($excerpt) ?>
                            </p>
                            <?php
                        }
                        ?>
                        <?php
                        if (!empty($permalinkget)) {
                            ?>
                            <a href="<?php echo jobcircle_esc_the_html($permalinkget) ?>" class="btn btn-green btn-sm"><span class="btn-text">
                                    <?php echo esc_html_e('Continue Reading', 'jobcircle-frame') ?>
                                </span></a>
                            <?php
                        }
                        ?>
                    </div>
                </article>
                <?php
            }
        }
        //also this one      
    
        wp_reset_postdata();
        ?>
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
add_shortcode('jobcircle_latest_blog_three', 'jobcircle_latest_blog_three_frontend');